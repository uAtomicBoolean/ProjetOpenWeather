<?php
session_start();
// Si le cookie n'existe pas, on renvoi à l'index.
if (!(isset($_SESSION['pseudo']))){
    header('Location: ../index.php');
}

// On récupère le nombre de visistes.
$fichier = fopen('../files/visites.txt', "r");
$nbVisite = intval(fgets($fichier));
fclose($fichier);

// On récupère le nombre de recherches.
$fichier = fopen('../files/recherches.txt', "r");
$nbRecherche = intval(fgets($fichier));
fclose($fichier);

// On récupère le nombre de comptes existant.
$lignes = file("../files/accounts.csv");
$nbComptes = sizeof($lignes);

// On récupère le nombre de comptes administrateur et régulier.
$admin = 0;
$regular = 0;
for ($k = 0; $k < sizeof($lignes); $k++){
    $temp = str_replace("\n", '', $lignes[$k]);
    $ligne = explode(";", $temp);
    if ($ligne != []) {
        if ($ligne[2] == "true") {
            $admin++;
        } else {
            $regular++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Compte - <?php if (isset($_SESSION['pseudo'])){ echo $_SESSION['pseudo']; }?></title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="../assets/style.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
    <script src="../scripts/bouton_comptes.js"></script>
</head>

    <body>
        <script>
            function launchStats(){
                afficherVisites(<?php echo $nbVisite . ", " . $nbRecherche; ?>);
                afficherComptes(<?php echo $regular . ", " . $admin; ?>);
            }
        </script>

        <header>
            <a href="../index.php"><img id="logo" alt="Logo" src="../assets/logo_site.jpg"/></a>
            <h1 id="main_title">Météo</h1>
            <a id='bouton_deconnexion' href='../scripts/deconnexion.php'>Deconnexion</a>
        </header>

        <div class="conteneur">
            <div id="div_boutons_compte">
                <h2 id="titre_pseudo"><?php
                    if (isset($_SESSION['pseudo'])){
                        echo $_SESSION['pseudo'];
                    }
                    else{
                        header('Location: ../scripts/deconnexion.php');
                    }
                    ?></h2>
                <button id="bouton_parametres" onclick="afficherParametres();">Paramètres</button>
                <?php
                $fichier = file('../files/accounts.csv');
                for ($k = 0; $k < sizeof($fichier); $k++){
                    $ligne = str_replace("\n", '', $fichier[$k]);
                    $ligne = explode(';', $ligne);
                    if ($ligne[0] == $_SESSION['pseudo'] AND $ligne[2] == "true"){
                        echo "<button id='bouton_stats' onclick='launchStats();'>Statistiques</button>";
                    }
                }
                ?>

            </div>
            <div id="trait_separateur"></div>

            <div id="Parametres"></div>

            <div id="Statistiques">
                <div id="pieVisite">
                    <canvas id="dataVisites"></canvas>
                </div>
                <div id="pieComptes">
                    <canvas id="dataComptes"></canvas>
                </div>
            </div>
            <?php
            if (isset($_GET['erreur'])){
                if ($_GET['erreur'] == "1"){
                    ?> <script>afficherParametres("L'ancien mot de passe est erroné.");</script> <?php
                }
            }
            ?></div>

    </body>
</html>