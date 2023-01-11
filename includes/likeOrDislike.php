<?php
//Liken eines Posts
if(isset($_GET["like"]))
{
    $liker = $currentUser->id; 
    $beitrag = $_GET["like"];

    //Checken, ob der Beitrag bereits vom User geliked oder gedisliked wurde
    $isLiked = $db->checkForLike($liker, $beitrag); 
    $isDisliked = $db->checkForDislike($liker, $beitrag); 

    if($isLiked==NULL)
    {
        $newLike = new Like(NULL, $liker, $beitrag);
        //wird ein Like hinzugefügt, wird ein Dislike (falls er exisitert) gelöscht
        if($isDisliked!=NULL)
            $check = $db->removeDislike($isDisliked); 
        $check = $db->likePost($newLike); 
        echo "<meta http-equiv='refresh' content='0; url=index.php?home'>";
    }
    else
    {
        //Wird ein gelikeder Beitrag nochmal geliked, dann wird der Like entfern
        $check = $db->removeLike($isLiked); 
        echo "<meta http-equiv='refresh' content='0; url=index.php?home'>";
    }
}
//Disliken eines Posts
if(isset($_GET["dislike"]))
{
    $disliker = $currentUser->id; 
    $beitrag = $_GET["dislike"];

    //Checken, ob der Beitrag bereits vom User geliked oder gedisliked wurde
    $isLiked = $db->checkForLike($disliker, $beitrag); 
    $isDisliked = $db->checkForDislike($disliker, $beitrag); 

    if($isDisliked==NULL)
    {
        $newDislike = new Dislike(NULL, $disliker, $beitrag);
        //wird ein Like hinzugefügt, wird ein Dislike (falls er exisitert) gelöscht
        if($isLiked!=NULL)
            $check = $db->removeLike($isLiked); 
        $check = $db->dislikePost($newDislike); 
        echo "<meta http-equiv='refresh' content='0; url=index.php?home'>";
    }
    else
    {
        //Wird ein gelikeder Beitrag nochmal geliked, dann wird der Like entfern
        $check = $db->removeDislike($isDisliked); 
        echo "<meta http-equiv='refresh' content='0; url=index.php?home'>";
    }
}
?>