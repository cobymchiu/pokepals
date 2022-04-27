<?php

class PokemonController {
    private $command;

    private $db;

    public function __construct($command) {

        $this->command = $command;
        $this->db = new Database();
    }

    public function run() {
        switch($this->command) {
            case "explore":
                $this->explore();
                break;
            case "addFriends":
                $this->addFriends();
                break;
            case "sendRequest":
                $this->sendRequest();
                break;
            case "acceptRequest":
                $this->acceptRequest();
                break;
            case "rejectRequest":
                $this->rejectRequest();
                break;
            case "viewRequests":
                $this->viewRequests();
                break;
            /* case "catch":
                $this->catchPokemon();
                break; */
            case "viewFriends":
                $this->viewFriends();
                break;
            case "profile":
                $this->profile();
                break;
            case "modifyPokemon":
                $this->modifyPokemon();
                break;
            case "getTeam":
                $this->getTeam();
                break;
            case "myTeam":
                $this->myTeam();
                break;
            case "getPokemonInfo":
                $this->getPokemonInfo();
                break;
            case "logout":
                $this->destroySession();
                break;
            case "login":
            default:
                $this->login();
                break;
        }
    }

    private function destroySession() {
        $this->clearCookies();
        session_destroy();   
        header("Location: ?command=login");
    }

    private function clearCookies() {
        setcookie("pkmnname", "", time()-3600);
        setcookie("picture", "", time()-3600);
        setcookie("type1", "", time()-3600);
        setcookie("type2", "", time()-3600);
    }

    private function login() {
        $error_msg="";

        if (isset($_POST["email"]) && isset($_POST["name"]) && isset($_POST["password"])) {
            $data = $this->db->query("select * from project_user where email = ?;", "s", $_POST["email"]);
            
            if ($data === false) {
                $error_msg = "<div class='alert alert-danger'>Error checking for user</div>";
            }else if (empty($data)){ //if there is no user then insert them
                if($this->validPass($_POST["password"])){
                    if($this->validEmail($_POST["email"])){
                        $picture = "pictures/profilePics/default.png";
                        $insert = $this->db->query("insert into project_user (username, email, password, picture, bio) values (?, ?, ?, ?, ?);", 
                        "sssss", $_POST["name"], $_POST["email"], 
                        password_hash($_POST["password"], PASSWORD_DEFAULT), $picture, "");
                        if ($insert === false) {
                            $error_msg = "<div class='alert alert-danger'>Error creating account</div>";
                        }
                        $data = $this->db->query("select * from project_user where email = ?;", "s", $_POST["email"]); //reload data after insert
                
                    }else{//email not valid
                        $error_msg = "<div class='alert alert-danger'>invalid email</div>";
                    
                    }
                }else{//pass not valid
                    $error_msg = "<div class='alert alert-danger'>Password must contain a capital letter, lowercase letter, a number, have no special characters, and be 6-15 characters long</div>"; 
                }   
             }
            
            if ($data === false) {
                $error_msg = "<div class='alert alert-danger'><b>Error checking for user </div>";
            } else if (!empty($data)) {
                if (password_verify($_POST["password"], $data[0]["password"])) {
                    $_SESSION["name"] = $data[0]["username"];
                    $_SESSION["email"] = $data[0]["email"];
                    $_SESSION["id"] = $data[0]["id"];
                  
                    header("Location: ?command=explore");
                }else {
                    $error_msg = "<div class='alert alert-danger'>incorrect password</div>";
                }
            } 
        }
        include("templates/login.php");
    }

