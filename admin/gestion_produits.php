<?php require_once('../inc/init.php');

// Si j'ai une action GET égal à supprimer avec en paramètre $_GET[id_produit]
// je supprime le produit en base
if(isset($_GET["action"]) && $_GET["action"] == "supprimer"){
    $pdo->query("DELETE FROM produit WHERE id_produit = '$_GET[id_produit]'");
    $content .= "<div class='alert alert-success' role='alert'>Le produit a bien été supprimé!</div>";
}

// Si j'ai une action GET égal à modifier avec en paramètre $_GET[id_produit]
// je modifie le produit en base
if(isset($_GET["action"]) && $_GET["action"] == "modifier"){
    $r = $pdo->query("SELECT * FROM produit WHERE id_produit= '$_GET[id_produit]'");
    $produit_actuel = $r->fetch(PDO::FETCH_ASSOC);
}

// Si je suis dans le cadre d'une modification/ ou d'un ajout
// alors je mets à jour les donnéés récupérées depuis le POST
if($_POST){


    // Si c'est une modification je récupère la photo actuelle du produit
    if(isset($_GET["action"]) && $_GET["action"] == "modifier"){
        $photo_bdd = $_POST["photo_actuelle"];
    }

    if(!empty($_FILES["photo"]["name"])){
        // Nom de la photo
        $nom_photo = $_POST["reference"] . "_" . $_FILES["photo"]["name"];
        $photo_bdd = URL . "/img/$nom_photo";
        $photo_dossier = RACINE_SITE . "/img/$nom_photo";
        copy($_FILES["photo"]["tmp_name"], $photo_dossier);

    }

    foreach ($_POST as $key => $value) {
        $_POST[$key] = addslashes($value);
    }

    // Si c'est une modification je fait un update en bdd

    if(isset($_GET["action"]) && $_GET["action"] == "modifier"){
        $r = $pdo->query("UPDATE produit SET reference = '$_POST[reference]', categorie = '$_POST[categorie]', titre = '$_POST[titre]', description = '$_POST[description]', couleur = '$_POST[couleur]', taille = '$_POST[taille]', public = '$_POST[public]', photo = '$photo_bdd', prix = '$_POST[prix]', stock = '$_POST[stock]' WHERE id_produit = '$_POST[id_produit]'");

        $id_produit = $r->rowCount();

        if($id_produit >=1 ){
            $content .= "<div class='alert alert-success' role='alert'>Le produit a bien été modifié!</div>";
        }

    }else{ // Si c'est un ajout je fais un insert en base
            $r = $pdo->query("INSERT INTO produit (
    reference, categorie, titre, description, couleur, taille, public, photo, prix, stock)
    VALUES('$_POST[reference]', '$_POST[categorie]', '$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', '$_POST[public]', '$photo_bdd', '$_POST[prix]', '$_POST[stock]')");

            // Je récupère le dernier ID inséré
    $id_produit = $pdo->lastInsertId();
    echo $id_produit;

    if($id_produit>=1){
        echo "je rentre ici";
        $content .= "<div class='alert alert-success' role='alert'>
      Le produit a bien été ajouté au catalogue;
    </div>";
    }
    }

}

// je récupère en base tous les produits pour les afficher
$r = $pdo->query("SELECT * FROM produit");
$content .= "<table class='table'>";
$content .= "<tr>";
// Ici je récupère les noms des columns pour les afficher dynamiquement
for ($i=0; $i < $r->columnCount(); $i++) {
    $column = $r->getColumnMeta($i);
    $content .= "<th>$column[name]</th>";
}

$content .= "<th> modification </th>";
$content .= "<th> suppression </th>";
$content .= "</tr>";

// Ici j'itère dans les différentes données pour alimenter mon tableau dynamiquement
while($produits = $r->fetch(PDO::FETCH_ASSOC)) {
    $content .= "<tr>";
    foreach($produits as $key => $value) {
        if($key == "photo") {
            $content .= "<td> <img src=\"$value\" width=\"70\" class=\"img-fluid\"> </td>";
        } else{
            $content .= "<td> $value </td>";
        }
    }
    $content .= "<td> <a href=\"?action=modifier&id_produit=$produits[id_produit]\"> Modifier </a> </td>";
    $content .= "<td> <a href=\"?action=supprimer&id_produit=$produits[id_produit]\"> Supprimer </a> </td>";
    $content .= "</tr>";
}


    $content .= "</table>";


// ICI si je suis dans le cadre d'une modification
    // je récupère et j'affiche les donées actuellement en base
    // Sinon c'est que je suis dans le cadre d'un ajout et donc j'initialise 
    // les champs avec du vide
    // chaque variable définie ci-dessous fait l'objet d"un echo dans la value d"un input
