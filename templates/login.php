<!DOCTYPE html>
<!--Sources/References
    banner images: 
        https://64.media.tumblr.com/870104d026f35051310431515a9e982b/tumblr_oxpwuhybPy1w1z10ao1_500h.jpg
        https://www.dualshockers.com/pokemon-lets-go-social-gameplay/
-->

<!--server url: https://cs4640.cs.virginia.edu/cc6hkb/cs4640-project/
    extra credit google cloud url: https://storage.googleapis.com/cs4640-pokepals/index.html
-->
<html lang="en">
    <head>
        <meta charset="UTF-8">  
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

        <meta name="author" content="Coby Chiu cc6hkb">
        <meta name="description" content="home page of website">
        <meta name="keywords" content="feature page for sprint 2">        
    
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
        <link rel="stylesheet/less" type="text/css" href="styles/styles.less" />
        <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <title>Home</title>

                   
    </head>

    <body>
        <br>
        <br>
        <br>

        <!--welcome banner thing-->
        <div class=" container text-center">
            <h1>Welcome to the world of Pokemon</h1>
        </div>
        
        <div class="container">
            <div class="row">

                <!-- Banner Side -->
                <div class="col-7">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://64.media.tumblr.com/870104d026f35051310431515a9e982b/tumblr_oxpwuhybPy1w1z10ao1_500h.jpg" class="d-block w-100" alt="banner of pokemon">
                            </div>
                            <div class="carousel-item">
                                <img src="pictures/trainers.jpg" class="d-block w-100" alt="picture of trainers">
                            </div>
                        </div>
                    </div>    
                </div>

                <!-- Login Side -->
                <div class="col-5 text-center">
                    <form action="?command=login" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"/>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"/>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"/>
                        </div>
                        <?=$error_msg?>
                        <div class="text-center">                
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>


        <!-- Second Row -->
        <br> <br>
        <div class="container">
            <div class="row text-center">
                <!--credit: https://codepen.io/johngerome/pen/jyrOrq-->
                <div class="hr-theme-slash-2">
                    <div class="hr-line"></div>
                    <div class="hr-icon"><img src="pictures/pokeball.png" alt="pokeball" width="20" height="20"></div>
                    <div class="hr-line"></div>
                </div>
                <h2>Catch, collect, and compare Pokemon with your friends!</h2>

                
                
            </div>
        </div>

        <div class="container footer">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top"  style="color:black;">

                <p class="col-md-4 mb-0 px-2">©2022</p>
                <ul class="nav col-md-4 justify-content-end">
                    <li class="nav-item"><a href="index.html" class="nav-link px-2">Home</a></li>
                    <li class="nav-item"><a href="explore.html" class="nav-link px-2">Explore</a></li>
                    <li class="nav-item"><a href="viewFriends.html" class="nav-link px-2">Friends List</a></li>
                    <li class="nav-item"><a href="profile.html" class="nav-link px-2">Profile</a></li>
                </ul>
            </footer>
        </div>
    </body>

</html>