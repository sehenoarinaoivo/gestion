<?php
session_start();
include('cadre.php');
$data=mysqli_query($conn, "select distinct promotion from classe order by promotion desc");
$retour=mysqli_query($conn, "select distinct nom from classe"); //pour afficher les classe existantes
?>
<div class="corp">
<img src="titre_img/affiche_conseil.png" class="position_titre">
<center><pre>
<?php
if(isset($_GET['supp_conseil'])){
$id=$_GET['supp_conseil'];
mysqli_query($conn, "delete from conseil where id='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Supprim� avec succ�s!"); </SCRIPT> <?php
}
else if(isset($_POST['nomcl']) and isset($_POST['numsem'])){
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$numsem=$_POST['numsem'];
$donnee=mysqli_query($conn, "select * from classe,conseil where classe.codecl=conseil.codecl and classe.codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and numsem='$numsem'");//select nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$classe'
?><center><table id="rounded-corner">
<thead><tr><?php if(isset($_SESSION['admin'])) echo '<th class="rounded-company">Supprimer</th>'; ?>
<th class="<?php echo rond(); ?>">Semestre</th>
<th class="rounded-q4">Classe</th>
</tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(1,2); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
if(isset($_SESSION['admin'])){
echo '</td><td><a href="affiche_conseil.php?supp_conseil='.$a['id'].'" onclick="return(confirm(\'Etes-vous s�r de vouloir supprimer cette entr�e?\'));">Supprimer</td>'; } echo '<td>S'.$a['numsem'].'</td><td>'.$a['nom'].'</td></tr>';
}
?>
</tbody>
</table></center>
<?php
}//fin   if(isset($_POST['radio']
else{ ?>

<form method="post" action="affiche_conseil.php" class="formulaire">
Veuillez choisir la classe et la promotion :<br/><br/>
Classe              :       <select name="nomcl"> 
<?php while($a=mysqli_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
Promotion        :       <select name="promotion"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/>
Semestre           :        <select name="numsem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/><br/>
<input type="submit" value="Afficher les stages">
</form>
<?php }
?>
<br/><br/><a href="affiche_conseil.php">Revenir � la page pr�c�dente !</a>
</pre></center>
</div>
</body>
</html>