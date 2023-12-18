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

        var_dump($infos);

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
            
                $req2 = $this->bd->prepare('
                INSERT INTO CV (idcv, nom_cv, taille, type, bin)
                VALUES (:idcv, :nom_cv, :taille, :type, :bin)
                ');

                $req2->bindValue(':idcv', $idUtilisateur);
                $req2->bindValue(':nom_cv', $infos['cv']['name']);
                $req2->bindValue(':taille', $infos['cv']['size']);
                $req2->bindValue(':type', $infos['cv']['type']);
                $imageData = file_get_contents($infos['cv']['tmp_name']);
                $req2->bindParam(5, $imageData, PDO::PARAM_LOB);
                

                $req2->execute();


                // Deuxième partie : insertion dans la table Formateur
                $req3 = $this->bd->prepare('
                    INSERT INTO Formateur (idutilisateur_1, page_linkedin, idcv)
                    VALUES (:idUtilisateur, :linkedin, :idcv)
                ');
                $req3->bindValue(':idUtilisateur', $idUtilisateur);
                $req3->bindValue(':linkedin', $infos['linkedin']);
                $req3->bindValue(':idcv', $idUtilisateur);
            
                $req3->execute();


                
            
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


    public function test() {
        $req = $this->bd->prepare('SELECT nom_cv, bin FROM CV WHERE idcv = :idcv');
        $req->bindValue(':idcv', 60);
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);
    
        $nom = $row['nom_cv'];
        $cvContent = $row['bin'];
        
    
        // Envoyer les en-têtes pour le fichier PDF
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=$nom");
    
        // Afficher le contenu du fichier
        echo $cvContent;
        exit; // Assurez-vous de terminer l'exécution du script après avoir affiché le fichier
    }
    




}
