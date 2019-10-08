<?php


// attention: all files included must not have any spaces!!
// (as html content, before or after php sign whatever)

require_once("config.php");
require_once("players.php");
require_once("actions.php");


error_reporting (E_ALL);

session_start();


// check session
if( isSet($_SESSION['playername']) )
{
    $curplayerx = $_SESSION['playername'];
}
else 
{
    exit(0);
}



// get http request strings
$curplayername = $curplayerx; // $_REQUEST["name"];

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
    
    exit(0);
}

if($curplayername != $actions->getcurrentplayername($players) )
{
    // it is not this players turn.
    $noturn = true;
}
else
{
    $noturn = false;
}


// if other player than now, or if someone has won
// (if someone won, it will be only once update, then the checkoing will stop)
if($noturn == false)  {
    
    print "update";
    //print " $expected_player ".$game["Current_Player"];
} else {
    //print "update";
    print "none";
    //print " $expected_player ".$game["Current_Player"];
}

?>