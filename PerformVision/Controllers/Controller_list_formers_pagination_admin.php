<?php
class Controller_list_formers_pagination_admin extends Controller{
    
    public function action_list_all_formers_admin(){

        $m = Model::getModel();

        $start = 1;
        $nb_pages = intval(($m->getNbFormer())/25) + 1;
        if($nb_pages <= 0){ $nb_pages = 1; }

        if( isset($_POST["start"]) && preg_match("/^\d+$/",$_POST["start"]) && $_POST["start"] > 0 ){ 
            if( $_POST["start"] < $nb_pages){ $start = $_POST["start"];}
            elseif($_POST["start"] >= $nb_pages){ $start = $nb_pages;}
        }      

    $data = ["tab" => $m->getFormersWithLimitVerifModerator($start), "start" => $start, "nb_pages" => $nb_pages];
        $this->render("list_all_formers_pagination_admin", $data);

    }

    public function action_default(){
        $this->action_list_all_formers_admin();
    }
}
?>
