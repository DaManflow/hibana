<?php
require_once "../Utils/functions.php";
//ceci est une vue pour generer les clés privé et public !! son execution peut prendre un peu de temps 

$bitLength = 4096;

// Générer les clés
$keys = generateRSAKeys($bitLength);

// Afficher la clé publique
echo 'Clé publique : ' . PHP_EOL;
echo 'e : ' . $keys['publicKey']['e'] . PHP_EOL;
echo 'n : ' . $keys['publicKey']['n'] . PHP_EOL;

// Afficher la clé privée
echo 'Clé privée : ' . PHP_EOL;
echo 'd : ' . $keys['privateKey']['d'] . PHP_EOL;
echo 'n : ' . $keys['privateKey']['n'] . PHP_EOL;

//Afficher les autres variables p , q , phi 
echo 'Autres : ' . PHP_EOL;
echo 'p : ' . $keys['autres']['p'] . PHP_EOL;
echo 'q : ' . $keys['autres']['q'] . PHP_EOL;
echo 'phi : ' . $keys['autres']['phi'] . PHP_EOL;

var_dump($keys) ;

?>