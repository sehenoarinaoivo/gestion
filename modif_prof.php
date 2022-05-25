<?php
session_start();
include('cadre.php');
require_once 'config.php';
echo '<div class="corp"><img src="titre_img/modif_prof.png" class="position_titre"><pre>';
if(isset($_GET['modif_prof'])){//modif_el qu'on a recup�rer de l'affichage (modifier)
$id=$_GET['modif_prof'];
$ligne=mysqli_fetch_array(mysqli_query($conn, "select * from prof where numprof='$id'"));
$nom=stripslashes($ligne['nom']);
$prenom=stripslashes($ligne['prenom']);
$phone=stripslashes($ligne['telephone']);
$adresse=stripslashes($ligne['adresse']);
?>

<form action="modif_prof.php" method="POST" class="formulaire">
Nom �tudiant       :       <?php echo $nom; ?><br/><br/>
Pr�nom                  :     <?php echo $prenom; ?><br/><br/>
Adresse                :       <textarea name="adresse" ><?php echo $adresse; ?></textarea><br/><br/>
Telephone             :         <input type="text" name="phone" value="<?php echo $phone; ?>"><br/><br/>
<input type="hidden" name="id" value="<?php echo $id; ?>">
<center><input type="image" src="button.png"></center>
</form>
<br/><br/><a href="afficher_prof.php?nomcl=<?php echo $ligne['nom']; ?>">Revenir � la page pr�c�dente !</a>
<?php
}
if(isset($_POST['nom'])){
	if($_POST['adresse']!="" and $_POST['phone']!=""){
		$id=$_POST['id'];
		$phone=addslashes(Htmlspecialchars($_POST['phone']));
		$adresse=addslashes(Nl2br(Htmlspecialchars($_POST['adresse'])));
		mysqli_query($conn, "update prof set adresse='$adresse', telephone='$phone' where numprof='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modifi� avec succ�s!"); </SCRIPT> <?php
		echo '<br/><br/><a href="modif_prof.php?modif_prof='.$id.'">Revenir � la page precedente !</a>';
	}
	else{
	?> <SCRIPT LANGUAGE="Javascript">	alert("erreur! Vous devez remplire tous les champs"); </SCRIPT> <?php
		echo '<br/><br/><a href="index.php?">Revenir � la page principale !</a>';
	}
}
if(isset($_GET['supp_prof'])){
$id=$_GET['supp_prof'];
mysqli_query($conn, "delete from prof where numprof='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprim� avec succ�s!"); </SCRIPT> <?php
echo '<br/><br/><a href="index.php?">Revenir � la page principale !</a>';
}
?>
</pre>
</div>