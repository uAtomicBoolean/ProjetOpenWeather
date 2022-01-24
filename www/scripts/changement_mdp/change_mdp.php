<?php
    $fichier = file("../../files/accounts.csv");
    $old_mdp = hash("sha256", $_POST['ancien_mdp']);

    for ($k = 0; $k < sizeof($fichier); $k++){
        $temp = $temp = str_replace("\n", '', $fichier[$k]);
        $ligne = explode(';', $fichier[$k]);
        if ($ligne[1] != $old_mdp){
            header('Location: ../../subpages/compte.php?erreur=1');;
        }
        else{
            $pos = $k;
            $ligne[1] = hash('sha256', $_POST['new_passwd1']);
            $infos_user = implode(';', $ligne);

            $new_fichier = fopen('../../files/accounts.csv', 'w');
            for ($k = 0; $k < sizeof($fichier); $k++){
                if ($k == $pos){
                    fwrite($new_fichier, $infos_user);
                }
                else{
                    fwrite($new_fichier, $fichier[$k]);
                }
            }
            fclose($new_fichier);
            header('Location: ../../subpages/compte.php');
        }
    }
?>
