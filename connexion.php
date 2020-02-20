<?php
require_once("inc/header.php");

// permet de se déconnecter en supprimant la cession membre
if(isset($_GET["action"]) && $_GET["action"] == "deconnexion"){
	unset($_SESSION["membre"]);
	header("Refresh:0; url=connexion.php");
	exit();
}
// Nous redirigeons l'internaute vers la page profil si il est déjà connecté
if(internauteEstConnecte()){
	header("location:profil.php");
	exit();
}

// Si un post de connexion est lancé (si une tentative de connexion et faite)
// je récupére en base les infos correspondant au pseudo
// et vérifie que le mdp inséret lors de la connexion et le même que celui en bdd pour ce pseudo
if($_POST){
	$r = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'");
	$membre = $r->fetch(PDO::FETCH_ASSOC);
	if($r->rowcount() >= 1){
		if(password_verify($_POST["mdp"], $membre["mdp"])){

			// alimentation de la cession membre avec les données récupérer lors de la connexion
			$_SESSION["membre"]["id_membre"] = $membre["id_membre"];
			$_SESSION["membre"]["pseudo"] = $membre["pseudo"];
			$_SESSION["membre"]["nom"] = $membre["nom"];
			$_SESSION["membre"]["prenom"] = $membre["prenom"];
			$_SESSION["membre"]["email"] = $membre["email"];
			$_SESSION["membre"]["civilite"] = $membre["civilite"];
			$_SESSION["membre"]["ville"] = $membre["ville"];
			$_SESSION["membre"]["code_postal"] = $membre["code_postal"];
			$_SESSION["membre"]["adresse"] = $membre["adresse"];
			$_SESSION["membre"]["status"] = $membre["status"];

			// redirection vers la page profil après connexion
			header("location:profil.php");

		} else{
			$content .= "<div class='alert alert-danger' role='alert'>
					  Mot de passe invalide!
					</div>";
		}
	}else{
		$content .= "<div class='alert alert-danger' role='alert'>
					  Le pseudo est invalide!
					</div>";
	}

}
?>

<h1> connexion </h1>

<form method="post" action="">
	<div>
		<label for="pseudo">pseudo</label>
		<input type="text" name="pseudo" placeholder="votre pseudo" id="pseudo" class="form-control">
	</div>
	<br>
	<div>
		<label for="mdp">mdp</label>
		<input type="password" name="mdp" placeholder="votre mdp" id="mdp" class="form-control">
	</div>
	<br>
	<div>
		<input type="submit" class="btn btn-default" value="se connecter">
	</div>
</form>

<?php
require_once("inc/footer.php");
?>