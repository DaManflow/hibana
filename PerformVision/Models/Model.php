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

        $req1 = $this->bd->prepare('SELECT COUNT(*) AS count FROM UTILISATEUR WHERE mail = :email');
        $req1->bindValue(":email", $infos['email']);
        $req1->execute();
        $row = $req1->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] == 0) {
            $req = $this->bd->prepare('INSERT INTO UTILISATEUR(nom,prenom,mail,role,motdepasse, estaffranchi) VALUES (:name,:surname,:email,:role,:password,:estaffranchi)');
        $marqueurs = ['name', 'surname', 'email', "role", 'password', "estaffranchi"];
        foreach ($marqueurs as $value) {
            
            $req->bindValue(':' . $value, $infos[$value]);
        }
        $req->execute();

        return true;

        }
        else {
            return false;
        }
        
        


    }



}
