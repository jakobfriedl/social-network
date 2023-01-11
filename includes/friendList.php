<div class="nav border-bottom">
    <h4 class="pt-2 pb-2 pl-2 font-italic">Freunde</h4>
    <a class="nav-link text-dark link-hover ml-auto my-auto" id="friendListDD" role="button" data-toggle="dropdown" aria-expanded="false"><?=$showMore?></a>
    <ul class="dropdown-menu dropdown-menu-right text-right" aria-labelledby="friendListDD">
        <li><a class="dropdown-item btn-light font-weight-bold dd-hover" href="index.php?home&section=freunde">Freunde anzeigen</a>
    </ul>
</div>
<div class="overflow-auto pr-3" style="max-width: 100%; height: 28vh;">
    <div class="row">
        <!--Foreach Schleife für Freundesliste-->
        <?php
            //Alle Freunde des Users abfragen
            $friendList = $db->listFriends($currentUser); 
            if(!empty($friendList))
            {
                $_SESSION["friends"]=$friendList;
                foreach($_SESSION["friends"] as $friend)
                {
                    if($friend != $currentUser)
                    {?>
                    <div class="col-md-4">
                        <div class="card mt-2">
                            <div class="card-header bg-transparent mx-auto">
                                <!--ICON mit Farbe-->
                                <svg style='color:<?=$friend->farbe?>' class='icon-style' width='2.5em' height='2.5em' viewBox='0 0 16 16' class='bi bi-person-circle' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                                <path d='M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z'/>
                                <path fill-rule='evenodd' d='M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/>
                                <path fill-rule='evenodd' d='M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z'/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <small class="card-text"><?=$friend->vorname."<br>".$friend->nachname?></small>
                            </div>
                        </div>
                    </div><?php
                    }
                }
            }
            else
            {?>
                <div class="alert alert-danger alert-dismissible fade show w-75 mx-auto mt-5 mb-5">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <label>Noch keine Freunde gefunden!</label><br>
                    <small>Erstellen Sie doch eine neue Freundschaftsanfrage!</small>
                </div><?php
            }
        ?>
    </div>
</div>