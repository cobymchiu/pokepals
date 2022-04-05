<?php
//used template files from class and reused login components from previous homeworks
// server url: https://cs4640.cs.virginia.edu/cc6hkb/cs4640-project/
// extra credit google cloud url: https://storage.googleapis.com/cs4640-pokepals/index.html
//https://stackoverflow.com/questions/17122218/get-all-the-images-from-a-folder-in-php
//https://stackoverflow.com/questions/23711508/regular-expression-to-match-at-least-one-capital-letter-and-at-least-one-digit-a
//https://stackoverflow.com/questions/19345689/mysql-exclude-all-blocked-users-from-the-results
session_start();
// Register the autoloader
spl_autoload_register(function($classname) {
    include "classes/$classname.php";
});


$command = "login";
if (isset($_GET["command"]))
    $command = $_GET["command"];

if (!isset($_SESSION["email"]) || !isset($_SESSION["name"])) {
    $command = "login";
}

// Instantiate the controller and run
$pokemon = new PokemonController($command);
$pokemon->run();