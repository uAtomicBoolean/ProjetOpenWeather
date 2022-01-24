<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Connexion</title>
        <link rel="stylesheet" type="text/css" href="../assets/style.css"/>
        <meta charset="UTF-8"/>
    </head>

    <body>
        <header>
            <a href="../index.php"><img id="logo" alt="Logo" src="../assets/logo_site.jpg"/></a>
            <h1 id="main_title">Météo</h1>
            <a id="register" href="page_inscription.php?id_error=0">Inscription</a>
        </header>

        <div id="espace_connexion">
            <h2 id="titre_connexion">Connexion</h2>

            <form method="post" action="../scripts/connexion.php" id="formulaire_connexion">
                <label for="identifiant">Identifiant:</label>
                <input type="text" id="identifiant" class="input" name="input_id"/>
                <p class="error" id="error_id"></p>

                <label for="password">Mot de passe<span class="asterix">*</span>:</label>
                <input type="password" id="password" class="input" name="input_passwd" minlength="6" required />
                <p class="error" id="error_pswd">
                    <?php
                        if (isset($_GET['mdp_error'])){
                            if ($_GET['mdp_error'] == "2"){
                                echo "Le mot de passe ou l'identifiant est erroné.";
                            }
                        }
                    ?>
                </p>

                <input type="button" id="bouton_ic" value="Se connecter" onclick="checkEmptyInput();"/>

                <p id="infos_asterix">
                    *6 caractères minimum.
                </p>
            </form>
        </div>

    <script src="../scripts/check_connexion.js"></script>
    </body>
</html>