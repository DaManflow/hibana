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
        $this->bd->exec("SET NAMES 'utf8'");
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
                //Insertion des experiences 
                $nombre_experiences = 0;

                    foreach ($_POST as $key => $value) {
                        // Vérifiez si la clé est associée à une expérience
                        if (strpos($key, 'theme') !== false) {
                            $nombre_experiences++;
                        }
                    }

                for ($i = 1; $i <= $nombre_experiences; $i++) {
                    // Préparation et insertion des données dans aExpertiseProfessionnelle
                    $reqExpertise = $this->bd->prepare('
                        INSERT INTO aExpertiseProfessionnelle(idn, idt, id_formateur, dureeMExperience, commentaire_expertise)
                        VALUES (:idn, :idt, :id_formateur, :duree, :commentaire)
                    ');
                    $reqExpertise->bindValue(':idn', $infos['expertise' . $i]);
                    $reqExpertise->bindValue(':idt', $infos['theme' . $i]);
                    $reqExpertise->bindValue(':id_formateur', $id_formateur);
                    $reqExpertise->bindValue(':duree', $infos['dureeExpertise' . $i]);
                    $reqExpertise->bindValue(':commentaire', $infos['commentaireExpertise' . $i]);
                    $reqExpertise->execute();
                
                    // Préparation et insertion des données dans aExperiencePeda
                    $reqPeda = $this->bd->prepare('
                        INSERT INTO aExperiencePeda(id_formateur, idt, idp, volumeHMoyenSession, nbSessionEffectuee, commentaire)
                        VALUES (:id_formateur, :idt, :idp, :volumeHMoyenSession, :nbSessionEffectuee, :commentaire)
                    ');
                    $reqPeda->bindValue(':id_formateur', $id_formateur);
                    $reqPeda->bindValue(':idt', $infos['theme' . $i]);
                    $reqPeda->bindValue(':idp', $infos['expePeda' . $i]);
                    $reqPeda->bindValue(':volumeHMoyenSession', $infos['VolumeHMoyenSession' . $i]);
                    $reqPeda->bindValue(':nbSessionEffectuee', $infos['nbSession' . $i]);
                    $reqPeda->bindValue(':commentaire', $infos['commentaireExpePeda' . $i]);
                    $reqPeda->execute();
                }

                // Deuxième partie : insertion dans la table Formateur
                $req3 = $this->bd->prepare('
                INSERT INTO Formateur (id_formateur, linkedin, date_signature, cv, declaration)
                VALUES (:id_formateur, :linkedin, :date_signature, :cv, :declaration)');
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

                // Déplace le fichier téléchargé vers le répertoire d'upload

                move_uploaded_file($_FILES["cv"]["tmp_name"], $cvUploadPath);
                // Créer un répertoire pour chaque formateur pour éviter les fichiers de même nom
                $formateurDirectory = $cvUploadDirectory . "cv_former_" . $id_formateur . "/";
                $derogationDirectory = $formateurDirectory . "derogation_former/";

                if (!file_exists($derogationDirectory)) {
                    mkdir($derogationDirectory, 0777, true);
                }

                $name = $infos['name'];
                $surname = $infos['surname'];

                $pdfContent =generatePDF($id_formateur, $name, $surname, $infos['email'], $infos['phone'], $infos['linkedin'], $infos['date_signature']);

                // Enregistrez le contenu du PDF dans le fichier spécifié
                $filePath = $derogationDirectory . "{$name}_{$surname}_declaration.pdf";

                $req3->bindValue(':declaration', $filePath);

                $req3->execute();

                file_put_contents($filePath, $pdfContent);

                

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
                $_SESSION['declaration'] = $filePath;
                
                
                
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

    public function getThemes($idsc = 0){
        if (isset($_POST['theme'])) {
            echo $_POST['theme'];
        }
        if($idsc != 0){
            $req = $this->bd->prepare('SELECT DISTINCT nomt, idc FROM THEME natural join categorie where validet = true and validec = true and theme.idc = :idscat');
            $req->bindValue(':idscat', $idsc);
        }else{
            $req = $this->bd->prepare('SELECT DISTINCT nomt, nomc, idc FROM THEME natural join categorie where validet = true and validec = true order by idc');
        }

        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories(){
        $req = $this->bd->prepare('SELECT c1.nomC, c1.idc, c2.nomc as idc_mere FROM Categorie as c1 left outer join categorie as c2 on c2.idc = c1.idc_mere where c2.validec = true order by idc'); // A revoir
        $req->execute();          // nomC, idc, idc_mere FROM Categorie where validec = true order by idc_mere
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCategorie($idc){
        $req = $this->bd->prepare('SELECT idc , nomc  from categorie where idc is not null and idc=:idc') ; 
        $req->bindValue(':idc',$idc) ;
        $req->execute() ; 
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        $categories = array();
        foreach ($result as $categorie) {
            $categories[$categorie['idc']] = $categorie['nomc'];
        }
    
        return $categories;
    }
    public function getCategoriesMeres(){
        $req = $this->bd->prepare('SELECT idc, nomc FROM categorie WHERE idC_mere IS NULL');
        $req->execute();
        
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        
    
        // Crée un tableau associatif avec 'idc' comme clé et 'nomc' comme valeur
        $categoriesMeres = array();
        foreach ($result as $categorie) {
            $categoriesMeres[$categorie['idc']] = $categorie['nomc'];
        }
    
        return $categoriesMeres;
    }
    public function getCategoriesWithSubcategoriesAndThemes2()
    {
        $req = $this->bd->prepare('SELECT idc,nomc from categorie WHERE idc_mere IS NULL'); 
        $req->execute();
        $tab = $req->fetchAll(PDO::FETCH_ASSOC);
        $tabC = [];
        foreach($tab as $val) {
            $tabC[] = $val['nomc'];
        }
        

        
        return $tabC;
    }

    public function getCategoriesWithSubcategoriesAndThemes(){
        $req= $this->bd-> prepare("SELECT 
        ");

        $req->execute();

        $tableau_final = array();

    // Parcourez les résultats
    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
        // Ajoutez chaque ligne au tableau associatif
        $tableau_final[$row['cle_principale']] = array(
            'tableau_idC_mere' => $row['tableau_idC_mere'],
            'tableau_themes' => $row['tableau_themes']
        );
    }

    return $tableau_final;

    }


    public function getFormateurs($cat="", $scat="", $th=""){
        $req = $this->bd->prepare('select formateur.id_formateur, nom, prenom, volumehmoyensession, nbsessioneffectuee, commentaire, nomt, theme.idt from formateur
inner join aexperiencepeda on formateur.id_formateur = aexperiencepeda.id_formateur
inner join theme on aexperiencepeda.idt = theme.idt
inner join utilisateur on formateur.id_formateur = utilisateur.id_utilisateur');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
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
                        $_SESSION['name'] = $req_tab['nom'];
                        $_SESSION['surname'] = $req_tab['prenom'];
                        $_SESSION['email'] = $req_tab['mail'];
                        $_SESSION['password'] = $req_tab['password'];
                        $_SESSION['phone'] = $req_tab['telephone'];
                        $_SESSION['role'] = $req_tab['role'];
                        $_SESSION['est_affranchi'] = $req_tab['est_affranchi'];
                    
                    if ($req_tab['role'] == "formateur") {
                        

                        $req2 = $this->bd->prepare('SELECT linkedin, date_signature, cv, declaration FROM formateur WHERE id_formateur = :id_formateur');
                        $req2->bindValue(':id_formateur', $req_tab['id_utilisateur']);
                        $req2->execute();

                        $req2_tab = $req2->fetch(PDO::FETCH_ASSOC);


                        

                        
                        $_SESSION['linkedin'] = $req2_tab['linkedin'];
                        $_SESSION['date_signature'] = $req2_tab['date_signature'];
                        $_SESSION['cv'] = $req2_tab['cv'];
                        $_SESSION['declaration'] = $req2_tab['declaration'];
                        
                        
                       
                    }

                    if ($req_tab['role'] == "client") {

                        $req4 = $this->bd->prepare('SELECT societe FROM client where id_client = :id_client');
                        $req4->bindValue(':id_client', $req_tab['id_utilisateur']);
                        $req4->execute();

                        $req4_tab = $req4->fetch(PDO::FETCH_ASSOC);

                        $_SESSION['company'] = $req4_tab['societe'];
                        
                    
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


    public function add_discussion($infos) {

        if (! $infos) {return false;}

        $erreur_type = [];

        try {

            $this->bd->beginTransaction();



            $req = $this->bd->prepare('INSERT INTO discussion(id_client,id_formateur) VALUES(:id_client, :id_formateur)');
            $req->bindValue(':id_client', $_SESSION['idutilisateur']);
            $req->bindValue(':id_formateur', $infos['id_former']);
            $req->execute();

            $id_discussion = $this->bd->lastInsertId();


            $req2 = $this->bd->prepare('INSERT INTO message(id_discussion,texte,date_heure,valideM,lu) VALUES(:id_discussion, :texte, :date_heure, :valideM, :lu)');
            $req2->bindValue(':id_discussion', $id_discussion);
            $req2->bindValue(':texte', $infos['message']);
            $req2->bindValue(':date_heure', $infos['date_msg']);
            $req2->bindValue(':valideM', "false");
            $req2->bindValue(':lu', "false");
            $req2->execute();







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

    public function getFormersWithLimitVerifModerator($start){
        /* 
        Cette fonction retourne une liste des formateurs avec un booléen 
        indiquant s'il s'agit d'un modérateur ou non sous forme de tableau 
        (clés = indice; valeurs = tableaux avec nom, prénom, est_modérateur)
        */

        // Requete pour obtenir un tableau avec les id, noms et prénoms des formateurs
        $requete1 = $this->bd->prepare('SELECT id_formateur, nom, prenom FROM formateur 
                                        JOIN utilisateur ON id_utilisateur = id_formateur
                                        ORDER BY nom ASC LIMIT :end OFFSET :offset');

        if($start == 0){ $offset = 0;}
        else{$offset = ($start - 1)*25 + 1;}
        $end = $offset + 24;
        $requete1->bindValue(':end', $end);
        $requete1->bindValue(':offset', $offset);
        $requete1->execute();
        $tab1 = $requete1->fetchAll(PDO::FETCH_ASSOC);

        // Requete pour obtenir les id_moderateur
        $requete2 = $this->bd->prepare('SELECT id_moderateur FROM moderateur');
        $requete2->execute();
        $tmp = $requete2->fetchAll(PDO::FETCH_ASSOC);

        /*
        Mise à jour de $tab1 pour obtenir un tableau de la forme :
        [
            indice0 => ["id_formateur"=>0, "nom"=>Buscaldi, "prenom"=>"Davide", "est_moderateur"=>false],
            indice1 => ["id_formateur"=>1, "nom"=>Ellouze, "prenom"=>"Slim", "est_moderateur"=>true],
            indice2 => ["id_formateur"=>2, "nom"=>Zargayouna, "prenom"=>"Haifa", "est_moderateur"=>true]
        ]
        */
        
        foreach($tab1 as $tab2){
            $i = 0;
            while($i<count($tmp)){
                if($tmp[$i]["id_moderateur"] == $tab2["id_formateur"]){
                    $tab2["est_moderateur"] = true;
                    break;
                }
                else{
                    $tab2["est_moderateur"] = false;
                }
                $i = $i + 1;
            }
        }
        return $tab1;
    }

    public function seeCategories(){
        $req = $this->bd->prepare('SELECT * FROM categorie WHERE idc_mere IS NULL') ;
        $req->execute() ;
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function seeSousCategories(){
        $req = $this->bd->prepare('SELECT * FROM categorie WHERE idc_mere IS NOT NULL') ;
        $req->execute() ;
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }   
    public function seeThemes(){
        $req = $this->bd->prepare('SELECT 
    t.idT AS id_theme,
    t.nomT AS theme,
    c1.nomC AS sous_categorie,
    c2.nomC AS categorie
FROM 
    theme t
JOIN 
    categorie c1 ON t.idC = c1.idC
LEFT JOIN 
    categorie c2 ON c1.idC_mere = c2.idC
WHERE 
    c1.idC_mere IS NOT NULL;
') ;
$req->execute();
    $themes = $req->fetchAll(PDO::FETCH_ASSOC);

    $result = array();
    foreach ($themes as $theme) {
        $id_theme = $theme['id_theme'];
        unset($theme['id_theme']);
        $result[$id_theme] = $theme;
    }

    return $result;

    } 
    public function seeLevel()
{
    $req = $this->bd->prepare('SELECT * FROM niveau');
    $req->execute();
    $levels = $req->fetchAll(PDO::FETCH_ASSOC);

    $result = array();
    foreach ($levels as $level) {
        $id = $level['idn'];
        unset($level['idn']);
        $result[$id] = $level;
    }

    return $result;
}
public function seePublic()
{
    $req = $this->bd->prepare('SELECT * FROM public');
    $req->execute();
    $publics = $req->fetchAll(PDO::FETCH_ASSOC);

    $result = array();
    foreach ($publics as $public) {
        $id = $public['idp'];
        unset($public['idp']);
        $result[$id] = $public;
    }

    return $result;
}

}