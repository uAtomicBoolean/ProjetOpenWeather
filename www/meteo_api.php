<?php
session_start();
$connected = false;
if (isset($_SESSION['pseudo'])) {
    $fichier = file('./files/accounts.csv');
    for ($k = 0; $k < sizeof($fichier); $k++){
        $ligne = explode(';', $fichier[$k]);
        if ($ligne[0] == $_SESSION['pseudo']){
            $connected= true;
            break;
        }
    }
}

// Ajoute +1 au compteur de recherches.
$fichier = fopen('./files/recherches.txt', "r");
$nbRecherche = intval(fgets($fichier));
fclose($fichier);
$nbRecherche += 1;
$fichier = fopen("./files/recherches.txt", "w");
fwrite($fichier, strval($nbRecherche));
fclose($fichier);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Meteo</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="./assets/style.css"/>
    </head>

    <body>
        <header>
            <a href="index.php"><img id="logo" alt="Logo" src="./assets/logo_site.jpg"/></a>
            <h1 id="main_title">Météo</h1>
            <?php
            if ($connected){
                echo "<a id='bouton_deconnexion' href='./scripts/deconnexion.php'>Deconnexion</a>";
                echo "<a id='compte_user' href='subpages/compte.php'>Comptes</a>";
            }
            else{
                echo "<a id='register' href='./subpages/page_inscription.php?id_error=0'>Inscription</a>";
                echo "<a id='connection' href='./subpages/page_connexion.php?id_error=0'>Connexion</a>";
            }
            ?>

        </header>

        <div class="conteneur">
            <h2 id="nom_ville"><?php echo $_GET['ville']; ?></h2>
            <?php
                $request = file_get_contents("https://www.prevision-meteo.ch/services/json/" . $_GET['ville']);
                // $request = file_get_contents("./assets/nantes.json");
                $request = json_decode($request, true);
            ?>

            <?php
                 if (!(isset($request['current_condition']['hour']))){
                     echo "<div id='infos_ville'><p id='error_ville'>Désolé, nous n'avons pas d'information sur cette ville.</p></div>";
                 }
                 else{
                        ?><div id="infos_ville">
                 <table>
                     <tr><td class="info">Heure:</td>
                         <td><?php echo $request['current_condition']['hour']; ?></td></tr>
                     <tr><td class="info">Température:</td>
                         <td><?php echo $request['current_condition']['tmp']; ?>°C</td></tr>
                     <tr><td class="info">Humidité:</td>
                         <td><?php echo $request['current_condition']['humidity']; ?>%</td></tr>
                     <tr><td class="info">Vitesse du vent:</td>
                         <td><?php echo $request['current_condition']['wnd_spd']; ?> km/h</td></tr>
                     <tr><td class="info">Condition métérologique:</td>
                         <td><?php echo $request['current_condition']['condition']; ?></td></tr>
                 </table>
                 <img class="icon_condition" alt="Icon condition" src='<?php
                 echo $request['current_condition']['icon']; ?>'/>
            </div>
            <?php
                $nb_jour = 1;
                $nb_iteration = 0;
                if ($_GET['actuel'] === "1") {
                    $nb_jour = 0;
                    $nb_iteration = 1;
                }

                if ($_GET['3jours'] === "1"){
                    if ($nb_iteration == 1){
                        $nb_iteration += 3;
                    }
                    else{
                        $nb_iteration += 4;
                    }
                }
                $cle_jour = "fcst_day_";

                for ($k = $nb_jour; $k < $nb_iteration; $k++) {
                    $day_key = $cle_jour . $k;
                    echo "<div class='jour'>";
                    echo "<h2>" . $request[$day_key]['day_long'] . "</h2>";

                    echo "<table class='meteo'>";
                    echo "<tr>";
                    for ($h = intval($_GET['debut']); $h < intval($_GET['fin'])+1; $h++) {
                        echo "<td class='heure'>$h" . "H00</td>";
                    }
                    echo "</tr>";

                    echo "<tr>";
                    for ($c = intval($_GET['debut']); $c < intval($_GET['fin'])+1; $c++) {
                        $temp = $request[$day_key]['hourly_data'][$c . "H00"]['TMP2m'];
                        $temp *= -1;
                        $temp = $temp * -15;

                        echo "<td><img style='margin-bottom:" . $temp . "px;' alt='Icon' src='" .
                            $request[$day_key]['hourly_data'][$c . "H00"]['ICON'] . "'></td>";
                    }
                    echo "</tr>";

                    echo "<tr>";
                    for ($t = intval($_GET['debut']); $t < intval($_GET['fin'])+1; $t++) {
                        $temp = $request[$day_key]['hourly_data'][$t . "H00"]['TMP2m'];
                        echo "<td class='temp'>$temp" . "°C</td>";
                    }
                    echo "</tr>";

                    echo "</table>";

                    echo "</div>";
                }
                ?>
            <?php
                 }
            ?>

        </div>
    </body>
</html>