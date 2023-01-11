<?php
//Get Posts from DB
//Falls aktuell nach etwas gesucht wird, werden nur die entsprechenden Beiträge angezeigt
if(isset($_SESSION["searchForPosts"]))
{
    $posts = $db->searchForPosts($_SESSION["searchForPosts"]); 
    echo "Suchbegriff: <strong>".$_SESSION["searchForPosts"]."</strong>";
}
//Wenn die Session gesetzt ist, werden nur Beiträge, die den gesuchten Tag haben angezeigt
//außer, es wird gerade nach einem Begriff gesucht, dann werden die suchergebnisse (aus allen Posts) angezeigt
else if(isset($_SESSION["filterPosts"]))
{
    $posts = $db->filterTags($_SESSION["filterPosts"]);
    $tag = $db->getTagName($_SESSION["filterPosts"]); 
    //Mit einem Klick auf das 'x' wird der Filter wieder entfernt
    echo "Gefiltert nach: <strong>".$tag->bezeichnung."</strong><a class='text-dark' href='index.php?home&rmFilter'> &times;</a>";
}
//Sonst werden alle Posts ausgewählt
else
    $posts = $db->getPostlist();  

if(!empty($posts))
{
    //Foreach Schleife für Beiträge
    foreach($posts as $post)
    {
        $creator = $db->getUserFromID($post->creator);
        //Wenn niemand eingeloggt ist, werden nur öffentliche Beiträge angezeigt
        if(isset($_SESSION["currentUser"]))
        {
            $friendship = $db->getFriendship($creator->id, $currentUser->id);
            //Überprüfen, ob ein Beitrag für Alle oder nur bestimmte User angezeigt werden soll
            //Um einen privaten Beitrag zu sehen, müssen Freunde schon vorher in der Freundesliste sein, deshalb wird der Timestamp überprüft
            if(($friendship->id!=NULL AND $friendship->timestamp < $post->timestamp) OR $creator==$currentUser OR $post->freigabestatus=="public")
            {?>
                <div class="card my-2">
                <div class="card-header">
                    <div class="nav">
                        <!--Icon mit Farbe-->
                        <label>
                        <svg style='color:<?=$creator->farbe?>' class='icon-style' width='2.5em' height='2.5em' viewBox='0 0 16 16' class='bi bi-person-circle' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z'/>
                        <path fill-rule='evenodd' d='M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/>
                        <path fill-rule='evenodd' d='M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z'/>
                        </svg> 
                        <strong><?=$creator->username?></strong>
                        </label> 
                        <?php
                        //Nur eigene Beiträge können bearbeitet oder gelöscht werden
                        if($creator == $currentUser)
                        {
                            $_SESSION["currentPost"] = $post; 
                            echo '<a class="ml-auto text-dark" data-toggle="tooltip" data-placement="top" title="Freigabestatus ändern" href="index.php?home&edit='.$post->id.'">'.$edit.'</a>';
                            echo '<a class="ml-2 text-danger" data-toggle="tooltip" data-placement="top" title="Beitrag löschen" href="index.php?home&del='.$post->id.'">'.$delete.'</a>';
                        }?>
                    </div>
                    <div class="nav">
                        <small><?=$post->timestamp?>
                        <?php
                        //Freigabestatus anzeigen
                        if($post->freigabestatus=="public")
                            echo " - öffentlich</small>";
                        else
                            echo "</small>"
                        ?>
                        <div class="ml-auto">
                            <?php
                            //Tags anzeigen
                                $tags = $db->getAllTags($post->id);
                                foreach($tags as $tag)
                                {
                                    $tagObject = $db->getTagName($tag->tag); 
                                    echo '<span class="badge mx-1 border" style="background-color:'.$tagObject->farbe.';">'.$tagObject->bezeichnung.'</span>'; 
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?=$post->titel?></h5>
                    <p class="card-text"><?=$post->inhalt?></p>
                    <?php
                    //Bild anzeigen, Falls eines Existiert
                    if($post->pfad_original!=NULL)
                    {
                        //Link für Fancybox
                        echo '<a href="'.$post->pfad_original.'" alt ="'.$post->pfad_original.'" data-fancybox="gallery" data-caption="by '.$creator->username.'">';
                            echo '<img class="img-thumbnail" style="width: 33%; height: auto;" src='.$post->pfad_original.'>';
                        echo '</a>';
                    }
                    ?>
                </div>
                <div class="card-footer nav my-auto">
                    <!--Kommentarfeld-->
                    <form method="post" class="form mr-auto" style="width: 65%;" action="<?=$_SERVER["REQUEST_URI"]?>">
                        <div class="input-group">
                            <!--BeitragsId als Hidden-Feld, um zu wissen, um welchen Beitrag es sich handelt-->
                            <input type="hidden" name="beitragID" value="<?=$post->id?>">
                            <input name="comment" type="text" class="form-control w-75" placeholder="Kommentieren...">
                            <div class="input-group-btn">
                            <button class="btn btn-dark rounded-0 py-auto" name="addComment" type="submit"><?=$senden?></button>
                            </div>
                        </div>
                    </form>
                    <!--Likes & Dislikes-->
                    <div class="my-auto">
                        <?php
                            //wenn ein Post geliked wurde, wird das Icon anders-farbig dargestellt
                            $likeColor = "#000000"; 
                            $dislikeColor = "#000000"; 
                            
                            $isLiked = $db->checkForLike($currentUser->id, $post->id); 
                            $isDisliked = $db->checkForDislike($currentUser->id, $post->id); 
                            
                            if($isLiked!=NULL)
                                $likeColor = "#1FACAC";
                            if($isDisliked!=NULL)
                                $dislikeColor = "#1FACAC"; 
                        ?>
                        <a style="color:<?=$likeColor?>;" href="<?=$_SERVER["REQUEST_URI"]?>&like=<?=$post->id?>"><?=$like?> <span class="badge badge-light"><?=$post->likes?></span> </a>
                        <a style="color:<?=$dislikeColor?>;" href="index.php?home&dislike=<?=$post->id?>"><?=$dislike?> <span class="badge badge-light"><?=$post->dislikes?></span> </a>
                        <a class="text-dark" href="index.php?home&showComments=<?=$post->id?>"><?=$commentsIcon?> <span class="badge badge-light"><?=$post->comments?></span> </a>
                    </div>
                </div>
            </div>
            <?php
                //Show Comments
                if(isset($_GET["showComments"]) && $post->comments!=0)
                {
                    $comments = $db->getComments($_GET["showComments"]);
                    //Zeige Kommentare unter dem Beitrag an
                    echo '<div class="ml-auto" style="width: 85%;">';
                        echo '<ul class="list-group list-group-flush">';
                        foreach($comments as $comment)
                        {
                            if($post->id == $comment->beitrag)
                            {
                                $creator = $db->getUserFromID($comment->user); 
                                echo '<li class="list-group-item border rounded"><strong>'.$creator->username.': </strong>'.$comment->inhalt.'<br>';
                                echo '<small>'.$comment->timestamp.'</small></li>';
                            }
                        }
                        echo '</ul>';
                    echo '</div>'; 
                }
            }
        }
        else //Ausgabe wenn Session nicht gesetzt ist
        {
            if($post->freigabestatus == "public")
            {?>
                <div class="card my-2">
                <div class="card-header">
                    <div class="nav">
                        <!--Icon mit Farbe-->
                        <label>
                        <svg style='color:<?=$creator->farbe?>' class='icon-style' width='2.5em' height='2.5em' viewBox='0 0 16 16' class='bi bi-person-circle' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z'/>
                        <path fill-rule='evenodd' d='M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/>
                        <path fill-rule='evenodd' d='M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z'/>
                        </svg> 
                        <strong><?=$creator->username?></strong>
                        </label> 
                    </div>
                    <div class="nav">
                        <small><?=$post->timestamp?>
                        <?php
                        //Freigabestatus anzeigen
                        if($post->freigabestatus=="public")
                            echo " - öffentlich</small>";
                        else
                            echo "</small>"
                        ?>
                        <div class="ml-auto">
                        <?php
                            //Tags anzeigen
                                $tags = $db->getAllTags($post->id);
                                foreach($tags as $tag)
                                {
                                    $tagObject = $db->getTagName($tag->tag); 
                                    echo '<span class="badge mx-1 border" style="background-color:'.$tagObject->farbe.';">'.$tagObject->bezeichnung.'</span>'; 
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?=$post->titel?></h5>
                    <p class="card-text"><?=$post->inhalt?></p>
                    <?php
                    //Bild anzeigen, Falls eines Existiert
                    if($post->pfad_original!=NULL)
                    {
                        //Link für Fancybox
                        echo '<a href="'.$post->pfad_original.'" alt ="'.$post->pfad_original.'" data-fancybox="gallery" data-caption="by '.$creator->username.'">';
                            echo '<img class="img-thumbnail" style="width: 33%; height: auto;" src='.$post->pfad_original.'>';
                        echo '</a>';
                    }
                    ?>
                </div>
                <div class="card-footer text-right">
                    <!--Likes & Dislikes-->
                    <a class="text-dark"><?=$like?> <span class="badge badge-light"><?=$post->likes?></span> </a>
                    <a class="text-dark"><?=$dislike?> <span class="badge badge-light"><?=$post->dislikes?></span> </a>
                    <a class="text-dark" href="index.php?home&showComments=<?=$post->id?>"><?=$commentsIcon?> <span class="badge badge-light"><?=$post->comments?></span> </a>
                </div>
            </div><?php
                //Show Comments
                if(isset($_GET["showComments"]) && $post->comments!=0)
                {
                    $comments = $db->getComments($_GET["showComments"]);
                    //Zeige Kommentare unter dem Beitrag an
                    echo '<div class="ml-auto rounded" style="width: 85%;">';
                        echo '<ul class="list-group list-group-flush">';
                        foreach($comments as $comment)
                        {
                            if($post->id == $comment->beitrag)
                            {
                                $creator = $db->getUserFromID($comment->user); 
                                echo '<li class="list-group-item border rounded"><strong>'.$creator->username.': </strong>'.$comment->inhalt.'<br>';
                                echo '<small>'.$comment->timestamp.'</small></li>';
                            }
                        }
                        echo '</ul>';
                    echo '</div>'; 
                }
            }
        }
    }
}
else
{?> 
    <div class="alert alert-danger alert-dismissible fade show w-75 mx-auto mb-5">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error! </strong>Noch keine Beiträge verfügbar!
    </div><?php
}
?>