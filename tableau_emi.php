<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	</head>
	
	<body>
<?php
		$hote="localhost";  $utilisateur="root";  $password="manu"; 
		
// ouverture de la connexion
			$bdNom ="projet";
			$bdConnexion = @mysqli_connect($hote,$utilisateur,$password) 
						or die ("Erreur de connexion à $hote pour l'utilisateur $utilisateur"); 
			mysqli_select_db($bdConnexion,$bdNom)
						or die ("Erreur de sélection de la base $bdNom");
?>	
<?php

//définition des variables utilisées
	
	$table = 'emissions emi';
	$select_geo="";
	$select_sect="";
	$select_pol="";
	$select_sum_pol="'pol'";
	$select_comb="";
	$coma_sect="";
	$coma_comb="";
	$coma_pol="";
	$from="";
	$join_geo="";
	$join_sect="";
	$join_comb="";
	$where_geo="";
	$where_geo1="";
	$where_geo2="";
	$where_geo3="";
	$where_sect="";
	$where_comb="";
	$and_sect="";
	$and_comb="";
	$and_pol="";
	$groupby_geo="";
	$groupby_sect="";
	$groupby_comb="";
	$groupby_pol="";
	$column_geo1 ="";
	$column_geo2 ="";
	$column_geo3 ="";
	$geo2=0;
	$geo3=0;

