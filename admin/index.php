<?php require_once('../inc/init.php'); ?>
<?php
if(!internauteEstConnecteEtEstAdmin())
{
    header('location:../connexion.php');
    exit();
}
?>
<!-- ------------------------------------------------------------------------------ -->
<?php require_once('header.php'); ?>

                        <h1>Bienvenue sur le BackOffice</h1>
                        <p>Selectionnez l'une des rubriques dans la colonne de gauche.</p>

<?php require_once('footer.php'); ?>                 
