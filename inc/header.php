<?php
	require_once("inc/init.php");

	// vous retrouvez dans le header la connexion a la bdd
	// presente dans init.php
	// ainsi que les differentes balises link et meta en tout genre
	// cote HTML
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Title of the document</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="inc/css/style.css">

</head>

<body>

	<div class="container">

<header>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="index.php">Home</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
			<!-- Si l'internaute est connecté (status 1 dans la table membre alors je lui laisse l'accès au backoffice) -->
	    	<?php if(internauteEstConnecteEtEstAdmin()) { ?>
	    		 <li class="nav-item active">
			        <a class="nav-link" href="admin/index.php">BackOffice <span class="sr-only">(current)</span></a>
			      </li>
	    	<?php } ?>

	    	<!-- Si il n'est pas connecté jaffiche les pages d'inscriptions et connexion et panier  -->
	    	<?php if(!internauteEstConnecte()) { ?>

			      <li class="nav-item active">
			        <a class="nav-link" href="connexion.php">connexion <span class="sr-only">(current)</span></a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link" href="inscription.php">inscription</a>
			      </li>

			      <li class="nav-item">
			        <a class="nav-link" href="panier.php">panier</a>
			      </li>

	    	<?php } else { ?>
	    			<!-- Sinon j'affiche les pages profil et panier -->
		  	      <li class="nav-item">
			        <a class="nav-link" href="profil.php">profil</a>
			      </li>

		  	      <li class="nav-item">
			        <a class="nav-link" href="panier.php">panier</a>
			      </li>

		  	      <li class="nav-item">
			        <a class="nav-link" href="connexion.php?action=deconnexion">Deconnexion</a>
			      </li>

	    	<?php } ?>

	    </ul>
	    <form class="form-inline my-2 my-lg-0">
	      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
	      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
	    </form>
	  </div>
	</nav>
</header>