//TERRITOIRES	
	if(isset($_POST['territoires'])){
		$col_id=0;
		
		foreach($_POST['territoires'] as $key => $value){
			if($value == 'Hauts-de-France') {
				$column_geo1 = 'region';
			}elseif($value == 'Aisne') {
				$column_geo2 = 'departement';
			}elseif($value == 'Oise') {
				$column_geo2 = 'departement';
			}elseif($value == 'Somme') {
				$column_geo2 = 'departement';
			}elseif($value == 'Pas-de-Calais') {
				$column_geo2 = 'departement';
			}elseif($value == 'Nord') {
				$column_geo2 = 'departement';
			}else{$column_geo3 = 'epci';}
		}
				
		if(($column_geo1!="")&&($column_geo2!="")&&($column_geo3!="")){
			$select_geo = $column_geo1.", ".$column_geo2.", ".$column_geo3;
			$groupby_geo = $select_geo;
				foreach($_POST['territoires'] as $key => $value){
					if($value == 'Aisne' || $value == 'Oise' || $value == 'Somme' || $value == 'Nord' || $value == 'Pas-de-Calais') {
						$geo2=$geo2+1;
						if ($geo2==1){
							$where_geo2 = "(".$column_geo2."= '".$value."'";
						}else{
							$where_geo2 = $where_geo2." OR ".$column_geo2."= '".$value."'";
						}		
					}elseif($value == 'Hauts-de-France') {
						$where_geo1 = "(".$column_geo1."= '".$value."'";
					}elseif($value != 'Aisne' || $value != 'Oise' || $value != 'Somme' || $value != 'Nord' || $value != 'Pas-de-Calais' || $value != 'Hauts-de-France') {
						$geo3=$geo3+1;
						if ($geo3==1){
							$where_geo3 = "(".$column_geo3."= '".$value."'";
						}else{
							$where_geo3 = $where_geo3." OR ".$column_geo3."= '".$value."'";
						}
					}else{}
				}
			$where_geo1 = $where_geo1.")";
			$where_geo2 = $where_geo2.")";
			$where_geo3 = $where_geo3.")";
			$where_geo = $where_geo1." AND ".$where_geo2." AND ".$where_geo3;
		}elseif(($column_geo1!="")&&($column_geo2!="")&&($column_geo3=="")){
			$select_geo = $column_geo1.", ".$column_geo2;
			$groupby_geo = $select_geo;
				foreach($_POST['territoires'] as $key => $value){
					if($value == 'Aisne' || $value == 'Oise' || $value == 'Somme' || $value == 'Nord' || $value == 'Pas-de-Calais') {
						$geo2=$geo2+1;
						if ($geo2==1){
							$where_geo2 = "(".$column_geo2."= '".$value."'";
						}else{
							$where_geo2 = $where_geo2." OR ".$column_geo2."= '".$value."'";
						}		
					}elseif($value == 'Hauts-de-France'){
						$where_geo1 = "(".$column_geo1."= '".$value."'";
					}else{}
				}
			$where_geo1 = $where_geo1.")";
			$where_geo2 = $where_geo2.")";
			$where_geo = $where_geo1." AND ".$where_geo2;
		}elseif(($column_geo1!="")&&($column_geo2=="")&&($column_geo3!="")){
			$select_geo = $column_geo1.", ".$column_geo3;
			$groupby_geo = $select_geo;
				foreach($_POST['territoires'] as $key => $value){
					if($value != 'Hauts-de-France') {
						$geo3=$geo3+1;
						if ($geo3==1){
							$where_geo3 = "(".$column_geo3."= '".$value."'";
						}else{
							$where_geo3 = $where_geo3." OR ".$column_geo3."= '".$value."'";
						}
					}elseif($value == 'Hauts-de-France'){
						$where_geo1 = "(".$column_geo1."= '".$value."'";
					}else{}
				}
			$where_geo1 = $where_geo1.")";
			$where_geo3 = $where_geo3.")";
			$where_geo = $where_geo1." AND ".$where_geo3;
		}elseif(($column_geo1!="")&&($column_geo2=="")&&($column_geo3=="")){
			$select_geo = $column_geo1;
			$groupby_geo = $select_geo;
				foreach($_POST['territoires'] as $key => $value){
					$where_geo1 = "(".$column_geo1."= '".$value."'";				
				}
			$where_geo = $where_geo1.")";
		}elseif(($column_geo1=="")&&($column_geo2!="")&&($column_geo3!="")){
			$select_geo = $column_geo2.", ".$column_geo3;
			$groupby_geo = $select_geo;
				foreach($_POST['territoires'] as $key => $value){
					if($value == 'Aisne' || $value == 'Oise' || $value == 'Somme' || $value == 'Nord' || $value == 'Pas-de-Calais') {
						$geo2=$geo2+1;
						if ($geo2==1){
							$where_geo2 = "(".$column_geo2."= '".$value."'";
						}else{
							$where_geo2 = $where_geo2." OR ".$column_geo2."= '".$value."'";
						}		
					}elseif($value != 'Aisne' || $value != 'Oise' || $value != 'Somme' || $value != 'Nord' || $value != 'Pas-de-Calais' || $value != 'Hauts-de-France') {
						$geo3=$geo3+1;
						if ($geo3==1){
							$where_geo3 = "(".$column_geo3."= '".$value."'";
						}else{
							$where_geo3 = $where_geo3." OR ".$column_geo3."= '".$value."'";
						}
					}else{}
				}
			$where_geo2 = $where_geo2.")";
			$where_geo3 = $where_geo3.")";
			$where_geo = $where_geo2." AND ".$where_geo3;	
		}elseif(($column_geo1=="")&&($column_geo2!="")&&($column_geo3=="")){
			$select_geo = $column_geo2;
			$groupby_geo = $select_geo;
			foreach($_POST['territoires'] as $key => $value){
			$geo2=$geo2+1;
				if ($geo2==1){
					$where_geo2 = "(".$column_geo2."= '".$value."'";
				}else{
					$where_geo2 = $where_geo2." OR ".$column_geo2."= '".$value."'";
				}
			}
			$where_geo = $where_geo2.")";
		}elseif(($column_geo1=="")&&($column_geo2=="")&&($column_geo3!="")){
		$select_geo = $column_geo3;
		$groupby_geo = $select_geo;
		foreach($_POST['territoires'] as $key => $value){
			$geo3=$geo3+1;
				if ($geo3==1){
					$where_geo3 = "(".$column_geo3."= '".$value."'";
				}else{
					$where_geo3 = $where_geo3." OR ".$column_geo3."= '".$value."'";
				}
			}
			$where_geo = $where_geo3.")";
		}else{
		$select_geo = "";
		$groupby_geo = $select_geo;
		}
		$join_geo = ' join territoire ter on (emi.id_commune=ter.id_commune)';
	}
