<?php
/*
* Developer: Hugh Caluscusin - a.k.a Melodic Crypter
* App: InstaFlick
* About: InstaFlick is a simple app that fetches images from Instagram and Flickr through APIs
* URL: http://www.melodiccrypter.com/apps/instaflick/
* Year: 2017
* Version 1
* */

    // Calling our app
    require 'instaflick.php';

    // Passing the query to InstaFalick
    InstaFlick::search($_GET['q']);

    // Instance of InstaFlick
    $app = new InstaFlick();

    // Calling InstaFlick methods
    $instaGeoAPI = $app->instaGeoAPI();
    $instaTagAPI = $app->instaTagAPI();
    $instaUserAPI = $app->instaUserAPI();
    $flickrPhotoAPI = $app->flickrPhotoAPI();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>InstaFlick - Melodic Crypter</title>
     <!-- <<<< YOUR STYLESHEETS HERE >>>>> -->
</head>
<body>
    
    <header>
        <!-- <<<< YOUR NAV STUFF HERE >>>>> -->
    </header>
    
    
    <!-- <<<< MAIN CONTENT >>>>> -->
    <main>
       <!-- <<<< THE FORM >>>>> -->
        <form action="">
            <input type="text" name="q" placeholder='<?php
                    if(isset($_GET["q"]))
                    {
                        echo $_GET["q"];
                    }
                    else
                    {
                        echo "Name, Food, Place, Things";
                    }

                    if ($_GET["q"] === "" || $_GET["q"] === " ")
                    {
                        echo "Name, Food, Place, Things";
                    }
                ?>'>
            <button type="submit">Go</button><br><br>
        </form>

        <!-- <<<< THE FETCHING PROCESS >>>>> -->
        <section id="img-container">
            <?php
            // If InstaFlick $err variable is not empty, meaning the user did not type anything
            if(!empty($app::$err)) {
                echo $app::$err;
            }
            else {

                // Echo image of Instagram - Tag API
                foreach ($instaTagAPI['data'] as $key => $tag_img) {
                    echo '<div class="img-box one"> <img src="' . $tag_img['images']['standard_resolution']['url'] . '"> </div>';
                }

                // Echo image of Flickr - Photo.Search API
                foreach ($flickrPhotoAPI['photos']['photo'] as $key => $flickr_img) {
                    echo '<div class="img-box two"> <img src="' . 'https://farm' . $flickr_img['farm'] . '.staticflickr.com/' . $flickr_img['server'] . '/' . $flickr_img['id'] . '_' . $flickr_img['secret'] . '_c.jpg' . '"> </div>';
                }

                // Echo images of Instagram - Location API
                foreach($instaGeoAPI['data'] as $key => $geo_img) {
                    echo '<div class="img-box three"> <img src="' . $geo_img['images']['standard_resolution']['url'] . '"> </div>';
                }

                // Echo images of Instagram - User API
                foreach ($instaUserAPI['data'] as $key => $user_img) {
                    echo '<div class="img-box four"> <img src="' . $user_img['profile_picture'] . '"> </div>';
                }
            }
            ?>
        </section>
    </main>
    
    <footer>
        <!-- <<<< YOUR FOOTER STUFF >>>>> -->
    </footer>
    
    
</body>
</html>