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
        <link rel="stylesheet" href="./styles/profile.css" />

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
                <div class="col-9">
                    <h1 class="text-center">Dashboard</h1>
                    <h2>Your Team</h2>
                    <!--<img src="pictures/team.png" alt="picture of your team">-->
                    <p>This image will be replaced by pictures loaded from a database</p>
                    <div class="container" id="team">

                    </div>
    
                    <h2>Recently Caught</h2>
                    <div class="row" id="recents">
                        <!-- generating cards of recently caught pokemon -->
                        <?php foreach ($pkmn as $pokemon) { ?>
                            <div class="col-sm-2">
                            <div class="card text-center" style="font-size: 8pt;">
                                <!--pokemon data -->
                                <img src="<?php echo $pokemon["picture"]; ?>" class="card-img-top" alt="pokemon icon">
                                <div class="card-body">
                                <p class="card-title"><?= $pokemon["name"] ?></p>
                                </div>
                                <ul class="list-group list-group-flush">
                                <li class="list-group-item">Type 1:  <?= $pokemon["type1"] ?></li>
                                <?php if ($pokemon["type2"] != "undefined") {?>
                                    <li class="list-group-item">Type 2:  <?= $pokemon["type2"] ?></li>
                                <?php } ?>
                                <!--action buttons-->
                                <button type="submit" class="btn btn-primary" name="teamselect">Add to Team </button>
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#releaseModal">
                                    Release
                                </button>
                                </ul>
                            </div>
                            </div>
                        <?php } ?>
                    </div>

                    <!--modal-->
                    <div class="modal fade" id="releaseModal" tabindex="-1" aria-labelledby="releaseModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="releaseModalLabel">Releasing a Pokemon</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>This action is permanent. Continue?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" name="delete">Continue</button>
                            </div>
                            </div>
                        </div>
                    </div>
    
                </div>

                <div class="col-2 text-center">
                    
                    <div class="card" style="width: 18rem;">
                        <img src="<?php echo $picture; ?>" class="card-img-top" alt="profile icon" width="150" height="200">
                        <div class="card-body">
                          <h5 class="card-title"><?= $name ?></h5>
                          <p class="card-text"><?= $bio ?></p>
                        </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item">Number of friends: </li>
                          <li class="list-group-item">Total Pokemon caught: <?=$totalpk ?></li>
                          <!--<li class="list-group-item">A third item</li>-->
                        </ul>
                        <div class="card-body">
                          <a href="#" class="card-link">Card link</a>
                          <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
    
                </div>
            </div>
            
        </div>

        <div id="footer"></div>

        <script>
            $('.button').click(function() {
                var clickBtnValue = $(this).val();
                var ajaxurl = 'PokemonController.php',
                data =  {'action': clickBtnValue};
                $.post(ajaxurl, data, function (response) {
                    // Response div goes here.
                    alert("action performed successfully");
                });
            });
        </script>

    </body>

</html>