//SECTEURS
	if(isset($_POST['secteurs'])){
		$column_sect = 'secteur';
		$select_sect = 'secteur';
		$join_sect = ' join secteur_activite sec on (emi.id_activite=sec.id_activite)';
		foreach($_POST['secteurs'] as $key => $value){
			if($key == 0) {
				$where_sect  = "(".$column_sect."= '".$value."'";
			}else{
				$where_sect = $where_sect." OR ".$column_sect."= '".$value."'";
			}
		}
		$where_sect = $where_sect.")";
		$groupby_sect = $column_sect;
		if(isset($_POST['territoires'])){
			$coma_sect = ", ";
			$and_sect=" AND ";
		}
	}
//COMBUSTIBLES
	if(isset($_POST['combustibles'])){
		$column_comb = 'famille_comb';
		$select_comb = 'famille_comb';
		$join_comb = ' join combustibles comb on (emi.combustible=comb.combustible)';
		foreach($_POST['combustibles'] as $key => $value){
			if($key == 0) {
				$where_comb  = "(".$column_comb."= '".$value."'";
			}else{
				$where_comb = $where_comb." OR ".$column_comb."= '".$value."'";
			}
		}
		$where_comb = $where_comb.")";
		$groupby_comb = $column_comb;
		if(isset($_POST['territoires']) || isset($_POST['combustibles'])){
			$coma_comb = ", ";
			$and_comb=" AND ";
		}
		
	}
//POLLUANTS
	if(isset($_POST['polluants'])){
		$column_pol = 'polluant';
		$select_pol = 'polluant';
		foreach($_POST['polluants'] as $key => $value){
			if($key == 0) {
				$where_pol  = "(".$column_pol."= '".$value."'";
			}else{
				$where_pol = $where_pol." OR ".$column_pol."= '".$value."'";
			}
		}
		$where_pol = $where_pol.")";
		$groupby_pol = $column_pol;
		if(isset($_POST['territoires']) || isset($_POST['combustibles']) || isset($_POST['secteurs'])){
			$coma_pol = ", ";
			$and_pol=" AND ";
		}
	}
//REQUETE
		$select = "SELECT ".$select_geo.$coma_sect.$select_sect.$coma_comb.$select_comb.$coma_pol.$select_pol.", round(sum(val_emi),2) as emission_en_kg";
		$from = " FROM ".$table;
		$where = " WHERE ".$where_geo.$and_sect.$where_sect.$and_comb.$where_comb.$and_pol.$where_pol;
		$groupby = " GROUP BY ".$groupby_geo.$coma_sect.$groupby_sect.$coma_comb.$groupby_comb.$coma_pol.$groupby_pol." ASC";
		
//Effectue la requete
		$query = $select.$from.$join_geo.$join_sect.$join_comb.$where.$groupby;
		
		$result = mysqli_query($bdConnexion,$query);
		
// affichage des noms de champs

// -------------------------------------------------------
$NbrCol = mysqli_num_fields($result);
// -------------------------------------------------------

echo "<table border=1>\n";
echo "<tr bgcolor=lightblue>\n";
if ($NbrCol == 1){
echo
"<td align=center>".(mysqli_fetch_field_direct($result,0)->name)."</td>";
}else if ($NbrCol == 2){
echo
"<td align=center>".(mysqli_fetch_field_direct($result,0)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,1)->name)."</td>";
}else if ($NbrCol == 3){
echo
"<td align=center>".(mysqli_fetch_field_direct($result,0)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,1)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,2)->name)."</td>";
}else if ($NbrCol == 4){
echo
"<td align=center>".(mysqli_fetch_field_direct($result,0)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,1)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,2)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,3)->name)."</td>";
}else if ($NbrCol == 5){
echo
"<td align=center>".(mysqli_fetch_field_direct($result,0)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,1)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,2)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,3)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,4)->name)."</td>";
}else if ($NbrCol == 6){
echo
"<td align=center>".(mysqli_fetch_field_direct($result,0)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,1)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,2)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,3)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,4)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,5)->name)."</td>";
}else if ($NbrCol == 7){
echo
"<td align=center>".(mysqli_fetch_field_direct($result,0)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,1)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,2)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,3)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,4)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,5)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,6)->name)."</td>";
}else if ($NbrCol == 8){
echo
"<td align=center>".(mysqli_fetch_field_direct($result,0)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,1)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,2)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,3)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,4)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,5)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,6)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,7)->name)."</td>";
}else if ($NbrCol == 9){
echo
"<td align=center>".(mysqli_fetch_field_direct($result,0)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,1)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,2)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,3)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,4)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,5)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,6)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,7)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,8)->name)."</td>";
}else if ($NbrCol == 10){
echo
"<td align=center>".(mysqli_fetch_field_direct($result,0)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,1)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,2)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,3)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,4)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,5)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,6)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,7)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,8)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,9)->name)."</td>";
}else if ($NbrCol == 11){
echo
"<td align=center>".(mysqli_fetch_field_direct($result,0)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,1)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,2)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,3)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,4)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,5)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,6)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,7)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,8)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,9)->name)."</td><td align=center>".(mysqli_fetch_field_direct($result,10)->name)."</td>";
}else{
echo "hors limite";
}
echo "\n</tr>\n";

