<?php
require_once "Controller.php";
class Controller_list extends Controller{

    public function action_last(){

        // $_POST['categorie'] = valeur du type
        // $_POST['locker'] = type du select
        // $_POST['filtrecategorie'] = valeur du filtre d'avant

        // On instancie le filtre quand on démarre la page
        if(!(isset($_POST['filtrecategorie']))){
            $filtrecat = [];
        }else{
            echo var_dump($_POST['filtrecategorie']);
            $filtrecat = unserialize($_POST['filtrecategorie']);
        }

        if(!(isset($_POST['filtresouscategorie']))){
            $filtresouscat = [];
        }else{
            echo 'feur';
            echo var_dump($_POST['filtresouscategorie']);
            $filtresouscat = unserialize($_POST['filtresouscategorie']);
        }

        if(!(isset($_POST['filtretheme']))){
            $filtretheme = [];
        }else{
            $filtretheme = unserialize($_POST['filtretheme']);
        }


        $filtre = ["categorie"=>$filtrecat, "souscategorie"=>$filtresouscat, "theme"=>$filtretheme];

        // Pour supprimer un élément dans le filtre

        if(isset($_POST['deleteLockerValue'])){
            $filtre[] = $filtre[$_POST['deleteLockerKind']][array_search($_POST['deleteLockerValue'], $filtre[$_POST['deleteLockerKind']])];
            $type = $_POST['deleteLockerKind'];  // Retourne le type choisi
            $valeur = $_POST['deleteLockerValue'];    // Retourne la valeur dans le tableau du type (Ex : Programmation dans categorie )
            $tabtypefiltre = $filtre[$type];    // Retourne le tableau d'un des 3 types dans le filtre
            $idvalasupr = array_search($valeur, $tabtypefiltre);    // Retourne l'id de la valeur dans le tableau du type
            unset($tabtypefiltre[$idvalasupr]);     // supprime la valeur dans le bon type

        }

        // Pour ajouter un élément dans le filtre
        if(isset($_POST['addLockerName']) and !in_array($_POST[$_POST['addLockerName']], $filtre[$_POST['addLockerName']])){
            $filtre[$_POST['addLockerName']][] = $_POST[$_POST['addLockerName']];
            $filtre['ajout'] = $_POST['addLockerName'];
        }



        if(count($filtre['categorie']) == 0){ // Si il n'y a pas encore de categorie choisie
            $valPourRequetecat = 'tout';

        }else{
            $valPourRequetecat = $filtre['categorie'];
        }

       $m = Model::getModel();
        $data = [
            "themes"=>$m->getThemes(),
            "listSousCategories"=>$m->getSousCategories($valPourRequetecat), // Une optimisation au niveau des requêtes peut-être envisagé dans listSousCategories pour prendre toutes les catégories mères même si il n'apparait pas dans le filtre
            "listCategories"=>$m->getCategoriesMeres(),
            "formateurs"=>$m->getFormateurs(),
            "filtre"=>$filtre
        ];
        $this->render("last", $data);
        
    }
    public function action_default(){
        $this->action_last();
    }
    public function action_list_categorieMere(){

        $m = Model::getModel();
        $data = [
            "themes"=>$m->getThemes(),
            "listCategories"=>$m->getCategories(),
            "formateurs"=>$m->getFormateurs(),
        ];
        $this->render("last", $data);
        
    }

}
?>