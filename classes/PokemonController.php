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
            case "catch":
                $this->catch();
                break;
            case "viewFriends":
                $this->viewFriends();
                break;
            case "profile":
                $this->profile();
                break;
            case "logout":
                $this->destroySession();
            case "login":
            default:
                $this->login();
        }
    }

    private function destroySession() {
        session_destroy();    
    }

    private function login() {
        $error_msg="";

        if (isset($_POST["email"],$_POST["name"], $_POST["password"] ) && !empty($_POST["email"])  && !empty($_POST["name"])  && !empty($_POST["password"])) { /// validate the email coming in
            $data = $this->db->query("select * from user where email = ?;", "s", $_POST["email"]);
            
            if ($data === false) {
                $error_msg = "<div class='alert alert-danger'>Error checking for user</div>";
            }else if (empty($data)){ //if there is no user then insert them
                if($this->validPass($_POST["password"])){
                    if($this->validEmail($_POST["email"])){
                        $insert = $this->db->query("insert into user (name, email, password) values (?, ?, ?);", 
                        "sss", $_POST["name"], $_POST["email"], 
                        password_hash($_POST["password"], PASSWORD_DEFAULT));
                        if ($insert === false) {
                            $error_msg = "<div class='alert alert-danger'>Error creating account</div>";
                        }
                        $data = $this->db->query("select * from user where email = ?;", "s", $_POST["email"]); //reload data after insert
                
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
                    $_SESSION["name"] = $data[0]["name"];
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
   
    public function catch(){
        echo "called";
        if($_POST["wild_pokemon"]){
            if($_POST["wild_pokemon"] == "Ignore"){
                include("templates/explore.php");
            }else{
                if(isset($_POST["pok"])){
                    $c=$_POST["pok"];
                    echo "<script>console.log('Debug Objects: GOT THE THING $c ' );</script>";
                }
                //insert id into team, take to profile
            }
        }
       
    }
    private function explore(){
      
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

        $friendList = $this->db->query("select user2 from friends where user1=?", "i", $user["id"]);
        $friendList2 = $this->db->query("select user1 from friends where user2=?", "i", $user["id"]);
        $list="";
        if(empty($friendList) && empty($friendList2)){
            $list = "No Friends to show";
        }else{

            foreach($friendList as $friendId){
                $friend = $this->db->query("select id, email, picture, name from user where id=?", "i", $friendId["user2"]);
               
                $name = $friend[0]["name"];
                $id = $friend[0]["id"];
                $pic = $friend[0]["picture"];
                $list = $list . "
                <div class='card friendColumn' style='width: 18rem;'>
                <img class='card-img-top' src='pictures/profilePics/$pic' alt='Card image cap'>
                <div class='card-body'>
                  <h5 class='card-title'>@$name</h5>
                  <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the card content.</p>
                  <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#teamModal'>View Team</button>
                </div>
            </div>";
               
            }
    
            foreach($friendList2 as $friendId){
                $friend = $this->db->query("select id, email, picture, name from user where id=?", "i", $friendId["user1"]);
    
                $name = $friend[0]["name"];
                $id = $friend[0]["id"];
                $pic = $friend[0]["picture"];
                $list = $list . "
                <div class='card friendColumn' style='width: 18rem;'>
                <img class='card-img-top' src='pictures/profilePics/$pic' alt='Card image cap'>
                <div class='card-body'>
                  <h5 class='card-title'>@$name</h5>
                  <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the card content.</p>
                  <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#teamModal'>View Team</button>
                </div>
            </div>";
               
            }
        }
       
        
//         $images = glob("pictures/profilePics/*");

// foreach($images as $image)
// {
//   echo "<img class='card-img-top' src='$image' alt='Card image cap'>";
// }
        include("templates/viewFriends.php");
    }
    private function profile(){
        echo "<script>console.log('Debug Objects: ' );</script>";
        
        include("templates/profile.php");
    }


   
}