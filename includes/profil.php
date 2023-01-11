<div>
    <h2 class="text-center">Einstellungen</h2>
    <div class="mx-5 mt-3 pt-3 text-justify border-top">
        <h4>Profileinstellungen</h4>
        <?php
        if(isset($_POST["editData"]))
        {
            $editUser = new User($currentUser->id, $_POST["anredeNeu"], $_POST["vornameNeu"], $_POST["nachnameNeu"], $_POST["emailNeu"], $_POST["usernameNeu"], $currentUser->passwort, $_POST["farbe"]);
            $check = $db->updateUser($editUser);
            if($check)
            {?>
                <div class="alert alert-info alert-dismissible fade show w-50 mx-auto mb-5">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success! </strong>Benutzerdaten erfolreich aktualisiert!
                </div><?php
                $_SESSION["currentUser"]=$editUser->getUsername();
                echo "<meta http-equiv='refresh' content='1; url=index.php?home&section=profil'>";
            }
            else
            {?>
                <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error! </strong>Fehler beim Aktualisieren der Daten!
                </div><?php
            }
        }
        if(isset($_POST["editPass"]))
        {
            $valid = true; 

            //Altes Passwort verifizieren
            if(!password_verify($_POST["oldPasswort"], $currentUser->passwort))
            {?>
                <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error! </strong>Altes Passwort muss korrekt bestätigt werden!
                </div><?php
            }
            else //Neue Passwörter verifizieren
            {
                if($_POST["newPasswort"]!=$_POST["newPasswort2"])
                {?>
                    <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error! </strong>Passwörter stimmen nicht überein!
                    </div><?php
                }
                else
                {
                    //Stärke des Passworts validieren
                    $passwort = $_POST["newPasswort"]; 
                    $uppercase = preg_match('@[A-Z]@', $passwort);
                    $lowercase = preg_match('@[a-z]@', $passwort);
                    $number = preg_match('@[0-9]@', $passwort);
                    
                    if(strlen($passwort)<10 || !$uppercase || !$lowercase || !$number)
                    {
                        $valid = false; 
                    }

                    if($valid)
                    {
                        $hash = password_hash($_POST["newPasswort"], PASSWORD_DEFAULT);
                        $check = $db->updatePassword($currentUser, $hash);
                        if($check)
                        {?>
                            <div class="alert alert-info alert-dismissible fade show w-50 mx-auto mb-5">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Success! </strong>Passwort erfolreich aktualisiert!
                            </div><?php
                        }
                        else
                        {?>
                            <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Error! </strong>Fehler beim aktualisieren des Passworts!
                            </div><?php
                        }
                    }
                    else
                    {?>
                        <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Error! </strong>Passwort zu schwach!
                        </div><?php
                    }
                }
            }
        }
        ?>
        <div class="container row">
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th scope="row">Anrede:</th>
                        <td><?=$currentUser->anrede?></td>
                    </tr>
                    <tr>
                        <th scope="row">Vorname:</th>
                        <td><?=$currentUser->vorname?></td>
                    </tr>
                    <tr>
                        <th scope="row">Nachname:</th>
                        <td><?=$currentUser->nachname?></td>
                    </tr>
                    <tr>
                        <th scope="row">Email:</th>
                        <td><?=$currentUser->email?></td>
                    </tr>
                    <tr>
                        <th scope="row">Benutzername:</th>
                        <td><?=$currentUser->username?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 my-auto">
                <button class="btn btn-light btn-block" data-toggle="modal" data-target="#editData"><?=$edit;?> Benutzerdaten ändern</button><br>
                <button class="btn btn-light btn-block" data-toggle="modal" data-target="#editPass"><?=$schluessel;?> Passwort ändern</button><br>
            </div>    
        </div>
    </div>  
</div>
