<div class="row">
    <?php
    if(isset($_SESSION["currentUser"]) && !empty($_SESSION["currentUser"]))
    {?>
    <div class="col-md-5">
        <div class="container border mb-2 bg-light rounded" style="height: 40vh;">
            <!--Freundschaften-->
            <?php
                include "friendList.php"; 
            ?>
        </div>
        <div class="container mb-5" style="height: 30vh;">
            <!--Freundschaftsanfragen / Chat-->
            <?php
                include "friendManagement.php";
            ?>
        </div>
    </div>
    <div class="col-md-7 border bg-light rounded" style="height: 80vh;">
    <?php
    }
    else //Im Gast-Zustand wird das Feed größer dargestellt
        echo '<div class="border bg-light"></div>';
    ?>
        <!--Beiträge-->
        <?php
            include "postFeed.php"; 
        ?>
    </div>
</div>