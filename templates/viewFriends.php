<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">  
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

        <meta name="author" content="Selena Johnson scj4ve">
        <meta name="description" content="page to view and search other users">
        <meta name="keywords" content="feature page for sprint 2">        
    
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
        <link rel="stylesheet/less" type="text/css" href="styles/styles.less" />
        <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
       

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
        <link rel="stylesheet" href="styles/friendsstyle.css">
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <title>Friends</title>
    </head>
    <body >
 
        <div id="header"></div>
        <h1 class="text-center">Friends List</h1>
        
       
            
        <br><br><br> <br>
        <?=$error_msg?>
        <!-- container for all friends -->
        <div class="container" style="width:75%; height:53vh; overflow-y:scroll"> 
            <div class="friendRow"> 
                <?=$list?>
                

            </div>
        </div>


        <!-- Team Modal -->
        <div class="modal" id="teamModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Friend's Team</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body col-12">
                <div id="teamrow" class="row">
                    <?php if (sizeof($friendpkmn) == 0 ) { ?>
                        <h2 class="text-center"> No Pokemon to display </h2>

                    <?php } else { ?>
                    <?php foreach ($friendpkmn as $pokemon) { ?>
                        <div id="pokemoncard" name="<?=$pokemon['name']?>" class="col-sm-4">
                            <div class="card text-center" style="font-size: 12pt;">
                                <!--pokemon data -->
                                <img src="<?php echo $pokemon["picture"]; ?>" class="card-img-top" alt="pokemon icon">
                                <!-- <div class="card-body" style="height: 200px"></div> -->
                                <p class="card-title"><?= $pokemon["name"] ?></p>
                                <div class="card-body"></div>
                                
                            </div>
                        </div>

                        <!--<div class="progress">
                            <p class="health-bar">Health:</p>
                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="progress">
                            <p class="agility-bar">Agility:</p>
                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="progress">
                            <p class="stamina-bar">Stamina:</p>
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="progress">
                            <p class="power-bar">Power:</p>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 87%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>-->
                    <?php } }?>
                </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
    
        <div id="footer"></div>

    </body>
</html>