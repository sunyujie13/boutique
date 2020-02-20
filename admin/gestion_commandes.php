<?php require_once('../inc/init.php');?>
<?php require_once('header.php'); ?>

<?php

// Je récupère toutes les commandes
$r = $pdo->query("SELECT * FROM commande");

// ici je récupère toutes les columns de la table commande
for ($i = 0; $i < $r->columnCount(); $i++) {
    $col = $r->getColumnMeta($i);
    $columns[] = $col['name'];
}

//echo "<pre>";var_dump( $columns);echo "</pre>";



?>

<table class="table">
  <thead>
    <tr>

      <!-- Ici j'itères dans les columns de la table commande pour créer dynamiquement mes th -->
      <?php foreach ($columns as $key => $value) { ?>
        <th scope="row"> <?php echo $value; ?> </th>
      <?php } ?> 
      <th scope="row"> Action </th> 

    </tr>
  </thead>
  <tbody>
      

      <?php
      // Ici j'itère dans les données de la commande pour les afficher ligne par ligne à chaque itération
      while ($commandes = $r->fetch(PDO::FETCH_ASSOC)) { ?>
          <tr>
          <?php foreach ($commandes as $value) { ?>
            <td> <?php echo $value; ?> </td>
          <?php } ?>
          <td>
          <!-- <?php //echo "<a href=\"facture.php?id_commande=$commandes[id_commande]\">Télécharger</a>" ?> -->
          <!-- Création dynamique d'un lien permettant de rediriger vers la page facture.php en indiquant l'id_commande de la facture qui devra être automatiquement pré-remplies avec le paramètre GET id_commande que je pourrai récupérer dans facture.php car au paramètre présent en URL -->
          <a href="facture.php?id_commande=<?=$commandes['id_commande']?>">Télécharger</a>
          </td>
          <tr>
      <?php } ?>

  </tbody>
</table>

<?php require_once('footer.php'); ?>