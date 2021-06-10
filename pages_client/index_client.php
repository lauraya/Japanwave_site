<?php 
session_start();
if(isset($_SESSION["id_u"])){
  if($_SESSION["statut"]==2){
    header("location:../page_vendeur.php");
  }
  if($_SESSION["statut"]==3){
    header("location:../pages_admin/page_admin.php");
  }
}
else{
  header("location:../index.php");
}

include("fonctions_client.php");
$con=connect_sqli();
$con->set_charset("utf8");
include("ajout_produitclient.php");//On ajoute ce fichier pour afficher le panier client 
//enregistré ds la bd + les produits du panier qd on ira ds panier.php et pour avoir le compte produit directement
if(isset($_SESSION["pseudo"])){
	$pseudo=$_SESSION["pseudo"];
}

?>
<?=accueil_menu($nbreprod,$pseudo)?>

<div class="presentation">
    <h2 class="ligne machine" id="ligne">Bienvenue <?php echo $pseudo; ?>! <br> Nous vous souhaitons une excellente expérience sur notre site.<br><br><a href="panier_client.php">Panier</a><br></h2>

    </div>

  <?=footer()?>