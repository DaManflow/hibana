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


        function utf8ToBinary($utf8String)
        {
            // Convertit la chaîne UTF-8 en binaire
            $binaryString = mb_convert_encoding($utf8String, '8bit', 'UTF-8');
        
            return $binaryString;
        }


/**
 * Récupère sous forme de tableau les numéros de pages à afficher dans un affichage avec pagination
 * @param int $page_active page qui va être affichée
 * @param int $nb_total_pages nombre total de pages de résultats
 * @return array Contient les numéros de page qui seront affichés
 */
function liste_pages($page_active, $nb_total_pages)
{
    $debut = max($page_active - 5, 1);
    if ($debut === 1) {
        $fin = min(10, $nb_total_pages);
    } else {
        $fin = min($page_active + 4, $nb_total_pages);
    }

    $pages = [];
    for ($i = $debut; $i <= $fin; $i++) {
        $pages[] = $i;
    }
    return $pages;
}
