<?php
require_once "../Utils/functions.php";

// Spécifier la longueur des clés (en bits)
$bitLength = 128;

// Générer les clés
$keys = generateRSAKeys($bitLength);

// Message à chiffrer
$messageToEncrypt = 'Hello, RSA!';

// Chiffrer le message
$encryptedMessage = encryptRSA($messageToEncrypt, $keys['publicKey']);

// Afficher le message chiffré
echo 'Message initial : ' . $messageToEncrypt . PHP_EOL;
echo 'Message chiffré : ' . $encryptedMessage . PHP_EOL;

// Déchiffrer le message
$decryptedMessage = decryptRSA($encryptedMessage, $keys['privateKey']);

// Afficher le message déchiffré
echo 'Message déchiffré : ' . $decryptedMessage . PHP_EOL;


//test des méthodes stringtonumber et l'inverse 
/*
$string = "Hello salut salut salut salut salut salut samut ";
$number = stringToNumber($string);
echo $number; 
echo '<br/>' ;
$num = 111427927971288184352394590473234428924778257282826682844946206312050911124615176970402548281114279279712881843523945904732344289247782572828266828449462063120509111246151769704025482811142792797128818435239459047323442892477825728282668284494620631205091112461517697040254828;
$str = numberToString($num);
echo $str;  
//parfait :))*/
/*
//suite des tests 
$keys = generateRSAKeys(32); 

// Message à chiffrer
$message = "Hello, RSA!";
echo "Le message initial est $message \n" ;

// Chiffrement
$encrypted = encryptRSA($message, $keys['publicKey']);
echo "Message chiffré : ".$encrypted. PHP_EOL;

// Déchiffrement
$decrypted = decryptRSA($encrypted, $keys['privateKey']);
echo "Message déchiffré : " .$decrypted."\n";

$keys = generateRSAKeys(32) ;
$publicKey = $keys['publicKey'];
$privateKey = $keys['privateKey'];

// Affichage de la clé publique
echo "Clé publique : <pre>" . PHP_EOL ; 
print_r($publicKey, true) . "</pre>";

// Affichage de la clé privée
echo "Clé privée : <pre>" . PHP_EOL ;
print_r($privateKey, true) . "</pre>";

$result = modPow(2, 3, 5);
echo "Résultat de modPow : " . $result . PHP_EOL;

$inverse = modInverse(3, 7);
echo "Inverse de 3 modulo 7 : " . $inverse . PHP_EOL;
*/

?>