    private function validPass($pass){
        $pattern="/^(?=.*\d)(?=.*[A-Z])(?!.*[^a-zA-Z0-9])(.{6,15})$/";

        $result= preg_match($pattern, $pass);

        if($result ===1){
            return true;
        }else{
            return false;
        }

    }
    private function validEmail($email){
        $pattern="/^\S+@\S+\.\S+$/";

        $result= preg_match($pattern, $email);

        if($result ===1){
            return true;
        }else{
            return false;
        }

    }
   
 
    private function explore(){
        $user = $this->getCurrentUser();
        
        if(isset($_POST["wild_pokemon"])){
            if($_POST["wild_pokemon"] == "Ignore"){
                // bug: clicking ignore makes the map unclickable
                $this->clearCookies();
               
                header("Location: ?command=explore");
               
                //include("templates/explore.php");
            }else{
                if(isset($_POST["pkmnname"])) {
                    // get the pokemon information
                    $name = $_COOKIE["pkmnname"];
                    $picture = $_COOKIE["picture"];
                    $type1 = $_COOKIE["type1"];
                    $type2 = $_COOKIE["type2"];
                    $insert = $this->db->query("insert into project_caughtpokemon (userid, name, type1, type2, picture, is_on_team) values (?, ?, ?, ?, ?, ?);", 
                                        "issssi", $user["id"], $name, $type1, $type2, $picture, 0);

                    // reset cookies and redirect
                    $this->clearCookies();
                   
                    $_SESSION["recentlycaught"] = true;
                    header("Location: ?command=profile");
                   
                    //set sectoin to be true, in doc.ready
                    // add something to create option to add to team?
                }
            }
        }
      
        include("templates/explore.php");
    }
    private function getCurrentUser(){
        return [
            "name" => $_SESSION["name"],
            "email" => $_SESSION["email"],
            "id" => $_SESSION["id"]
        ];
    }
    private function viewFriends(){
        $user = $this->getCurrentUser();
        $error_msg="";
        $friendList = $this->db->query("select user2 from project_friends where user1=?", "i", $user["id"]);
        // $friendList2 = $this->db->query("select user1 from project_friends where user2=?", "i", $user["id"]);
        $list="";
        if($friendList === false){
            $list="Error retrieving friends";
        }else if (empty($friendList)){
            $list = "No Friends to show";
        }else{

            foreach($friendList as $friendId){
                $friend = $this->db->query("select id, email, picture, bio, username from project_user where id=?", "i", $friendId["user2"]);
                
                if($friend ===false){
                    $error_msg = "<div class='alert alert-danger'>Error loading friends</div>";
                }else{
                    $name = $friend[0]["username"];
                    $id = $friend[0]["id"];
                    $pic = $friend[0]["picture"];
                    
                    $bio = $friend[0]["bio"];
                    $list = $list . "
                    <div class='card friendColumn' style='width: 18rem;'>
                        <img class='card-img-top' src='$pic' alt='Card image cap'>
                        <div class='card-body'>
                            <h5 class='card-title'>@$name</h5>
                            <p class='card-text'>$bio</p>
                            <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#teamModal'>View Team</button>
                        </div>
                    </div>";
               
                    }
                }
                
    
        }
   
        include("templates/viewFriends.php");
    }

