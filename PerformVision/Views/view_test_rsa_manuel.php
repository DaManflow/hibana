<?php
require_once "../Utils/functions.php";
//test des méthodes stringtonumber et l'inverse 
$string = "Hello salut salut salut salut salut salut samut ";
$number = stringToNumber($string);
echo $number; 
echo '<br/>' ;
$num = 111427927971288184352394590473234428924778257282826682844946206312050911124615176970402548281114279279712881843523945904732344289247782572828266828449462063120509111246151769704025482811142792797128818435239459047323442892477825728282668284494620631205091112461517697040254828;
$str = numberToString($num);
echo $str;  
//parfait :))

//suite des tests 
$keys = generateRSAKeys(128); // 128 bits pour des fins de démonstration, augmentez pour plus de sécurité

// Message à chiffrer
$message = "Hello, RSA!";

// Chiffrement
$encrypted = encryptRSA($message, $keys['publicKey']);
echo "Message chiffré : $encrypted\n";

// Déchiffrement
$decrypted = decryptRSA($encrypted, $keys['privateKey']);
echo "Message déchiffré : $decrypted\n";

$keys = generateRSAKeys(32) ;
$publicKey = $keys['publicKey'];
$privateKey = $keys['privateKey'];

// Affichage de la clé publique
echo "Clé publique : <pre>" . print_r($publicKey, true) . "</pre>";

// Affichage de la clé privée
echo "Clé privée : <pre>" . print_r($privateKey, true) . "</pre>";



/*
$message = "Bonjour, ceci est un exemple de message.";

$encryptedMessage = encryptRSA($message, $publicKey);
echo "Message chiffré : " . $encryptedMessage . PHP_EOL;
echo '<br/>' ;

$decryptedMessage = decryptRSA($encryptedMessage, $privateKey);
echo "Message déchiffré : " . $decryptedMessage . PHP_EOL;*/
?>