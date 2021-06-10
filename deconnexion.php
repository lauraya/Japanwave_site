<?php 
session_start();
include("fonctions.php");
$con=connect_sqli(); 
$con->set_charset("utf8");


//Le statut etatcommande 'en cours' dans la table commande est en fait le panier client et lorsque etatcommande correspond 'complete' l'utilisateur a passé commande et ds ce cas la date est rajoutée 
if(isset($_SESSION["id_u"]) && isset($_SESSION["panier_client"]) && $_SESSION["statut"]==1){ //En gros si l'utilisateur qui se déconnecte est un client avec des produits dans son panier
	$idu=$_SESSION["id_u"]; //id du client
	$sql="SELECT p.* FROM commande c, panier p WHERE c.etatcommande='en cours' AND p.id_com=c.id_com AND c.id_client=$idu";
	$result = $con->query($sql);
	if(mysqli_num_rows($result)>0){ //S'il y avait déjà une commande en cours enregistrée (== un panier) dans la bd
		$row=mysqli_fetch_assoc($result);
		$idcom=$row["id_com"];
		$sql2="DELETE FROM panier where id_com=$idcom";//On supprime d'abord ttes les lignes de panier correspondant a idcom
		if ($con->query($sql2) === TRUE) {
  			echo "Suppresion panier ok";
		} else {
 			echo "Error: " . $sql2 . "<br>" . $con->error;
		}
		
		foreach ($_SESSION["panier_client"] as $produit){//Ensuite on rajoute le nouveau panier
			$id_produit=$produit['id'];
			$qtecom=$produit['quantite'];
			$sql3="INSERT INTO panier (id_com,id_produit,qtecom) VALUES ($idcom,$id_produit,$qtecom)";
			if ($con->query($sql3) === TRUE) {
  			echo "Insertion panier ok";
		} 	else {
 			echo "Error: " . $sql3 . "<br>" . $con->error;
		}
		}
		
	}
	else{ //S'il n'y a pas de panier (== pas de commande en cours) dans la base de donnée
		$sql="INSERT INTO commande (etatcommande, id_client) VALUES ('en cours',$idu)"; //On insère d'abord la commande en cours dans la table commande
		if ($con->query($sql) === TRUE) {
  			echo "insertion commande ok";
		} else {
 			echo "Error: " . $sql . "<br>" . $con->error;
		}
		$sql2="SELECT id_com FROM commande c WHERE id_client=$idu AND etatcommande='en cours'"; //Ce que l'on vient d'insérer dans la bd
		$result = $con->query($sql2);
		$row=mysqli_fetch_assoc($result);
		$idcom=$row["id_com"];
		foreach ($_SESSION["panier_client"] as $produit) {
			$id_produit=$produit['id'];
			$qtecom=$produit['quantite'];
			$sql3="INSERT INTO panier (id_com,id_produit,qtecom) VALUES ($idcom,$id_produit,$qtecom)";
			if ($con->query($sql3) === TRUE) {
  			echo "Insertion panier ok";
		} else {
 			echo "Error: " . $sql3 . "<br>" . $con->error;
		}
		}

	}
}
if(isset($_SESSION["id_u"]) && isset($_SESSION["pseudo"])){
	session_destroy();
}

$con->close();
header("Location: index.php");
die;
?>