// affichage des données

while ($row = mysqli_fetch_array($result)) {
echo "<tr>\n";
if ($NbrCol == 1){
echo
"<td align=center>".$row[0]."</td>";
}else if ($NbrCol == 2){
echo
"<td align=center>".$row[0]."</td><td align=center>".$row[1]."</td>";
}else if ($NbrCol == 3){
echo
"<td align=center>".$row[0]."</td><td align=center>".$row[1]."</td><td align=center>".$row[2]."</td>";
}else if ($NbrCol == 4){
echo
"<td align=center>".$row[0]."</td><td align=center>".$row[1]."</td><td align=center>".$row[2]."</td><td align=center>".$row[3]."</td>";
}else if ($NbrCol == 5){
echo
"<td align=center>".$row[0]."</td><td align=center>".$row[1]."</td><td align=center>".$row[2]."</td><td align=center>".$row[3]."</td><td align=center>".$row[4]."</td>";
}else if ($NbrCol == 6){
echo
 "<td align=center>".$row[0]."</td><td align=center>".$row[1]."</td><td align=center>".$row[2]."</td><td align=center>".$row[3]."</td><td align=center>".$row[4]."</td><td align=center>".$row[5]."</td>";
}else if ($NbrCol == 7){
echo
"<td align=center>".$row[0]."</td><td align=center>".$row[1]."</td><td align=center>".$row[2]."</td><td align=center>".$row[3]."</td><td align=center>".$row[4]."</td><td align=center>".$row[5]."</td><td align=center>".$row[6]."</td>";
}else if ($NbrCol == 8){
echo
"<td align=center>".$row[0]."</td><td align=center>".$row[1]."</td><td align=center>".$row[2]."</td><td align=center>".$row[3]."</td><td align=center>".$row[4]."</td><td align=center>".$row[5]."</td><td align=center>".$row[6]."</td><td align=center>".$row[7]."</td>";
}else if ($NbrCol == 9){
echo
"<td align=center>".$row[0]."</td><td align=center>".$row[1]."</td><td align=center>".$row[2]."</td><td align=center>".$row[3]."</td><td align=center>".$row[4]."</td><td align=center>".$row[5]."</td><td align=center>".$row[6]."</td><td align=center>".$row[7]."</td><td align=center>".$row[8]."</td>";
}else if ($NbrCol == 10){
echo
"<td align=center>".$row[0]."</td><td align=center>".$row[1]."</td><td align=center>".$row[2]."</td><td align=center>".$row[3]."</td><td align=center>".$row[4]."</td><td align=center>".$row[5]."</td><td align=center>".$row[6]."</td><td align=center>".$row[7]."</td><td align=center>".$row[8]."</td><td align=center>".$row[9]."</td>";
}else if ($NbrCol == 11){
echo
"<td align=center>".$row[0]."</td><td align=center>".$row[1]."</td><td align=center>".$row[2]."</td><td align=center>".$row[3]."</td><td align=center>".$row[4]."</td><td align=center>".$row[5]."</td><td align=center>".$row[6]."</td><td align=center>".$row[7]."</td><td align=center>".$row[8]."</td><td align=center>".$row[9]."</td><td align=center>".$row[10]."</td>";
}else{
echo "hors limite";
}
echo "\n</tr>\n";
}
echo "</table>\n";
mysqli_close($bdConnexion); 
?>
<ul>
	<li><a href="accueil.php">Retour à la page d'accueil</a></li>
</ul>
<?php 
		include ("footer.php");
?>
</body></html>
