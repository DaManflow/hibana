<?php
//fichiers annexes ./Crypt/clef.hibana et  /Crypt/clef.hibana.private qui contient les clés privés et publiques 
//chiffrer le message 
function crypt_biblio($str) {
    $publicKey = openssl_pkey_get_public(file_get_contents("./Crypt/clef.hibana"));
    openssl_public_encrypt($str,$crypted, $publicKey);
    return base64_encode($crypted);
}

function decrypt_biblio($str) {
    $privateKey = openssl_pkey_get_private(file_get_contents("./Crypt/clef.hibana.private"));
    openssl_private_decrypt(base64_decode($str), $decrypted, $privateKey);
    return $decrypted;
}
?>
