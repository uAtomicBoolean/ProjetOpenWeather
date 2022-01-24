let r1 = document.getElementById("haut_de_france");
let r2 = document.getElementById("normandie");
let r3 = document.getElementById("ile_de_france");
let r4 = document.getElementById("grand_est");
let r5 = document.getElementById("bretagne");
let r6 = document.getElementById("pays_de_la_loire");
let r7 = document.getElementById("centre_val_de_loire");
let r8 = document.getElementById("bourgogne_franche_comte");
let r9 = document.getElementById("nouvelle_aquitaine");
let r10 = document.getElementById("auvergne_rhones_alpes");
let r11 = document.getElementById("occitanie");
let r12 = document.getElementById("alpes_cote_dazur");
let r13 = document.getElementById("corse");

r1.addEventListener("click", function(){ afficherDepartements(32); }, false);
r2.addEventListener("click", function(){ afficherDepartements(28); }, false);
r3.addEventListener("click", function(){ afficherDepartements(11); }, false);
r4.addEventListener("click", function(){ afficherDepartements(44); }, false);
r5.addEventListener("click", function(){ afficherDepartements(53); }, false);
r6.addEventListener("click", function(){ afficherDepartements(52); }, false);
r7.addEventListener("click", function(){ afficherDepartements(24); }, false);
r8.addEventListener("click", function(){ afficherDepartements(27); }, false);
r9.addEventListener("click", function(){ afficherDepartements(75); }, false);
r10.addEventListener("click", function(){ afficherDepartements(84); }, false);
r11.addEventListener("click", function(){ afficherDepartements(76); }, false);
r12.addEventListener("click", function(){ afficherDepartements(93); }, false);
r13.addEventListener("click", function(){ afficherDepartements(94); }, false);


function afficherDepartements(code){
	let url = "https://geo.api.gouv.fr/regions/" + code + "/departements?";
	let request = new XMLHttpRequest();
	request.open("GET", url, false);
	request.send();

	let departs = JSON.parse(request.response);
	let option = document.getElementById("menu_d");
	option.innerHTML = "<option value=''>...</option>";

	for (let k = 0; k < departs.length; k++){
		option.innerHTML += "<option value='" + departs[k]['code'] + "'>" + departs[k]['nom'] + "</option>";
	}
}


function afficherCommunes(){
	let code = document.getElementById('menu_d').value;

	let url = "https://geo.api.gouv.fr/departements/" + code + "/communes";
	let request = new XMLHttpRequest();
	request.open("GET", url, false);
	request.send();

	let communes = JSON.parse(request.response);

	let option = document.getElementById('menu_v');
	option.innerHTML = "<option value=''>...</option>";

	for (let k= 0; k < communes.length; k++){
		option.innerHTML += "<option value='" + communes[k]['nom'] + "'>" + communes[k]['nom'] + "</option>";
	}
}

function getMeteo(){
	let ville = document.getElementById("menu_v").value;

	let jours = document.getElementById("3_jours").checked;
	let actuel = document.getElementById("jour_actuel").checked;
	let preferences = document.getElementById("preferences").checked;

	let h_debut = document.getElementById("h_debut").value;
	let h_fin = document.getElementById("h_fin").value;

	// On traite les heures de début et fin pour qu'elle reste dans les limites.
	if (parseInt(h_debut)){
		h_debut = parseInt(h_debut);
	}
	else{
		h_debut = 6;
	}

	if (parseInt(h_fin)){
		h_fin = parseInt(h_fin);
	}
	else{
		h_fin = 22;
	}

	if (h_debut > h_fin){
		let temp = h_fin;
		h_fin = h_debut;
		h_debut = temp;
	}

	if (h_debut < 0){
		h_debut = 0;
	}
	else if (h_debut > 23){
		h_debut = 23;
	}

	if (h_fin < 0){
		h_fin = 0;
	}
	else if (h_fin > 23){
		h_fin = 23;
	}

	// On enregistre les préférences de l'utilisateurs si il l'a demandé.
	if (preferences){
		let date = new Date(Date.now() + 86400000 * 30);
		date = date.toUTCString();
		document.cookie = "preferences=1; path=/; expires=" + date;
		document.cookie = "ville=" + ville + "; path=/; expires=" + date;
		document.cookie = "h_debut=" + h_debut + "; path=/; expires=" + date;
		document.cookie = "h_fin=" + h_fin + "; path=/; expires=" + date;
		document.cookie = "actuel=" + actuel + "; path=/; expires=" + date;
		document.cookie = "jours=" + jours + "; path=/; expires=" + date;
	}

	let url = "./meteo.php?ville=" + ville;

	if (ville !== "") {
		if (jours === true){
			url += "&3jours=1";
		}
		else{
			url += "&3jours=0";
		}

		if (actuel === true){
			url += "&actuel=1";
		}
		else{
			url += "&actuel=0";
		}
		url += "&debut=" + h_debut + "&fin=" + h_fin;
		document.location.href = url;
	}
}