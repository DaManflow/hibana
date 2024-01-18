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
            $filtrecat = unserialize($_POST['filtrecategorie']);
        }

        if(!(isset($_POST['filtresouscategorie']))){
            $filtresouscat = [];
        }else{
            $filtresouscat = unserialize($_POST['filtresouscategorie']);
        }

        if(!(isset($_POST['filtretheme']))){
            $filtretheme = [];
        }else{
            $filtretheme = unserialize($_POST['filtretheme']);
        }


        $filtre = ["categorie"=>$filtrecat, "souscategorie"=>$filtresouscat, "theme"=>$filtretheme];



        // Algorithme pour ajouter un élément dans le filtre

        if(isset($_POST['addLockerName'])){
            if(isset($_POST['addLockerCat'])){
                $_POST['addLockerCat'] = implode(' ', explode('_', $_POST['addLockerCat']));
                if(isset($_POST['addLockerSousCat'])){ // si on veut ajouter un theme
                    $_POST['addLockerSousCat'] = implode(' ', explode('_', $_POST['addLockerSousCat']));
                    if(!in_array($_POST[$_POST['addLockerName']], $filtre[$_POST['addLockerName']])){
                        $filtre[$_POST['addLockerName']][$_POST['addLockerSousCat']][] = $_POST[$_POST['addLockerName']];
                    }
                }else{ // si on veut ajouter une sous catégorie
                    if(!in_array($_POST[$_POST['addLockerName']], $filtre[$_POST['addLockerName']])){
                        $filtre[$_POST['addLockerName']][$_POST['addLockerCat']][] = $_POST[$_POST['addLockerName']];
                    }
                }

            }else{ // si on veut ajouter une categorie
                if(!in_array($_POST[$_POST['addLockerName']], $filtre[$_POST['addLockerName']])){
                    $filtre[$_POST['addLockerName']][] = $_POST[$_POST['addLockerName']];
                }
            }

            $filtre['ajout'] = $_POST['addLockerName'];
        }


        // Pour supprimer un élément dans le filtre

        if(isset($_POST['deleteLockerValue'])){
            $_POST['deleteLockerSubval'] = implode(' ', explode('_', $_POST['deleteLockerSubval']));

            if($_POST['deleteLockerSubval'] == 0){ // si c'est une sous-catégorie à supprimer
                $idcat = array_search($_POST['deleteLockerValue'], $filtre[$_POST['deleteLockerKind']]);
                unset($filtre['categorie'][$idcat]); // on supprime la catégorie
                if(isset($filtre['souscategorie'][$_POST['deleteLockerValue']])){ // si la catégorie existe dans le filtre sous catégorie
                    foreach ($filtre['souscategorie'][$_POST['deleteLockerValue']] as $sc){
                        if(in_array($sc, $filtre['theme'])){ // si la sous catégorie existe dans le filtre theme
                            unset($filtre['theme'][$sc]); // on supprime tous les thèmes des sous catégories de la catégorie à supprimer
                        }
                    }
                    unset($filtre['souscategorie'][$_POST['deleteLockerValue']]); // on supprime les sous catégories de la catégories

                }


            }else if($_POST['deleteLockerKind'] == 'souscategorie'){ // si c'est une sous-categorie ou un thème à supprimer
                $_POST['deleteLockerValue'] = trim(explode(':', $_POST['deleteLockerValue'])[1]);
                $idsouscat = array_search($_POST['deleteLockerValue'], $filtre[$_POST['deleteLockerKind']][$_POST['deleteLockerSubval']]);
                unset($filtre[$_POST['deleteLockerKind']][$_POST['deleteLockerSubval']][$idsouscat]);     // supprime la valeur dans le bon type
            }
        }


        if(count($filtre['categorie']) == 0){ // Si il n'y a pas encore de categorie choisie
            $valPourRequetecat = 'tout';

        }else{
            $valPourRequetecat = $filtre['categorie'];
        }

        if(count($filtre['souscategorie']) == 0){
            $valPourRequetesc = 'tout';
        }else{
            $valPourRequetesc = "''";
            foreach ($filtre['theme'] as $sc){
                foreach ($sc as $t){
                    $valPourRequetesc .= ",'".$t."'";
                }
            }
        }

        if(count($filtre['theme']) == 0){
            $valPourRequetetheme = 'tout';
        }else{
            $valPourRequetetheme = "''";
            foreach ($filtre['theme'] as $sc){
                foreach ($sc as $t){
                    $valPourRequetetheme .= ",'".$t."'";
                }
            }
        }

       $m = Model::getModel();
        $data = [
            "themes"=>$m->getThemes($valPourRequetesc),
            "listSousCategories"=>$m->getSousCategories($valPourRequetecat), // Une optimisation au niveau des requêtes peut-être envisagé dans listSousCategories pour prendre toutes les catégories mères même si il n'apparait pas dans le filtre
            "listCategories"=>$m->getCategoriesMeres(),
            "experiences"=>$m->getExpercienceByTheme($valPourRequetetheme),
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
