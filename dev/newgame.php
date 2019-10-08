
<html>
<body>

<?php
// includes
require_once("config.php");
require_once("display.php");
require_once("letters.php");
require_once("field.php");
require_once("actions.php");
require_once("players.php");

$field = new CScField();
$letters = new CLetters();
$actions = new CActions();

$letters->init();
$letters->newletters(0);
$letters->newletters(1);
//$letters->openletters();
$letters->saveletters();

$field->clearfield();
$field->savefield();

$actions->clear();

//players
$p1 = $_POST['player1'];
$p2 = $_POST['player2'];

echo 'Els� j�t�kos neve: '.$p1."</br>";
echo 'M�sodik j�t�kos neve: '.$p2."</br>";

$players = new CPlayers();
$players->saveplayers($p1, $p2);


?>

Az �j j�t�k l�trej�tt.
</body>
</html>

