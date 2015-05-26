<?php 

		$type = "";
		$street = "";
		$city = "";
		$postal = "";
		
		if(isset($_POST["woning"])) $type = $_POST["woning"];
		if(isset($_POST["straatnaam"])) $street = $street . $_POST["straatnaam"];
		if(isset($_POST["huisnummer"])) $street = $street . " " . $_POST["huisnummer"];	
		if(isset($_POST["toevoeging"]) && isset($_POST["huisnummer"])) $street = $street . $_POST["toevoeging"];
		if(isset($_POST["plaatsnaam"])) $city = $_POST["plaatsnaam"];
		if(isset($_POST["postcode"])) $postal = $_POST["postcode"];
		if(isset($_POST["street"])) $street = $_POST["street"];
		
    	$db = new PDO('mysql:host=localhost;dbname=funda;charset=utf8', 'root', 'root');
		if(!isset($_POST["count"])){
			$selectStatement = "SELECT wo.Address, wo.PC, wo.City, Vraagprijs, soortvraagprijs.Name AS prijstype, mkantoor.Name AS makelaar,  WoonOppervlakte, AantalKamers, soortbouw.Name
							FROM wo, mkantoor, soortvraagprijs, soortbouw
							WHERE 1
							AND wo.MKID = mkantoor.MKID
							AND wo.vraagprijssoort = soortvraagprijs.id
							AND wo.soortbouw = soortbouw.id
							AND soortbouw.Name LIKE ?
							AND wo.Address LIKE ?
							AND wo.City LIKE ?
							AND wo.PC LIKE ?";
							
			$stmt = $db->prepare($selectStatement);
	
			$stmt->bindValue(1, "%". $type . "%", PDO::PARAM_STR);
			$stmt->bindValue(2, "%". $street . "%", PDO::PARAM_STR);
			$stmt->bindValue(3, "%". $city . "%", PDO::PARAM_STR);
			$stmt->bindValue(4, "%". $postal . "%", PDO::PARAM_STR);
					
			$stmt->execute();
			$_POST["count"] = $stmt->rowCount();
			$_POST["page"] = 1;
		}
		
		$selectStatement = "SELECT wo.Address, wo.PC, wo.City, Vraagprijs, soortvraagprijs.Name AS prijstype, mkantoor.Name AS makelaar,  WoonOppervlakte, AantalKamers, soortbouw.Name
							FROM wo, mkantoor, soortvraagprijs, soortbouw
							WHERE 1
							AND wo.MKID = mkantoor.MKID
							AND wo.vraagprijssoort = soortvraagprijs.id
							AND wo.soortbouw = soortbouw.id
							AND soortbouw.Name LIKE ?
							AND wo.Address LIKE ?
							AND wo.City LIKE ?
							AND wo.PC LIKE ?
							LIMIT ?, 15 ";
							
			$stmt = $db->prepare($selectStatement);
	
			$stmt->bindValue(1, "%". $type . "%", PDO::PARAM_STR);
			$stmt->bindValue(2, "%". $street . "%", PDO::PARAM_STR);
			$stmt->bindValue(3, "%". $city . "%", PDO::PARAM_STR);
			$stmt->bindValue(4, "%". $postal . "%", PDO::PARAM_STR);
			$stmt->bindValue(5, (($_POST["page"]-1) * 15), PDO::PARAM_INT);
			$stmt->execute();
 		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"><head> 
<title>Funda</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
  <link rel="stylesheet" href="style.css" type="text/css"/>
</head>

<body>

<div id="logo">
  <img src="img/funda-logo-hp.gif" id="toplogo" alt="toplogo"/>
</div>


<div id="balk">
  <ul>
    <li class="active">Woningaanbod</li>
    <li>Verkoop</li>
    <li>NVM Makelaars</li>
    <li>Gids</li>
    <li>Verhuizen</li>
    <li>My Funda</li>
  </ul>
</div>

<div id="nav">
  <ul>
    <li><a href="index.html" class="active">Koopwoningen</a></li>
    <li>Huurwoningen</li>
    <li>Nieuwbouwprojecten</li>
    <li>Recreatiewoningen</li>
    <li>Europa</li>
  </ul>
</div>

<div id="txt">
  <?php echo $_POST["count"]; ?> koopwoningen gevonden
</div>

<div id="main">

