
<?php
// ************ main file for scrabble game *************

?>


<html>
<head>
<link rel="stylesheet" type="text/css" href="scrabble.css" />
<script type="text/javascript" src="scrabble.js"></script>
<script type="text/javascript" src="timer.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Scrabble játék</title>

<?php

session_start();

// includes
require_once("config.php");
require_once("display.php");
require_once("letters.php");
require_once("field.php");
require_once("ajax.php");
require_once("players.php");
require_once("actions.php");


// check session
if( isSet($_SESSION['playername']) )
{
    $curplayerx = $_SESSION['playername'];
}
else 
{

    print ("</head><body>");

    echo '<a href="admin.php">Belépés szükséges!</a></body>';
    exit(0);
}




// get http request strings
$curplayername = $curplayerx; // $_REQUEST["name"];

$field = new CScField();
$field->openfield();

$letters = new CLetters();
$letters->openletters();

$players = new CPlayers();
//$players->init();
$players->loadplayers();

$actions = new CActions();
$actions->open();

// whether player can take a turn
$noturn = true;

// get player
$curplayer = $players->findfromname($curplayername);
if( $curplayer == -1)
{
    print ("</head><body>");
    print("Ebben a játékban ilyen nevű játékos nincs.</body>");
    exit(0);
}

//print("megadott jatekos: ".$curplayername);
//print("kovetkezo: ".$actions->getcurrentplayername($players));
if($curplayername != $actions->getcurrentplayername($players) )
{
    // it is not this players turn.
    $noturn = true;
}
else
{
    $noturn = false;
}


if($noturn) 
{
    //PrintAjaxInteractive($curplayername);
    print ("</head><body onLoad=\"setupTimer('game', '$curplayername');\">\n");
    //print ("</head><body onLoad=\"alert('$curplayername');\">\n");
}
else 
{
    print ("</head><body>\n");
}


//write actions, turns
CDisplay::writeTurn( ($noturn==false), $curplayername, $players );
print("<table>\n<tr><td class=\"field_cell\">\n");
// display field and letters
CDisplay::writeField($field);
print("</td>\n");
print("<td class=\"actions_cell\">\n");
CDisplay::writeButtons();
CDisplay::writeLetters($letters->letters[$curplayer]);
?>

<!-- new letter input field for player -->
<div>

<form action="scrabble_set.php" method="get" onSubmit="return checkword()">
<input type="hidden" name="name" value="<?php print($curplayername) ?>" />
<input type="hidden" name="posx" id="posx" value="3" />
<input type="hidden" name="posy" id="posy" value="3" />
<input type="hidden" name="orient" id="orient" value="1" />
<input type="hidden" name="wordcode" id="wordcode" value="" />

<?php

if( $noturn == false )
{
  print ("<input type=\"submit\" class=\"setbutton\" value=\"GO\" />");
}

?>

</form>

<!-- pass on to next player -->
<form action="scrabble_pass.php" method="get">
<input type="hidden" name="name" value="<?php print($curplayername) ?>" />
<?php

if( $noturn == false )
{
  print ("<input type=\"submit\" class=\"passbutton\" value=\"PASS\" />");
}

?>
</form>
</div>

<!-- end of field/action split table -->
</td></tr></table>

</body>
</html>