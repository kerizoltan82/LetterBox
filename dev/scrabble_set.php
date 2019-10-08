
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
$prevword = $_REQUEST["wordcode"];
$prevposx = $_REQUEST["posx"];
$prevposy = $_REQUEST["posy"];
$prevorient = $_REQUEST["orient"];
$sc_err_str = "";



$field = new CScField();
$field->openfield();
$letters = new CLetters();
$letters->openletters();
$players = new CPlayers();
//$players->init();
$players->loadplayers();

$actions = new CActions();
$actions->open();

// get player
$curplayer = $players->findfromname($curplayername);
if( $curplayer == -1)
{
    $sc_err_str = "Ervenytelen jatekosnev.";
}

if( $prevword == "" )
{
    $sc_err_str = "Nincs megadva szo.";
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

  $prevwordclass = new CNewWord();
  $prevwordclass->orient = $prevorient;
  $prevwordclass->posx = (int)$prevposx;
  $prevwordclass->posy = (int)$prevposy;
  $prevwordclass->word = $prevword;
  //$field->write();
  $remlettermask = $field->addtofield($prevwordclass);
  if( $letters->maskhaserror($remlettermask) )
  {
     $sc_err_str = "Error in Field! Mask: ". $remlettermask . " word: ".$prevword . " orient: " . $prevorient;
  }
  $remletters = $letters->filter($prevword, $remlettermask);
 // $field->write();
  $field->savefield();
  // get new letters for player
  $letters->removeletters($curplayer, $remletters);
  $letters->newletters($curplayer);
  $letters->saveletters();
  // save the action
  $actions->playermoved($curplayername);
  $actions->save();


}

if( $sc_err_str != "" )
{
  print("<body> \n<p>\n");
	print ("Hiba történt: " . $sc_err_str);
	print ("<br />");
	print ("Átiranyitás következik vissza, várjál.</p>\n");
}
else
{
  print("<body onload=\"set_redirect_timeout()\"> \n<p>\n");
  // last word
  print("<br />Új szó: $prevword<br /> </p>\n ");
}


?>

</body>
</html>