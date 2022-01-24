<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Inscription</title>
        <link rel="stylesheet" type="text/css" href="../assets/style.css"/>
        <meta charset="UTF-8"/>
        <script src="../scripts/check_inscription.js"></script>
    </head>

    <body>
        <header>
            <a href="../index.php"><img id="logo" alt="Logo" src="../assets/logo_site.jpg"/></a>
            <h1 id="main_title">Météo</h1>
            <a id="connection" href="page_connexion.php?id_error=0">Connexion</a>
        </header>

        <div id="espace_connexion">
            <h2 id="titre_connexion">Inscription</h2>

            <form method="post" action="../scripts/inscription.php" id="formulaire_inscription">
                <label for="identifiant">Identifiant:</label>
                <input type="text" id="identifiant" class="input" name="input_id"/>
                <p class="error" id="errorID"><?php if (isset($_GET['id_error'])){ if ($_GET['id_error'] == '1'){ echo "L'identifiant existe déjà."; }} ?></p>

                <label for="password">Mot de passe<span class="asterix">*</span>:</label>
                <input type="password" id="password" class="input" name="input_passwd" minlength="6" required />

                <label for="password2">Entrez à nouveau le mot de passe<span class="asterix">*</span>:</label>
                <input type="password" id="password2" class="input" minlength="6" required />
                <p class="error" id="errorMDP"></p>

                <input type="button" id="bouton_ic" value="S'inscrire" onclick="checkInscription();"/>

                <p id="infos_asterix">
                    *6 caractères minimum.
                </p>
            </form>
        </div>

    </body>
</html>