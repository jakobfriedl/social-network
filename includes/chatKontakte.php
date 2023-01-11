<h4 class="border-bottom pb-2 my-3">Kontakte</h4>
<div class="overflow-auto pr-3" style="max-width: 100%; max-height: 60vh;">
    <!--Foreach Schleife für alle Freunde-->
    <?php
        $friends = $db->listFriends($currentUser); 
        foreach($friends as $friend)
        {
            if($friend != $currentUser)
            {
                //Letzte Nachricht des Chatverlaufs bekommen
                $chat = $db->getChat($currentUser->id, $friend->id); 
                if($chat->id != NULL)
                {
                    $messagelist = $db->getMessages($chat->id); 
                    if(!empty($messagelist))
                        $latestMessage = $messagelist[count($messagelist)-1]; 
                }
                ?>
                <div class="card my-2">
                    <a href="index.php?home&section=chat&chat=<?=$friend->id?>" class="btn btn-white text-left">
                        <h5 class="pb-1 border-bottom">
                        <!--Icon-->
                        <svg style='color:<?=$friend->farbe?>' class='icon-style' width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-person-circle' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z'/>
                        <path fill-rule='evenodd' d='M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/>
                        <path fill-rule='evenodd' d='M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z'/>
                        </svg> <?=$friend->username?></h5>
                        <?php
                            if(isset($latestMessage))
                            {
                                if($latestMessage->verfasser == $friend->id)
                                {
                                    if($latestMessage->status == "sent") //Wenn Nachricht noch nicht gelesen wurde, wird sie fett dargestellt
                                        echo '<label class="font-weight-bold" style="color:'.$friend->farbe.';">'.$friend->username.'</label>: <label class="font-weight-bold">'.$latestMessage->nachricht.'</label><br>';
                                    else
                                        echo '<label class="font-weight-bold" style="color:'.$friend->farbe.';">'.$friend->username.'</label>: <label>'.$latestMessage->nachricht.'</label><br>';
                                }
                                else
                                {
                                    echo '<label>'.$latestMessage->nachricht.'</label><br>';
                                }
                                echo '<small class="font-italic text-right">'.$latestMessage->timestamp.'</small>';
                                unset($latestMessage); 
                            }
                            else
                            {
                                echo '<label class="text-danger font-italic">Noch keine Nachrichten vorhanden!</label>';
                            }
                        ?>
                    </a>
                </div>
            <?php
            }
        }
    ?>
</div>