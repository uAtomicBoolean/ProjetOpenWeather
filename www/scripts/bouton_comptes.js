function afficherVisites(visites, recherches){
    let params = document.getElementById('Parametres');
    params.innerHTML = "";

    let cvs = document.getElementById('dataVisites').getContext('2d');
    let setPieVisites = new Chart(cvs, {
        type: 'pie',
        data: {
            labels: ['Visites', 'Recherches'],
            datasets: [{
                label: "Nombre de visites.",
                backgroundColor : ["rgb(0, 0, 255)", "rgb(255, 0, 0)"],
                data: [visites, recherches],
            }]
        },
    })
}


function afficherComptes(regular, admin){
    let cvs = document.getElementById('dataComptes').getContext('2d');
    let setPieComptes = new Chart(cvs, {
        type: 'pie',
        data: {
            labels: ['Administrateur', 'Régulier'],
            datasets: [{
                label: "Nombre de comptes.",
                backgroundColor : ["rgb(3, 207, 252)", "rgb(3, 252, 123)"],
                data: [admin, regular],
            }]
        },
    })
}


function afficherParametres(erreur="") {
    let stats = document.getElementById('Statistiques');
    stats.innerHTML = "<div id='pieVisite'>\n" +
        "                <canvas id='dataVisites'></canvas>\n" +
        "            </div>\n" +
        "            <div id='pieComptes'>\n" +
        "                <canvas id='dataComptes'></canvas>\n" +
        "            </div>";

    let params = document.getElementById('Parametres');
    params.innerHTML = "";

    let changePassword = "<div id='change_passwd'>" +
        "<form method='post' action='../scripts/changement_mdp/change_mdp.php' id='form_change_mdp'>" +
        "<h3>Changement de mot de passe</h3>" +
        "<label for='ancien_mdp' class='label_change'>Ancien mot de passe:</label>" +
        "<input type='password' class='passwd_change' id='old_passwd' name='ancien_mdp'>" +
        "<label for='new_passwd1' class='label_change'>Nouveau mot de passe:</label>" +
        "<input type='password' class='passwd_change' id='new_passwd1' name='new_passwd1'>" +
        "<label for='new_passwd2' class='label_change'>Ré-entrez le nouveau mot de passe:</label>" +
        "<input type='password' class='passwd_change' id='new_passwd2' name='new_passwd2'>" +
        "<p id='erreur_changement'>" + erreur + "</p>" +
        "<input type='button' id='button_new_passwd' value='Valider' onclick='verifMdp();'>" +
        "</form>" +
        "</div>";

    let reinitPreferences = "<div id='reinit_preferences'>" +
        "<h3>Réinitialiser les préférences</h3>" +
        "<input type='button' id='bouton_preferences' value='Réinitialiser' onclick='reinitPreferences();'/></div>";

    params.innerHTML += changePassword + reinitPreferences;
}


function reinitPreferences(){
    let date = new Date(Date.now() + 1);
    date = date.toUTCString();

    document.cookie = "preferences=1; path=/; expires=" + date;
    document.cookie = "ville=; path=/; expires=" + date;
    document.cookie = "h_debut=; path=/; expires=" + date;
    document.cookie = "h_fin=; path=/; expires=" + date;
    document.cookie = "actuel=; path=/; expires=" + date;
    document.cookie = "jours=; path=/; expires=" + date;
}


function verifMdp(){
    let oldPasswd = document.getElementById("old_passwd").value;
    let new1 = document.getElementById("new_passwd1").value;
    let new2 = document.getElementById("new_passwd2").value;

    let erreur = document.getElementById("erreur_changement");
    let formulaire = document.getElementById('form_change_mdp');

    if (oldPasswd === ""){
        erreur.innerHTML = "Vous n'avez pas renseigné l'ancien mot de passe.";
    }
    else{
        if (new1 === ""){
            erreur.innerHTML = "Le nouveau mot de passe est vide.";
        }
        else {
            if (new1 !== new2) {
                erreur.innerHTML = "Les nouveaux mots de passe sont différents.";
            }
            else {
                if (new1.length < 6){
                    erreur.innerHTML = "Le nouveau mot de passe fait moins de 6 caractères.";
                }
                else{
                    erreur.innerHTML = "";
                    formulaire.submit();
                }
            }
        }
    }
}