    private function profile(){
        $user = $this->getCurrentUser();
        $profiledata = $this->db->query("select id, email, picture, bio, username from project_user where id=?", "i", $user["id"]) ;
        $error_msg = "";

        // setting up user data
        $name = $profiledata[0]["username"];
        $email = $profiledata[0]["email"];
        $id = $profiledata[0]["id"];

        $bio = $profiledata[0]["bio"];
        if(!isset($bio)){
            $bio = "No biography yet.";
        }

        $picture = $profiledata[0]["picture"];
        if($picture == ""){ //default image
            $picture = "pictures/profilePics/default.png"; 
        }

        $totalFriends = sizeof($this->db->query("select user2 from project_friends where user1=?", "i", $user["id"]));

        $filename = "";
        $folder = "";
        // changing profile
        if(isset($_POST["submit"])){
            $filename = $_FILES["profilepicupload"]["name"];
            if (
                !isset($_FILES['profilepicupload']['error']) ||
                is_array($_FILES['profilepicupload']['error'])
            ) {
                    $error_msg = "<div class='alert alert-danger'>Error loading uploading image</div>";
            }
            if($filename != ""){
                $folder = "pictures/profilePics/";
                $target = $folder . basename($_FILES["profilepicupload"]["name"]);
                if(move_uploaded_file($_FILES["profilepicupload"]["tmp_name"], $target)){
                    $error_msg = "<div class='alert alert-danger'>Error loading uploading image</div>";
                }
                $picture = /* "classes/" . */$folder . basename($filename);                
            }


            if(isset($_POST["biography"])){
                $bio = $_POST["biography"];
            }

            

            // put in database
            $insert = $this->db->query("update project_user set bio=?, picture=? where id=?;", "ssi", $bio, $picture, $id);
            header("Location: ?command=profile");
        }

        if(isset($_POST["removepic"])){
            $picture = "";
            $insert = $this->db->query("update project_user set picture=? where id=?;", "si", $picture, $id);
            header("Location: ?command=profile");
        }

        // organizing pokemon data
        $pkmn = $this->db->query("select id, name, type1, type2, picture, is_on_team 
            from project_caughtpokemon where userid=? order by id desc", "i", $user['id']) ;
        // split up into rows of 6
        $temp = array_chunk($pkmn, 6, true);
        $temp = array_slice($temp, 0,3); // should just be three rows
        //$row1 = $temp[0]; $row2 = $temp[1]; $row3 = $temp[2];

        /* $pkmn = json_encode($this->db->query("select id, name, type1, type2, picture, is_on_team 
            from project_caughtpokemon where userid=?", "i", $user['id']), JSON_PRETTY_PRINT | JSON_FORCE_OBJECT) ; */
        $totalpk = sizeof($this->db->query("select id from project_caughtpokemon where userid=?", "i", $user['id']) );
        $team = $this->db->query("select id, name, type1, type2, picture, is_on_team 
        from project_caughtpokemon where userid=? and is_on_team=1 limit 6;", "i", $user['id']) ;


        include("templates/profile.php");
    }

    public function modifyPokemon() {
        $user = $this->getCurrentUser();
        $pkmn = $this->db->query("select id, name, type1, type2, picture, is_on_team 
            from project_caughtpokemon where userid=?", "i", $user['id']) ;
        $error_msg = "";

        // modifying team functions
        if(isset($_POST["teamselect"])){
            // modify
            $this->db->query("update project_caughtpokemon set is_on_team = 1 where id=?", "i", $_POST['pokemonid']);
            header("Location: ?command=profile");
        }
        
        if(isset($_POST["delete"])) {
            // release pokemon
            $this->db->query("delete from project_caughtpokemon where id=?", "i", $_POST['delpokemonid']);
            header("Location: ?command=profile");
        }

        

    }

    public function getPokemonInfo() {
        $user = $this->getCurrentUser();
        $pkmn = $this->db->query("select id, name, type1, type2, picture, is_on_team 
        from project_caughtpokemon where userid=? and is_on_team=1 limit 6;", "i", $user['id']) ;

        if(!isset($pkmn[0])) {
            die("Nothing on team");
        }

        header("Content-type: application/json");
        echo json_encode($pkmn, JSON_PRETTY_PRINT);
    }

    public function myTeam() {
        $user = $this->getCurrentUser();
        $team = $this->db->query("select id, name, type1, type2, picture, is_on_team 
        from project_caughtpokemon where userid=? and is_on_team=1 limit 6;", "i", $user['id']) ;
        $error_msg = "";

        // modifying team functions
        if(isset($_POST["teamselect"])){
            // modify
            $this->db->query("update project_caughtpokemon set is_on_team = 1 where id=?", "i", $_POST['pokemonid']);
            header("Location: ?command=myTeam");
        }
        
        if(isset($_POST["delete"])) {
            // release pokemon
            $this->db->query("delete from project_caughtpokemon where id=?", "i", $_POST['delpokemonid']);
            header("Location: ?command=myTeam");
        }

        include("templates/viewTeam.php");
    }

    private function viewRequests(){
        $user = $this->getCurrentUser();
        $error_msg="";
        $requestList = $this->db->query("select requestfrom from project_friendrequest where requestto=?", "i", $user["id"]);
        
        $list="";
        if($requestList ===false || empty($requestList)){
            $list = "No requests to show";
        }else{

            foreach($requestList as $request){
                $requestor = $this->db->query("select id, email, picture, bio, username from project_user where id=?", "i", $request["requestfrom"]);
               if($requestor===false || empty($requestor)){
                $error_msg = "<div class='alert alert-danger'>Error checking for user</div>";
               }else{
                    $name = $requestor[0]["username"];
                    $id = $requestor[0]["id"];
                    $pic = $requestor[0]["picture"];
                    
                    $bio = $requestor[0]["bio"];
                    $list = $list . "
                    <div class='card friendColumn' style='width: 18rem;'>
                        <img class='card-img-top' src='$pic' alt='Card image cap'>
                        <div class='card-body'>
                            <h5 class='card-title'>@$name</h5>
                            <p class='card-text'>$bio</p>
                            <form action='?command=acceptRequest' method='post'>
                                <div>
                                    <button class='accept btn btn-primary'>Accept</button>
                                    <input id='user_id' type='hidden' name='user_id' value='$id'>
                                </div>
                            </form>
                            <form action='?command=rejectRequest' method='post'>
                                <p>
                                    <button class='btn btn-primary'>Delete</button>
                                    <input id='user_id' type='hidden' name='user_id' value='$id'>
                                </p>
                            </form>
                        </div>
                    </div>";
               }
               
               
            }
        }
    

        include("templates/requestFriends.php");
    }
    private function sendRequest(){
        $user = $this->getCurrentUser();
        if(isset($_POST["user_id"])){
            $stmt = $this->db->query("insert into project_friendrequest (requestfrom, requestto) values (?, ?)", "ii", $user["id"], $_POST["user_id"]);
            if($stmt ===false){
                $error_msg="<div class='alert alert-danger'>Error sending request</div>";
            }else{
               $error_msg= "<div class='alert alert-success'>Friend request sent</div>";
            }
        }
        header("Location: ?command=viewFriends");
        // include("templates/addFriends.php");
    }
    private function rejectRequest(){
        $user = $this->getCurrentUser();
        if(isset($_POST["user_id"])){
            $stmt = $this->db->query("delete from project_friendrequest where requestfrom =? and requestto=?", "ii", $_POST["user_id"], $user["id"]);
            if($stmt ===false){
                $error_msg = "<div class='alert alert-danger'>Error rejecting request</div>";
            }else{
                $error_msg= "<div class='alert alert-success'>Friend request rejected</div>";
             }
        }
        header("Location: ?command=viewRequests");
        // include("templates/addFriends.php");
    }
    private function acceptRequest(){
        $user = $this->getCurrentUser();
        if(isset($_POST["user_id"])){
            $deleterequest = $this->db->query("delete from project_friendrequest where requestfrom =? and requestto=?", "ii", $_POST["user_id"], $user["id"]);
            $addAsFriend = $this->db->query("insert into project_friends (user1, user2) values (?,?)", "ii", $_POST["user_id"], $user["id"]);
            $addAsFriendReciprocal = $this->db->query("insert into project_friends (user1, user2) values (?,?)", "ii",$user["id"], $_POST["user_id"]);
            if($addAsFriend ===false || $addAsFriendReciprocal ===false){
                $error_msg = "<div class='alert alert-danger'>Error adding friend</div>";
            }else{
                $error_msg= "<div class='alert alert-success'>Friend added</div>";
             }
        }
        header("Location: ?command=viewRequests");
        // include("templates/addFriends.php");
    }

    private function addFriends(){
        $user = $this->getCurrentUser();
        $error_msg ="";
        if(isset($_POST["username_search"]) && !empty($_POST["username_search"])){
            $searchMatches = $this->db->query("select username, id, picture, bio from project_user where username LIKE ? and id != ? and id not in (select user2 from project_friends where user1 =?) and id not in (select requestto from project_friendrequest where requestfrom=?)", "ssss", "%".$_POST["username_search"]."%", $user["id"],$user["id"], $user["id"]);
            $list="";
            if($searchMatches ===false){
                $error_msg="<div class='alert alert-danger'>Error searching user</div>";
                
            }else if(empty($searchMatches)){
                $list = "No matches for '".$_POST["username_search"]."'";
            }else{
    
                foreach($searchMatches as $matchingUser){
                    // $friend = $this->db->query("select id, email, picture, name from project_user where id=?", "i", $friendId["user2"]);
                   
                    $name = $matchingUser["username"];
                    $id = $matchingUser["id"];
                    $pic = $matchingUser["picture"];
                    
                    $bio = $matchingUser["bio"];
                    $list = $list . "
                    <div class='card friendColumn' style='width: 18rem;'>
                    <img class='card-img-top' src='$pic' alt='Card image cap'>
                    <div class='card-body'>
                      <h5 class='card-title'>@$name</h5>
                      <p class='card-text'>$bio</p>
                      <form action='?command=sendRequest' method='post'>
                        <button class='btn btn-primary' id='add-friend'>Add Friend</button>
                        <input id='user_id' type='hidden' name='user_id' value='$id'>
                      </form>
                    </div>
                </div>";
                }
                // $list=print_r($friendList);
                }
            
        }else{
            $allUsers = $this->db->query("select username, id, picture, bio from project_user where id != ? and id not in (select user2 from project_friends where user1 =?) and id not in (select requestto from project_friendrequest where requestfrom=?) limit 15", "sss", $user["id"], $user["id"], $user["id"]);
            if($allUsers === false){
                $error_msg =  "<div class='alert alert-danger'>Error displaying users</div>";
                
            }  else if(empty($allUsers)){
                $list = "No users to show";
            }else{
                $list="";
                foreach($allUsers as $randomUser){
                    // $friend = $this->db->query("select id, email, picture, name from project_user where id=?", "i", $friendId["user2"]);
                   
                    $name = $randomUser["username"];
                    $id = $randomUser["id"];
                    $pic = $randomUser["picture"];
                    $bio = $randomUser["bio"];
                    $list = $list . "
                    <div class='card friendColumn' style='width: 18rem;'>
                    <img class='card-img-top' src='$pic' alt='Card image cap'>
                    <div class='card-body'>
                      <h5 class='card-title'>@$name</h5>
                      <p class='card-text'>$bio</p>
                      <form action='?command=sendRequest' method='post'>
                        <button class='btn btn-primary' id='add_friend'>Add Friend</button>
                        <input id='user_id' type='hidden' name='user_id' value='$id'>
                      </form>
                   
                      </div>
                </div>";
                }
                // $list=print_r($friendList);
                }
           
        } 
               
        include("templates/addFriends.php");
    }


   
}