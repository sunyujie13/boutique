<?php
require_once("inc/header.php");
?>

<?php

// Vérifier que j'ai bien recuperer un produit
// sinon je suis redirigé vers index.php
if(!isset($_GET["idproduit"])){
	header("location:index.php");
	exit();
}

// ici je récupère le paramétre GET envoyé depuis index.php
// lorsqu'un produit a été cliqué grace a son idproduit
if(isset($_GET["idproduit"])){
	//echo $_GET["idproduit"];
	$r = $pdo->query("SELECT * FROM produit WHERE id_produit
		= '$_GET[idproduit]'");

	// je récupère les infos du produits en question
	// et les imbrique dans des balises HTML
	$produit = $r->fetch(PDO::FETCH_ASSOC);
	$content .= "<div class=\"row d-flex align-content-end\">";
	$content .= "<div class=\"col-md-6\">";
	$content .= "<p> <img style=\"width:100%\" class=\"img-fluid\" src=\"$produit[photo]\"> </<p>";
	$content .= "<h3 style=\"text-align:center\"> $produit[titre] </h3>";
	$content .= "<p style=\"text-align:center\">$produit[description] </<p>";
	$content .= "</div>";

	$content .= "<div class=\"col-md-6\">";
	$content .= "<p> catégorie: $produit[categorie] </<p>";
	$content .= "<p> couleur: $produit[couleur] </<p>";
	$content .= "<p> taille: $produit[taille] </<p>";
	$content .= "<p> prix: $produit[prix] </<p> <br>";

	// Si le produit est en stock jindique le stock
	// de façon dynamique dans un select option
	if($produit['stock'] > 0)
	{	
		// Création d'un form avec method POST permettant au moment du SUBMIT de rediriger vers panier.php
		// avec tous les paramètres post correspond aux name du FORM
		$content .= "Nombre de produit disponible en stock : $produit[stock]<br>";
		$content .= "<form method=\"POST\" action=\"panier.php\">";
		$content .= "<input type=\"hidden\" name=\"id_produit\" value=\"$produit[id_produit]\"><br><br>";
		$content .= "<label for=\"quantite\">Quantité</label>";
		$content .= "<select name=\"quantite\" id=\"quantite\">";
			for($i = 1; $i <= $produit['stock']; $i++)
			{
				$content .= "<option>$i</option>";	
			}
		$content .= "</select><br><br>";
		$content .= "<input type=\"submit\" value=\"ajout au panier\" name=\"ajout_panier\" class=\"btn btn-default\"><br><br>";
		$content .= "</form>";		
	}else{ // Si pas de stock alors je naffiche pas le bouton pour ajouter au panier
		$content .= "<p style=\"border:2px solid; background:red;width: 30%;padding: 15px;\">Rupture de stock</p>";

	}
	$content .= "<a href=index.php?categorie=$produit[categorie]> Retour a la catégorie $produit[categorie] </a>";
	$content .= "</div>";
	$content .= "</div>";

	//echo "<pre>";var_dump($produit);echo "</pre>";

}


?>

<h1> fiche produit </h1>

<?php echo $content; ?>

<?php
require_once("inc/footer.php");
?>