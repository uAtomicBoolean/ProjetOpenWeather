function checkEmptyInput(){
    let id = document.getElementById('identifiant').value;
    let password = document.getElementById('password').value;
    let errorID = document.getElementById('error_id');
    let errorPSWD = document.getElementById('error_pswd');

    let emptyID = true;
    for (let k = 0; k < id.length; k++){
        if (id.charCodeAt(k) !== 32){
            emptyID = false;
        }
    }

    let emptyPSWD = true;
    for (let k = 0; k < password.length; k++){
        if (password.charCodeAt(k) !== 32){
            emptyPSWD = false;
        }
    }

    if (emptyID){
        errorID.innerHTML = "L'identifiant n'est pas renseigné.";
    }
    else{
        errorID.innerHTML = "";
    }

    if (emptyPSWD){
        errorPSWD.innerHTML = "Le mot de passe n'est pas renseigné.";
    }
    else{
        errorPSWD.innerHTML = "";
    }

    if (!(emptyID) && !(emptyPSWD)){
        document.getElementById("formulaire_connexion").submit();
    }
}