<?php
//Löschen eines Beitrags
if(isset($_GET["del"]))
{
    $post = $db->getPost($_GET["del"]);
    //Likes, Dislikes und Kommentare löschen, um referentielle Integrität nicht zu verletzen
    //Sonst würde es Likes, etc. geben zu einem Beitrag, der nicht existiert
    $check = $db->deleteLikes($_GET["del"]);
    $check = $db->deleteDislikes($_GET["del"]);
    $check = $db->deleteComments($_GET["del"]); 
    //Delete Tag References
    $check = $db->deleteTags($_GET["del"]); 
    //Delete Post 
    $check = $db->deletePost($_GET["del"]);
    if($check)
    {
        //Lösche den Beitrag aus dem Verzeichnis
        if($post->pfad_original!=NULL)
        {
            //Aufteilen des Pfads, um den Speicherort des Bildes zu finden
            //explode() teilt den pfad dort, wo ein "/" steht und speichert die einzelnen Teile in ein Array
            $verzeichnis = explode("/", $post->pfad_original);
            //Bild und der Ordner des Bildes werden gelöscht
            unlink($post->pfad_original);
            rmdir($verzeichnis[0]."/".$verzeichnis[1]."/".$verzeichnis[2]);
        }    
        ?>
        <div class="alert alert-info alert-dismissible fade show w-75 mx-auto mb-5">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success! </strong>Beitrag erfolreich gelöscht!
        </div><?php
        echo "<meta http-equiv='refresh' content='0; url=index.php?home'>";
    }
    else
    {?>
        <div class="alert alert-danger alert-dismissible fade show w-75 mx-auto mb-5">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error! </strong>Fehler beim Löschen des Beitrags!
        </div><?php
    }
}

if(isset($_GET["edit"]))
{
    //Ändern des Freigabestatus eines Beitrags
    $post = $db->getPost($_GET["edit"]); 
    if($post->freigabestatus == "public")
        $newStatus = "private"; 
    else
        $newStatus = "public"; 
    
    $check = $db->changeAccess($_GET["edit"], $newStatus);
    if($check)
    {?>
        <div class="alert alert-info alert-dismissible fade show w-75 mx-auto mb-5">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success! </strong>Freigabestatus erfolreich geändert!
        </div><?php
        echo "<meta http-equiv='refresh' content='0; url=index.php?home'>";
    }
    else
    {?>
        <div class="alert alert-danger alert-dismissible fade show w-75 mx-auto mb-5">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error! </strong>Fehler beim Ändern des Freigabestatus!
        </div><?php
    }
}
?>