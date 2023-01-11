<div class="container-fluid">
<ul class="navbar-nav d-flex flex-row">
    <h1><a href="index.php?home">Contact Point</a></h1>
    <!-- Icon dropdown -->
    <li class="nav-item mr-3 mr-lg-0 dropdown ml-auto my-auto text-center text-dark">
    <?php
    //Dropdown Menü (Icon und Username)
    if(isset($_SESSION["currentUser"]) && !empty($_SESSION["currentUser"]))
        echo '<a class="nav-link text-dark" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false"><strong><label class="text-center ml-auto mr-2 my-auto" style="vertical-align:middle; font-size: 2em; -webkit-text-stroke: 1px black; color:'.$currentUser->farbe.'";">'.$currentUser->vorname.' '.$currentUser->nachname.'</label></strong><label> '.$avatar.'</label></a>';
    else
        echo '<a class="nav-link text-dark" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">'.$avatar.'</a>';
    ?>
    <ul class="dropdown-menu dropdown-menu-right text-right" aria-labelledby="navbarDropdown">
        <?php
        if(isset($_SESSION["currentUser"]) && !empty($_SESSION["currentUser"]))
            echo '<li><a class="dropdown-item btn-light font-weight-bold dd-hover" href="index.php?home&section=logout">Logout</a>';
        else
            echo '<li><a class="dropdown-item btn-light font-weight-bold dd-hover" href="index.php">Login</a>';
        ?>
        <div class="dropdown-divider"></div>
        <li><a class="dropdown-item btn-light dd-hover" href="index.php?home">Home</a></li>
        <div class="dropdown-divider"></div>
        <li><a class="dropdown-item btn-light dd-hover" href="index.php?home&section=hilfe">Hilfe</a></li>
        <div class="dropdown-divider"></div>
        <li><a class="dropdown-item btn-light dd-hover" href="index.php?home&section=impressum">Impressum</a></li>
        <?php
        if(isset($_SESSION["currentUser"]) && !empty($_SESSION["currentUser"]))
        {
            //Einstellungen werden nur für eingeloggte User angezeigt
            echo '<div class="dropdown-divider"></div>';
            echo '<li><a class="dropdown-item btn-light dd-hover" href="index.php?home&section=profil">Einstellungen</a></li>';
        }
        ?>
        </li>
    </ul>
    </li>
</ul>
</div>