function checkInscription(){

    let identifiant = document.getElementById('identifiant').value;
    let password = document.getElementById('password').value;
    let password2 = document.getElementById('password2').value;
    let errorID = document.getElementById('errorID');
    let errorMDP = document.getElementById('errorMDP');

    let emptyID = true;
    for (let k = 0; k < identifiant.length; k++){
        if (identifiant.charCodeAt(k) !== 32){
            emptyID = false;
        }
    }

    if (emptyID){
        errorID.innerHTML = "L'identifiant n'est pas renseigné.";
    }
    else{
        errorID.innerHTML = "";
    }
    if (password !== password2){
        errorMDP.innerHTML = "Les mots de passe sont différents.";
    }
    else{
        if (password.length < 6){
            errorMDP.innerHTML = "Les mots de passe sont trop courts.";
        }
        else{
            document.getElementById("formulaire_inscription").submit();
        }
    }
}