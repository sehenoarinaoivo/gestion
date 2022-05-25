<?php
session_start();
include('cadre.php');

require_once 'config.php';
echo '<div class="corp">';
if(isset($_GET['modif_matiere'])){//modif_el qu'on a recup�rer de l'affichage (modifier)
$id=$_GET['modif_matiere'];
$ligne=mysqli_fetch_array(mysqli_query($conn, "select * from matiere,classe where classe.codecl=matiere.codecl and codemat='$id'"));//classe pour afficher la promotion
$nom=stripslashes($ligne['nommat']);
$codecl=stripslashes($ligne['codecl']);
$promo=mysqli_fetch_array(mysqli_query($conn, "select promotion,nom from classe where codecl='$codecl'"));//pour selection la classe par defualt et afficher la promotion
?>
<center><h1>Modifier une mati�re</h1></center>
<form action="modif_matiere.php" method="POST" class="formulaire">
Mati�re :<input type="text" name="nommat" value="<?php echo $nom; ?>"><br/><br/>
Classe : <?php echo $promo['nom']; ?><br/><br/>
Promotion : <?php echo $promo['promotion']; ?><br/><br/>
<input type="hidden" name="id" value="<?php echo $id; ?>"><!-- pour revenir en arriere et pour avoir l'id dont lequel on va modifier-->
<center><input type="image" src="button.png"></center>
</form>
<?php
echo '<br/><br/><a href="affiche_matiere.php?nomcl='.$promo['nom'].'">Revenir � la page pr�c�dente !</a>';
}
if(isset($_POST['nommat'])){//s'il a cliquer sur le bouton modifier
	if($_POST['nommat']!=""){
		$id=$_POST['id'];
		$nom=addslashes(Htmlspecialchars($_POST['nommat']));
		mysqli_query($conn, "update matiere set nommat='$nom' where codemat='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modifi� avec succ�s!"); </SCRIPT> <?php
	}
	else{
		?> <SCRIPT LANGUAGE="Javascript">	alert("erreur! Vous devez remplire tous les champss"); </SCRIPT> <?php
		}
	echo '<br/><br/><a href="modif_matiere.php?modif_matiere='.$id.'">Revenir � la page precedente !</a>';
}
if(isset($_GET['supp_matiere'])){
$id=$_GET['supp_matiere'];
mysqli_query($conn, "delete from matiere where codemat='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprim� avec succ�s!"); </SCRIPT> <?php
echo '<br/><br/><a href="index.php">Revenir � la page  principale!</a>'; //on revient � la page princippale car on n'a plus l'id dont on affiche la matiere dans la modification
}
?>
</div>