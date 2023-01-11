<div>
    <h2 class="text-center">Benutzeranleitung</h2>
    <div class="mx-5 mt-3 pt-3 text-justify border-top">
        <?php
            if(isset($_SESSION["currentUser"]))
            {?>
                <p>Herzlich Willkommen! Hier haben Sie die Möglichkeit, aktuelle Ereignisse Ihres Lebens mit der ganzen Welt zu teilen. Sie können Beiträge (inklusive Fotos und Tags) hochladen und öffentlich bzw. nur für Ihre Freunde, die Sie hier ebenfalls finden können, freigeben.</p>
                <p>Natürlich können Sie die Beiträge Ihrer Freunde und Bekannten liken, disliken und kommentieren. Zudem gibt es eine Such- bzw. Filterfunktion, mit der Sie nur bestimmte Beiträge anzeigen können.</p>
                <p>Ist ein Gesprächsthema zu privat für einen öffentlichen Kommentar, so können Sie dem jeweiligen Freund eine private Nachricht über den <a class="text-info" href="index.php?home&section=chat">Chat</a> senden.</p>
                <p>Falls Sie mit Ihren Benutzerdaten unzufrieden sind, können Sie dieser in den <a class="text-info" href="index.php?home&section=profil">Einstellungen</a> ändern. Weiters kann dort auch das Passwort geändert werden.</p>
                <p>Im <a class="text-info" href="index.php?home&section=impressum">Impressum</a> finden Sie Informationen zum Ersteller der Website.</p>
                <p>Wenn Sie auf das Schriftzug-Logo der Website klicken kommen Sie zurück zur Homepage.</p>
            <?php
            }
            else
            {?>
                <p>Herzlich Willkommen! Hier haben Sie die Möglichkeit, aktuelle Ereignisse Ihres Lebens mit der ganzen Welt zu teilen. Sie können Beiträge (inklusive Fotos und Tags) hochladen und öffentlich bzw. nur für Ihre Freunde, die Sie hier ebenfalls finden können, freigeben.</p>
                <p>Natürlich können Sie die Beiträge Ihrer Freunde und Bekannten liken, disliken und kommentieren. Zudem gibt es eine Such- bzw. Filterfunktion, mit der Sie nur bestimmte Beiträge anzeigen können.</p>
                <p>Es gibt zudem eine Chatfunktion, über die Sie Ihren Freunden private Nachrichten schicken können.</p>
                <p>Falls Sie schon einen Account haben können Sie sich <a class="text-info" href="index.php">hier</a> einloggen. Andernfalls können Sie sich kostenfrei registrieren.</p>
            <?php
            }
        ?>
    </div>  
    
</div>
