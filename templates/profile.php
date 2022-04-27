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
            <div class="row" >
                <?php if(isset($error_msg)) $error_msg ?>
                <div class="col-9">
                    <h1 class="text-center">Dashboard</h1>
                    <h2>Your Team</h2>
                    <!--<img src="pictures/team.png" alt="picture of your team">-->
                    <div class="row" id="team" >
						<?php foreach ($team as $pokemon) { ?>
							<div class="col-sm-2">
                            	<form action="?command=modifyPokemon" method="post">
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
                                    <button type="submit" class="btn btn-primary" name="teamunselect">Remove from Team </button>
                                    </ul>
                                </div>
                            	</form>
                            </div>
						<?php } ?>
                    </div>
    

                    <div class="row" id="recents"  style="margin-top: 10px">
                    	<h2>Recently Caught</h2>
                        <!-- generating cards of recently caught pokemon -->
                        <?php  $i = 0;
						foreach($temp as $row) { ?>
						<div id="row<?=$i?>" class="row"  style="margin-bottom: 20px">
							<?php foreach ($row as $pokemon) { ?>
                            <div class="col-sm-2">
                            	<form action="?command=modifyPokemon" method="post">
									<div class="card text-center" style="font-size: 10pt;">
										<!--pokemon data -->
										<img src="<?php echo $pokemon["picture"]; ?>" class="card-img-top" alt="pokemon icon">
										<div class="card-body">
											<p class="card-title"><?= $pokemon["name"] ?></p>
										</div>
										<ul class="list-group list-group-flush">
										<!--hidden input for pokemon identification-->
										<input id="pokemonid" name="pokemonid" type="hidden" value="<?=$pokemon["id"]?>">
										<!--action buttons-->
										<button type="submit" class="btn btn-primary" name="teamselect" 
										<?php if($pokemon["is_on_team"] == 1) { ?> disabled <?php } ?>>
											Add to Team 
										</button>
										<button type="button" class="btn btn-secondary" onclick="setPokemonId(<?=$pokemon['id']?>)" 
										data-bs-toggle="modal" data-bs-target="#releaseModal">
											Release
										</button>
										</ul>
									</div>
                                    

									<!--modal-->
									<div class="modal" id="releaseModal" tabindex="-1" aria-labelledby="releaseModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">

											<div class="modal-header">
												<h5 class="modal-title" id="releaseModalLabel">Releasing a Pokemon</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<!--todo: type confirmation and validate with js-->
												<label for="validation" class="form-label">This action is permanent. <br> Please enter the word "release" to continue</label>
												<input type="text" class="form-control" id="validation" name="validation" >
												<p id="err" style="color: red"></p>
											</div>
											<div class="modal-footer">
													<input id="delpokemonid" name="delpokemonid" type="hidden" value="">
													<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
													<button id="deletepkmn" type="submit" class="btn btn-primary" onclick="getPokemonId()" name="delete" disabled>Continue</button>
											</div>

											</div>
										</div>
									</div>

                            	</form>
                            </div>
                        <?php } ?>
						</div> 
						<?php $i++; 
						} ?>

                    </div>

					<div id="buttongroup" class="text-center">
						<p>Select how many rows to display: </p>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="inlineRadioOptions" id="option1" value="option1" checked>
							<label class="form-check-label" for="option1">1</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="inlineRadioOptions" id="option2" value="option2">
							<label class="form-check-label" for="option2">2</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="inlineRadioOptions" id="option3" value="option3">
							<label class="form-check-label" for="option3">3</label>
						</div>
					</div>

    
                </div>

                <div class="col-2 text-center">
                    
                    <div class="card" style="width: 18rem;">
                        <img src="<?php echo $picture; ?>" class="card-img-top" alt="profile icon" width="150" height="200">
                        <div class="card-body">
                          <h3 class="card-title"><?= $name ?></h3>
                          <p class="card-text"><?= $bio ?></p>
                        </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item">Number of friends: <?=$totalFriends?></li>
                          <li class="list-group-item">Total Pokemon caught: <?=$totalpk ?></li>
                          <!--<li class="list-group-item">A third item</li>-->
                        </ul>
                        <div class="card-body">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profileModal">
                                Edit Profile
                            </button>
                        </div>
                    </div>

                    <!--modal-->
                    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
                        <form action="?command=profile" method="post" enctype="multipart/form-data">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="profileModalLabel">Edit Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body justify-content center">
                                <label for="biography" class="form-label">Change your biography</label>
                                <input type="text" class="form-control" name="biography" id="biography" value=<?=$bio?>>

                                <label for="profilepicupload" class="form-label">Change your profile picture</label>
                                <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                                <input type="file" name="profilepicupload" value="Upload image" accept=".png, .jpg, .tiff">
                                <input type="submit" class="btn btn-secondary" name="removepic" id="removepic" value="Remove Picture">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            </div>
                            </div>
                        </div>
                        </form>
                    </div>
    
                </div>
            </div>
            
        </div>

        <div id="footer"></div>

        <script>
            /* $('.button').click(function() {
                var clickBtnValue = $(this).val();
                var ajaxurl = 'PokemonController.php',
                data =  {'action': clickBtnValue};
                $.post(ajaxurl, data, function (response) {
                    // Response div goes here.
                    alert("action performed successfully");
                });
            }); */
			
			// jquery for deleting confirmation
			$("#validation").keyup(function() {
				var match = false;
				if($(this).val() == "release") {
					match = true;
				}

				if(match) {
					$("#deletepkmn").removeAttr('disabled');
					$("#err").html("");
				} else {
					$("#err").html("You must enter the word to continue");
				}
			});

			// jquery for radio button
			if($("#option1").prop("checked", true)){
				$("#row1").attr("hidden", true);
				$("#row2").attr("hidden", true);
				console.log("selected 1");
			} 

			$("#buttongroup input:radio").click(function() {
				if($(this).val() == "option1"){
					$("#row1").attr("hidden", true);
					$("#row2").attr("hidden", true);
				} else if($(this).val() == "option2"){
					$("#row1").attr("hidden", false);
					$("#row2").attr("hidden", true);
				} else if($(this).val() == "option3"){
					$("#row1").attr("hidden", false);
					$("#row2").attr("hidden", false);
				}
			});

			// to send correct pokemon id when deleting
			var pokemon = "";
			function setPokemonId(id) {
				console.log(id);
				pokemon = id;
			}

			function getPokemonId() {
				document.getElementById("delpokemonid").value = pokemon;
			}
			
        </script>

    </body>

</html>