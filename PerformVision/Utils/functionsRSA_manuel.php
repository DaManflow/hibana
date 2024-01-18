<?php
// voici les fonctions de chiffrement manuel des mot de passe avec la méthode RSA
//RSA : En premier générer les clés publique et privé 
function generateRSAKeys($bitLength) {
    $p = generatePrime($bitLength);
    $q = generatePrime($bitLength);
//multiplication , substraction
    $n = gmp_mul($p, $q);
    $phi = gmp_mul(gmp_sub($p, 1), gmp_sub($q, 1));

    $e = findCoprime($phi);
    $d = modInverse($e, $phi);
//renvoyer les valeurs 
    return [
        'publicKey' => compact('e', 'n'),
        'privateKey' => compact('d', 'n'),
        'autres'=> compact('p' , 'q' , 'phi')
    ];
}
//générer des nombres premiers 
function generatePrime($bitLength) {
    do {
        $randomNumber = gmp_random_bits($bitLength);
    } while (!gmp_prob_prime($randomNumber, 50));

    return gmp_strval($randomNumber);
}
//trouver un nombre premier $e avec $phi 
function findCoprime($phi) {
    $e = gmp_init(5); //valeur par défaut 
    $phi = gmp_intval($phi);
    
    while (gmp_cmp(gmp_gcd($e, gmp_init($phi)), 1) != 0) {
        $e = gmp_add($e, 1);
    }

    return gmp_strval($e);
}
//inverse modulaire
function modInverse($a, $m) {
    return gmp_intval(gmp_invert($a, $m));
}

//La fonction pour chiffrer un message passé en paramètre 
function crypt_manuel($message) {
    $e = gmp_init(5);
    $n = gmp_init("3890858955378152207");
    $blocks = convertMessageToBlocks($message);
    $encryptedBlocks = [];

    foreach ($blocks as $block) {
        $encryptedBlock = gmp_powm($block, $e, $n);
        $encryptedBlocks[] = $encryptedBlock;
    }
    return convertBlocksToPassword($encryptedBlocks) ; 
}

function convertMessageToBlocks($message) {
    $blocks = [];
    for ($i = 0; $i < strlen($message); $i++) {
        $blocks[] = gmp_init(ord($message[$i])); 
    }
    return $blocks;
}

// Fonction pour convertir des blocs de nombres en message
function convertBlocksToMessage($blocks) {
    $message = '';
    foreach ($blocks as $block) {
    // Afficher la valeur numérique du bloc déchiffré
        $message .= chr(gmp_intval($block)); 
    }
    return $message;
}
function convertBlocksToPassword($blocks){
    $message = '';
    foreach ($blocks as $block) {
    // Afficher la valeur numérique du bloc déchiffré
        $message .= gmp_intval($block).' '; 
    }
     // Nouvelle ligne pour la clarté dans l'affichage
    return trim($message);
}

// Fonction pour déchiffrer un message chiffré passé également en paramètre
function decrypt_manuel($encryptedMessage) {
    $d = gmp_init("3112687161145476077");
    $n = gmp_init("3890858955378152207");
    // Convertir la chaîne de caractères en blocs de nombres
    $encryptedBlocks = convertPasswordToBlocks($encryptedMessage);

    $decryptedBlocks = [];

    // Déchiffrer chaque bloc
    foreach ($encryptedBlocks as $block) {
        $decryptedBlock = gmp_powm($block, $d, $n);
        $decryptedBlocks[] = $decryptedBlock;
    }

    // Retourner le message déchiffré
    return convertBlocksToMessage($decryptedBlocks);
}

// Fonction pour convertir une chaîne de caractères en blocs de nombres
function convertPasswordToBlocks($password) {
    $blocks = [];
    $numbers = explode(' ', trim($password));

    foreach ($numbers as $number) {
        $blocks[] = gmp_init($number);
    }

    return $blocks;
}
?>
