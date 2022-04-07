<?php
// server url: https://cs4640.cs.virginia.edu/cc6hkb/cs4640-project/
// extra credit google cloud url: https://cs4640project-poke.uk.r.appspot.com/

//Sources
//used template files from class and reused login components from previous homeworks
//https://stackoverflow.com/questions/17122218/get-all-the-images-from-a-folder-in-php
//https://stackoverflow.com/questions/23711508/regular-expression-to-match-at-least-one-capital-letter-and-at-least-one-digit-a
//https://stackoverflow.com/questions/19345689/mysql-exclude-all-blocked-users-from-the-results

//Helpers
//Nour Goulmamine (ng9sc)-helped arrange database schema for friend adding
//Christian Riewerts(car2xz) - helped create the regex for password validation

session_start();
// Register the autoloader
spl_autoload_register(function($classname) {
    include "classes/$classname.php";
});

/* switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':                   // URL (without file name) to a default screen
       require 'login.php';
       break; 
    default:
       http_response_code(404);
       exit('Not Found');
 }   */

$command = "login";
if (isset($_GET["command"]))
    $command = $_GET["command"];

if (!isset($_SESSION["email"]) || !isset($_SESSION["name"])) {
    $command = "login";
}


// Instantiate the controller and run
$pokemon = new PokemonController($command);
$pokemon->run();