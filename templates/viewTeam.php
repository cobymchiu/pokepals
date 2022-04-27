<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">  
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

        <meta name="author" content="Coby Chiu cc6hkb">
        <meta name="description" content="profile page for user">
        <meta name="keywords" content="feature page for sprint 2">        
    
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
        <link rel="stylesheet/less" type="text/css" href="styles/styles.less" />
        <link rel="stylesheet" href="styles/profile.css" />

        <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity= "sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"> </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <title>Home</title>

        <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous">
        </script>

        <!--source:https://stackoverflow.com/questions/18712338/make-header-and-footer-files-to-be-included-in-multiple-html-pages-->
        <script> 
            $(function(){
              $("#header").load("header.html"); 
              $("#footer").load("footer.html"); 
            });

        </script> 
            
    </head>

    <body>
        <div id="header"></div>

        <div class="container">
            <div class="row">
                <?php if(isset($error_msg)) $error_msg ?>
                <div class="col-12">
                    <h1 class="text-center">Your Team</h1>
                    <!--<img src="pictures/team.png" alt="picture of your team">-->
                    <div class="row" id="team">
						<?php foreach ($team as $pokemon) { ?>
							<div id="pokemoncard" name="<?=$pokemon['name']?>" class="col-sm-2">
                                <div class="card text-center" style="font-size: 12pt;">
                                    <!--pokemon data -->
                                    <img src="<?php echo $pokemon["picture"]; ?>" class="card-img-top" alt="pokemon icon">
                                    <div class="card-body">
                                    <p class="card-title"><?= $pokemon["name"] ?></p>
                                    </div>
                                    <ul class="list-group list-group-flush">
									<!--hidden input for pokemon identification-->
									<input id="pokemonid" name="pokemonid" type="hidden" value="<?=$pokemon["id"]?>">
                                    <!--action buttons-->
                                    <button type="button" onclick ="getDetails('<?=$pokemon['name']?>')" class="btn btn-primary" id="detailsbutton" name="detailsbutton" data-bs-toggle="modal" data-bs-target="#detailModal">Details </button>
                                    <button type="submit" class="btn btn-secondary" name="teamunselect">Remove from Team </button>
                                    </ul>
                                </div>
                            </div>
						<?php } ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal" id="detailModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detail-modal-label">Pokemon Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-center col-12">
                   <!-- put data from ajax function here -->
                   <h6><b>Types</b></h6>
                   <p id="type1">  </p>
                   <p id="type2"> </p>
                   <h6><b>Base Stat</b></h6>
                   <p id="basestat"> </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

        <div id="footer"></div>

        <script>
			
			// script to generate pokemon details -- based on lecture trivia example
			var details = 'hi';
            var pokemon = "";
            // https://www.w3schools.com/xml/ajax_xmlhttprequest_response.asp
			function getDetails(name) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        pokemon = name;   
                        //document.getElementById("type1").innerHTML = this.responseText;
                        details = JSON.parse(this.responseText);
                        //console.log(pokemon);      
                        //console.log("length of obj: " + details.length);
                        //document.getElementById("type1").innerHTML = details.length;
                        displayInfo();
                    }
                };
                xhttp.open("GET", "?command=getPokemonInfo", true);
                xhttp.send();
			}

			// displays team
			function displayInfo() {
                console.log(details);
                var type1;
                var type2;
                var basestat;

                // find data for the right pokemon
                for(let i = 0; i < details.length; i++){
                    if(details[i]["name"] == pokemon){
                        type1 = details[i]["type1"];
                        type2 = details[i]["type2"];
                        basestat = details[i]["basestat"];
                        break;
                    }
                }

				document.getElementById("type1").innerHTML = type1;
				document.getElementById("type2").innerHTML = type2;
				document.getElementById("basestat").innerHTML = basestat;
			}

            //getDetails();
        </script>

    </body>

</html>