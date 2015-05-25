<? require 'header.php'; ?>

<div id="specifiek" style="width: 300px; margin-left: 30px;">
<form method="post">
 <fieldset>
   Soort woning: 
   <input type="radio" name="woning" value="bestaand" id="bestaand"/><label for="bestaand">Bestaande bouw</label>
   <input type="radio" name="woning" value="nieuwbouw" id="nieuwbouw"/><label for="nieuwbouw">Bestaande bouw</label>
   <br/>

   Vul (een deel van) het adres in dat u zoekt.<br/>

   <table>
    <tr><td>Straatnaam </td><td><input type="text" name="straatnaam" size="50"/></td></tr>
    <tr><td>Huisnummer </td><td><input type="text" name="huisnummer" size="7"/>Toevoeging <input type="text" name="toevoeging" size="3"/></td></tr>
    <tr><td>Postcode </td><td><input type="text" name="postcode" size="7"/></td></tr>
    <tr><td>Plaatsnaam </td><td><input type="text" name="plaatsnaam" size="50"/></td></tr> 
   </table>

   <input type="submit" value="Zoek koopaanbod"/> 
 </fieldset>
</form>
</div>

</body></html>
