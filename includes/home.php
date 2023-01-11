<!--Header-->
<div class="bg-color pt-3 pb-1 px-4 bb sticky-top">
    <div class="navbar-nav w-100">
        <?php
            include "nav.php";
        ?>
    </div>
</div>
<!--Content-->
<div class="container mt-3 main-wrapper">
    <?php
    //Includes
    if(isset($_GET["section"]))
    {
        switch($_GET["section"])
        {
            case 'hilfe': 
                echo "<div class='container'>";
                    include "hilfe.php";
                echo "</div>";
            break;
            case 'impressum': 
                echo "<div class='container'>";
                    include "impressum.php";
                echo "</div>";
            break;
            case 'profil': 
                echo "<div class='container'>";
                    include "profil.php";
                echo "</div>";
            break;
            case 'chat':
                echo "<div class='container'>";
                    include "chat.php";
                echo "</div>";
            break; 
            case 'freunde':
                echo "<div class='container'>";
                    include "displayFriends.php";
                echo "</div>";
            break; 
            case 'friendRequests':
                echo "<div class='container'>";
                include "friendRequests.php";
                echo "</div>";
            break;
            case 'newFriend':
                echo "<div class='container'>";
                include "newFriend.php";
                echo "</div>";
            break;
            case 'logout':
                //Logout
                session_unset(); 
                echo "<meta http-equiv='refresh' content='0; url=index.php'>"; 
            break;
            default: 
                echo "<div>";
                    include "mainfeed.php";
                echo "</div>";
            break;
        }
    }
    else
    {
        echo "<div>";
            include "mainfeed.php";
        echo "</div>";
    }
    ?>
</div>