$id_produit = (isset($produit_actuel['id_produit'])) ? $produit_actuel['id_produit'] : '';
$reference = (isset($produit_actuel['reference'])) ? $produit_actuel['reference'] : '';
$categorie = (isset($produit_actuel['categorie'])) ? $produit_actuel['categorie'] : '';
$titre = (isset($produit_actuel['titre'])) ? $produit_actuel['titre'] : '';
$description = (isset($produit_actuel['description'])) ? $produit_actuel['description'] : '';
$couleur = (isset($produit_actuel['couleur'])) ? $produit_actuel['couleur'] : '';
$taille = (isset($produit_actuel['taille'])) ? $produit_actuel['taille'] : '';
$public = (isset($produit_actuel['public'])) ? $produit_actuel['public'] : '';
$photo = (isset($produit_actuel['photo'])) ? $produit_actuel['photo'] : '';
$prix = (isset($produit_actuel['prix'])) ? $produit_actuel['prix'] : '';
$stock = (isset($produit_actuel['stock'])) ? $produit_actuel['stock'] : '';

?>

<!-- ------------------------------------------------------------------------------ -->
<?php require_once('header.php');

echo $content;
?>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="id_produit" value="<?=$id_produit?>">
        
        <div class="row">

            <div class="col">
                <label for="reference">reference</label>
                <input type="text" name="reference" placeholder="reference" id="reference" class="form-control" value="<?=$reference?>"><br>
            </div>

            <div class="col">
                <label for="categorie">categorie</label>
                <input type="text" name="categorie" placeholder="categorie" id="categorie" class="form-control" value="<?=$categorie?>"><br>
            </div>

        </div>

        <div class="row">
            <div class="col">
                <label for="titre">titre</label>
                <input type="text" name="titre" placeholder="titre" id="titre" class="form-control" value="<?=$titre?>"><br>
            </div>

            <div class="col">
                <label for="description">description</label>
                <textarea name="description" placeholder="description" id="description" class="form-control"><?=$description?></textarea><br>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="couleur">couleur</label>
                <select name="couleur" id="couleur" class="form-control">
                <option <?php if($couleur == 'bleu') echo 'selected'; ?>>bleu</option>
                <option <?php if($couleur == 'rouge') echo 'selected'; ?>>rouge</option>
                <option <?php if($couleur == 'vert') echo 'selected'; ?>>vert</option>
                <option <?php if($couleur == 'blanc') echo 'selected'; ?>>blanc</option>
                <option <?php if($couleur == 'noir') echo 'selected'; ?>>noir</option>
                <option <?php if($couleur == 'jaune') echo 'selected'; ?>>jaune</option>
                <option <?php if($couleur == 'violet') echo 'selected'; ?>>violet</option>
            </select><br>

            </div>

            <div class="col">
                <label for="taille">taille</label>
                    <select name="taille" id="taille" class="form-control">
                    <option <?php if($taille == 'S') echo 'selected'; ?>>S</option>
                    <option <?php if($taille == 'M') echo 'selected'; ?>>M</option>
                    <option <?php if($taille == 'L') echo 'selected'; ?>>L</option>
                    <option <?php if($taille == 'XL') echo 'selected'; ?>>XL</option>
                </select><br>

            </div>

            <div class="col">
                <label for="public">public</label>
                <select name="public" id="public" class="form-control">
                    <option value="m" <?php if($public == 'm') echo 'selected'; ?>>Homme</option>
                    <option value="f" <?php if($public == 'f') echo 'selected'; ?>>Femme</option>
                    <option value="mixte" <?php if($public == 'mixte') echo 'selected'; ?>>Mixte</option>
                </select><br>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="photo">photo</label>
                <input type="file" name="photo" id="photo" class="form-control">
                <?php if(!empty($photo)): ?>
                    <p>Vous pouvez uplaoder une nouvelle photo si vous souhaitez la changer.<br>
                    <img src="<?= $photo ?>" width="100"></p>
                <?php   endif;  ?><br>
                <input type="hidden" name="photo_actuelle" value="<?=$photo?>">
            </div>

            <div class="col">
                <label for="prix">prix</label>
                <input type="text" name="prix" placeholder="prix" id="prix" class="form-control" value="<?=$prix?>"><br>
            </div>

            <div class="col">
                <label for="stock">stock</label>
                <input type="text" name="stock" placeholder="stock" id="stock" class="form-control" value="<?=$stock?>"><br>
            </div>
        </div>
        
        <br><input type="submit" value="enregistrer le produit" class="btn btn btn-primary">
    </form>                       

<?php require_once('footer.php'); ?>      