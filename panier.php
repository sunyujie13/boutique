<?php
require_once("inc/header.php");

// Si je viens de fiche produit et que je suis dans le cadre d'un post dont l'action est ajout_panier (voir name de l'input type submit dans fiche produit pour lajout de produit dans le panier)
if(isset($_POST["ajout_panier"])){
	// Je récupère les infos du produits en bdd
	$r = $pdo->query("SELECT * FROM produit WHERE id_produit = '$_POST[id_produit]'");

	$produit = $r->fetch(PDO::FETCH_ASSOC);
	//echo "<pre>";var_dump($produit);echo "</pre>";
	// Je les ajoutes à la session
	ajoutProduitDansPanier($produit["id_produit"], $_POST["quantite"], $produit["prix"]);
}


/// PAYER et creer une commande en base
// je vais creer une variable "content"
// si jai des problemes de stock je vais stoker les erreurs dans la variable erreur
// Je veux checher pour chaque produit dans mon panier que la quantite selectionne nest pas superieur au stock en base

// si le stock en base est inferieur a la quantite choisi, si le stock est superieur a 0 je veux un message qui me dit "le stock disponible pour larticle est de x"

// si je nai plus de stock
// je veux un message qui me dit produit epuise
// et je veux appeler une fonction dans fonction.php
// qui me retire le produit de la session et donc du panier

// si jai pas derreur
// alors je vais creer une commande en base
// mettre id_membre a 1 car pas encore dutilisateur

if(isset($_POST["payer"])){

	for ($i=0; $i < count($_SESSION["panier"]["id_produit"]); $i++) { 
		
		$r = $pdo->query("SELECT * FROM produit WHERE id_produit ='" . $_SESSION["panier"]["id_produit"][$i] . "'");
		$produit = $r->fetch(PDO::FETCH_ASSOC);

		if($produit["stock"] < $_SESSION["panier"]["quantite"][$i]){

			// Soit jindique au client ce quil reste

			if($produit["stock"] > 0){
				$_SESSION["panier"]["quantite"][$i] = $produit["stock"];
				$content .= "<div class=\"alert alert-primary\" role=\"alert\"> La quantité du produit " . $_SESSION["panier"]["id_produit"][$i]."a été réduite car notre stock était insuffisant, veuillez vérifier vos achats. </div>";
			} else{
				$content .= "<div class=\"alert alert-primary\" role=\"alert\"> Le produit " . $_SESSION["panier"]["id_produit"][$i]." a été retiré de vos achats car le stock est indisponible, veuillez vérifier vos achats. </div>";
				retirerProduitPanier($_SESSION["panier"]["id_produit"][$i]);
			}
			// Soit jai plus de stock
			// jindique qu client que le produit est en rupture de stock

			$erreur = true;

		}
	}

	// id_membre a inventer
	// montant -> faire une fonction qui calcule le montant total
	// (Le montant total est a calculer et afficher dans le tableau)
	if(!isset($erreur)){

		$r = $pdo->exec("INSERT INTO commande(id_membre, montant, date_enregistrement)
		VALUES('". $_SESSION['membre']['id_membre'] ."','" . montantTotal() . "', NOW()) ");
		$id_commande = $pdo->lastInsertId();

		// Insérer les produits de la commande dans la table details commande en les liant avec l id de la commande dans la table commande
		for ($i=0; $i < count($_SESSION["panier"]["id_produit"]) ; $i++) { 
			$pdo->query('INSERT INTO details_commande(id_commande, id_produit, quantite, prix)
				VALUES("' . $id_commande . '",
				"' . $_SESSION['panier']['id_produit'][$i] . '",
				"' . $_SESSION['panier']['quantite'][$i] . '",
				"' . $_SESSION['panier']['prix'][$i] . '")');

			$pdo->query('UPDATE produit SET stock = stock -
				"' . $_SESSION['panier']['quantite'][$i] .
				'" WHERE id_produit = "' . $_SESSION['panier']['id_produit'][$i]  . '"');
		}
		// Suppression du panier dans la session
		unset($_SESSION['panier']);
		$content .= "<div class='alert alert-success' role='alert'>Merci pour votre commande, votre n° de suivi est le " . $id_commande  ." </div>";

	}

}


// Recuperer la session "panier"
// voir combien jai de produits
// et iterer a linterieur
// et afficher autant de produit que je naurais de produit en session
// boucle for
$content .= "<table border=1>";
$content .= "<tr> <th> Référence </th> <th> Quantité </th> <th> Prix </th> </tr>";

// Si la session panier est vide
if(empty($_SESSION["panier"]["id_produit"])){
	$content .= "<tr> <td colspan=\"3\"> Votre panier est vide </td> </tr>";
} else{ // Si elle n'est pas vide
// j'itère dans les produits en cession
// et je les affiche dans le panier
	for ($i=0; $i < count($_SESSION["panier"]["id_produit"]); $i++) {

		$content .= "<tr>" . "<td>" . $_SESSION["panier"]["id_produit"][$i] . "</td>" . "<td>" . $_SESSION["panier"]["quantite"][$i] . "</td>" . "<td>" . $_SESSION["panier"]["prix"][$i] . "</td>". "<td> X </td> </tr>"; 
	}

	$content .= "<th colspan=\"3\">" . montantTotal() . "</th>";

	// Tu maffiches le bouton valider le paiement
	// Si l'internaute est connecté
	if(internauteEstConnecte()){
		$content .= "<form method=\"post\" action=\"\">";
		$content .= "<tr> <td colspan=\"3\"> <input type=\"submit\" value=\"Valider le paiement\" name=\"payer\" class=\"btn btn-default\">  </td></tr>";
		$content .= "</form>";
	} else{// Si il n'est pas connecté
		// Veuillez vous inscrire ou vous connecter
		// du texte avec des liens 
		// faire redirection vers inscription.php ou connexion.php
		$content .= "<tr><td colspan=\"3\"> Veuillez vous <a href=\"inscription.php\"> inscrire </a> ou vous <a href=\"connexion.php\">connecter </a> </td>  </tr>";
	}

}


$content .= "</table>";
$content .= "<p> Réglement par chéque à l'adresse suivante : 123 rue quelquechose, 75000, PARIS CEDEX";

?>

<h1> panier </h1>

<?php echo $content;?>

<?php
require_once("inc/footer.php");
?>