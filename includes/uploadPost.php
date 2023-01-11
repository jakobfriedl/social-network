<?php
$root = "pictures/"; 
if(isset($_POST["uploadPost"]))
{ 
    //Timestamp of Upload
    //Aufgeteilt, um Ordner zu benennen
    $date = date('d.m.Y');
    $time = date('H-i-s');

    $titel = $_POST["postTitel"];
    $inhalt = $_POST["postText"]; 
    $freigabeStatus = $_POST["postAccess"];
    $creator = $currentUser->id; 

    //Create Folder for User
    if(!is_dir($root.$currentUser->username))
        mkdir($root.$currentUser->username); 
    //Der Name des Folders für den beitrag ist das Datum des Beitrags
    $postFolder = $root.$currentUser->username."/".$date."_".$time;
    if(!is_dir($postFolder))
        mkdir($postFolder, 0777, true);
    
    //Zwecks Formatierung wird time nochmal initialisiert
    $time=date('H:i:s');
    $timestamp = $date." - ".$time; 
    //Upload Picture
    if(isset($_FILES["postBild"]))
    {
        $allowedFormats = array("image/jpeg", "image/png", "image/gif");
        if(in_array($_FILES["postBild"]["type"], $allowedFormats))
        {
            if(move_uploaded_file($_FILES["postBild"]["tmp_name"], $postFolder."/".$_FILES["postBild"]["name"]))
            {
                $pfad_original = $postFolder."/".$_FILES["postBild"]["name"];
                $newPost = new Beitrag(NULL, $titel, $inhalt, $timestamp, $freigabeStatus, $pfad_original, NULL, $currentUser->id);   
            }
            else
            {?>
                <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error! </strong>Fehler beim Upload!
                </div><?php
            }
        }
        //Es können auch Posts ohne Bild geuploaded werden
        else if($_FILES["postBild"]["type"]=="")
        {
            $newPost = new Beitrag(NULL, $titel, $inhalt, $timestamp, $freigabeStatus, NULL, NULL, $currentUser->id);  
            //Wenn kein Bild hochgeladen wird, wird das leere Verzeichnis gelöscht
            rmdir($postFolder);
        }
        else
        {
            ?>
            <div class="alert alert-danger alert-dismissible fade show w-75 mx-auto mb-5">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error! </strong>Ungültiger Dateityp!
            </div><?php
            rmdir($postFolder); 
            echo "<meta http-equiv='refresh' content='1; url=index.php?home'>";
            exit; 
        }
    }

    //Neuen Datenbankeintrag für den neuen Post anlegen
    if($newPost!=NULL);
    {
        $check = $db->createPost($newPost);
        if($check)
        {?>
            <div class="alert alert-info alert-dismissible fade show w-75 mx-auto mb-5">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! </strong>Beitrag erstellt!
            </div><?php

            //TAGS
            //ID des neuen Posts
            $post = $db->getLatestPost();

            //Tags zu Post hinzufügen
            //Other Tag
            if(isset($_POST["tagOther"]) && !empty($_POST["tagOther"]))
            {
                //Check, ob es bereits einen gleichnamigen Tag gibt
                $tag = $db->getTag($_POST["tagOther"]);
                if($tag == NULL)
                {
                    //Create Tag
                    $otherTag = new Tag(NULL, $_POST["tagOther"], "#ffffff"); 
                    $check = $db->addTag($otherTag);
                    $tag = $db->getTag($_POST["tagOther"]);
                }
                $tagPost = new Beitrag_Tag(NULL, $post, $tag); 
                $check = $db->tagPost($tagPost);  
            }
            //Checkboxen
            if(isset($_POST["tag"]))
            {
                foreach($_POST["tag"] as $tagBez)
                {
                    $tagID = $db->getTag($tagBez); 
                    $tagPost = new Beitrag_Tag(NULL, $post, $tagID); 
                    $check = $db->tagPost($tagPost);  
                } 
            }
            echo "<meta http-equiv='refresh' content='0; url=index.php?home'>";
        }
        else
        { 
            ?>
            <div class="alert alert-danger alert-dismissible fade show w-75 mx-auto mb-5">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error! </strong>Fehler beim Erstellen eines Beitrags!
            </div><?php
        }
    }
}
?>