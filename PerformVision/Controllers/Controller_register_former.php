<?php
require_once "Controller.php";
require_once "./Utils/functions.php";
class Controller_register_former extends Controller{

    public function action_form_register_former() {

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }
        $m = Model::getModel();
        $data =[
            'categoriesMeres' => $m->getCategoriesMeres(),
            'tous'=>$m->getCategoriesWithSubcategoriesAndThemes2(),
        ];
        $this->render("form_register_former",$data);

    }

    public function action_default(){
        $this->action_form_register_former();
    }

    public function action_register_former(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }


        if (isset($_POST['submit'])) {


            $m = Model::getModel();
            $tab = check_data_former();
            

            
            


                if ($tab['name'] == 'false') {
                    echo "Le nom n'est pas valide. Assurez-vous d'entrer uniquement des caractères alphabétiques.";
                    $this->render("form_register_former");
                    
                }
                        
                elseif ($tab['surname'] == 'false') {
                    echo "Le prénom n'est pas valide. Assurez-vous d'entrer uniquement des caractères alphabétiques.";
                    $this->render("form_register_former");
                    
                }
    
                elseif ($tab['email'] == 'false') {
                    echo "Adresse email non conforme !!";
                    $this->render("form_register_former");
                    
                }

                elseif ($tab['phone'] == 'false') {
                    echo "Numéro de téléphone non conforme !";
                    $this->render("form_register_former");
                    
                }
    
                elseif ($tab['password'] == 'false') {
                    echo "Mot de passe non conforme !!";
                    $this->render("form_register_former");
                    
                }
    
                elseif ($tab['linkedin'] == 'false') {
                    echo "Linkedin non conforme !!";
                    $this->render("form_register_former");
                    
                }

                elseif ($tab['cv']['type'] == 'false') {
                    echo "Le CV doit être au format pdf !";
                    $this->render("form_register_former");
                    
                }

                elseif ($tab['cv'] == 'false') {
                    echo "CV non conforme !!";
                    $this->render("form_register_former");
                    
                }

                elseif ($tab['date_signature'] == 'false') {
                    echo "Veuillez signer !";
                    $this->render("form_register_former");
                    
                }


            $rep = $m->createFormer($tab);
             //a avoir si je peux lappeler dans la balise du submit 
            
            if (in_array("none",$rep)) {

                
               /* $nomPrenom = $name.$surname;

                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\Exception;

                require './Mail/PHPMailer/PHPMailer/src/Exception.php';
                require './Mail/PHPMailer/PHPMailer/src/PHPMailer.php';
                require './Mail/PHPMailer/PHPMailer/src/SMTP.php';

                // Informations sur l'utilisateur
                $destinataire_email = $tab['email'];
                $nom_utilisateur = $nomPrenom;

                // Paramètres de l'e-mail
                $sujet = 'Confirmation d\'inscription';
                $message = "Bienvenue, $nom_utilisateur! Merci de vous être inscrit.";

                // Configurer PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // Paramètres du serveur SMTP
                    $mail->isSMTP();
                    $mail->Host = 'localhost'; // L'adresse du serveur SMTP local
                    $mail->SMTPAuth = true;
                    $mail->Username = 'hibana.sae@gmail.com';  // Remplacez par votre adresse e-mail
                    $mail->Password = '1234';  // Remplacez par votre mot de passe
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 1025; // Le port par défaut utilisé par MailHog

                    // Destinataire
                    $mail->setFrom('hibana.sae@gmail.com', 'Hibana');  // Remplacez par votre adresse e-mail et votre nom
                    $mail->addAddress($destinataire_email, $nom_utilisateur);

                    // Contenu de l'e-mail
                    $mail->isHTML(true);
                    $mail->Subject = $sujet;
                    $mail->Body = $message;

                    // Envoyer l'e-mail
                    $mail->send();

                    echo "Un e-mail de confirmation a été envoyé à $destinataire_email.";
                } catch (Exception $e) {
                    echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
                }
                */

                header("Location: ?controller=home_former&action=home_former");
                exit;
                
            }
            else {

                if (in_array("error_db",$rep)) {
                    echo "La transaction à été annulée";
                    $this->render("form_register_former");
                }
                if (in_array("id_already_take",$rep)) {
                    echo "Identifiant déjà pris !";
                    $this->render("form_register_former");
                }
            }
            
        }
        else {

            if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
                header("Location: ?controller=home_customer&action=home_customer");
            }
    
            if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
                header("Location: ?controller=home_former&action=home_former");
            }

            if (!isset($_SESSION['idutilisateur'])) {
                header("Location: ?controller=home&action=home");
            }

        }

        

    }

    
    
}
?>