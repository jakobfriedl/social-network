<?php
    $nrRequests = $db->nrRequests($currentUser->id); 
    $nrMessages = $db->countMessages($currentUser->id); 
?>
<div class="container">
    <a href="index.php?home&section=friendRequests" class="btn btn-info btn-block py-3">ausstehende Freundschaftsanfragen <span class="badge badge-light"><?=$nrRequests?></span></a>
    <button class="btn btn-info btn-block py-3" data-toggle="modal" data-target="#sendFriendrequest">Neue Freundschaftsanfrage</button>
    <a href="index.php?home&section=chat" target="blank" class="btn btn-info btn-block py-3">Nachrichten <span class="badge badge-light"><?=$nrMessages?></span></a>
    <button class="btn btn-info btn-block py-3" data-toggle="modal" data-target="#uploadPost">Neuer Beitrag</button>
</div>