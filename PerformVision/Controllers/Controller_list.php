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
            $filtrecat = $_POST['filtrecategorie'];
        }

        if(!(isset($_POST['filtresouscategorie']))){
            $filtresouscat = null;
        }else{
            $filtresouscat = $_POST['filtresouscategorie'];
        }

        if(!(isset($_POST['filtretheme']))){
            $filtretheme = null;
        }else{
            $filtretheme = $_POST['filtretheme'];
        }

        $filtre = ["categorie"=>$filtrecat, "souscategorie"=>$filtresouscat, "theme"=>$filtretheme];


        // il faut modifier que select qui est locked

        if(isset($_POST['locker'])){
            $filtre[$_POST['locker']] = $_POST[$_POST['locker']];
        }


        /*if(isset($_POST['filtre'.$_POST['locker']])){
            $filtre[$_POST['filtre'.$_POST['locker']]] = $_POST[$_POST['locker']];
        }*/


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