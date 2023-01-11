<div class="container">
    <h2 class="text-center border-bottom">Freundschaftsanfragen</h2>
    <div class="overflow-auto pr-3" style="max-width: 100%; max-height: 70vh;">
        <?php
            //Request_reverse wird verwendet, um sicher zu gehen, dass zwei User befreundet sind,
            //wenn einer der beiden die Anfrage bestätigt. Der Andere kann dann nicht mehr ablehnen.
            if(isset($_GET["accept"]))
            {
                $newFriend = $db->getUserFromID($_GET["accept"]);
                
                $request = $db->getRequest($_GET["accept"], $currentUser->id);
                $request_reverse = $db->getRequest($currentUser->id, $_GET["accept"]);
                $check = $db->acceptRequest($request_reverse->getId());
                $check = $db->acceptRequest($request->getId());
                if($check)
                {?>
                    <div class="alert alert-info alert-dismissible fade show w-50 mx-auto mb-5">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success! </strong>Sie sind nun mit <?=$newFriend->vorname." ".$newFriend->nachname?> befreundet!
                    </div><?php
                    echo "<meta http-equiv='refresh' content='1; url=index.php?home&section=friendRequests'>";
                }
                else
                {?>
                    <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error! </strong>Fehler beim Bestätigen!
                    </div><?php
                }
            }
            //Wenn einer der beiden User die Anfrage ablehnt, ist sie für beide abgelehnt
            else if(isset($_GET["deny"]))
            {
                $request = $db->getRequest($_GET["deny"], $currentUser->id);
                $request_reverse = $db->getRequest($currentUser->id, $_GET["deny"]); 
                $check = $db->denyRequest($request_reverse->getId());
                $check = $db->denyRequest($request->getId());
                if($check)
                {?>
                    <div class="alert alert-info alert-dismissible fade show w-50 mx-auto mb-5">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success! </strong>Freundschaftsanfrage abgelehnt!
                    </div><?php
                    echo "<meta http-equiv='refresh' content='3; url=index.php?home&section=friendRequests'>";
                }
                else
                {?>
                    <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error! </strong>Fehler beim Ablehnen!
                    </div><?php
                }
            }
        ?>
        <div class="row">
        <!--Foreach Schleife für Freundschaftsanfragen-->
            <?php  
                $requests = $db->listRequests($currentUser->id);
                if(!empty($requests))
                {
                    foreach($requests as $request)
                    {?>
                    <div class="col-md-4 my-3">
                        <div class="card">
                            <div class="card-body">
                                <!--Icon mit Farbe-->
                                <h5 class="card-title"><svg style='color:<?=$request->farbe?>' class='icon-style' width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-person-circle' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                                <path d='M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z'/>
                                <path fill-rule='evenodd' d='M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/>
                                <path fill-rule='evenodd' d='M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z'/>
                                </svg><?=" ".$request->username." "?></h5>
                                <p class="card-text"><?=$request->vorname." ".$request->nachname?> möchte mit Ihnen befreundet sein.</p>
                                <div class="inline text-white">
                                    <a class="btn btn-success mx-2 px-3" href=<?=$_SERVER["REQUEST_URI"]."&accept=".$request->id?>>Annehmen</a>
                                    <a class="btn btn-danger mx-2 px-3" href=<?=$_SERVER["REQUEST_URI"]."&deny=".$request->id?>>Ablehnen</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    }
                }
                else
                {?>
                    <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error! </strong>Sie haben keine Freundschaftsanfragen!
                    </div><?php
                }
                ?>

        </div>
    </div>

</div>