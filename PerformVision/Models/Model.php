<?php

class Model
{
    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;

    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;

    /**
     * Constructeur : effectue la connexion à la base de données.
     */
    private function __construct()
    {
        include "credentials.php";
        $this->bd = new PDO($dsn, $login, $mdp);
        $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->bd->query("SET nameS 'utf8'");
    }

    public static function getModel()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function createCustomer($infos) {
        if (! $infos) {return false;}

        $erreur_type = [];

        
        

        

        $req_verif = $this->bd->prepare('SELECT COUNT(*) AS count FROM UTILISATEUR WHERE mail = :email OR telephone = :phone');
        $req_verif->bindValue(":email", $infos['email']);
        $req_verif->bindValue(":phone", $infos['phone']);
        $req_verif->execute();
        $row = $req_verif->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] == 0) {
            try {



                $this->bd->beginTransaction();
                $req1 = $this->bd->prepare('INSERT INTO UTILISATEUR(nom,prenom,mail,password, telephone, role, est_affranchi) VALUES (:name,:surname,:email,:password,:phone,:role,:estaffranchi)');
                $marqueurs = ['name', 'surname', 'email', 'password', 'phone', "role", "estaffranchi"];
                foreach ($marqueurs as $value) {
            
                    $req1->bindValue(':' . $value, $infos[$value]);
                }
                $req1->execute();

                $id_client = $this->bd->lastInsertId();

                $req2 = $this->bd->prepare('
                    INSERT INTO Client (id_client, societe)
                    VALUES (:id_client,:company)
                ');

                $req2->bindValue(':id_client', $id_client);
                $req2->bindValue(':company', $infos['company']);

                $req2->execute();


                $this->bd->commit();

                if (session_status() == PHP_SESSION_NONE) {
                    // Si la session n'est pas démarrée, alors on la démarre
                    session_start();
                }
                else {
                    session_destroy();
                    session_start();
                }


                $_SESSION['idutilisateur'] = $id_client;
                $_SESSION['name'] = $infos['name'];
                $_SESSION['surname'] = $infos['surname'];
                $_SESSION['email'] = $infos['email'];
                $_SESSION['role'] = $infos['role'];
                $_SESSION['password'] = $infos['password'];
                $_SESSION['phone'] = $infos['phone'];
                $_SESSION['company'] = $infos['company'];
                $_SESSION['estaffranchi'] = $infos['estaffranchi'];



            } catch (PDOException $e) {
                // En cas d'erreur, annuler la transaction
                $this->bd->rollBack();
                $_SESSION = array();
                session_destroy();
                echo "Erreur : " . $e->getMessage();
                $erreur_type[] = "error_db";
                return $erreur_type;
            }

            $erreur_type[] = "none";
            return $erreur_type;

        }
        else {
            $erreur_type[] = "id_already_take";
            return $erreur_type;
        }
        
    }

    public function createFormer($infos) {
        if (! $infos) {return false;}

        $erreur_type = [];


        

        $req_verif = $this->bd->prepare('SELECT COUNT(*) AS count FROM UTILISATEUR WHERE mail = :email OR telephone = :phone');
        $req_verif->bindValue(":email", $infos['email']);
        $req_verif->bindValue(":phone", $infos['phone']);
        $req_verif->execute();
        $row = $req_verif->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] == 0) {
            try {

                


                $this->bd->beginTransaction();
            
                // Première partie : insertion dans la table Utilisateur
                $req1 = $this->bd->prepare('INSERT INTO UTILISATEUR(nom,prenom,mail,password, telephone, role, est_affranchi) VALUES (:name,:surname,:email,:password,:phone,:role,:estaffranchi)');
                $marqueurs = ['name', 'surname', 'email', 'password', 'phone', "role", "estaffranchi"];
                foreach ($marqueurs as $value) {
            
                    $req1->bindValue(':' . $value, $infos[$value]);
                }
                $req1->execute();
            
                // Récupérer l'idUtilisateur généré
                $id_formateur = $this->bd->lastInsertId();


                // Deuxième partie : insertion dans la table Formateur
                $req3 = $this->bd->prepare('
                INSERT INTO Formateur (id_formateur, linkedin, date_signature, cv)
                VALUES (:id_formateur, :linkedin, :date_signature, :cv)
                ');
                $req3->bindValue(':id_formateur', $id_formateur);
                $req3->bindValue(':linkedin', $infos['linkedin']);
                $req3->bindValue(':date_signature', $infos['date_signature']);

                $cvUploadDirectory = "./Content/CV_former/";

                if (isset($_FILES["cv"]) && $_FILES["cv"]["error"] == UPLOAD_ERR_OK) {
                // Créer un répertoire pour chaque formateur pour éviter les fichiers de même nom
                $formateurDirectory = $cvUploadDirectory . "cv_former_" . $id_formateur . "/";
                if (!file_exists($formateurDirectory)) {
                    mkdir($formateurDirectory, 0777, true);
                }

                // Nom du fichier CV dans le répertoire
                $cvFileName = basename($_FILES["cv"]["name"]);
                $cvUploadPath = $formateurDirectory . $cvFileName;

                $req3->bindValue(':cv', $cvUploadPath);
                
                $req3->execute();

                // Déplace le fichier téléchargé vers le répertoire d'upload
                move_uploaded_file($_FILES["cv"]["tmp_name"], $cvUploadPath);
                } else {
                // Gérez les erreurs liées au téléchargement du fichier CV
                echo "Erreur lors du téléchargement du fichier CV.";
                exit;
                }
                
                // Valider la transaction
                $this->bd->commit();

                if (session_status() == PHP_SESSION_NONE) {
                    // Si la session n'est pas démarrée, alors on la démarre
                    session_start();
                    
                }
                else {
                    session_destroy();
                    session_start();
                    
                }

                $_SESSION['idutilisateur'] = $id_formateur;
                $_SESSION['name'] = $infos['name'];
                $_SESSION['surname'] = $infos['surname'];
                $_SESSION['email'] = $infos['email'];
                $_SESSION['role'] = $infos['role'];
                $_SESSION['password'] = $infos['password'];
                $_SESSION['phone'] = $infos['phone'];
                $_SESSION['estaffranchi'] = $infos['estaffranchi'];
                $_SESSION['linkedin'] = $infos['linkedin'];
                $_SESSION['cv'] = $cvUploadPath;
                $_SESSION['date_signature'] = $infos['date_signature'];

            } catch (PDOException $e) {
                // En cas d'erreur, annuler la transaction
                $this->bd->rollBack();
                $_SESSION = array();
                session_destroy();
                echo "Erreur : " . $e->getMessage();
                $erreur_type[] = "error_db";
                return $erreur_type;
            }
            
            $erreur_type[] = "none";
            return $erreur_type;
            

        }
        else {
            $erreur_type[] = "id_already_take";
            return $erreur_type;
        }
    }

    public function getFormersWithLimit($offset = 0, $limit = 25) {

        $req = $this->bd->prepare('Select id_utilisateur,nom, prenom from utilisateur WHERE role = :role ORDER BY id_utilisateur DESC LIMIT :limit OFFSET :offset');
        $req->bindValue(':role', "formateur");
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);


    }


    public function getFormerInformations($id)
    {
        $requete = $this->bd->prepare('Select nom,prenom, mail, telephone, cv from utilisateur JOIN formateur ON utilisateur.id_utilisateur = formateur.id_formateur WHERE utilisateur.id_utilisateur = :id');
        $requete->bindValue(':id', $id);
        $requete->execute();
        return $requete->fetchAll();
    }

    public function getNbFormer()
    {
        $req = $this->bd->prepare('SELECT COUNT(*) FROM utilisateur WHERE role = :formateur');
        $req->bindValue(':formateur', "formateur");
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    public function VerifConnectUser($infos) {

        if (! $infos) {return false;}

        $erreur_type = [];

        

        

        $req = $this->bd->prepare('SELECT id_utilisateur, nom, prenom, mail, telephone, password, role, est_affranchi FROM utilisateur WHERE mail = :mail');
        $req->bindValue(':mail', $infos['email']);
        $req->execute();

        

        if ($req->rowCount() > 0) {

                $req_tab = $req->fetch(PDO::FETCH_ASSOC);
                
   
                if ($infos['email'] == $req_tab['mail'] && decrypt_biblio($infos['password']) == decrypt_biblio($req_tab['password'])) {

                    try {

                        // Vérifie si la session est déjà démarrée
                        if (session_status() == PHP_SESSION_NONE) {
                            // Si la session n'est pas démarrée, alors on la démarre
                            session_start();
                            
                        }
                        else {
                            session_destroy();
                            session_start();
                            
                        }

                        $this->bd->beginTransaction();

                        $_SESSION['idutilisateur'] = $req_tab['id_utilisateur'];
                        $_SESSION['nom'] = $req_tab['nom'];
                        $_SESSION['prenom'] = $req_tab['prenom'];
                        $_SESSION['mail'] = $req_tab['mail'];
                        $_SESSION['password'] = $req_tab['password'];
                        $_SESSION['telephone'] = $req_tab['telephone'];
                        $_SESSION['role'] = $req_tab['role'];
                        $_SESSION['est_affranchi'] = $req_tab['est_affranchi'];
                    
                    if ($req_tab['role'] == "formateur") {
                        

                        $req2 = $this->bd->prepare('SELECT linkedin, date_signature, cv FROM formateur WHERE id_formateur = :id_formateur');
                        $req2->bindValue(':id_formateur', $req_tab['id_utilisateur']);
                        $req2->execute();

                        $req2_tab = $req2->fetch(PDO::FETCH_ASSOC);


                        

                        
                        $_SESSION['linkedin'] = $req2_tab['linkedin'];
                        $_SESSION['date_signature'] = $req2_tab['date_signature'];
                        $_SESSION['cv'] = $req2_tab['cv'];
                        
                        
                       
                    }

                    if ($req_tab['role'] == "client") {

                        $req4 = $this->bd->prepare('SELECT societe FROM client where id_client = :id_client');
                        $req4->bindValue(':id_client', $req_tab['id_utilisateur']);
                        $req4->execute();

                        $req4_tab = $req4->fetch(PDO::FETCH_ASSOC);

                        $_SESSION['societe'] = $req4_tab['societe'];
                        
                    
                    }

                    

                    
                    
                        $this->bd->commit();

                    }catch (PDOException $e) {
                        // En cas d'erreur, annuler la transaction
                        $this->bd->rollBack();

                        $_SESSION = array();
                        session_destroy();

                        echo "Erreur : " . $e->getMessage();
                        $erreur_type[] = "error_db";
                        return $erreur_type;
                    }

                    $erreur_type[] = "none";
                    return $erreur_type;

                }
                $erreur_type[] = "mail_mdp_error";
                return $erreur_type;
        }
        $erreur_type[] = "mail_mdp_error";
        return $erreur_type;
        
    }

}