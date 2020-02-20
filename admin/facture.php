<?php require_once('../inc/init.php');?>
<?php require_once('header.php');

// ici on récupère l'id_commmande de la commande qui a été selectionnée dans gestion_commandes.php pour pré-remplir la facture dans la page actuelle
if(isset($_GET["id_commande"])){
  $r = $pdo->query("SELECT * FROM details_commande d, commande c, membre m, produit p WHERE d.id_commande = c.id_commande AND c.id_membre = m.id_membre AND p.id_produit = d.id_produit AND c.id_commande = '$_GET[id_commande]'");

$donnees_commandes = $r->fetchAll(PDO::FETCH_ASSOC);
//echo "<pre>";var_dump($donnees_commandes);echo "</pre>";
}
?>

<div class="container">

      <div class="row">

        <div class="col-md-6">
          <h1> SH AUTO </h1>
          <h2> 2 chemin du Ponceau </h2>
          <h3> 02200 Soissons </h3>
          <h4> Tél: 07.82.14.81.41 </h4>
          <h5> Siren : 844 913 822 </h5>
          <h6> contactshauto@gmail.com </h6>
        </div>

      </div>

      <div class="row d-flex justify-content-end">

        <div class="col-md-6">
          <h1> <?php echo $donnees_commandes[0]["nom"] ?> </h1>
          <h1> <?php echo $donnees_commandes[0]["prenom"] ?> </h1>
          <h1> <?php echo $donnees_commandes[0]["email"] ?> </h1>
          <h1> <?php echo $donnees_commandes[0]["adresse"] ?> </h1>
          <h1> <?php echo $donnees_commandes[0]["code_postal"] ?> </h1>
          <h1> <?php echo $donnees_commandes[0]["ville"] ?> </h1>
        </div>

      </div>

      <div class="row invoiceHeader">
        <ul class="d-flex justify-content-between">
          <li>Facture Nº</li>
          <li><?php echo $donnees_commandes[0]["id_commande"] ?></li>
          <li>Reims, le</li>
          <li><?php echo $donnees_commandes[0]["date_enregistrement"] ?></li>
        </ul>
      </div>

      <div class="row invoiceContent mt-2">

        <table border="1">
          <tr>
            <th>reference</th>
            <th>titre</th>
            <th>description</th>
            <th>taille</th>
            <th>couleur</th>
            <th>prix</th>
          </tr>

          <?php
            foreach ($donnees_commandes as $key => $value) { ?>
              <tr>
                <td> <?php echo $value["reference"]; ?> </td>
                <td> <?php echo $value["titre"]; ?> </td>
                <td> <?php echo $value["description"]; ?> </td>
                <td> <?php echo $value["taille"]; ?> </td>
                <td> <?php echo $value["couleur"]; ?> </td>
                <td> <?php echo $value["prix"]; ?> </td>
              </tr>
            <?php }?>
          
        </table>

      </div>

      <div class="row invoiceFooter mt-2">

        <div class="d-flex bd-highlight">

          <div class="ml-auto bd-highlight backgroundGey" style="font-weight:bold"><?php echo $donnees_commandes[0]["montant"] ?></div>
        </div>
      </div>

      <div class="row d-flex justify-content-between invoiceTotal mt-2">

        <div class="col-md-5">
          <div class="headerTotal" style="font-weight:bold"> Vendeur </div>
        </div>

        <div class="col-md-5 d-flex flex-column justify-content-around" style="padding:10px 0 10px 10px">

        <div class="d-flex bd-highlight">
          <div class="mr-auto bd-highlight" style="font-weight:bold">Total TTC</div>
          <div class="ml-auto bd-highlight backgroundGeySmall" style="padding: 0 10px;font-weight:bold"><?php echo $donnees_commandes[0]["montant"] ?></div>
        </div>

        <div class="d-flex bd-highlight">
          <div class="mr-auto bd-highlight" style="font-weight:bold">Mode de réglement</div>
          <div class="ml-auto bd-highlight" style="    padding: 0 10px;">Virement</div>
        </div>

        </div>

      </div>

    </div>


<?php require_once('footer.php'); ?>