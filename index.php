<?php
require_once("inc/header.php");

// Ici je récupère les différentes catégories de produit présente en base car au DISTINCT
$r = $pdo->query("SELECT DISTINCT(categorie) FROM produit");
$content .= '<div class="row">';
$content .= '<div class="col-md-12"><ul class="list-group">';

// Tant que je récupére des produits de différentes catégories
// je récupère la catégorie et je l'affiche dans une liste
while($categories = $r->fetch(PDO::FETCH_ASSOC)) {
	$content .= "<li><a href=\"?categorie=$categories[categorie]\"> $categories[categorie] </a> </li>";
}
$content .= '</ul></div>';
// Si j'ai cliqué sur une catégorie et donc jai un paramètre GET dans l'URL, alors je récupère en bases tous les produits qui correspondent à cette catégorie que jaffiche après rechargement de la page dans index.php
if(isset($_GET["categorie"])){

$r = $pdo->query("SELECT * FROM produit WHERE categorie = '$_GET[categorie]'");
while($produits = $r->fetch(PDO::FETCH_ASSOC)) {
	$content .= "<div class=\"card\" style=\"width: 18rem;\">
			<img class=\"card-img-top\" src=\"$produits[photo]\" alt=\"Card image cap\">
			<div class=\"card-body\">
			<h5 class=\"card-title\">$produits[titre]</h5>
			<p class=\"card-text\">$produits[description]</p>
			<a href=\"fiche-produit.php?idproduit=$produits[id_produit]\" class=\"btn btn-primary\">Accéder au produit</a>
			</div>
			</div>";
}

}

?>

<!-- Afficher les differentes categories de produits -->
<!-- Quand je clique sur une categorie jaffiche dans index.php
les produits de la categories -->
<!-- c'est seulement lorsque je clique sur un produit que jarrive
sur sa fiche produit -->

<h1> Mon contenu </h1>

<?php echo $content ?>

<?php
require_once("inc/footer.php");
?>