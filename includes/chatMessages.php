<!--New Chatmessage-->
<?php
    if(isset($_POST["message"]) && !empty($_POST["message"]))
    {
        $receiver = $db->getUserFromID($_GET["chat"]); 
        $timestamp = date('d.m.Y - H:i:s'); 
        $status = "sent";
        $message = $_POST["message"]; 
        $chat = $db->getChat($currentUser->id, $receiver->id); 

        //Neue Nachricht erstellen
        $message = new Nachricht(NULL, $message, $timestamp, $status, $currentUser->id, $chat->id);
        $check = $db->newMessage($message); 

        echo "<meta http-equiv='refresh' content='0; url=".$_SERVER["REQUEST_URI"]."'>";
    }
?>
<div class="container mx-3 my-3">
    <?php
    if(isset($_GET["chat"]))
    {
        $friend = $db->getUserFromID($_GET["chat"]);
        //Überprüfen, ob bereits ein Chat der beiden User existiert
        $chat = $db->getChat($currentUser->id, $friend->id); 
        //Wenn nicht wird ein neuer erzeugt
        if($chat->id == NULL)
            $check = $db->startChat($chat);
        ?>
        <h4 class="border-bottom pb-2">
        <!--Icon-->
        <svg style='color:<?=$friend->farbe?>' class='icon-style' width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-person-circle' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
        <path d='M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z'/>
        <path fill-rule='evenodd' d='M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/>
        <path fill-rule='evenodd' d='M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z'/>
        </svg> <?=$friend->vorname." ".$friend->nachname?></h4>
        <div class="overflow-auto pr-3" style="max-width: 100%; height: 55vh;">
        
        <!--Nachrichtenfeld-->
        <?php
            $messages = $db->getMessages($chat->id); 
    
            foreach($messages as $message)
            {
                //Status der Nachricht
                if($message->status == "sent") 
                    $statusIcon = $notRead; 
                else
                    $statusIcon = $read; 

                //Nachrichten, abhängig vom Versender anzeigen
                if($message->verfasser == $currentUser->id)
                {?>
                    <div class="message-right ml-auto w-75 my-2">
                        <div class="text-right pr-3 py-2">
                            <label><?=$message->nachricht?></label><small> | <?=$message->timestamp." ".$statusIcon?></small>
                        </div>
                    </div><?php
                }
                else
                {
                    //Messages lesen / Status updaten
                    $check = $db->readMessage($message); 
                    ?>
                    <div class="message-left w-75 my-2">
                        <div class="pl-3 py-2">
                            <small><?=$message->timestamp?> | </small><label><?=$message->nachricht?></label>
                        </div>
                    </div><?php
                }
            }
        ?>
        </div>

        <!--Nachricht verfassen-->
        <form class="form mt-2" method="post" action="<?=$_SERVER["REQUEST_URI"]?>">
            <div class="input-group">
                <input name="message" type="text" class="form-control" placeholder="Nachricht...">
                <div class="input-group-btn">
                    <button class="btn btn-dark rounded-0" type="submit"><?=$sendMessage?></button>
                </div>
            </div>
        </form>
        
    <?php
    }
    else
    {?>
        <div class="alert alert-danger alert-dismissible fade show w-75 mx-auto mt-5">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <label>Keinen Chat ausgewählt!</label><br>
            <small>Starten Sie einen neuen Chat, indem Sie links auf einen Kontakt klicken!</small>
        </div><?php
    }
    ?>
</div>