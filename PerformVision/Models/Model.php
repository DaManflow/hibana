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

        if (session_status() == PHP_SESSION_NONE) {
            // Si la session n'est pas démarrée, alors on la démarre
            session_start();
        }
        else {
            session_destroy();
            session_start();
        }

        

        $req_verif = $this->bd->prepare('SELECT COUNT(*) AS count FROM UTILISATEUR WHERE mail = :email');
        $req_verif->bindValue(":email", $infos['email']);
        $req_verif->execute();
        $row = $req_verif->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] == 0) {
            try {
                $this->bd->beginTransaction();
                $req1 = $this->bd->prepare('INSERT INTO UTILISATEUR(nom,prenom,mail,role,motdepasse, estaffranchi) VALUES (:name,:surname,:email,:role,:password,:estaffranchi)');
                $marqueurs = ['name', 'surname', 'email', "role", 'password', "estaffranchi"];
                foreach ($marqueurs as $value) {
            
                    $req1->bindValue(':' . $value, $infos[$value]);
                }
                $req1->execute();

                $idUtilisateur = $this->bd->lastInsertId();

                $req2 = $this->bd->prepare('
                    INSERT INTO Client (idutilisateur)
                    VALUES (:idUtilisateur)
                ');

                $req2->bindValue(':idUtilisateur', $idUtilisateur);

                $req2->execute();

                $_SESSION['idutilisateur'] = $idUtilisateur;
                $_SESSION['name'] = $infos['name'];
                $_SESSION['surname'] = $infos['surname'];
                $_SESSION['email'] = $infos['email'];
                $_SESSION['role'] = $infos['role'];
                $_SESSION['password'] = $infos['password'];
                $_SESSION['estaffranchi'] = $infos['estaffranchi'];

                $this->bd->commit();
            } catch (PDOException $e) {
                // En cas d'erreur, annuler la transaction
                $this->bd->rollBack();
                echo "Erreur : " . $e->getMessage();
            }

        return true;

        }
        else {
            return false;
        }
        
    }

    public function createFormer($infos) {
        if (! $infos) {return false;}

        

        if (session_status() == PHP_SESSION_NONE) {
            // Si la session n'est pas démarrée, alors on la démarre
            session_start();
        }
        else {
            session_destroy();
            session_start();
        }

        $req_verif = $this->bd->prepare('SELECT COUNT(*) AS count FROM UTILISATEUR WHERE mail = :email');
        $req_verif->bindValue(":email", $infos['email']);
        $req_verif->execute();
        $row = $req_verif->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] == 0) {
            try {




                $this->bd->beginTransaction();
            
                // Première partie : insertion dans la table Utilisateur
                $req1 = $this->bd->prepare('
                    INSERT INTO UTILISATEUR(nom, prenom, mail, role, motdepasse, estaffranchi) 
                    VALUES (:name, :surname, :email, :role, :password, :estaffranchi)
                ');
            
                $marqueurs1 = ['name', 'surname', 'email', 'role', 'password', 'estaffranchi'];
                foreach ($marqueurs1 as $value) {
                    $req1->bindValue(':' . $value, $infos[$value]);
                }
            
                $req1->execute();
            
                // Récupérer l'idUtilisateur généré
                $idUtilisateur = $this->bd->lastInsertId();


                // Deuxième partie : insertion dans la table Formateur
                $req3 = $this->bd->prepare('
                    INSERT INTO Formateur (idutilisateur_1, page_linkedin, idcv)
                    VALUES (:idUtilisateur, :linkedin, :idcv)
                ');
                $req3->bindValue(':idUtilisateur', $idUtilisateur);
                $req3->bindValue(':linkedin', $infos['linkedin']);
                $req3->bindValue(':idcv', $idUtilisateur);
            
                $req3->execute();

                $cvUploadDirectory = "./Content/CV_former/";

                if (isset($_FILES["cv"]) && $_FILES["cv"]["error"] == UPLOAD_ERR_OK) {
                    $cvFileName = rawurlencode(basename($_FILES["cv"]["name"]));
                    $cvUploadPath = $cvUploadDirectory . $cvFileName;
                    
            
                    // Déplace le fichier téléchargé vers le répertoire d'upload
                    move_uploaded_file($_FILES["cv"]["tmp_name"], $cvUploadPath);
                } else {
                    // Gérez les erreurs liées au téléchargement du fichier CV
                    echo "Erreur lors du téléchargement du fichier CV.";
                    exit;
                }
                
                
                $req4 = $this->bd->prepare('INSERT INTO CV VALUES (:idcv, :chemin_acces, :nom_cv, :taille, :type, :bin)');
                $req4->bindValue(':idcv', $idUtilisateur);
                $req4->bindValue(':chemin_acces', $cvUploadPath);
                $req4->bindValue(':nom_cv', $cvFileName);
                $req4->bindValue(':taille', $_FILES["cv"]["size"]);
                $req4->bindValue(':type', $_FILES["cv"]["type"]);
                $req4->bindValue(':bin', file_get_contents($cvUploadPath), PDO::PARAM_LOB);

                $req4->execute();



                $_SESSION['idutilisateur'] = $idUtilisateur;
                $_SESSION['name'] = $infos['name'];
                $_SESSION['surname'] = $infos['surname'];
                $_SESSION['email'] = $infos['email'];
                $_SESSION['role'] = $infos['role'];
                $_SESSION['password'] = $infos['password'];
                $_SESSION['estaffranchi'] = $infos['estaffranchi'];
                $_SESSION['linkedin'] = $infos['linkedin'];
                $_SESSION['cv'] = $infos['cv'];


                

            
                // Valider la transaction
                $this->bd->commit();
            } catch (PDOException $e) {
                // En cas d'erreur, annuler la transaction
                $this->bd->rollBack();
                echo "Erreur : " . $e->getMessage();
            }
            

        return true;

        }
        else {
            return false;
        }
    }

    public function getFormersWithLimit($offset = 0, $limit = 25) {

        $req = $this->bd->prepare('Select idutilisateur,nom, prenom from utilisateur WHERE role = :role ORDER BY idutilisateur DESC LIMIT :limit OFFSET :offset');
        $req->bindValue(':role', "formateur");
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);


    }


    public function getFormerInformations($id)
    {
        $requete = $this->bd->prepare('Select nom,prenom, mail, chemin_acces from utilisateur JOIN CV ON utilisateur.idutilisateur = cv.idcv WHERE utilisateur.idutilisateur = :id');
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

        

        // Vérifie si la session est déjà démarrée
        if (session_status() == PHP_SESSION_NONE) {
            // Si la session n'est pas démarrée, alors on la démarre
            session_start();
        }
        else {
            session_destroy();
            session_start();
        }

        $req = $this->bd->prepare('SELECT idutilisateur, nom, prenom, mail, role, motdepasse, estaffranchi FROM utilisateur WHERE mail = :mail');
        $req->bindValue(':mail', $infos['email']);
        $req->execute();

        

        if ($req->rowCount() > 0) {

                $req_tab = $req->fetch();
   
                if ($infos['email'] == $req_tab['mail'] && decrypt_biblio($infos['password']) == decrypt_biblio($req_tab['motdepasse'])) {

                    try {

                        $this->bd->beginTransaction();

                        $_SESSION['idutilisateur'] = $req_tab['idutilisateur'];
                        $_SESSION['nom'] = $req_tab['nom'];
                        $_SESSION['prenom'] = $req_tab['prenom'];
                        $_SESSION['mail'] = $req_tab['mail'];
                        $_SESSION['role'] = $req_tab['role'];
                        $_SESSION['motdepasse'] = $req_tab['motdepasse'];
                        $_SESSION['estaffranchi'] = $req_tab['estaffranchi'];
                    
                    if ($req_tab['role'] == "formateur") {

                        $req2 = $this->bd->prepare('SELECT page_linkedin FROM formateur WHERE idutilisateur_1 = :idutilisateur');
                        $req2->bindValue('idutilisateur', $req_tab['idutilisateur']);
                        $req2->execute();


                        $req3 = $this->bd->prepare('SELECT chemin_acces FROM CV WHERE idcv = :idformateur');
                        $req3->bindValue(':idformateur', $req_tab['idutilisateur']);
                        $req3->execute();

                        
                        $_SESSION['linkedin'] = $req2->fetch()['page_linkedin'];
                        $_SESSION['chemin_acces'] = $req3->fetch()['chemin_acces'];
                        
                    }
                    
                    
                        $this->bd->commit();

                    }catch (PDOException $e) {
                        // En cas d'erreur, annuler la transaction
                        $this->bd->rollBack();
                        echo "Erreur : " . $e->getMessage();
                    }
                    
                    return true;

                }
                
                return false ;
        }
        
        return false;
        
    }

}