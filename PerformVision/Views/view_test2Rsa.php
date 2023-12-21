<?php require_once "../Utils/functions.php" ; 
$message = "Bonjour";
$encryptedMessage = crypt_biblio($message);
echo "Message chiffré : " . $encryptedMessage;
echo '<br/>' ;

$decryptedMessage = decrypt_biblio($encryptedMessage);
echo "Message déchiffré : " . $decryptedMessage;
?>