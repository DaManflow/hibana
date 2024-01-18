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

        $req_admin = $this->bd->prepare('SELECT * FROM utilisateur');
        $req_admin->execute();

        if ($req_admin->rowCount() == 0) {

            $req1 = $this->bd->prepare('INSERT INTO UTILISATEUR(nom,prenom,mail,password, telephone, role, est_affranchi) VALUES (:name,:surname,:email,:password,:phone,:role,:estaffranchi)');
            
            $req1->bindValue(':name', $infos['name']);
            $req1->bindValue(':surname', $infos['surname']);
            $req1->bindValue(':email', $infos['email']);
            $req1->bindValue(':password', $infos['password']);
            $req1->bindValue(':phone', $infos['phone']);
            $req1->bindValue(':role', 'administrateur');
            $req1->bindValue(':estaffranchi', 'true');
            $req1->execute();

            // Récupérer l'idUtilisateur généré
            $id_formateur = $this->bd->lastInsertId();

            

            // Deuxième partie : insertion dans la table Formateur
            $req3 = $this->bd->prepare('
            INSERT INTO Formateur (id_formateur, linkedin, date_signature, cv, declaration)
            VALUES (:id_formateur, :linkedin, :date_signature, :cv, :declaration)
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

            file_put_contents($filePath, $pdfContent);

        }else {
            // Gérez les erreurs liées au téléchargement du fichier CV
            echo "Erreur lors du téléchargement du fichier CV.";
            exit;
            }
            
            
            

            if (session_status() == PHP_SESSION_NONE) {
                // Si la session n'est pas démarrée, alors on la démarre
                session_start();
                
            }
            else {
                session_destroy();
                session_start();
                
            }
            $req4 = $this->bd->prepare('INSERT INTO admin VALUES (:id_administrateur)');
            $req4->bindValue(':id_administrateur', $id_formateur);
            $req4->execute();
            
            

                $_SESSION['idutilisateur'] = $id_formateur;
                $_SESSION['name'] = $infos['name'];
                $_SESSION['surname'] = $infos['surname'];
                $_SESSION['email'] = $infos['email'];
                $_SESSION['role'] = "administrateur";
                $_SESSION['password'] = $infos['password'];
                $_SESSION['phone'] = $infos['phone'];
                $_SESSION['estaffranchi'] = 'true';
                $_SESSION['linkedin'] = $infos['linkedin'];
                $_SESSION['cv'] = $cvUploadPath;
                $_SESSION['date_signature'] = $infos['date_signature'];
                $_SESSION['declaration'] = $filePath;
            

                $erreur_type[] = "none";
                return $erreur_type;
    }

    else {

    

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
                INSERT INTO Formateur (id_formateur, linkedin, date_signature, cv, declaration)
                VALUES (:id_formateur, :linkedin, :date_signature, :cv, :declaration)
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
    }


    public function getFormersWithLimit($offset = 0, $limit = 25) {

        $req = $this->bd->prepare('Select id_utilisateur,nom, prenom, mail from utilisateur WHERE role = :formateur OR role = :moderateur OR role = :admin ORDER BY id_utilisateur DESC LIMIT :limit OFFSET :offset');
        $req->bindValue(':formateur', "formateur");
        $req->bindValue(':moderateur', "moderateur");
        $req->bindValue(':admin', "administrateur");
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);


    }


    public function getFormerInformations($id)
    {
        $requete = $this->bd->prepare('Select id_utilisateur, nom,prenom, mail, telephone, est_affranchi, cv from utilisateur JOIN formateur ON utilisateur.id_utilisateur = formateur.id_formateur WHERE utilisateur.id_utilisateur = :id');
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


    public function getThemes($sc = 'tout'){
        if($sc == 'tout'){
            $req = $this->bd->prepare('SELECT DISTINCT nomt, nomc, idc FROM THEME natural join categorie where validet = true and validec = true order by idc');
        }else{
            $req = $this->bd->prepare('SELECT DISTINCT nomt, idc FROM THEME natural join categorie where validet = true and validec = true and categorie.nomc IN('.$sc.')');
        }
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getSousCategories($cat){
        if($cat == 'tout'){
            $req = $this->bd->prepare('SELECT c1.nomC, c1.idc, c2.nomc as nomc_mere, c2.idc_mere FROM Categorie as c1 left outer join categorie as c2 on c2.idc = c1.idc_mere where c2.validec = true order by idc');

        }else{
            $res = "''";
            foreach ($cat as $c){
                $res .= ",'".$c."'";
            }
            $req = $this->bd->prepare('SELECT c1.nomC, c1.idc, c2.nomc as nomc_mere, c2.idc_mere FROM Categorie as c1 left outer join categorie as c2 on c2.idc = c1.idc_mere where c2.validec = true and c2.nomc IN('.$res.') order by idc');
        }
        $req->execute();          // nomC, idc, idc_mere FROM Categorie where validec = true order by idc_mere
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoriesMeres(){
        $req  = $this->bd->prepare('SELECT * FROM categorie WHERE validec = true and idC_mere IS NULL') ;
        $req->execute() ; 
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFormateurs($cat="", $scat="", $th=""){
        $req = $this->bd->prepare('select formateur.id_formateur, nom, prenom, volumehmoyensession, nbsessioneffectuee, commentaire, nomt, theme.idt from formateur
inner join aexperiencepeda on formateur.id_formateur = aexperiencepeda.id_formateur
inner join theme on aexperiencepeda.idt = theme.idt
inner join utilisateur on formateur.id_formateur = utilisateur.id_utilisateur');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getExpercienceByTheme($theme){
        if($theme == 'tout'){
            $req = $this->bd->prepare('select libellep, nomt, theme.idt, volumehmoyensession, nbsessioneffectuee, commentaire from aexperiencepeda inner join public on aexperiencepeda.idp = public.idp inner join theme on aexperiencepeda.idt = theme.idt order by idt limit 10');
        }else{
            $req = $this->bd->prepare('select libellep, nomt, theme.idt, volumehmoyensession, nbsessioneffectuee, commentaire from aexperiencepeda inner join public on aexperiencepeda.idp = public.idp inner join theme on aexperiencepeda.idt = theme.idt where theme.nomt IN('.$theme.') order by idt limit 10');
        }
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
                    
                    if ($req_tab['role'] == "formateur" || $req_tab['role'] == "administrateur" || $req_tab['role'] == "moderateur") {
                        

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


    public function add_discussion_message_customer($infos) {

        if (! $infos) {return false;}

        $erreur_type = [];

        try {

            $this->bd->beginTransaction();


            $req_verif = $this->bd->prepare('SELECT * FROM discussion WHERE id_client = :id_client AND id_formateur = :id_formateur');
            $req_verif->bindValue(':id_client', $_SESSION['idutilisateur']);
            $req_verif->bindValue(':id_formateur', $infos['id_former']);
            $req_verif->execute();

            

            if ($req_verif->rowCount() == 0) {


                $req = $this->bd->prepare('INSERT INTO discussion(id_client,id_formateur) VALUES(:id_client, :id_formateur)');
                $req->bindValue(':id_client', $_SESSION['idutilisateur']);
                $req->bindValue(':id_formateur', $infos['id_former']);
                $req->execute();

            }

            $req_verif = $this->bd->prepare('SELECT * FROM discussion WHERE id_client = :id_client AND id_formateur = :id_formateur');
            $req_verif->bindValue(':id_client', $_SESSION['idutilisateur']);
            $req_verif->bindValue(':id_formateur', $infos['id_former']);
            $req_verif->execute();

            $req_verif_tab = $req_verif->fetch(PDO::FETCH_ASSOC);

            

            $req2 = $this->bd->prepare('INSERT INTO message(id_discussion, id_utilisateur, texte,date_heure,valideM,lu) VALUES(:id_discussion, :id_utilisateur, :texte, :date_heure, :valideM, :lu)');
            $req2->bindValue(':id_discussion', $req_verif_tab['id_discussion']);
            $req2->bindValue(':id_utilisateur', $_SESSION['idutilisateur']);
            $req2->bindValue(':texte', $infos['message']);
            $req2->bindValue(':date_heure', $infos['date_msg']);
            $req2->bindValue(':valideM', "false");
            $req2->bindValue(':lu', "false");
            $req2->execute();

            $this->bd->commit();


        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

            echo "Erreur : " . $e->getMessage();
            $erreur_type[] = "error_db";
            return $erreur_type;
        }

        $erreur_type[] = "none";
        return $erreur_type;
    }

    public function add_discussion_message_customer_affranchi($infos) {

        if (! $infos) {return false;}

        $erreur_type = [];

        try {

            $this->bd->beginTransaction();


            $req_verif = $this->bd->prepare('SELECT * FROM discussion WHERE id_client = :id_client AND id_formateur = :id_formateur');
            $req_verif->bindValue(':id_client', $_SESSION['idutilisateur']);
            $req_verif->bindValue(':id_formateur', $infos['id_former']);
            $req_verif->execute();

            

            if ($req_verif->rowCount() == 0) {


                $req = $this->bd->prepare('INSERT INTO discussion(id_client,id_formateur) VALUES(:id_client, :id_formateur)');
                $req->bindValue(':id_client', $_SESSION['idutilisateur']);
                $req->bindValue(':id_formateur', $infos['id_former']);
                $req->execute();

            }

            $req_verif = $this->bd->prepare('SELECT * FROM discussion WHERE id_client = :id_client AND id_formateur = :id_formateur');
            $req_verif->bindValue(':id_client', $_SESSION['idutilisateur']);
            $req_verif->bindValue(':id_formateur', $infos['id_former']);
            $req_verif->execute();

            $req_verif_tab = $req_verif->fetch(PDO::FETCH_ASSOC);

            

            $req2 = $this->bd->prepare('INSERT INTO message(id_discussion, id_utilisateur, texte,date_heure,valideM,lu) VALUES(:id_discussion, :id_utilisateur, :texte, :date_heure, :valideM, :lu)');
            $req2->bindValue(':id_discussion', $req_verif_tab['id_discussion']);
            $req2->bindValue(':id_utilisateur', $_SESSION['idutilisateur']);
            $req2->bindValue(':texte', $infos['message']);
            $req2->bindValue(':date_heure', $infos['date_msg']);
            $req2->bindValue(':valideM', "true");
            $req2->bindValue(':lu', "false");
            $req2->execute();

            $this->bd->commit();


        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

            echo "Erreur : " . $e->getMessage();
            $erreur_type[] = "error_db";
            return $erreur_type;
        }

        $erreur_type[] = "none";
        return $erreur_type;
    }


    public function add_discussion_message_former($infos) {

        if (! $infos) {return false;}

        $erreur_type = [];

        try {

            $this->bd->beginTransaction();


            $req_verif = $this->bd->prepare('SELECT * FROM discussion WHERE id_client = :id_client AND id_formateur = :id_formateur');
            $req_verif->bindValue(':id_formateur', $_SESSION['idutilisateur']);
            $req_verif->bindValue(':id_client', $infos['id_client']);
            $req_verif->execute();

            

            if ($req_verif->rowCount() == 0) {


                $req = $this->bd->prepare('INSERT INTO discussion(id_client,id_formateur) VALUES(:id_client, :id_formateur)');
                $req->bindValue(':id_formateur', $_SESSION['idutilisateur']);
                $req->bindValue(':id_client', $infos['id_client']);
                $req->execute();

            }

            $req_verif = $this->bd->prepare('SELECT * FROM discussion WHERE id_client = :id_client AND id_formateur = :id_formateur');
            $req_verif->bindValue(':id_formateur', $_SESSION['idutilisateur']);
            $req_verif->bindValue(':id_client', $infos['id_client']);
            $req_verif->execute();

            $req_verif_tab = $req_verif->fetch(PDO::FETCH_ASSOC);

            

            $req2 = $this->bd->prepare('INSERT INTO message(id_discussion, id_utilisateur, texte,date_heure,valideM,lu) VALUES(:id_discussion, :id_utilisateur, :texte, :date_heure, :valideM, :lu)');
            $req2->bindValue(':id_discussion', $req_verif_tab['id_discussion']);
            $req2->bindValue(':id_utilisateur', $_SESSION['idutilisateur']);
            $req2->bindValue(':texte', $infos['message']);
            $req2->bindValue(':date_heure', $infos['date_msg']);
            $req2->bindValue(':valideM', "false");
            $req2->bindValue(':lu', "false");
            $req2->execute();

            $this->bd->commit();


        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

            echo "Erreur : " . $e->getMessage();
            $erreur_type[] = "error_db";
            return $erreur_type;
        }

        $erreur_type[] = "none";
        return $erreur_type;
    }


    public function add_discussion_message_former_affranchi($infos) {

        if (! $infos) {return false;}

        $erreur_type = [];

        try {

            $this->bd->beginTransaction();


            $req_verif = $this->bd->prepare('SELECT * FROM discussion WHERE id_client = :id_client AND id_formateur = :id_formateur');
            $req_verif->bindValue(':id_formateur', $_SESSION['idutilisateur']);
            $req_verif->bindValue(':id_client', $infos['id_client']);
            $req_verif->execute();

            

            if ($req_verif->rowCount() == 0) {


                $req = $this->bd->prepare('INSERT INTO discussion(id_client,id_formateur) VALUES(:id_client, :id_formateur)');
                $req->bindValue(':id_formateur', $_SESSION['idutilisateur']);
                $req->bindValue(':id_client', $infos['id_client']);
                $req->execute();

            }

            $req_verif = $this->bd->prepare('SELECT * FROM discussion WHERE id_client = :id_client AND id_formateur = :id_formateur');
            $req_verif->bindValue(':id_formateur', $_SESSION['idutilisateur']);
            $req_verif->bindValue(':id_client', $infos['id_client']);
            $req_verif->execute();

            $req_verif_tab = $req_verif->fetch(PDO::FETCH_ASSOC);

            

            $req2 = $this->bd->prepare('INSERT INTO message(id_discussion, id_utilisateur, texte,date_heure,valideM,lu) VALUES(:id_discussion, :id_utilisateur, :texte, :date_heure, :valideM, :lu)');
            $req2->bindValue(':id_discussion', $req_verif_tab['id_discussion']);
            $req2->bindValue(':id_utilisateur', $_SESSION['idutilisateur']);
            $req2->bindValue(':texte', $infos['message']);
            $req2->bindValue(':date_heure', $infos['date_msg']);
            $req2->bindValue(':valideM', "true");
            $req2->bindValue(':lu', "false");
            $req2->execute();

            $this->bd->commit();


        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

            echo "Erreur : " . $e->getMessage();
            $erreur_type[] = "error_db";
            return $erreur_type;
        }

        $erreur_type[] = "none";
        return $erreur_type;
    }
    

    public function add_discussion_message_former_admin_moderator($infos) {

        if (! $infos) {return false;}

        $erreur_type = [];

        try {

            $this->bd->beginTransaction();


            $req_verif = $this->bd->prepare('SELECT * FROM discussion WHERE id_client = :id_client AND id_formateur = :id_formateur');
            $req_verif->bindValue(':id_formateur', $_SESSION['idutilisateur']);
            $req_verif->bindValue(':id_client', $infos['id_client']);
            $req_verif->execute();

            

            if ($req_verif->rowCount() == 0) {


                $req = $this->bd->prepare('INSERT INTO discussion(id_client,id_formateur) VALUES(:id_client, :id_formateur)');
                $req->bindValue(':id_formateur', $_SESSION['idutilisateur']);
                $req->bindValue(':id_client', $infos['id_client']);
                $req->execute();

            }

            $req_verif = $this->bd->prepare('SELECT * FROM discussion WHERE id_client = :id_client AND id_formateur = :id_formateur');
            $req_verif->bindValue(':id_formateur', $_SESSION['idutilisateur']);
            $req_verif->bindValue(':id_client', $infos['id_client']);
            $req_verif->execute();

            $req_verif_tab = $req_verif->fetch(PDO::FETCH_ASSOC);

            

            $req2 = $this->bd->prepare('INSERT INTO message(id_discussion, id_utilisateur, texte,date_heure,valideM,lu) VALUES(:id_discussion, :id_utilisateur, :texte, :date_heure, :valideM, :lu)');
            $req2->bindValue(':id_discussion', $req_verif_tab['id_discussion']);
            $req2->bindValue(':id_utilisateur', $_SESSION['idutilisateur']);
            $req2->bindValue(':texte', $infos['message']);
            $req2->bindValue(':date_heure', $infos['date_msg']);
            $req2->bindValue(':valideM', "true");
            $req2->bindValue(':lu', "false");
            $req2->execute();

            $this->bd->commit();


        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

            echo "Erreur : " . $e->getMessage();
            $erreur_type[] = "error_db";
            return $erreur_type;
        }

        $erreur_type[] = "none";
        return $erreur_type;
    }


    public function list_discussions_customers() {

        try {

            $this->bd->beginTransaction();

            $req = $this->bd->prepare('SELECT id_formateur , nom , prenom, mail from utilisateur join discussion on id_formateur=id_utilisateur where id_client=:id_client');
            $req->bindValue(':id_client', $_SESSION['idutilisateur']);
            $req->execute();


            $this->bd->commit();



        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

        
            echo "Erreur : " . $e->getMessage();
            
        }

        return $req->fetchAll(PDO::FETCH_ASSOC);;

    }

    public function list_messages_customers($id_formateur) {

        try {

            $this->bd->beginTransaction();

            $req = $this->bd->prepare('

        SELECT message.id_utilisateur, prenom, nom, mail, texte, date_heure, role, validem
        FROM message
        JOIN discussion USING (id_discussion)
        JOIN utilisateur ON id_client = utilisateur.id_utilisateur
        WHERE id_formateur = :id_formateur AND id_client = :id_client AND validem = :vrai OR validem = :faux AND role = :client ORDER BY date_heure
');


            $req->bindValue(':id_client', $_SESSION['idutilisateur']);
            $req->bindValue(':id_formateur', $id_formateur);
            $req->bindValue(':vrai', 'true');
            $req->bindValue(':faux', 'false');
            $req->bindValue(':client', 'client');
            $req->execute();


            $this->bd->commit();



        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

        
            echo "Erreur : " . $e->getMessage();
            
        }

        return $req->fetchAll(PDO::FETCH_ASSOC);

    }
    public function list_discussions_formers(){
        try {

            $this->bd->beginTransaction();

            $req = $this->bd->prepare('SELECT distinct id_client , nom , prenom, mail from utilisateur join discussion on id_client=id_utilisateur where id_formateur=:id_formateur');
            $req->bindValue(':id_formateur', $_SESSION['idutilisateur']);
            $req->execute();


            $this->bd->commit();



        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

        
            echo "Erreur : " . $e->getMessage();
            
        }

        return $req->fetchAll(PDO::FETCH_ASSOC);;
    }
    public function list_messages_formers($id_client) {

        try {

            $this->bd->beginTransaction();

            $req = $this->bd->prepare('

        SELECT message.id_utilisateur, prenom, nom, mail, texte, date_heure, role, validem
        FROM message
        JOIN discussion USING (id_discussion)
        JOIN utilisateur ON id_formateur = utilisateur.id_utilisateur
        WHERE id_formateur = :id_formateur AND id_client = :id_client AND validem = :vrai OR validem = :faux AND role = :formateur ORDER BY date_heure
');
            $req->bindValue(':id_formateur', $_SESSION['idutilisateur']);
            $req->bindValue(':id_client', $id_client);
            $req->bindValue(':faux', 'false');
            $req->bindValue(':formateur', 'formateur');
            $req->bindValue(':vrai', 'true');
            $req->execute();


            $this->bd->commit();



        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

        
            echo "Erreur : " . $e->getMessage();
            
        }

        return $req->fetchAll(PDO::FETCH_ASSOC);

    }



    public function getAdminsWithLimit($offset = 0, $limit = 25) {
        $req = $this->bd->prepare('Select id_utilisateur,nom, prenom, mail from utilisateur WHERE role = :role ORDER BY id_utilisateur DESC LIMIT :limit OFFSET :offset');
        $req->bindValue(':role', "administrateur");
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNbAdmin()
    {
        $req = $this->bd->prepare('SELECT COUNT(*) FROM utilisateur WHERE role = :admin');
        $req->bindValue(':admin', "administrateur");
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    public function getModeratorsWithLimit($offset = 0, $limit = 25) {
        $req = $this->bd->prepare('Select id_utilisateur,nom, prenom, mail from utilisateur WHERE role = :role ORDER BY id_utilisateur DESC LIMIT :limit OFFSET :offset');
        $req->bindValue(':role', "moderateur");
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNbModerator()
    {
        $req = $this->bd->prepare('SELECT COUNT(*) FROM utilisateur WHERE role = :moderateur');
        $req->bindValue(':moderateur', "moderateur");
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    public function promote($id_formateur) {
        
        try {

            $this->bd->beginTransaction();

            $req = $this->bd->prepare('UPDATE UTILISATEUR
            SET role = :moderateur, est_affranchi = :vrai
            WHERE id_utilisateur = :id_formateur');
            $req->bindValue(':moderateur', 'moderateur');
            $req->bindValue(':vrai', 'true');
            $req->bindValue(':id_formateur', $id_formateur);
            $req->execute();


            $this->bd->commit();



        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

        
            echo "Erreur : " . $e->getMessage();
            
        }


    }

    public function unpromote($id_formateur) {
        
        try {

            $this->bd->beginTransaction();

            $req = $this->bd->prepare('UPDATE UTILISATEUR
            SET role = :formateur, est_affranchi = :faux
            WHERE id_utilisateur = :id_formateur');
            $req->bindValue(':formateur', 'formateur');
            $req->bindValue(':faux', 'false');
            $req->bindValue(':id_formateur', $id_formateur);
            $req->execute();


            $this->bd->commit();



        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

        
            echo "Erreur : " . $e->getMessage();
            
        }


    }

    public function getCustomerInformations($id)
    {
        $requete = $this->bd->prepare('Select id_utilisateur, nom,prenom, mail, telephone, societe, est_affranchi from utilisateur JOIN client ON id_utilisateur = id_client WHERE id_utilisateur = :id');
        $requete->bindValue(':id', $id);
        $requete->execute();
        return $requete->fetchAll();
    }

    public function getCustomersWithLimit($offset = 0, $limit = 25) {
        $req = $this->bd->prepare('Select id_utilisateur,nom, prenom, mail from utilisateur WHERE role = :role ORDER BY id_utilisateur DESC LIMIT :limit OFFSET :offset');
        $req->bindValue(':role', "client");
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNbCustomers()
    {
        $req = $this->bd->prepare('SELECT COUNT(*) FROM utilisateur WHERE role = :client');
        $req->bindValue(':client', "client");
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    public function getEstAffranchiTrueWithLimit($offset = 0, $limit = 25) {
        $req = $this->bd->prepare('Select id_utilisateur,nom, prenom, mail, role from utilisateur WHERE est_affranchi = :est_affranchi AND role != :admin AND role != :moderateur ORDER BY id_utilisateur DESC LIMIT :limit OFFSET :offset');
        $req->bindValue(':est_affranchi', "true");
        $req->bindValue(':admin', "administrateur");
        $req->bindValue(':moderateur', "moderateur");
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNbEstAffranchiTrue()
    {
        $req = $this->bd->prepare('SELECT COUNT(*) FROM utilisateur WHERE est_affranchi = :est_affranchi AND role != :admin AND role != :moderateur');
        $req->bindValue(':est_affranchi', "true");
        $req->bindValue(':admin', "administrateur");
        $req->bindValue(':moderateur', "moderateur");
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    public function getEstAffranchiFalseWithLimit($offset = 0, $limit = 25) {
        $req = $this->bd->prepare('Select id_utilisateur,nom, prenom, mail, role from utilisateur WHERE est_affranchi = :est_affranchi ORDER BY id_utilisateur DESC LIMIT :limit OFFSET :offset');
        $req->bindValue(':est_affranchi', "false");
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNbEstAffranchiFalse()
    {
        $req = $this->bd->prepare('SELECT COUNT(*) FROM utilisateur WHERE est_affranchi = :est_affranchi');
        $req->bindValue(':est_affranchi', "false");
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    public function free($id_utilisateur) {
        
        try {

            $this->bd->beginTransaction();

            $req = $this->bd->prepare('UPDATE UTILISATEUR
            SET est_affranchi = :vrai
            WHERE id_utilisateur = :id_utilisateur');
            $req->bindValue(':vrai', 'true');
            $req->bindValue(':id_utilisateur', $id_utilisateur);
            $req->execute();


            $this->bd->commit();



        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

        
            echo "Erreur : " . $e->getMessage();
            
        }


    }


    public function unfree($id_utilisateur) {
        
        try {

            $this->bd->beginTransaction();

            $req = $this->bd->prepare('UPDATE UTILISATEUR
            SET est_affranchi = :faux
            WHERE id_utilisateur = :id_utilisateur');
            $req->bindValue(':faux', 'false');
            $req->bindValue(':id_utilisateur', $id_utilisateur);
            $req->execute();


            $this->bd->commit();



        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

        
            echo "Erreur : " . $e->getMessage();
            
        }


    }

    public function getFormersUniqueWithLimit($offset = 0, $limit = 25) {

        $req = $this->bd->prepare('Select id_utilisateur,nom, prenom, mail from utilisateur WHERE role = :formateur ORDER BY id_utilisateur DESC LIMIT :limit OFFSET :offset');
        $req->bindValue(':formateur', "formateur");
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->bindValue(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);


    }

    public function discussionList() {

        $req = $this->bd->prepare('SELECT
        D.id_discussion AS id_discussion,
        D.id_formateur AS id_formateur,
        F.nom AS formateur_nom,
        F.prenom AS formateur_prenom,
        F.mail AS formateur_mail,
        D.id_client AS id_client,
        C.nom AS client_nom,
        C.prenom AS client_prenom,
        C.mail AS client_mail
        FROM
            discussion D
        JOIN
            utilisateur F ON D.id_formateur = F.id_utilisateur
        JOIN
            utilisateur C ON D.id_client = C.id_utilisateur');

        $req->execute();

        $id_former_customer = $req->fetchAll(PDO::FETCH_ASSOC);

        return $id_former_customer;

    }

    public function messageList($id_discussion) {
    
        $req = $this->bd->prepare('SELECT
        C.est_affranchi AS client_affranchi,
        F.est_affranchi AS formateur_affranchi,
        M.id_message AS id_message,
        M.id_utilisateur AS id_utilisateur,
        D.id_discussion AS id_discussion,
        D.id_formateur AS id_formateur,
        F.nom AS formateur_nom,
        F.prenom AS formateur_prenom,
        F.mail AS formateur_mail,
        F.role AS formateur_role,
        D.id_client AS id_client,
        C.nom AS client_nom,
        C.prenom AS client_prenom,
        C.mail AS client_mail,
        C.role AS client_role,
        M.texte AS message_texte,
        M.date_heure AS message_date_heure,
        M.valideM AS message_valideM
        FROM
            discussion D
        JOIN
            utilisateur F ON D.id_formateur = F.id_utilisateur
        JOIN
            utilisateur C ON D.id_client = C.id_utilisateur
        JOIN
            message M ON D.id_discussion = M.id_discussion
        WHERE
            D.id_discussion = :id_discussion
        ORDER BY M.date_heure');

        $req->bindValue(':id_discussion', $id_discussion);
        $req->execute();


        $message_former_customer = $req->fetchAll(PDO::FETCH_ASSOC);

        return $message_former_customer;

    }


    public function validemTrue($id_message) {

        try {

            $this->bd->beginTransaction();

            $req = $this->bd->prepare('UPDATE MESSAGE
            SET validem = :vrai
            WHERE id_message = :id_message');
            $req->bindValue(':vrai', 'true');
            $req->bindValue(':id_message', $id_message);
            $req->execute();


            $this->bd->commit();



        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

        
            echo "Erreur : " . $e->getMessage();
            
        }

    }

    public function validemFalse($id_message) {

        try {

            $this->bd->beginTransaction();

            $req = $this->bd->prepare('UPDATE MESSAGE
            SET validem = :faux
            WHERE id_message = :id_message');
            $req->bindValue(':faux', 'false');
            $req->bindValue(':id_message', $id_message);
            $req->execute();


            $this->bd->commit();



        }catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->bd->rollBack();

        
            echo "Erreur : " . $e->getMessage();
            
        }

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
    c1.idC_mere IS NOT NULL and valideT = :true ;
') ;
$req->bindValue(':true' , 'true') ; 
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
public function seeCategories(){
    $req = $this->bd->prepare('SELECT 
        c.idC AS id_categorie,
        c.nomC AS categorie,
        c2.nomC AS categorie_mere
    FROM 
        categorie c
    LEFT JOIN 
        categorie c2 ON c.idC_mere = c2.idC
    WHERE 
        c.idC_mere IS NOT NULL;
    ') ;
    $req->execute();
    $categories = $req->fetchAll(PDO::FETCH_ASSOC);

    $result = array();
    foreach ($categories as $categorie) {
        $id_categorie = $categorie['id_categorie'];
        unset($categorie['id_categorie']);
        $result[$id_categorie] = $categorie;
    }

    return $result;
}
public function createTheme($tab){
    $req= $this->bd->prepare('INSERT INTO theme(nomT , valideT , idC) 
    VALUES (:nomTheme, :valideT , :idC)') ; 
    $req->bindValue(':nomTheme',$tab['theme_contenu']) ; 
    $req->bindValue(':valideT','false') ; 
    $req->bindValue(':idC',$tab['sous_categorie']) ; 
    $req->execute() ; 
    
}
public function seeThemesValides(){
    $req= $this->bd->prepare('SELECT idt , nomt , validet FROM theme WHERE validet=:true') ; 
    $req->bindValue(':true','true') ;
    $req->execute();

    return $req->fetchAll(PDO::FETCH_ASSOC);

}
public function seeThemesNonValides(){
    $req= $this->bd->prepare('SELECT idt , nomt , validet FROM theme WHERE validet=:false') ; 
    $req->bindValue(':false','false') ;
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);

}
public function UpdateTheme(){
    $req= $this->bd->prepare('UPDATE theme SET validet=:true WHERE idt=:idt') ; 
    $req->bindValue(':idt',$_GET['idt']) ;
    $req->bindValue(':true','true') ;
    $req->execute();
}
public function DeleteTheme(){
    $req= $this->bd->prepare('DELETE FROM theme WHERE idt=:idt') ; 
    $req->bindValue(':idt',$_GET['idt']) ;
    $req->execute();
}

}
