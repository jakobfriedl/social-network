<div class="container">
    <h2 class="text-center mb-2">Freunde</h2>
    <?php
    //Freundschaft beenden
    if(isset($_GET["unfriend"]))
    {
        //Chat und Nachrichten löschen, wenn es einen gibt
        $chat = $db->getChat($_GET["unfriend"], $currentUser->id); 
        if($chat->id!=NULL)
        {
            $check = $db->deleteMessages($chat->id);
            $check = $db->deleteChat($chat->id);
        }
        //Friendship_reverse, damit Freundschaft von beiden Seiten aus gelöscht wird
        $friendship = $db->getRequest($_GET["unfriend"], $currentUser->id);
        $friendship_reverse = $db->getRequest($currentUser->id, $_GET["unfriend"]); 
        $check = $db->denyRequest($friendship_reverse->getId());
        $check = $db->denyRequest($friendship->getId());
        if($check)
        {?>
            <div class="alert alert-info alert-dismissible fade show w-50 mx-auto mb-5">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! </strong>Freundschaft beendet!
            </div><?php
            echo "<meta http-equiv='refresh' content='3; url=index.php?home&section=freunde'>";
        }
        else
        {?>
            <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error! </strong>Fehler beim Beenden der Freundschaft!
            </div><?php
        }
    }

    //Anzeigen der Freunde
    $friendList = $db->listFriends($currentUser);
    if(!empty($friendList))
    {?>
        <table class="table table-striped text-center mt-3">
            <thead class="thead">
                <th scope="col">Anrede</th>
                <th scope="col">Vorname</th>
                <th scope="col">Nachname</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col"></th>
            </thead>
            <tbody><?php 
        
            //Foreach Schleife für Freunde
            $_SESSION["friends"]=$friendList;
            foreach($_SESSION["friends"] as $friend)
            {
                if($friend!=$currentUser)
                {
                    echo "<tr>";
                        echo "<td>".$friend->anrede."</td>";
                        echo "<td>".$friend->vorname."</td>";
                        echo "<td>".$friend->nachname."</td>";
                        echo "<td>".$friend->username."</td>";
                        echo "<td>".$friend->email."</td>";
                        echo "<td><a class='text-danger' href='".$_SERVER["REQUEST_URI"]."&unfriend=".$friend->id."'>".$deleteFriend."</a></td>";
                    echo "</tr>";
                }
            }?>
           </tbody>
        </table><?php
    } 
    else
    {?>
        <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <label>Noch keine Freunde gefunden!</label><br>
            <small>Erstellen Sie doch eine neue Freundschaftsanfrage!</small>
        </div><?php
    }
    ?>
</div>