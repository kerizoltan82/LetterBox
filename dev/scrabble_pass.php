
<?php
// ************ set field  file for scrabble game *************
?>


<html>
<head>
<script type="text/javascript" src="scrabble_set.js"></script>

</head>


<?php

// includes
require_once("config.php");
require_once("display.php");
require_once("letters.php");
require_once("field.php");
require_once("players.php");
require_once("actions.php");

// get http request strings
$curplayername = $_REQUEST["name"];
$sc_err_str = "";



$field = new CScField();
$field->openfield();
$letters = new CLetters();
$letters->openletters();
$players = new CPlayers();
$players->loadplayers();

$actions = new CActions();
$actions->open();

// get player
$curplayer = $players->findfromname($curplayername);
if( $curplayer == -1)
{
    $sc_err_str = "Ervenytelen jatekosnev.";
}

//print("megadott jatekos: ".$curplayername);
//print("kovetkezo: ".$actions->getcurrentplayername($players));
if($curplayername != $actions->getcurrentplayername($players) )
{
    // it is not this players turn.
    $sc_err_str = "Egy masik jatekos lep most.";
}

// save word of previous player to field
if( $sc_err_str == "" )
{
  $actions->playerpassed($curplayername);

  $actions->save();


}

if( $sc_err_str != "" )
{
  print("<body> \n<p>\n");
	print ("Hiba tortent: " . $sc_err_str);
	print ("<br />");
	print ("Atiranyitas kovetkezik vissza, varjal.</p>\n");
}
else
{
  print("<body onload=\"set_redirect_timeout('$curplayername')\"> \n<p>\n");
  // last word
  print("<br />Uj szo: $prevword<br /> </p>\n ");
}


?>

</body>
</html>