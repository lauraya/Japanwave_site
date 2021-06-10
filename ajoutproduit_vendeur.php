<?php
session_start();
if (!isset($_SESSION["id_u"])){ //Empêche les non vendeurs de rentrer dans cette page, lors de la connexion on a déclaré 3 variables de session
  header("location: index.php");
}

if (isset($_SESSION["id_u"])){ //Empêche les non vendeurs de rentrer dans cette page, lors de la connexion on a déclaré 3 variables de session
  if($_SESSION["statut"]==1){
    header("location:pages_client/index_client.php");
  }
    if($_SESSION["statut"]==3){
    header("location:pages_admin/page_admin.php");
  }
}

include("fonctions.php");
menu_vendeur("Modification","accueil_site"); 
$con=connect_sqli(); 
$con->set_charset("utf8");

?>

<br>
<?php
if(isset($_POST['submit'])){
	$fichier=$_FILES['image'];
	$nomFichier=$_FILES['image']['name'];
	$tempnomFichier=$_FILES['image']['tmp_name'];
	$tailleFichier=$_FILES['image']['size'];
	$erreurFichier=$_FILES['image']['error']; //0 pas d'arreur ou 1 erreur
	$typeFichier=$_FILES['image']['type'];
	$fichierExt=explode('.',$nomFichier);
	$fichierVraiExt=strtolower(end($fichierExt));
	$ok=array('jpg','jpeg','png'); //Extensions autorisées
	if (in_array($fichierVraiExt, $ok)){
		if ($erreurFichier===0){
			if($tailleFichier<1000000){
				$newnomFichier=uniqid('',true).".".$fichierVraiExt;//on génère un identifiant unique pr le fichier afin qu'il ne remplace pas un autre fichier
				$destinationFichier='products/'.$newnomFichier;
				move_uploaded_file($tempnomFichier, $destinationFichier);
			}
			else{
				echo "ton fichier est trop volumineux!";
			}

		} else {
			echo "Il y a eu une erreur dans l'enregistrement de votre fichier!";
		}
	}else{
		echo "Format non valide!";
	}
	if(isset($destinationFichier)){
		$nomp=$_POST["nomp"];
		$cat=$_POST["categorie"];
		$prix=$_POST["prix"];
		$qte=$_POST["quantite"];
		$description=$_POST["description"];
		$id_vendeur=$_SESSION["id_u"];
		$sql="INSERT INTO produits(image,nomp,prixp,qtep,id_vendeur,description,catp) VALUES ('$destinationFichier','$nomp',$prix,$qte,$id_vendeur,'$description','$cat')";
		if ($con->query($sql) === TRUE) {
  				echo "Produit ajouté!";
			} 	else {
 				echo "Error: " . $sql . "<br>" . $con->error;
			}
	}
}
  ?>
<br>
 <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data"> 
 	<fieldset>
 	<legend style="text-align: center"><h2>Ajout de produit</h2></legend><br>
 	<table style="margin: auto">
 	<tr>	
 	<td>Image:</td> <td><input type="file" id="image" name="image" required></td></tr>
 
 	<td> Nom de produit:</td><td><input type="text" id="nomp" name="nomp" required></td></tr>

 	<tr>
 	<td>Catégorie:</td><td>
 		<select name="categorie" required>
 			<option value="">--Choisir une option</option>
 			<option value="patisserie">Pâtisserie</option>
 			<option value="boisson">Boisson</option>
 			<option value="bonbon">Bonbon</option>
 			<option value="nouille">Nouille</option>
 			<option value="goodie">Goodie</option>
 		</select>
 	</td>
 	</tr>
 		<tr>
 	<td>Prix:</td><td><input type="number" id="prix" name="prix" min="1" max="1000000" value="100" required></td>
 	</tr>
 		<tr>
 	<td>Quantité:</td><td><input type="number" id="quantite" name="quantite" min="1" max="100000" value="1" required></td>
 	</tr>
 		<tr>
 	<td>Description:</td><td><textarea id="description" name="description" rows="5" cols="33"></textarea></td>
 	</tr>
 	</table>
 	</fieldset>
 	<br><br><br>
 	<div style="text-align: center">
 	<button type="submit" name="submit" style="background-color: black;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;">Ajouter</button>
 </div>
 </form>


