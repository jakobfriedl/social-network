<?php
//Function to generate a new Password
function generatePassword($length)
{
    $generatedPassword = "";
    $characters = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    //Length of Char Array
    $charsLength = strlen($characters)-1; 
    for($i = 0; $i < $length; $i++)
    {
        $randomNr = rand(0, $charsLength); 
        $generatedPassword .= $characters[$randomNr]; 
    }
    return $generatedPassword; 
}
?>
<!--Main Page Design-->
<div class="bg-color">
<?php
        //Register User
        if(isset($_POST["register"]))
        {
            $valid = true; 
            if($_POST["passwort"]!=$_POST["passwort2"])
            {?>
                <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error! </strong>Passwort muss korrekt bestätigt werden!
                </div><?php
            }
            else
            {
                //Stärke des Passworts validieren
                $passwort = $_POST["passwort"]; 
                $uppercase = preg_match('@[A-Z]@', $passwort);
                $lowercase = preg_match('@[a-z]@', $passwort);
                $number = preg_match('@[0-9]@', $passwort);
                
                if(strlen($passwort)<10 || !$uppercase || !$lowercase || !$number)
                {
                    $valid = false; 
                }
                
                if($valid)
                {
                    //encyrpt Password
                    $hash = password_hash($_POST["passwort"], PASSWORD_DEFAULT); 
                    $newUser = new User(NULL, $_POST["anrede"], $_POST["vorname"], $_POST["nachname"], $_POST["email"], $_POST["username"], $hash, NULL);
                    $check = $db->registerUser($newUser); 
                    if($check)
                    {?>
                        <div class="alert alert-info alert-dismissible fade show w-50 mx-auto mb-5">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success! </strong>Benutzer wurde erfolreich registriert!
                        </div><?php
                    }
                    else
                    {?>
                        <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Error! </strong>Fehler beim Registrieren!
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
        //Login User
        if(isset($_POST["login"]))
        {
            $check = $db->loginUser($_POST["loginUsername"], $_POST["loginPasswort"]); 
            if(!$check)
            {?>
                <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error! </strong>Passwort oder Benutzername fehlerhaft!
                </div><?php
            }
            else
            {
                $_SESSION["currentUser"]=$_POST["loginUsername"];
                echo "<meta http-equiv='refresh' content='0; url=index.php?home'>"; 
            }
        }

        //Forgot Password --> send to email
        if(isset($_POST["forgotPw"]) && !empty($_POST["forgotPw"]))
        {
            $user = $db->getUserFromName($_POST["forgotPw"]); 
            if($user->id == NULL)
            {?>
                <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error! </strong>Kein Benutzer mit diesem Namen gefunden!
                </div><?php
            }
            else
            {
                //Generate new Password and send it per Mail
                $email = $user->email;
                $subject = "Neues Passwort"; 
                $newPw = generatePassword(10); 
                
                //Anrede überprüfen
                if($user->anrede == "Herr")
                    $anrede = "geehrter Herr";
                else
                    $anrede = "geehrte Frau"; 

                $body = "Sehr ". $anrede ." ". $user->nachname."!\n\nIhr neues Passwort lautet: ". $newPw ."\nVergessen Sie nicht es nach dem Einloggen zu ändern!";
                $header = "From: webhausuebung@gmail.com"; 

                $hash = password_hash($newPw, PASSWORD_DEFAULT); 
                $check = $db->updatePassword($user, $hash); 
                if($check)
                {
                    if(mail($email, $subject, $body, $header))
                    {?>
                        <div class="alert alert-info alert-dismissible fade show w-50 mx-auto mb-5">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success! </strong>Neues Passwort wurde an die Email-Adresse des Users geschickt!
                        </div><?php
                    }
                    else
                    {?>
                        <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Error! </strong>Fehler beim Senden der Email!
                        </div><?php
                    }
                }
                else
                {?>
                    <div class="alert alert-danger alert-dismissible fade show w-50 mx-auto mb-5">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error! </strong>Fehler beim Ändern des Passworts!
                    </div><?php
                }
            }

        }

        ?>
    <div class="container flex">
        <h1>Contact Point</h1>
        <button type="button" class="btn-outline-dark btn-style-1 btn-color-1" data-toggle="modal" data-target="#register">Registrieren</button>
        <button type="button" class="btn-outline-dark btn-style-1 btn-color-2" data-toggle="modal" data-target="#login">Login</button>
        <a href="index.php?home" class="btn-light btn-style-2">Gast</a>
    </div>
</div>