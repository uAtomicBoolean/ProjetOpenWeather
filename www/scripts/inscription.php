<?php
    function checkID($data){

        $fichier = file('../files/accounts.csv');

        for ($k = 0; $k < sizeof($fichier); $k++){
            $ligne = explode(";", $fichier[$k]);
            if ($data['input_id'] == $ligne[0]){
                header('Location: ../subpages/page_inscription.php?id_error=1');
                return;
            }
        }
        register($data);
    }


    function register($data){
        $mdp = hash("sha256", $data['input_passwd']);
        $chaine = $data['input_id'] . ";" . $mdp . ";false\n";

        file_put_contents("../files/accounts.csv", $chaine, FILE_APPEND);

        header('Location: ../subpages/page_connexion.php');
    }

    checkID($_POST);
?>
