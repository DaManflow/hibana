<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Chemin de la clé publique
$publicKeyPath = "C:\\wamp64\\bin\\php\\php8.2.13\\openssl\\clef.hibana";

// Vérifie si le fichier de clé publique existe
if (!file_exists($publicKeyPath)) {
    die("Fichier de clé publique introuvable : $publicKeyPath");
}

// Lit le contenu du fichier de clé publique
$publicKeyContent = file_get_contents($publicKeyPath);

if ($publicKeyContent === false) {
    die("Impossible de lire le fichier de clé publique : $publicKeyPath");
}

// Charge la clé publique
$publicKey = openssl_pkey_get_public($publicKeyContent);

// Vérifie si la clé publique est valide
if ($publicKey !== false) {
    echo 'Clé publique chargée avec succès';

    // Chiffre et déchiffre
    $plaintext = "1";
    openssl_public_encrypt($plaintext, $crypted, $publicKey);
    echo '<br>';
    echo 'Message Crypté : \n' ;
    echo base64_encode($crypted);
    echo '<br>';

    // Chemin de la clé privée
$privateKeyPath = "C:\\wamp64\\bin\\php\\php8.2.13\\openssl\\clef.hibana.private";

// Vérifie si le fichier de clé privée existe
if (!file_exists($privateKeyPath)) {
    die("Fichier de clé privée introuvable : $privateKeyPath");
}

// Lit le contenu du fichier de clé privée
$privateKeyContent = file_get_contents($privateKeyPath);
// Charge la clé privée
$privateKey = openssl_pkey_get_private($privateKeyContent);
    // Déchiffre avec la clé privée
    openssl_private_decrypt($crypted, $decrypted, $privateKey);
    echo 'Message décrypté :  ' ;
    echo $decrypted;
} else {
    echo 'Erreur : Impossible de charger la clé publique';
}


?>

