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
    $hex_result =gmp_strval($message_dechiffre, 16);
    if (strlen($hex_result) % 2 != 0) {
        $hex_result = '0' . $hex_result;
    }

    return $hex_result;
}

function hexToAscii($hex) {
    $ascii = '';
    for ($i = 0; $i < strlen($hex); $i += 2) {
        $ascii .= chr(hexdec(substr($hex, $i, 2)));
    }
    return $ascii;
}

// Message à chiffrer
$message_original = "Bonjour";
echo 'Message original : '. $message_original .'<br>' ;
// Convertir le message de ascii en hexadécimal
$message_hex = bin2hex($message_original);
echo '<br>' ; 
// Chiffrer le message avec la clé publique
$message_chiffre = chiffrement($message_hex, $e, $n);
echo "Message chiffré : $message_chiffre\n";
echo '<br>' ; 
// Déchiffrer le message avec la clé privée
$message_hex_dechiffre = dechiffrement($message_chiffre, $d, $n);
echo "Résultat hexadécimal déchiffré : $message_hex_dechiffre\n";

// Affichez chaque octet de la chaîne hexadécimale déchiffrée
for ($i = 0; $i < strlen($message_hex_dechiffre); $i += 2) {
    echo "Octet $i: " . substr($message_hex_dechiffre, $i, 2) . "\n";
}

echo '<br>';

$message_dechiffre = hexToAscii($message_hex_dechiffre);
echo "Message déchiffré en ASCII : $message_dechiffre\n";
/*
// Convertir le message déchiffré en ASCII
$message_ascii = hexToAscii($message_dechiffre);
echo "Message déchiffré en ASCII : $message_ascii\n";
*/
?>
