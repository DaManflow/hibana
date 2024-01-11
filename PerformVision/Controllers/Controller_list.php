<?php
require_once "Controller.php";
class Controller_list extends Controller{

    public function action_last(){

        // $_POST['categorie'] = valeur du type
        // $_POST['locker'] = type du select
        // $_POST['filtrecategorie'] = valeur du filtre d'avant

        // On instancie le filtre quand on démarre la page
        if(!(isset($_POST['filtrecategorie']))){
            $filtrecat = null;
        }else{
            $filtrecat = unserialize($_POST['filtrecategorie']);
        }

        if(!(isset($_POST['filtresouscategorie']))){
            $filtresouscat = null;
        }else{
            $filtresouscat = unserialize($_POST['filtresouscategorie']);
        }

        if(!(isset($_POST['filtretheme']))){
            $filtretheme = null;
        }else{
            $filtretheme = unserialize($_POST['filtretheme']);
        }

        if(isset($_POST['deletelocker'])){
            $valeur = explode("_", $_POST['deletelocker']);
            $filtre[] = $valeur;
        }

        $filtre = ["categorie"=>$filtrecat, "souscategorie"=>$filtresouscat, "theme"=>$filtretheme];


        // il faut modifier que select qui est locked

        if(isset($_POST['addlocker'])){
            $filtre[$_POST['addlocker']][] = $_POST[$_POST['addlocker']];
        }




       $m = Model::getModel();
        $data = [
            "themes"=>$m->getThemes(),
            "listCategories"=>$m->getCategories(),
            "formateurs"=>$m->getFormateurs(),
            "filtre"=>$filtre
        ];
        $this->render("last", $data);
        
    }
    public function action_default(){
        $this->action_last();
    }
    public function action_list_categorie(){
        
    }

}
?>