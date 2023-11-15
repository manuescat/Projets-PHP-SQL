<!doctype html>
<html>
	<head>
		<title>Emissions atmosphériques</title>
		<meta charset="utf-8" />
	</head>
	
	<body>
	
	<?php 
		include ("header.php");
	?>
	
	<!-- Body -->
<?php
//connexion
		$hote="localhost";  $utilisateur="root";  $password="manu"; 
		$dnspdo = 'mysql:dbname=projet;host=localhost;charset=utf8';
		
	try{
		$connexion = new PDO($dnspdo, $utilisateur, $password);
		$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//préparation des requêtes permettant d'afficher les menus déroulants
		$territoire1 = $connexion->prepare(
		'SELECT epci FROM territoire group by epci'
		);
		$territoire2 = $connexion->prepare(
		'SELECT departement FROM territoire group by departement'
		);
		$territoire3 = $connexion->prepare(
		'SELECT region FROM territoire group by region'
		);
		$combustible = $connexion->prepare(
		'SELECT famille_comb FROM combustibles group by famille_comb'
		);
		$secteur = $connexion->prepare(
		'SELECT secteur FROM secteur_activite group by secteur'
		);
		$territoire1->execute();
		$territoire2->execute();
		$territoire3->execute();
		$combustible->execute();
		$secteur->execute();
	}
	catch(PDOException $e){
		echo 'Echec : ' .$e->getMessage();
	}
?>	
	<h2>Consulter les données de consommations d'énergie</h2>
<?php
// insertion du POST qui permet d'accéder à tableau_emi lorsqu'on clique sur le bouton valider
//pas de rubrique polluant ici
?>
<form method="POST" action="tableau_conso.php">
<p>Sélectionnez le ou les territoires</p>
<select NAME=territoires[] size="6" multiple>
<?php
//territoire regroupe 3 requetes afin que tous les territoires soient dans la même liste
		while($ligne = $territoire3->fetch()) {
			echo "<option value='".$ligne['region']."'>".$ligne['region']."</option>";
			}
		while($ligne = $territoire2->fetch()) {
			echo "<option value='".$ligne['departement']."'>".$ligne['departement']."</option>";
			}
		while($ligne = $territoire1->fetch()) {
			echo "<option value='".$ligne['epci']."'>".$ligne['epci']."</option>";
			}
?>
</select>
<p>Sélectionnez le ou les combustibles</p>
<select NAME=combustibles[] multiple>
<?php
		while($ligne = $combustible->fetch()) {
			echo "<option value='".$ligne['famille_comb']."'>".$ligne['famille_comb']."</option>";
			}
?>
</select>
<p>Sélectionnez le ou les secteurs d'activité</p>
<select NAME=secteurs[] multiple>
<?php
		while($ligne = $secteur->fetch()) {
			echo "<option value='".$ligne['secteur']."'>".$ligne['secteur']."</option>";
			}
?>
</select>
</br>
</br>			
<input type='submit' value='valider'>
</br>
</form>
<ul>
		<li><a href="accueil.php">Retour à la page d'accueil</a></li>
	</ul>
	
	
	<?php 
		include ("footer.php");
	?>
<?php
// libère le résultat
		$territoire1->closeCursor();
		$territoire2->closeCursor();
		$territoire3->closeCursor();
		$combustible->closeCursor();
		$secteur->closeCursor();		
?>	
		
	</body>
</html>