<?php 
//Ce fichier est  utilisé en include

//Code pour ajouter le panier préexistant == panier temporaire+panier dans le bd

if (!isset($_SESSION["msg_out"])) {
    $_SESSION["msg_out"]="";
}
//Cette variable va nous permettre de prévenir l'utilisateur si un produit est devenu out of stock (== si un vendeur a mis la quantité à 0 ou si un acheteur a tout acheté ou s'il a été "supprimé")

if(isset($_SESSION["id_u"]) && !isset($_SESSION["panier_client"])){ 
$id_user=$_SESSION["id_u"];
$sql_panier="SELECT * FROM commande c,panier p,produits pr WHERE c.id_client=$id_user and c.etatcommande='en cours' and c.id_com=p.id_com and p.id_produit=pr.id_produit "; //requête pour connaitre le panier du client
$result_panier=$con->query($sql_panier);
$num_rows=mysqli_num_rows($result_panier);
if($num_rows>0){
    while($line=$result_panier->fetch_assoc()){ //Grâce a cette boucle while le client retrouvera le panier qu'il avait laissé a sa dernière deconnexion
    $msg_quantite="";
    $id=$line['id_produit']; 
    $nom=$line['nomp'];
    $prix=$line['prixp'];
    $image=$line['image'];
    $id_v=$line['id_vendeur'];
    $qtecom=$line['qtecom'];//Quantité commandée
    $quantite=$line["qtep"];//quantité du produit
    $statutprod=$line["statutprod"];
    if($qtecom>$quantite && $quantite!=0){
        $qtecom=$quantite; //Ici on anticipe le cas où le vendeur baisse la quantité du produit à une quantité inférieure 
        //de celle commandée ou le cas où un client achète une trop grande quantité du produit
        $msg_quantite="Quantité changée, car le stock a diminué: ".$line['qtecom']." -> ".$quantite=$line["qtep"];
    }
    else if(($quantite==0&&$qtecom>$quantite) || ($statutprod=='supprime')){
        $_SESSION["msg_out"]=$_SESSION["msg_out"].$nom." retiré du panier (supprimé ou out of stock)<br>";
        continue;//On passe la mise ds le panier du produit si sa quantité est de 0
    }

    if(!isset($_SESSION["panier_client"])){ 
        $_SESSION["panier_client"]=array(  
        $id => array(
        'nom' =>$nom,
        'id' =>$id,
        'prix' =>$prix,
        'quantite'=>$qtecom,
        'qtep' => $quantite,
        'image'=>$image,
        'vendeur'=>$id_v,
        'msg'=>$msg_quantite)

);
        }
        else{
            $_SESSION["panier_client"]=$_SESSION["panier_client"]+array(  
            $id => array(
            'nom' =>$nom,
            'id' =>$id,
            'prix' =>$prix,
            'quantite'=>$qtecom,
            'qtep' => $quantite,
            'image'=>$image,
            'vendeur'=>$id_v,
            'msg'=>$msg_quantite));
        }
        }
    }
     if(isset($_SESSION["shopping_cart"]) && !isset($_SESSION["panier_client"])){//shopping cart est le panier temporaire avant que le visiteur se connecte
        $_SESSION["panier_client"]=$_SESSION["shopping_cart"];
        //On unset la variable pour que lorsqu'on vide le panier puis qu'on rajoute on ne se retrouve pas avec le panier visiteur
        unset($_SESSION["shopping_cart"]);
    }

 if(isset($_SESSION["shopping_cart"]) && isset($_SESSION["panier_client"])){
        $_SESSION["panier_client"]=$_SESSION["panier_client"]+$_SESSION["shopping_cart"];//S'il y a des produits présents dans le panier temporaire mais pas présent dans le panier client on rajoute dans le panier client, cependant si des produits du panier temporaire sont déjà présents dans le panier client c'est l'information du panier client qui est gardé avec cette opération
    }
}



//Même code que dans ajout_produit.php
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
    if($quantite>0){//si la quantite du produit ds la bd est supérieure a 0
        $panier=array(  //Contient les informations de produit
        $id => array(
        'nom' =>$nom,
        'id' =>$id,
        'prix' =>$prix,
        'quantite'=>1,
        'qtep' => $quantite,
        'image'=>$image,
        'vendeur'=>$id_v,
        'msg'=>$msg_quantite)

);}else{
        $msgpanier="<p style='color:white;text-align:center;background-color:black;'>Out of stock!</p>";
        }




    if(empty($_SESSION["panier_client"])) {
        if (isset($panier)) {
        
        $_SESSION["panier_client"] = $panier;
        $msgpanier= "<p style='color:white;text-align:center;background-color:black;'>Nouveau produit!</p>";}
}

    else{
        if (array_key_exists($id,$_SESSION["panier_client"])) {
            $msgpanier= "<p style='color:white;text-align:center;background-color:black;'>Produit déjà ajouté, modifier la quantité ds le panier</p>";
        }
        else {
            if (isset($panier)) {
           
            $_SESSION["panier_client"] = $_SESSION["panier_client"]+$panier;
            $msgpanier= "<p style='color:white;text-align:center;background-color:black;'>Nouveau produit!</p>"; }

}
    }

        }

     if(!empty($_SESSION["panier_client"])) {
        $nbreprod = count(array_keys($_SESSION["panier_client"])); //Variable utilisée ds les pages produits pr afficher le nombre de produits actuel ds le panier 
    }
    else{
        $nbreprod=0;
    }

?>
