<?php 


/**
 * Fonction échappant les caractères html dans $message
 * @param string $message chaîne à échapper
 * @return string chaîne échappée
 */
function e($message)
{
    return htmlspecialchars($message, ENT_QUOTES);
}

function check_data_customer() {

    $infos = [];
    
    if (isset($_POST['name'])) {
        if (! empty(trim($_POST['name']))) {
            
            $infos['name'] = $_POST['name'];
        }
        else {
            return false;
        }
    }

    if (isset($_POST['surname'])) {
        if (! empty(trim($_POST['surname']))) {
            
            $infos['surname'] = $_POST['surname'];
        }
        else {
            return false;
        }
    }
    
    if (isset($_POST['email'])) {
        if (! empty(trim($_POST['email']))) {
            
            $infos['email'] = $_POST['email'];
        }
        else {
            return false;
        }
    }

    $infos['role'] = "client";

    if (isset($_POST['password'])) {
        if (! empty(trim($_POST['password']))) {
            
            $infos['password'] = $_POST['password'];
        }
        else {
            return false;
        }
    }

    $infos['estaffranchi'] = "false";
    
    
    
    return $infos;
    
    }


    function check_data_former() {

        $infos = [];
        
        if (isset($_POST['name'])) {
            if (! empty(trim($_POST['name']))) {
                
                $infos['name'] = $_POST['name'];
            }
            else {
                return false;
            }
        }
    
        if (isset($_POST['surname'])) {
            if (! empty(trim($_POST['surname']))) {
                
                $infos['surname'] = $_POST['surname'];
            }
            else {
                return false;
            }
        }
        
        if (isset($_POST['email'])) {
            if (! empty(trim($_POST['email']))) {
                
                $infos['email'] = $_POST['email'];
            }
            else {
                return false;
            }
        }
    
        $infos['role'] = "formateur";
    
        if (isset($_POST['password'])) {
            if (! empty(trim($_POST['password']))) {
                
                $infos['password'] = $_POST['password'];
            }
            else {
                return false;
            }
        }
    
        $infos['estaffranchi'] = "false";

        if (isset($_POST['linkedin'])) {
            if (! empty(trim($_POST['linkedin']))) {
                
                $infos['linkedin'] = $_POST['linkedin'];
            }
            else {
                return false;
            }
        }

        if (isset($_FILES['cv'])) {
            if (! empty(($_FILES['cv']))) {
                
                $infos['cv'] = $_FILES['cv'];
            }
            else {
                return false;
            }
        }
        
        
        
        
        return $infos;
        
        }
        function crypt_biblio($str) {
            $publicKey = openssl_pkey_get_public(file_get_contents("../Crypt/clef.hibana"));
            openssl_public_encrypt($str,$crypted, $publicKey);
            return base64_encode($crypted);
        }
        
        function decrypt_biblio($str) {
            $privateKey = openssl_pkey_get_private(file_get_contents("../Crypt/clef.hibana.private"));
            openssl_private_decrypt(base64_decode($str), $decrypted, $privateKey);
            return $decrypted;
        }
        

        ?>
        
        

