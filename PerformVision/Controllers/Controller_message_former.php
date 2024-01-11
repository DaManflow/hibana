<?php
require_once "Controller.php";
class Controller_message_former extends Controller{
    public function action_mes_messages() {
        $this->render("mes_messages");
    }
    public function action_default(){
        $this->action_mes_messages();
    }

    
}
?>