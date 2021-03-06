<?php
require_once("inc/header.php");
?>

<?php

// Lorsque j'ai un événement POST lors de l'inscription (quand je clique sur l'input type submit du FORM)
if($_POST){

	$erreur = "";
	// VERIFIER QUE LE PSEUDO FAIT BIEN ENTRE 3 ET 20 CARACTERES
	if(strlen($_POST["pseudo"]) < 3 ||  strlen($_POST["pseudo"]) > 20){
		$erreur .= "<div class='alert alert-danger' role='alert'>
					  Le pseudo doit comporter entre 3 et 20 caractères!
					</div>";
	}
	// QUE LE PSEUDO SOIT BIEN DES CHIFFRES OU DES NOMBRES OU LES DEUX (une valeur alphanumérique)
	if(!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $_POST["pseudo"])){
		$erreur .= "<div class='alert alert-danger' role='alert'>
					  Le pseudo doit doit avoir une valeur alpha numérique!
					</div>";
	}
	// SI JAI DES ERREURS JAFFICHE UN MSG DERREUR
	// AVANT DE CREER LE PROFIL JE VAIS VERIFIER QUE LE PSEUDO N'EST PAS PRESENT EN BASE
	$r = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'");

	// je veux cripter le mot de passe
	// je veux aussi etre sur que jaurais pas de problèmes de guillemets
	// quand je vais recuperer les valeurs de mes champs pour les inserer en base

	// Si le pseudo est déjà pris en base
	// j'affiche une alerte
	if($r->rowCount() >= 1){
		$erreur .= "<div class='alert alert-danger' role='alert'>
					  Pseudo non disponible, veuillez-choisir un autre pseudo
					</div>";
	}

	// addslashes permet d'échapper les caractères comme les guillements
	// pour éviter des erreurs coté sql
	foreach ($_POST as $indice => $valeur) {
		$_POST[$indice] = addslashes($valeur);
	}

	$_POST["mdp"] = password_hash($_POST["mdp"], PASSWORD_DEFAULT);

	// INSERER EN BASE UN NOUVEAU MEMBRE ET JE VAIS CRYPTER SON MDP
	// MESSAGE DE SUCCESS SI LINSERTION SEST BIEN FAITE
	if(empty($erreur)){
		$r = $pdo->query("INSERT INTO membre(pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse)
			VALUES('$_POST[pseudo]', '$_POST[mdp]', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', 
			'$_POST[civilite]', '$_POST[ville]', '$_POST[code_postal]', '$_POST[adresse]')");
		$content .= "<div class='alert alert-success' role='alert'>Inscription validé</div>";
	}

	$content .= $erreur;

}

?>

<h1> inscription </h1>

<?php echo $content ?>

<form method="post" action="">

		<label for="pseudo">pseudo</label>
		<input type="text" class="form-control" placeholder="votre pseudo" name="pseudo" id="pseudo" maxlength="20" pattern="[a-zA-Z0-9-_.]{3,20}" title="caractères acceptés : a-z A-Z 0-9 .-_" required><br>
	
		<label for="mdp">mot de passe</label>
		<input type="password" class="form-control" placeholder="votre mot de passe" name="mdp" id="mdp" required><br>

		<label for="nom">nom</label>
		<input type="text" class="form-control" placeholder="votre nom" name="nom" id="nom"><br>
	
		<label for="prenom">prenom</label>
		<input type="text" class="form-control" placeholder="votre prenom" name="prenom" id="prenom"><br>

		<label for="email">email</label>
		<input type="email" class="form-control" placeholder="votre email" name="email" id="email" required><br>
	
	<br>

		<label for="civilite">civilite</label> 
		<input type="radio" class="" name="civilite" id="civilite" value="m" checked>
		Homme -- Femme
		<input type="radio" class="" name="civilite" id="civilite" value="f"><br>
	
		<label for="ville">ville</label>
		<input type="text" class="form-control" placeholder="votre ville" name="ville" id="ville">	<br>
	
		<label for="cp">code postal</label>
		<input type="text" class="form-control" placeholder="votre cp" name="code_postal" id="cp"><br>
	
		<label for="adresse">adresse</label>
		<textarea class="form-control" placeholder="votre adresse" name="adresse" id="adresse"></textarea><br>
	
		<input type="submit" class="btn btn-default">
	
</form>


<?php
require_once("inc/footer.php");
?>