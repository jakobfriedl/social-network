<?php
    $foundFriends = array(); 
    if(isset($_POST["freundSuchen"]) && !empty($_POST["suchen"]))
        $_SESSION["searchUser"]=$_POST["suchen"];
    if(isset($_SESSION["searchUser"]))
        $foundFriends = $db->searchUsers($_SESSION["searchUser"]); 
?>

<div class="container">
    <h2 class="text-center mb-2">Neue Freundschaftsanfrage</h2>
    <table class="table table-striped text-center mt-3">
        <thead class="thead">
            <th scope="col">Anrede</th>
            <th scope="col">Vorname</th>
            <th scope="col">Nachname</th>
            <th scope="col">Username</th>
            <th scope="col"></th>
        </thead>
        <tbody>
            <?php
            //Senden der Freundschaftsanfrage
            if(isset($_GET["add"]))
            {
                $newRequest = new Freundschaft(NULL, NULL, "requested", $currentUser->id, $_GET["add"]); 
                //Überprüfen ob bereits Freundschaften oder Freundschaftsanfragen existieren
                $checkRequest = $db->getRequest($currentUser->id, $_GET["add"]);
                if($checkRequest->id==NULL && $checkRequest->status!="accepted")
                {
                    $check = $db->sendRequest($newRequest); 
                    if($check)
                    {?>
                        <div class="alert alert-info alert-dismissible fade show w-50 mx-auto mb-5">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success! </strong>Anfrage wurde gesendet!
                        </div><?php
                    }
                    else
                    {?>
                        <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Error! </strong>Fehler beim Senden der Anfrage!
                        </div><?php
                    }
                    echo "<meta http-equiv='refresh' content='3; url=index.php?home&section=newFriend'>";
                }
                else
                {
                    //Falls die User schon befreundet sind, oder eine Freundschaftsanfrage versendet wurde wird eine Fehlermeldung ausgegeben
                    if($checkRequest->getStatus()=="accepted")
                    {?>
                        <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Error! </strong>Sie sind bereits befreundet!
                        </div><?php
                        }
                    else
                    {?>
                    <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error! </strong>Es existiert bereits eine Anfrage an bzw. von dieser Person!
                    </div><?php
                    }
                }
            }
            //Anzeigen der gefundenen User
            if(!empty($foundFriends))
            {
                //Foreach Schleife für Suchergebnisse
                foreach($foundFriends as $friend)
                {
                    if($friend!=$currentUser)
                    {
                        echo "<tr>";
                            echo "<td>$friend->anrede</td>";
                            echo "<td>$friend->vorname</td>";
                            echo "<td>$friend->nachname</td>";
                            echo "<td>$friend->username</td>";
                            echo "<td><a class='text-info' href='".$_SERVER["REQUEST_URI"]."&add=".$friend->id."'>".$addFriend."</a></td>";
                        echo "</tr>";
                    }
                }
            }
            else //Wenn nichts eingegeben bzw. gefunden wurde werden alle User angezeigt
            {
                {?>
                    <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error! </strong>Keine Treffer gefunden. Stattdessen wurde eine Liste aller User ausgegeben!
                    </div><?php
                }   
                $users = $db->getUserlist();
                foreach($users as $user)
                {
                    if($user!=$currentUser)
                    {
                        echo "<tr>";
                            echo "<td>$user->anrede</td>";
                            echo "<td>$user->vorname</td>";
                            echo "<td>$user->nachname</td>";
                            echo "<td>$user->username</td>";
                            echo "<td><a class='text-info' href='".$_SERVER["REQUEST_URI"]."&add=".$user->id."'>".$addFriend."</a></td>";
                        echo "</tr>";
                    }
                }
            }
            ?>
        </tbody>
    </table>
</div>