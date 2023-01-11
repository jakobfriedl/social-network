<?php
    if(isset($_POST["addComment"]) && !empty($_POST["comment"]))
    {
        $user = $currentUser->id; 
        $comment = $_POST["comment"];
        $beitrag = $_POST["beitragID"]; 
        $timestamp = date('d.y.Y  - H:i:s'); 
        
        $newComment = new Kommentar(NULL, $comment, $timestamp, $user, $beitrag);
        $check = $db->addComment($newComment);
        if(!$check)
        {?>
            <div class="alert alert-danger alert-dismissible fade show w-75 mx-auto mb-5">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error! </strong>Fehler beim Schreiben des Kommentars!
            </div><?php
        }
    }
?>