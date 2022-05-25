<?php
session_start();
include('cadre.php');
if(isset($_GET['modif_classe'])){//modif_el qu'on a recup�rer de l'affichage (modifier)
$id=$_GET['modif_classe'];
$ligne=mysqli_fetch_array(mysqli_query($conn, "select codecl,classe.nom as nomcl,promotion,numprofcoord,prof.nom,prenom from classe,prof where numprof=numprofcoord and codecl='$id'"));
$promo=mysqli_query($conn, "select distinct promotion from classe");
$prof=mysqli_query($conn, "select numprof,nom,prenom from prof");
$nom=stripslashes($ligne['nomcl']);
$numprof=stripslashes($ligne['numprofcoord']);
$promotion=stripslashes($ligne['promotion']);
?>
<div class="corp">
<img src="titre_img/modifier_classe.png" class="position_titre">
<center><pre>
<form action="modif_classe.php" method="POST" class="formulaire">
<h4>Veuillez choisir les nouveaux informations  :</h4></br>
Nom de la classe        :        <input type="text" name="nom" value="<?php echo $nom; ?>"></br></br><br/><br/>
Prof coordinataire     :        <select name="prof"> 
<?php while($a=mysqli_fetch_array($prof)){
echo '<option value="'.$a['numprof'].'" '.choixpardefault2($a['numprof'],$numprof).'>'.$a['nom'].' '.$a['prenom'].'</option>';
}?></select><br/><br/>
Promotion                  :        <select name="promo"> 
<?php while($a=mysqli_fetch_array($promo)){
echo '<option value="'.$a['promotion'].'" '.choixpardefault2($a['promotion'],$promotion).'>'.$a['promotion'].'</option>';
}?></select><br/><br/>
<input type="hidden" name="id" value="<?php echo $id; ?>"><!-- pour revenir en arriere et pour avoir l'id dont lequel on va modifier-->
<center><input type="image" src="modifier.png"></center>
</form>
<br/><br/><a href="affiche_classe.php">Revenir � la page pr�c�dente !</a>
<?php
}
if(isset($_POST['nom'])){//s'il a cliquer sur le bouton modifier
	if($_POST['nom']!=""){
		$id=$_POST['id'];
		$nom=addslashes(Htmlspecialchars($_POST['nom']));
		$prof=addslashes(Htmlspecialchars($_POST['prof']));
		$promo=addslashes(Htmlspecialchars($_POST['promo']));
		mysqli_query($conn, "update classe set nom='$nom',numprofcoord='$prof',promotion='$promo' where codecl='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modifi� avec succ�s!"); </SCRIPT> <?php
		echo '<br/><br/><a href="modif_classe.php?modif_classe='.$id.'">Revenir � la page precedente !</a>';
	}
	else{
		echo '<h1>erreur! Vous devez remplire tous les champss<h1>';
		echo '<br/><br/><a href="modif_classe.php?modif_classe='.$id.'">Revenir � la page  precedente  !</a>';
	}
}
if(isset($_GET['supp_classe'])){
$id=$_GET['supp_classe'];
mysqli_query($conn, "delete from classe where codecl='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprim� avec succ�s!"); </SCRIPT> <?php
echo '<br/><br/><a href="affiche_classe.php">Revenir � la page  precedente !</a>';
}
?>
</center></pre>
</div>