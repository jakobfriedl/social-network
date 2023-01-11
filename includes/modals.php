<!--Modals-->
<!---------------------->
<!--MODAL FÜR REGISTRIERUNG--> 
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Registrierung</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" method="post" action="<?=$_SERVER["PHP_SELF"]?>">
                    <div class="form-group">
                        <label for="anrede">Anrede: </label>
                        <select name="anrede" class="form-control">
                            <option value="Herr">Herr</option>
                            <option value="Frau">Frau</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="vorname">Vorname: </label>
                        <input type="text" name="vorname" class="form-control" placeholder="Max" required>
                    </div>
                    <div class="form-group">
                        <label for="nachname">Nachname: </label>
                        <input type="text" name="nachname" class="form-control" placeholder="Musterman" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: </label>
                        <input type="email" name="email" class="form-control" placeholder="max@mustermann.com" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Benutzername: </label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="passwort">Passwort*: </label>
                        <input type="password" name="passwort" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="passwort2">Passwort bestätigen: </label>
                        <input type="password" name="passwort2" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <small>*Passwort muss aus mind. 10 Zeichen, sowie jeweils aus mind. einer Zahl, einem Groß- und einem Kleinbuchstaben bestehen.</small>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="register" class="btn-outline-dark btn-block btn-color-1 py-2 rounded" value="Registrieren">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--MODAL FÜR LOGIN-->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Login</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--Modal Nav-->
                <ul class="nav nav-tabs pb-2" id="tabContent">
                    <li class="nav-item ml-auto active"><a href="#loginTab" data-toggle="tab">Login</a></li>
                    <li class="nav-item" ><a href="#forgotPassword" data-toggle="tab">Passwort vergessen</a></li>
                </ul><br>
                <div class="tab-content">
                    <div class="tab-pane active" id="loginTab">
                        <form class="form" method="post" action="<?=$_SERVER["PHP_SELF"]?>">
                            <div class="form-group">
                                <label for="loginUsername">Benutzername: </label>
                                <input type="text" name="loginUsername" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="loginPasswort">Passwort: </label>
                                <input type="password" name="loginPasswort" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="login" class="btn-outline-dark btn-block btn-color-2 py-2 rounded" value="Login">
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="forgotPassword">
                        <form class="form my-2" method="post" action="<?=$_SERVER["PHP_SELF"]?>">
                            <div class="form-group">
                                <label for="forgotPw">Benutzername: </label>
                                <input type="text" name="forgotPw" class="form-control" required>
                            </div>
                            <input type="submit" class="btn-outline-dark btn-block btn-color-2 py-2 rounded" name="sendPwd" value="Passwort senden">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<!--MODAL DATEN ÄNDERN-->
<div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Benutzerdaten ändern</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" method="post" action="index.php?home&section=profil">
                    <div class="form-group">
                        <label for="anredeNeu">Anrede: </label>
                        <select name="anredeNeu" class="form-control">
                        <?php
                        //Anzeigen der Anrede
                        if($currentUser->anrede == "Herr")
                        {
                            echo '<option value="Herr">Herr</option>';
                            echo '<option value="Frau">Frau</option>';
                        }
                        else
                        {
                            echo '<option value="Frau">Frau</option>';
                            echo '<option value="Herr">Herr</option>';
                        }?>         
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="vornameNeu">Vorname: </label>
                        <input type="text" name="vornameNeu" class="form-control" value="<?=$currentUser->vorname?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nachnameNeu">Nachname: </label>
                        <input type="text" name="nachnameNeu" class="form-control" value="<?=$currentUser->nachname?>" required>
                    </div>
                    <div class="form-group">
                        <label for="emailNeu">Email: </label>
                        <input type="email" name="emailNeu" class="form-control" value="<?=$currentUser->email?>" required>
                    </div>
                    <div class="form-group">
                        <label for="usernameNeu">Benutzername: </label>
                        <input type="text" name="usernameNeu" class="form-control" value="<?=$currentUser->username?>" required>
                    </div>
                    <div class="form-group">
                        <label for="farbe">Avatarfarbe: </label>
                        <input type="color" name="farbe" value="<?=$currentUser->farbe?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="editData" class="btn-outline-dark btn-block btn-color-2 py-2 rounded" value="Speichern">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--MODAL PASSWORT ÄNDERUNG-->
<div class="modal fade" id="editPass" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Passwort ändern</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" method="post" action="index.php?home&section=profil">
                    <div class="form-group">
                        <label for="oldPasswort">Altes Passwort: </label>
                        <input type="password" name="oldPasswort" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="newPasswort">Neues Passwort: </label>
                        <input type="password" name="newPasswort" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="newPasswort2">Neues Passwort bestätigen: </label>
                        <input type="password" name="newPasswort2" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="editPass" class="btn-outline-dark btn-block btn-color-2 py-2 rounded" value="Speichern">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--MODAL BEITRAGSERSTELLUNG-->
<div class="modal fade" id="uploadPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Neuen Beitrag erstellen</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-1">
                <form class="form" method="post" enctype="multipart/form-data" action="index.php?home">
                    <div class="form-inline text-left">
                        <label for="postTitel" class="w-25">Überschrift: </label>
                        <input type="text" name="postTitel" class="form-control w-75 my-2" required>
                    </div>
                    <div class="form-inline text-left">
                        <label for="postText" class="w-25">Inhalt: </label>
                        <textarea type="text" name="postText" class="form-control w-75 my-2" rows="5"></textarea>
                    </div>
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input my-2" id="customFile" name="postBild">
                        <label class="custom-file-label" for="postBild">Bild hochladen</label>
                    </div>
                    <label>Freigeben für: </label>
                    <div class="pl-5">
                        <div class="form-check">
                            <input class="form-check-input my-2" type="radio" name="postAccess" value="public" checked>
                            <label class="form-check-label" for="postAccess"> Alle</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input my-2" type="radio" name="postAccess" value="private">
                            <label class="form-check-label" for="postAccess"> Nur Freunde</label>
                        </div>
                    </div> 
                    <!--Checkboxen für Tags-->
                    <div class="mt-2">
                        <label>Tags: </label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="tag[]" value="Sport">
                            <label class="form-check-label" for="tag[]">Sport</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="tag[]" value="Nachrichten">
                            <label class="form-check-label" for="tag[]">Nachrichten</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="tag[]" value="Natur">
                            <label class="form-check-label" for="tag[]">Natur</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="tag[]" value="Humor">
                            <label class="form-check-label" for="tag[]">Humor</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="tag[]" value="Politik">
                            <label class="form-check-label" for="tag[]">Politik</label>
                        </div>
                        <!--Eigenen Tag hinzufügen-->
                        <input type="text" class="form-control" name="tagOther" placeholder="Other...">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="uploadPost" class="btn-outline-dark btn-block btn-color-2 py-2 rounded mt-4" value="Hochladen">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--FREUNDSCHAFTSANFRAGEN SENDEN-->
<div class="modal fade" id="sendFriendrequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Neue Freundschaftsanfrage</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" method="post" action="index.php?home&section=newFriend">
                    <div class="input-group">
                        <input name="suchen" type="text" class="form-control" placeholder="Suchen...">
                        <div class="input-group-btn">
                        <button name="freundSuchen" class="btn btn-dark rounded-0" type="submit"><?=$search?></button>
                        </div>
                    </div>
                    <small>Suchen Sie nach Vor-, Nach-, oder Benutzernamen eines Users.</small><br>
                </form>
            </div>
        </div>
    </div>
</div>


<!--Script für Beitragsupload-->
<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>

<!--Script für Tooltips-->
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>