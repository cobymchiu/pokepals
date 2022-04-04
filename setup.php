<?php

// Register the autoloader
spl_autoload_register(function($classname) {
    include "classes/$classname.php";
});

$db = new mysqli(Config::$db["host"],
                Config::$db["user"], Config::$db["pass"], 
                Config::$db["database"]);

//verify username is certain length
$db->query("drop table if exists project_user;");
if($db->query("create table project_user (
    id int not null auto_increment,
    email text not null, 
    username text not null,
    password text not null,
    picture text not null,
    bio varchar(255),
    primary key (id)
);")){
    echo "created user table<br>";
} else {
    echo "error creating user table<br>";
}

$db->query("drop table if exists project_friends;");
if($db->query("create table project_friends (
    user1 int not null,
    user2 int not null,
    primary key (user1, user2)
);")){
    echo "created friends table<br>";
} else {
    echo "error creating friends table<br>";
}

$db->query("drop table if exists project_friendRequest;");
if($db->query("create table project_friendRequest (
    requestfrom int not null,
    requestto int not null,
    primary key (requestfrom, requestto)
);")) {
    echo "created friendrequest table<br>";
} else {
    echo "error creating friendrequest table<br>";
}

// table to store all caught pokemon
// includes a boolean to determine which are on the team
$db->query("drop table if exists project_caughtPokemon;");
if($db->query("create table project_caughtPokemon (
    id int auto_increment,
    userid int not null, -- the user who caught the pokemon
    name text not null,
    type1 text not null,
    type2 text not null,
    picture text not null,
    is_on_team bit not null, -- stores team status as bit https://www.databasestar.com/sql-boolean-data-type/#:~:text=There%20is%20no%20boolean%20data,TRUE%20and%200%20for%20FALSE.
    -- add more information as we see fit
    primary key(id)
);")) {
    echo "created caughtpokemon table<br>";
} else {
    echo "error creating caughtpokemon table<br>";
}