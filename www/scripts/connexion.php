<?php
    function checkID($data){
        $fichier = file('../files/accounts.csv');

        for ($k = 0; $k < sizeof($fichier); $k++){
            $ligne = explode(";", $fichier[$k]);
            if ($data['input_id'] == $ligne[0]){
                checkPassword($data, $fichier);
                return;
            }
        }

        header('Location: ../subpages/page_connexion.php?mdp_error=2');
    }

    function checkPassword($data, $fichier){
        $password = hash('sha256', $data['input_passwd']);

        for ($k = 0; $k < sizeof($fichier); $k++){
            $ligne = explode(';', $fichier[$k]);
            if ($password == $ligne[1]){
                session_start();
                $_SESSION['pseudo'] = $data['input_id'];
                header("Location: ../index.php");
                return;
            }
        }
        header('Location: ../subpages/page_connexion.php?mdp_error=2');
    }

    checkID($_POST);
?>