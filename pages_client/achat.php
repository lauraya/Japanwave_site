<?php
session_start();

if(isset($_SESSION["id_u"])){
	if($_SESSION["statut"]==1 && !isset($_POST["paiement"])){
		header("location:index_client.php");
	}
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
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$idu=$_SESSION["id_u"];
	$sql="SELECT p.* FROM commande c, panier p WHERE c.etatcommande='en cours' AND p.id_com=c.id_com AND c.id_client=$idu";
	$result = $con->query($sql);
	if(mysqli_num_rows($result)>0){ //S'il y avait déjà une commande en cours enregistrée 
	$row=mysqli_fetch_assoc($result);
		$idcom=$row["id_com"];
		$sql2="DELETE FROM panier where id_com=$idcom";//On supprime d'abord ttes les lignes de panier correspondant a idcom
		$con->query($sql2);
		/*if ($con->query($sql2) === TRUE) {
  			echo "Suppresion panier ok";
		} else {
 			echo "Error: " . $sql2 . "<br>" . $con->error;
		}*/
	$sql2="SELECT id_com FROM commande WHERE id_client=$idu AND etatcommande='en cours'";
	$result=$con->query($sql2);
	$row=mysqli_fetch_assoc($result);
	$date=date("Y/m/d");
	$prix=$_SESSION["prix_final"];
	$paiement=$_POST["paiement"];
	$livraison=$_POST["livraison"];
	$sql="UPDATE commande SET etatcommande='fini',datecom='$date', prixtotal=$prix,typepaiement='$paiement', Livraison='$livraison' WHERE id_com=$idcom";
	$con->query($sql);
	/*if ($con->query($sql) === TRUE) {
  		echo "commande fini ok";
	} else {
 		echo "Error: " . $sql . "<br>" . $con->error;
	}*/
	foreach ($_SESSION["panier_client"] as $produit){//Ensuite on rajoute le panier
		$id_produit=$produit['id'];
		$qtecom=$produit['quantite'];
		$sql3="INSERT INTO panier (id_com,id_produit,qtecom) VALUES ($idcom,$id_produit,$qtecom)";
		$con->query($sql3);
	/*	if ($con->query($sql3) === TRUE) {
  		echo "Insertion panier ok";
	} 	else {
 		echo "Error: " . $sql3 . "<br>" . $con->error;
	}*/
		$new_quantity=$produit["qtep"]-$produit["quantite"]; //On update la quantité
		$sql="UPDATE produits SET qtep=$new_quantity WHERE id_produit=$id_produit";
		$con->query($sql);
	}
}
else{//S'il n'y avait pas de panier au préalable
	$date=date("Y/m/d");
	$prix=$_SESSION["prix_final"];
	$paiement=$_POST["paiement"];
	$livraison=$_POST["livraison"];
	$sql="INSERT INTO commande (etatcommande,datecom, id_client,prixtotal,typepaiement,Livraison) VALUES ('fini','$date',$idu,$prix,'$paiement','$livraison')";
	$con->query($sql);
	/*if ($con->query($sql) === TRUE) {
  			echo "insertion commande sans panier ok";
		} else {
 			echo "Error: " . $sql . "<br>" . $con->error;
		}*/
	$sql2="SELECT id_com FROM commande c WHERE id_client=$idu AND etatcommande='fini' ORDER BY id_com DESC LIMIT 1"; //On selectionne le dernier id_com inséré
	$result = $con->query($sql2);
	$row=mysqli_fetch_assoc($result);
	$idcom=$row["id_com"];
	foreach ($_SESSION["panier_client"] as $produit) {
		$id_produit=$produit['id'];
		$qtecom=$produit['quantite'];
		$sql3="INSERT INTO panier (id_com,id_produit,qtecom) VALUES ($idcom,$id_produit,$qtecom)";
		$con->query($sql3);
	/*if ($con->query($sql3) === TRUE) {
  		echo "Insertion panier ok";
	} else {
 		echo "Error: " . $sql3 . "<br>" . $con->error;
	}*/
		$new_quantity=$produit["qtep"]-$produit["quantite"];
		$sql="UPDATE produits SET qtep=$new_quantity WHERE id_produit=$id_produit";
		$con->query($sql);
	}


}
unset($_SESSION["panier_client"]); //a l'achat on unset le panier client
header("refresh:1,url=index_client.php");
}	

  ?>

<!DOCTYPE html>
<html>
<head>
	<title>Achat</title>
	<link rel="stylesheet" type="text/css" href="StyleCss_client/achat.css">
</head>
<body>
<p style="font-size: 50px;display: flex;
  justify-content: center;
  align-items: center;
  height: 200px;
  ">Paiement effectué!</p>
</body>
</html>