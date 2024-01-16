<?php
require_once "../Utils/functions.php";
require_once "../Crypt/variablesRSA.php";


$messageToEncrypt = "abcd";
echo $messageToEncrypt ; 

// Chiffrement du message
$encryptedBlocks = crypt_manuel($messageToEncrypt);
var_dump($encryptedBlocks) ; 


// Déchiffrement du message
$decryptedMessage = decrypt_manuel($encryptedBlocks);

// Afficher le message déchiffré
echo "Message déchiffré: " . $decryptedMessage . PHP_EOL;
?>