<?php

// Permet de créer de une session
// Panier
function creation_panier(){
	if(!isset($_SESSION["panier"])){
		$_SESSION["panier"]["id_produit"] = array();
		$_SESSION["panier"]["quantite"] = array();
		$_SESSION["panier"]["prix"] = array();
	}
}

// Permet d'ajouter un produit dans la cession panier
function ajoutProduitDansPanier($id_produit, $quantite, $prix) {
	// si c'est le premier ajout au panier
	// alors la cession panier est créée
	creation_panier();
	$position_produit = array_search($id_produit, $_SESSION["panier"]["id_produit"]);
	if($position_produit !== false) // Produit existant
	{
		$_SESSION["panier"]["quantite"][$position_produit] += $quantite;
	} else{
 	// nouveau produit
	$_SESSION["panier"]["id_produit"][] = $id_produit;
	$_SESSION["panier"]["quantite"][] = $quantite;
	$_SESSION["panier"]["prix"][] = $prix ;

/*	echo "<pre>";var_dump($_SESSION["panier"]);echo "</pre>";	
*/	}

}

// permet de voir si une cession membre a été créée
function internauteEstConnecte(){

	if(!isset($_SESSION["membre"])){
		return false;
	}else{
		return true;
	}

}

// Permet de retirer un produit du panier au niveau de la cession
function retirerProduitPanier($id_produit_a_supprimer){
	// Permet de voir si le produit est dans le panier
	// et récupérer sa position
	$position_produit_a_supprimer = array_search($id_produit_a_supprimer, $_SESSION["panier"]["id_produit"]);

	if($position_produit_a_supprimer !== false){
		array_splice($_SESSION["panier"]["id_produit"], $position_produit_a_supprimer, 1);
		array_splice($_SESSION["panier"]["quantite"], $position_produit_a_supprimer, 1);
		array_splice($_SESSION["panier"]["prix"], $position_produit_a_supprimer, 1);
	}

}

// permet de calculer le montant total du panier
function montantTotal() {

	$montantTotal = 0;

	for ($i=0; $i < count($_SESSION["panier"]["id_produit"]) ; $i++) { 
		$montantTotal += $_SESSION["panier"]["quantite"][$i] * $_SESSION["panier"]["prix"][$i];
	}

	return $montantTotal;

}

// permet de savoir si lutilisateur connecté
// est administrateur du site
function internauteEstConnecteEtEstAdmin(){
		
	if(internauteEstConnecte() && $_SESSION["membre"]["status"] == 1){
		return true;
	}else{
		return false;
	}

}

?>