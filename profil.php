<?php
require_once("inc/header.php");

//echo "<pre>";var_dump($_SESSION);echo "</pre>";
// Lorsque j'accède à la page profil
// Si je ne suis pas connecté, je suis automatiquement
// redirigé vers la page de connexion
if(!internauteEstConnecte()){
	header("location:connexion.php");
	exit();
}

?>

<!-- Si je suis connecté j'affiche les infos de l'internaute -->
<h1> Page profil </h1>

<h3> Bonjour <?php echo $_SESSION["membre"]["pseudo"] ?> </h3>

<p> Voici vos informations </p> <br>
<p> nom: <?php echo $_SESSION["membre"]["nom"] ?>  </p> <br>
<p> prenom: <?php echo $_SESSION["membre"]["prenom"] ?> </p> <br>
<p> email: <?php echo $_SESSION["membre"]["email"] ?> </p> <br>

<?php
require_once("inc/footer.php");
?>