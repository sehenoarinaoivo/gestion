<?php
session_start();
include('cadre.php');
include('calendrier.html');
?>
<div class="corp">
<img src="titre_img/ajout_etudiant.png" class="position_titre">
<center><pre>
<?php
require_once 'config.php';
if(isset($_POST['nom'])){
	if($_POST['nom']!="" and $_POST['prenom']!="" and $_POST['date']!="" and $_POST['adresse']!="" and $_POST['phone']!="" and $_POST['pseudo']!="" and $_POST['passe']!=""){
	$nom=addslashes(Htmlspecialchars($_POST['nom']));
	$prenom=addslashes(Htmlspecialchars($_POST['prenom']));
	$date=addslashes(Htmlspecialchars($_POST['date']));
	$phone=addslashes(Htmlspecialchars($_POST['phone']));
	$adresse=addslashes(Nl2br(Htmlspecialchars($_POST['adresse'])));
	$nomcl=$_POST['nomcl'];
	$promo=$_POST['promotion'];
	$pseudo=$_POST['pseudo'];
	$passe=$_POST['mdp'];
	$nb=mysqli_fetch_array(mysqli_query("select count(*) as nb from eleve where nomel='$nom' and prenomel='$prenom'"));
	if($nb['nb']!=0){
	?><SCRIPT LANGUAGE="Javascript">alert("erreur! cet enregistrement existe d�ja!");</SCRIPT><?php
	}
	else{
	$data=mysqli_fetch_array(mysqli_query("select codecl from classe where nom='$nomcl' and promotion='$promo'"));
	$codecl=$data['codecl'];
	mysqli_query("insert into eleve(nomel,prenomel,date_naissance,adresse,telephone,codecl) values('$nom','$prenom','$date','$adresse','$phone','$codecl')");
	/*		Ajouter le num dans le login    */
	$numel=mysqli_fetch_array(mysqli_query("select numel from eleve where nomel='$nom' and prenomel='$prenom'"));
	$num=$numel['numel'];
	mysqli_query($conn, "insert into login(Num,pseudo,passe,type) values('$num','$pseudo','$passe','etudiant')");
	?>	<SCRIPT LANGUAGE="Javascript">alert("Ajout avec succ�s!");</SCRIPT> 	<?php
	}
	}
	else{
	?> 	<SCRIPT LANGUAGE="Javascript">alert("Vous devez remplir tous les champs!");	</SCRIPT> 	<?php
	}
}
?>
<?php
$data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");
?>
<form action="Ajout_etudiant.php" method="POST" class="formulaire">
   <FIELDSET>
 <LEGEND align=top>Ajouter un Etudiant<LEGEND>  <pre>
Nom �tudiant        :       <input type="text" name="nom"><br/>
Pr�nom                   :       <input type="text" name="prenom"><br/>
Date de naissance   :       <input type="text" name="date" class="calendrier" ><br/>
Adresse                    :        <input type="text" name="adresse"><br/>
Telephone              :        <input type="text" name="phone"><br/>
pseudo                    :        <input type="text" name="pseudo"><br/>
mot de passe         :        <input type="password" name="mdp"><br/>
Classe                     :        <select name="nomcl"> 
<?php 
$retour=mysqli_query($conn, "select distinct nom from classe"); // afficher les classes
while($a=mysqli_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/>
Promotion              :      <select name="promotion"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/>
<center><input type="image" src="button.png"></center>
</pre></fieldset>
</form>
</pre></center>
</div>
</body>
</html>
