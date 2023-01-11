<?php
    session_start();

    /////////////////////////////////////////////////////////
    //Datenbankverbindung starten
    require_once "./utility/DB.class.php"; 
    $db = new DB(); 

    /////////////////////////////////////////////////////
    $farbe = '#000000'; 
    if(isset($_SESSION["currentUser"]))
    {
        $currentUser = $db->getUserFromName($_SESSION["currentUser"]); 
        $farbe = $currentUser->farbe;
    }
    include "includes/icons.php";
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Social Network</title>

        <link rel="stylesheet" href="resources/css/bootstrap.css">
        <link rel="stylesheet" href="resources/css/styles.css">

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <!--FancyBox-->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
        <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    </head>
    <?php
        //Datei mit allen Modals, die benötigt werden
        include "includes/modals.php";
    ?>
    <body>
        <?php
            if(isset($_GET["home"]) || isset($_SESSION["currentUser"]))
                include "includes/home.php"; 
            else
                include "includes/loginScreen.php";
        ?>
    </body>
</html>