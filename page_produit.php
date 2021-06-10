<?php
session_start();
if(isset($_SESSION['id_u'])){
  if($_SESSION["statut"]==1){
  include("pages_client/fonctions_client.php");
$con=connect_sqli(); 
$con->set_charset("utf8");
include("pages_client/ajout_produitclient.php");
menu2("Produits",$nbreprod,$_SESSION["pseudo"],"produits");
$idp=$_GET["id_produit"];
$sql="SELECT * from produits p, utilisateurs u  WHERE p.id_produit=$idp and u.id_u=id_vendeur";
$result=$con->query($sql);
$ligne = $result->fetch_object(); 
echo "
  <article class='container'>
<section class='image'>
        <form method='post' action=''>
          <input type='hidden' name='id' value=".$ligne->id_produit." />
          <img src='".$ligne->image."' >
          <p>".$ligne->nomp."</p>
          <p>".$ligne->prixp." ¥</p>
          
          <button type='submit' class='ajout produit1'>Ajouter au panier</button>
         </form>
      </section>
      </article>
      <article class='container' style='  margin-top: 0px;
 adding-bottom: 50px;'>
      <section class='image'>
      <p> Entreprise: ".$ligne->nomEntreprise."</p>
      <p>".$ligne->description."</p>
      </section>
       </article>
      ";

  }
    if($_SESSION["statut"]==2){
      header("location:page_vendeur.php");
  }
    if($_SESSION["statut"]==3){
      header('location:pages_admin/page_admin.php');
  }
}
else{
include("fonctions.php");
$con=connect_sqli(); 
$con->set_charset("utf8");
include("ajout_produit.php");
menu("Produits",$nbreprod,"produits");
$idp=$_GET["id_produit"];
$sql="SELECT * from produits p, utilisateurs u  WHERE p.id_produit=$idp and u.id_u=id_vendeur";
$result=$con->query($sql);
$ligne = $result->fetch_object();	
echo "
  <article class='container'>
<section class='image'>
        <form method='post' action=''>
          <input type='hidden' name='id' value=".$ligne->id_produit." />
          <img src='".$ligne->image."' >
          <p>".$ligne->nomp."</p>
          <p>".$ligne->prixp." ¥</p>
          
          <button type='submit' class='ajout produit1'>Ajouter au panier</button>
         </form>
      </section>
      </article>
      <article class='container' style='  margin-top: 0px;
 adding-bottom: 50px;'>
      <section class='image'>
      <p> Entreprise: ".$ligne->nomEntreprise."</p>
      <p>".$ligne->description."</p>
      </section>
       </article>
      ";

    }?>	


