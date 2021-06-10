<?php 
//Ce fichier est exclusivement utilisé en include


if (isset($_POST['id']) && $_POST['id']!=""){
    $msg_quantite="";
    $msgpanier="";
    $id=$_POST['id'];
    $sql_produit="SELECT * FROM `produits` WHERE `id_produit`= $id ";
    $result_produit = $con->query($sql_produit);
    $row=mysqli_fetch_assoc($result_produit);
    $id=$row['id_produit'];
    $nom=$row['nomp'];
    $prix=$row['prixp'];
    $image=$row['image'];
    $id_v=$row['id_vendeur'];
    $quantite=$row['qtep'];//quantite ds la base de donnée
    if($quantite>0){ //si la quantite du produit ds la bd est supérieure a 0
        $panier=array(  //Contient les informations de produit
        $id => array(
        'nom' =>$nom,
        'id' =>$id,
        'prix' =>$prix,
        'quantite'=>1,
        'qtep' => $quantite,
        'image'=>$image,
        'vendeur'=>$id_v,
        'msg'=>$msg_quantite));}
    



    if(empty($_SESSION["shopping_cart"])) {
        if (isset($panier)) {//Le isset permet d'éviter une erreur php lorsque la quantité de produit est égale à 0 (car ds ce cas panier n'est pas déclaré)
        $_SESSION["shopping_cart"] = $panier;
        $msgpanier= "<p style='color:white;text-align:center;background-color:black;'>Nouveau produit!</p>";}
}
    else{
        if (array_key_exists($id,$_SESSION["shopping_cart"])) {
            $msgpanier= "<p style='color:white;text-align:center;background-color:black;'>Produit déjà ajouté, modifier la quantité ds le panier</p>";
        }
        else {
            if (isset($panier)) {
            $_SESSION["shopping_cart"] = $_SESSION["shopping_cart"]+$panier;
            $msgpanier= "<p style='color:white;text-align:center;background-color:black;'>Nouveau produit!</p>";}

}
    }
  
        }

     if(!empty($_SESSION["shopping_cart"])) {
        $nbreprod = count(array_keys($_SESSION["shopping_cart"])); //Variable utilisée ds les pages produits pr afficher le nombre de produits actuel ds le panier 
    }
    else{
        $nbreprod=0;
    }
?>
