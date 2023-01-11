<?php
    //Verwaltung der Suche
    //Wird nach einem Begriff gesucht werden nur Posts angezeigt, die diesen Begriff in Titel oder Inhalt, bzw. Bildnamen enthalten
    if(isset($_POST["suchen"]) && !empty($_POST["suchen"]))
        $_SESSION["searchForPosts"] = $_POST["suchen"]; 
    //Wird nach einem leeren Input gesucht wird die Session wieder gelöscht und alle Beiträge angezeigt
    if(isset($_POST["suchen"]) && isset($_SESSION["searchForPosts"]) && empty($_POST["suchen"]))
        unset($_SESSION["searchForPosts"]);

    //Filtern
    if(isset($_GET["filter"]))
        $_SESSION["filterPosts"]=$_GET["filter"];
    //Entfernen des Filters
    if(isset($_GET["rmFilter"]))
    {
        unset($_SESSION["filterPosts"]);
        echo "<meta http-equiv='refresh' content='0; url=index.php?home'>";
    }
?>
<div class="container">
    <!--Search Bar mit Filterfunktion-->
    <form class="form mt-3" method="post" action="<?=$_SERVER["REQUEST_URI"]?>">
        <div class="input-group">
            <!--Filter Tags, Dropdownmenü-->
            <div class="dropdown">
                <button class="btn btn-dark rounded-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$filter?></button>
                <ul class="dropdown-menu dropdown-menu" aria-labelledby="friendListDD">
                    <li class="dropdown-item btn-light"><strong>Filtern:</strong></li>
                    <!--Foreach Schleife für Tags-->
                    <?php
                        //Es werden nur jene Tags dargestellt, von denen es Beiträge mit diesem Tag gibt
                        $tags = $db->getTaglist();
                        foreach($tags as $tag)
                        {
                            echo '<li><a class="dropdown-item btn-light dd-hover" href="index.php?home&filter='.$tag->id.'">-   '.$tag->bezeichnung.'</a>';
                        }
                    ?>
                </ul>
            </div>
            <!--SearchBar-->
            <input name="suchen" type="text" class="form-control" placeholder="Suchen...">
            <div class="input-group-btn">
            <button class="btn btn-dark rounded-0" type="submit"><?=$search?></button>
            </div>
        </div>
    </form>
</div>
<div class="container mt-3">
    <div class="overflow-auto pr-3" style="max-width: 100%; height: 66vh;">
    <?php
        //Include Script zum Löschen oder Ändern eines Beitrags
        include "includes/deletePost.php";
        //Include Scripts zum Liken und Disliken
        include "includes/likeOrDislike.php";
        //Include Kommentarfunktion
        include "includes/addComment.php"; 
        //Include Upload Script
        include "includes/uploadPost.php"; 
        //Include Beitragsanzeige
        include "includes/displayPosts.php"; 
        ?>
    </div>
</div>