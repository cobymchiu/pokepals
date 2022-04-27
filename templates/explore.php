
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">  
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

        <meta name="author" content="Selena Johnson scj4ve">
        <meta name="description" content="map with clickable areas to catch pokemon">
        <meta name="keywords" content="feature page for sprint 2">        

        <!--https://stackoverflow.com/questions/52130918/web-api-error-this-request-has-been-blocked-the-content-must-be-served-over-h-->
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    
        <link rel="stylesheet/less" type="text/css" href="styles/styles.less" />
        <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity= "sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"> </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="scripts/jquery.rwdImageMaps.min.js"></script>
        <title>Explore</title>

        <!--source:https://stackoverflow.com/questions/18712338/make-header-and-footer-files-to-be-included-in-multiple-html-pages-->
        <script> 
            $(function(){
              $("#header").load("header.html"); 
              $("#footer").load("footer.html"); 
            });
        </script> 

<script>
    var pokemon= {
        name:"",
        type1:"",
        type2:"",
        pic:"",
        back_pic:""
    };
    const caughtPokemon = () => alert(pokemon.name+" was caught!");
    $(document).ready(function(e) {
        // console.log($("#catch").html());
        // $("#img01").hover(alert("hovering"));4
        var img = document.getElementById('img01');
        img.addEventListener('mouseenter', function() {
            this.src = pokemon.back_pic;
        }, false);

        img.addEventListener('mouseleave', function() {
            this.src = pokemon.pic;
        }, false);

        $('img[usemap]').rwdImageMaps(); //resize when document size is changed
        $("#catch").click(caughtPokemon)
        $('area').on('click', async function() { //do this when an area is clicked
            $(".modal-body").html("Searching for Pokemon...");
            // call for pokemon of a certain type
            var pokemon_type = this.id;
            // console.log(pokemon_type)
            const api_url = "https://pokeapi.co/api/v2/type/" + pokemon_type;
            const response = await fetch(api_url);
            const data = await response.json();

            // see how many pokemon were returned and randomly select one
            const length = data["pokemon"].length;
            const random_num = Math.floor(Math.random() *length);
            const chosen_pokemon_name = data["pokemon"][random_num]["pokemon"]["name"]

            // send this pokemon's name to the modal body
            const pokemon_details = await fetch("https://pokeapi.co/api/v2/pokemon/"+chosen_pokemon_name);
            const result = await pokemon_details.json();
            console.log(result); //stats 0125
            var stats_list =[];
            result["stats"].forEach(stat => {
                stats_list.push([stat["base_stat"],stat['stat']])
            })
            console.log(stats_list);
            var types_list=[];
            
            result["types"].forEach(element => {
                types_list.push(element["type"]["name"])
            });
            // console.log("res is ", result);
            // console.log("res is ", result["id"]);
            var modalImg = document.getElementById("img01"); //space where picture will go in the modal
            modalImg.src = result["sprites"]["front_default"]; //url for image
            var labelName = document.getElementById("wild_pokemon_id");
            labelName.value = result["id"];
            $(".modal-body").html(chosen_pokemon_name +" <br>"+ types_list);
            pokemon.name=chosen_pokemon_name;
            pokemon.type1=types_list[0];
            pokemon.type2=types_list[1];
            pokemon.pic =result["sprites"]["front_default"];
            pokemon.back_pic = result["sprites"]["back_default"];
            // set cookies to be read from php; source = https://www.w3schools.com/js/js_cookies.asp
            document.cookie = "pkmnname=" + chosen_pokemon_name + ";";
            document.cookie = "picture=" + result["sprites"]["front_default"] + ";";
            document.cookie = "type1=" + types_list[0] + ";";
            document.cookie = "type2=" + types_list[1] + ";";
        });
    });
</script>
            
    </head>

    <body>
        <div id="header"></div>

        <!-- <div class="center"> -->
            <!-- <center> -->
                <h1 class="exploreHeader">Click on the map to catch a Pokemon!</h1>
                <img class="center" alt="location map" src="pictures/region.jpg" usemap="#image-map" style="text-align:center; display:block; width:90%">
            <!-- </center> -->

            <map name="image-map">
                <area id="fire" data-bs-toggle="modal" data-bs-target="#exampleModal" coords="554,253,526,312,623,356,715,340,664,261" shape="poly">
                <area id="water" data-bs-toggle="modal" data-bs-target="#exampleModal" coords="178,353,409,348,346,520,128,555" shape="poly">
                <area id="ice" data-bs-toggle="modal" data-bs-target="#exampleModal" coords="158,194,390,98,521,166,457,247" shape="poly">
                <area id="dark" data-bs-toggle="modal" data-bs-target="#exampleModal" coords="402,387,589,348,488,390" shape="poly">
                <area id="grass" data-bs-toggle="modal" data-bs-target="#exampleModal" coords="638,414,803,520,879,463,774,356" shape="poly">
                <area id="bug" data-bs-toggle="modal" data-bs-target="#exampleModal" coords="436,266,150,230,102,304,386,314" shape="poly">
                <area id="flying" data-bs-toggle="modal" data-bs-target="#exampleModal" coords="560,135,801,230,818,144" shape="poly">
            </map>
        <!-- </div> -->
        <!-- <div id = "caught"><?=$caught?></div> -->
        <!-- Modal -->
        
        <div class="modal" id="exampleModal" aria-hidden="true">
          
        <form action="?command=explore" method="post">
            <div class="modal-content modal-dialog">
                <div class="modal-body">Searching for Pokemon...</div>
                <img class="modal-content" src="..." alt="image of pokemon" id="img01">
                <div class="modal-footer">
                    
                        <input type="submit" id="catch" name="wild_pokemon" class="btn btn-secondary" data-bs-dismiss="modal" value="Catch">
                        <input type="submit" id= "ignore" name="wild_pokemon" class="btn btn-secondary" data-bs-dismiss="modal" value="Ignore">
                        <input id="wild_pokemon_id" type="hidden" name="pok" value="9">
                        <!--passing info from cookie to database-->
                        <input type="hidden" id="pkmnname" name="pkmnname" value="<?= $_COOKIE["pkmnname"] ?>" >
                        <input type="hidden" name="picture" value="<?= $_COOKIE["picture"] ?>">
                        <input type="hidden" name="type1" value="<?= $_COOKIE["type1"] ?>">
                        <input type="hidden" name="type2" value="<?= $_COOKIE["type2"] ?>">
                </div>
            </div>
            </form>
        </div>
       
        <div id="footer"></div>
    </body>
    

</html>