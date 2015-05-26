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
  1.123 koopwoningen gevonden
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
    	$db = new PDO('mysql:host=localhost;dbname=funda;charset=utf8', 'root', 'root');
		$selectStatement = "SELECT wo.Address, wo.PC, wo.City, Vraagprijs, soortvraagprijs.Name AS prijstype, mkantoor.Name AS makelaar,  WoonOppervlakte, AantalKamers, soortbouw.Name
							FROM wo, mkantoor, soortvraagprijs, soortbouw
							WHERE 1
							AND wo.MKID = mkantoor.MKID
							AND wo.vraagprijssoort = soortvraagprijs.id
							AND wo.soortbouw = soortbouw.id
							AND soortbouw.Name = ?
							AND wo.Address LIKE ?
							AND wo.City LIKE ?
							AND wo.PC LIKE ?";
							
		$stmt = $db->prepare($selectStatement);
		
		$type = $_POST["woning"];
		$street = "";
		$city = "";
		$postal = "";
		
		if(isset($_POST["straatnaam"])) $street = $street . $_POST["straatnaam"];
		if(isset($_POST["huisnummer"])) $street = $street . " " . $_POST["huisnummer"];	
		if(isset($_POST["toevoeging"]) && isset($_POST["huisnummer"])) $street = $street . $_POST["toevoeging"];
		if(isset($_POST["plaatsnaam"])) $city = $_POST["plaatsnaam"];
		if(isset($_POST["postcode"])) $postal = $_POST["postcode"];
		
		$stmt->bindValue(1, $type, PDO::PARAM_STR);
		$stmt->bindValue(2, "%". $street . "%", PDO::PARAM_STR);
		$stmt->bindValue(3, "%". $city . "%", PDO::PARAM_STR);
		$stmt->bindValue(4, "%". $postal . "%", PDO::PARAM_STR);
				
		$stmt->execute();
 
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    		echo "<div class=\"huisdata\">";
    		echo    "<div class=\"head\"><a class=\"normal\" href=\"detail.html\">". $row["Address"] . "</a></div><div class=\"prijs\">€ ". number_format($row["Vraagprijs"], 0 , ",", ".") . " ". $row["prijstype"] . "</div><br/>";
		    echo    "<span class=\"adres\">". $row["PC"] . " " . $row["City"] . "<br/>". $row["WoonOppervlakte"] . " m<sup>2</sup> - ". $row["AantalKamers"] . " kamers</span><br/>";
		    echo    "<span><a class=\"makelaar\" href=\"makelaar.html\">". $row["makelaar"] . "</a></span>";
      		echo "</div>";
		}
   
    ?>
      <div class="huisdata">
        <div class="head"><a class="normal" href="detail.html">Bekemaheerd 22</a></div><div class="prijs">€ 135.000 k.k.</div><br/>
        <span class="adres">9737 PT Groningen<br/>75 m<sup>2</sup> - 3 kamers</span><br/>
        <span><a class="makelaar" href="makelaar.html">Hypodomus Groningen</a></span>
      </div>

      <div class="huisdata">
        <div class="head"><a class="normal" href="detail.html">Bekemaheerd 22</a></div><div class="prijs">€ 135.000 k.k.</div><br/>
        <span class="adres">9737 PT Groningen<br/>75 m<sup>2</sup> - 3 kamers</span><br/>
        <span><a class="makelaar" href="makelaar.html">Hypodomus Groningen</a></span>
      </div>

      <div class="huisdata">
        <div class="head"><a class="normal" href="detail.html">Bekemaheerd 22</a></div><div class="prijs">€ 135.000 k.k.</div><br/>
        <span class="adres">9737 PT Groningen<br/>75 m<sup>2</sup> - 3 kamers</span><br/>
        <span><a class="makelaar" href="makelaar.html">Hypodomus Groningen</a></span>
      </div>

      <div class="huisdata">
        <div class="head"><a class="normal" href="detail.html">Bekemaheerd 22</a></div><div class="prijs">€ 135.000 k.k.</div><br/>
        <span class="adres">9737 PT Groningen<br/>75 m<sup>2</sup> - 3 kamers</span><br/>
        <span><a class="makelaar" href="makelaar.html">Hypodomus Groningen</a></span>
      </div>
    </td>
  </tr>
</table>

</div>



</body></html>


         

      


