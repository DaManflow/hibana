<?php
require_once "../Utils/functions.php";
require_once "../Crypt/variablesRSA.php";

// Les clés publiques
$var_e = 65537;
$var_n = "76708638958274754648626122012559255693"; // Remplacez par la vraie valeur de la clé publique

// Clé privée
$var_d = "2285404872647808645";

// Convertir les clés en entiers
$e = gmp_init($var_e);
$d = gmp_init($var_d);
$n = gmp_init($var_n);

function chiffrement($message, $e, $n) {
    $message_num = gmp_init($message, 16);
    $message_chiffre = gmp_powm($message_num, $e, $n);
    return gmp_strval($message_chiffre, 16);
}

function dechiffrement($message_chiffre, $d, $n) {
    $message_chiffre_num = gmp_init($message_chiffre, 16);
    $message_dechiffre = gmp_powm($message_chiffre_num, $d, $n);
    return gmp_strval($message_dechiffre, 16);
}

function hexToAscii($hex) {
    $ascii = '';
    foreach (str_split($hex, 2) as $pair) {
        $ascii .= chr(hexdec($pair));
    }
    return $ascii;
}

// Message à chiffrer
$message_original = "Bonjour";

// Convertir le message de ascii en hexadécimal
$message_hex = bin2hex($message_original);

// Chiffrer le message avec la clé publique
$message_chiffre = chiffrement($message_hex, $e, $n);
echo "Message chiffré : $message_chiffre\n";

// Déchiffrer le message avec la clé privée
$message_dechiffre = dechiffrement($message_chiffre, $d, $n);
echo "Message déchiffré en hexadécimal : $message_dechiffre\n";

// Convertir le message déchiffré en ASCII
$message_ascii = hexToAscii($message_dechiffre);
echo "Message déchiffré en ASCII : $message_ascii\n";
?>
