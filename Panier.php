<?php 
session_start();
if(isset($_SESSION['id_u']) and isset($_SESSION["statut"])){
  if($_SESSION["statut"]==1){
    header("location: pages_client/index_client.php");
  }
  if($_SESSION["statut"]==2){
    header("location: page_vendeur.php");
  }
  if($_SESSION["statut"]==3){
    header("location: pages_admin/page_admin.php");
  }
}
define('MyConst', TRUE); //utilisé pour limiter l'accès à la page ajout_produit par exemple, plus généralement les fichiers en include
include("fonctions.php");//Contient toutes les fonctions de connexion etc.
$con=connect_sqli(); 
$con->set_charset("utf8");
   $msg="";
if (isset($_POST['action']) && $_POST['action']=="retirer"){ //si on clique sur le bouton submit retirer (input hidden line 61)
if(!empty($_SESSION["shopping_cart"])) {
    foreach($_SESSION["shopping_cart"] as $key => $value) {
        if($_POST["id"] == $key){ //lorsqu'on a trouvé l'id envoyé en oist qui correspond a la clé de shopping_cart, on retire le produit du tableau
        unset($_SESSION["shopping_cart"][$key]);
        }
        if(empty($_SESSION["shopping_cart"])) 
        unset($_SESSION["shopping_cart"]);
            }       
        }
}

if (isset($_POST['action']) && $_POST['action']=="change"){ //Permet de changer la quantité de produits (input hidden line 75)
  foreach($_SESSION["shopping_cart"] as &$value){
    if(($value['id'] === $_POST["id"]) and ($_POST["quantite"]<=$_POST["qtep"])){
        $value['quantite'] = $_POST["quantite"];
        break; 
    }
   else if (($_POST["quantite"]>$_POST["qtep"])){ //qtep est la quantité du produit dans la base de données
        break;
    }
}
}
if(!empty($_SESSION["shopping_cart"])) { //nombre de produits ds le cart
$compteproduit = count(array_keys($_SESSION["shopping_cart"]));}
else{
   $compteproduit = 0;
}
?>

<?=menu("",$compteproduit,"panier")?>
<?php
if(isset($_SESSION["shopping_cart"])){
    $prixtotal = 0;

?>    
<div class="product-container">
        <div class="product-header">
            <h2 class="titre">Produit</h2>
            <h2 class="prix">Prix</h2>
            <h2 class="quantite">Quantité</h2>
            <h2 class="total">Total</h2>
        </div>
        <div class="produits">
            <?php  
foreach ($_SESSION["shopping_cart"] as $produit){
?>   

<div class="align">
<div class="produit"> 
<img src='<?php echo $produit["image"]; ?>'>
<span><?php echo $produit["nom"]; ?><br>
<form method='post' action=''>
<input type='hidden' name='id' value="<?php echo $produit["id"]; ?>" />
<input type='hidden' name='action' value="retirer" />
<button type='submit' class='retirer'>Retirer</button><br><br>
    <?php
if ($produit["qtep"]<=20){
    echo "Restant : ".$produit["qtep"];
}
  ?></form></span>

</div>
<div class="prix"><?php echo $produit["prix"].'¥'; ?></div>
<div class="quantite">
<form method='post' action=''>
    <input type='hidden' name='id' value="<?php echo $produit["id"]; ?>" />
    <input type='hidden' name='qtep' value="<?php echo $produit["qtep"]; ?>" />
    <input type="hidden" name="action" value="change">
    <select style="width: auto" name='quantite' class='quantite' onchange="this.form.submit()">
<option <?php if($produit["quantite"]==1) echo "selected";?> value="1">1</option>
<option <?php if($produit["quantite"]==2) echo "selected";?> value="2">2</option>
<option <?php if($produit["quantite"]==3) echo "selected";?> value="3">3</option>
<option <?php if($produit["quantite"]==4) echo "selected";?> value="4">4</option>
<option <?php if($produit["quantite"]==5) echo "selected";?> value="5">5</option>
<option <?php if($produit["quantite"]==6) echo "selected";?> value="6">6</option>
<option <?php if($produit["quantite"]==7) echo "selected";?> value="7">7</option>
<option <?php if($produit["quantite"]==8) echo "selected";?> value="8">8</option>
<option <?php if($produit["quantite"]==9) echo "selected";?> value="9">9</option>
<option <?php if($produit["quantite"]==10) echo "selected";?> value="10">10</option>
<option <?php if($produit["quantite"]==11) echo "selected";?> value="11">11</option>
<option <?php if($produit["quantite"]==12) echo "selected";?> value="12">12</option>
<option <?php if($produit["quantite"]==13) echo "selected";?> value="13">13</option>
<option <?php if($produit["quantite"]==14) echo "selected";?> value="14">14</option>
<option <?php if($produit["quantite"]==15) echo "selected";?> value="15">15</option>

</select></form>
</div>

<div class="total"><?php echo $produit["prix"]*$produit["quantite"].'¥'; ?></div>
</div>
<?php 
$prixtotal+=($produit["prix"]*$produit["quantite"]);

} ?>

<br>
<h3><?php echo "Prix total : ".$prixtotal.'¥'?></h3>
<?php }
else{
  echo "<h2>Panier vide</h2>";
}
?>
        </div>
    </div>
    <div class="bouton">
    <button onclick="location.href='connexion.php'">Passer commande</a></button>
    </div>
</body>
</html>