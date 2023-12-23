<?php
require_once "../Utils/functions.php";
$keys = generateRSAKeys(256);
$publicKey = $keys['publicKey'];
$privateKey = $keys['privateKey'];

echo 'la clé publique' ;
echo '<br/>' ;
echo $publicKey ;
echo '<br/>' ;
echo 'la clé privé' ;
echo '<br/>' ;
echo $privateKey ;
echo '<br/>' ;


/*$message = "Bonjour, ceci est un exemple de message.";

$encryptedMessage = encryptRSA($message, $publicKey);
echo "Message chiffré : " . $encryptedMessage . PHP_EOL;

$decryptedMessage = decryptRSA($encryptedMessage, $privateKey);
echo "Message déchiffré : " . $decryptedMessage . PHP_EOL;*/
?>