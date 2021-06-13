<!DOCTYPE html>
<html lang="EN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EenmaalAndermaal</title>
    <link rel="stylesheet" href="<?=ROOT?>Data/bulma/css/mystyles.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css'>
    <link rel="stylesheet" href="<?=ROOT?>Data/style/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>

</head>



<body class="fixed-wrapper">

<nav class="navbar px-5 has-shadow" aria-label="main navigation">
    <div class="navbar-brand large">
        <a style="font-size: 20px;" class="navbar-item" href="/Home">
            <img src="https://iproject18.ip.aimsites.nl/Data/img/splash.png" alt="" width="20" height="30">&nbsp;EenmaalAndermaal
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="/Rubrieken/Pagina">
                Alle Veilingen
            </a>
            <?php if (!empty($args["itemlists"][0])) { ?>
            <?php foreach ($args["itemlists"] as $itemlist) { ?>
            <a class="navbar-item" href="/Rubrieken/Pagina/1/<?=$itemlist["Rubrieknummer"]; ?>">
                <?=$itemlist["Rubrieknaam"]; ?>
            </a>

            <?php } } ?>
        </div>
        <div class="navbar-end pl-3" style="align-items: center;">
            <div class="field has-addons">
                <?php
                if ($args["isVerkoper"]) {
                    echo '<form action="/Veiling">';
                    echo '<button class="button is-primary mr-3">Plaats Veiling</button>';
                    echo '</form>';
                }
                ?>
            </div>
        </div>
        <div class="navbar-item pr-6 has-dropdown is-hoverable">
            <a class="navbar-link is-hidden-touch" href="/Instellingen">
                <i class="fa fa-user-circle is-hidden-touch" aria-hidden="true"></i>
            </a>

            <div class="navbar-dropdown">
                <?php if (!$args["Loggedin"]) { ?>
                    <a class="navbar-item" href="/Login">
                        Login
                    </a>
                    <a class="navbar-item" href="/Register">
                        Register
                    </a>
                <?php } else { ?>
                    <a class="navbar-item" href="/Instellingen">

                        <?php echo $_SESSION["Voornaam"]; ?></a>
                    <a class="navbar-item" href="/Login/Logout">
                        Logout
                    </a>
                <?php } ?>

            </div>
        </div>



    </div>
</nav>
