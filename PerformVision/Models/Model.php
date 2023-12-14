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

    public function createUser() {
        
        $req = $this->bd->prepare('INSERT INTO UTILISATEUR(nom,prenom,mail,role,motdepasse, estaffranchi) VALUES (:nom,:prenom,:mail,:role,:motdepasse,:estaffranchi)');
        $req->bindValue(":nom",$_POST['name']);
        $req->bindValue(":prenom",$_POST['surname']);
        $req->bindValue(":mail",$_POST['email']);
        $req->bindValue(":role","client");
        $req->bindValue(":motdepasse",$_POST['password']);
        $req->bindValue(":estaffranchi",'false');
        $req->execute();


    }



}