<table>
  <tr>
    <td id="data" valign="top">
      <div class="head">Prijsklasse van/tot</div><br/>
      <div class="head">Soort object</div>
      <div class="content">
        <a href="#" class="licht">Data</a> 
        <!-- DATA WEERGEVEN -->
      </div>

      <div class="head">Soort bouw</div>
      <div class="content">
        <a href="#" class="licht">Data</a> 
        <!-- DATA WEERGEVEN -->
      </div>

      <div class="head">Aantal kamers</div>
      <div class="content">
        <a href="#" class="licht">Data</a> 
        <!-- DATA WEERGEVEN -->
      </div>

      <div class="head">Woonoppervlakte</div>
      <div class="content">
        <a href="#" class="licht">Data</a> 
        <!-- DATA WEERGEVEN -->
      </div>
    </td>

    <td valign="top">
 		<?php
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    		echo "<div class=\"huisdata\">";
    		echo    "<div class=\"head\"><a class=\"normal\" href=\"detail.html\">". $row["Address"] . "</a></div><div class=\"prijs\">€ ". number_format($row["Vraagprijs"], 0 , ",", ".") . " ". $row["prijstype"] . "</div><br/>";
		    echo    "<span class=\"adres\">". $row["PC"] . " " . $row["City"] . "<br/>". $row["WoonOppervlakte"] . " m<sup>2</sup> - ". $row["AantalKamers"] . " kamers</span><br/>";
		    echo    "<span><a class=\"makelaar\" href=\"makelaar.html\">". $row["makelaar"] . "</a></span>";
      		echo "</div>";
		}
    ?>
    </td>
  </tr>
</table>

<?php
	$pages = ceil($_POST["count"]/15);
	$start = 1;
	$end = $pages;
	if($_POST["page"] == 1){
		$start = 2;
		$end = 5;
	} else if($_POST["page"] < 5){
		$start = 2;
		$end = $_POST["page"] + 2;
	} else if($_POST["page"] > $pages - 4){
		$start = $pages - 6;
		$end = $pages-1;
	} else {
		$start = $_POST["page"] - 2;
		$end = $_POST["page"] + 2;
	}
	
	$displayNumber;
	if($_POST["page"] == 1){
		$displayNumber = "1\" style=\"font-weight:bold";
	} else {
		$displayNumber = "1";
	}
	
	echo "<table style=\"width:150%\">";
  	echo "<tr>";
	echo 	"<td>";
	echo 		"<form method=\"post\">";
	echo 			"<input type=\"hidden\" name=\"street\" value=\"" . $street . "\"/>";
	echo 			"<input type=\"hidden\" name=\"woning\" value=\"" . $type . "\"/>";
	echo 			"<input type=\"hidden\" name=\"plaatsnaam\" value=\"" . $city . "\"/>";
	echo 			"<input type=\"hidden\" name=\"postcode\" value=\"" . $postal . "\"/>";
	echo 			"<input type=\"hidden\" name=\"count\" value=\"" . $_POST["count"] . "\"/>";
	echo 			"<input type=\"hidden\" name=\"page\" value=\"1\"/>";
	echo 			"<input type=\"submit\" value=\"". $displayNumber . "\"/>";
	echo 		"</form>";
	echo 	"</td>";
	
	if($start > 2) echo "<td> . . . </td>";
	
	for( ; $start <= $end; $start++){
		if($_POST["page"] == $start){
			$displayNumber = $start . "\" style=\"font-weight:bold";
		}  else {
			$displayNumber = $start;
		}
		echo "<td>";
		echo 	"<form method=\"post\">";
		echo 		"<input type=\"hidden\" name=\"street\" value=\"" . $street . "\"/>";
		echo 		"<input type=\"hidden\" name=\"woning\" value=\"" . $type . "\"/>";
		echo 		"<input type=\"hidden\" name=\"plaatsnaam\" value=\"" . $city . "\"/>";
		echo 		"<input type=\"hidden\" name=\"postcode\" value=\"" . $postal . "\"/>";
		echo 		"<input type=\"hidden\" name=\"count\" value=\"" . $_POST["count"] . "\"/>";
		echo 		"<input type=\"hidden\" name=\"page\" value=\"". $start . "\"/>";
		echo 		"<input type=\"submit\" value=\"". $displayNumber . "\"/>";
		echo 	"</form>";
		echo "</td>";
	}
	
	if($end < $pages - 1) echo "<td> . . . </td>";
	
	if($_POST["page"] == $pages){
		$displayNumber = $pages . "\" style=\"font-weight:bold";
	} else {
		$displayNumber = $pages;
	}
	echo 	"<td>";
	echo 		"<form method=\"post\">";
	echo 			"<input type=\"hidden\" name=\"street\" value=\"" . $street . "\"/>";
	echo 			"<input type=\"hidden\" name=\"woning\" value=\"" . $type . "\"/>";
	echo 			"<input type=\"hidden\" name=\"plaatsnaam\" value=\"" . $city . "\"/>";
	echo 			"<input type=\"hidden\" name=\"postcode\" value=\"" . $postal . "\"/>";
	echo 			"<input type=\"hidden\" name=\"count\" value=\"" . $_POST["count"] . "\"/>";
	echo 			"<input type=\"hidden\" name=\"page\" value=\"". $pages ."\"/>";
	echo 			"<input type=\"submit\" value=\"". $displayNumber . "\"/>";
	echo 		"</form>";
	echo 	"</td>";
	echo "</tr>";
	echo "</table>";
?>

</div>



</body></html>


         

      


