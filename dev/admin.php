
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Scrabble adminisztráció</title>
<link rel="stylesheet" type="text/css" href="admin.css" />

</head>

<body>

<?php

session_start();

$loggedin = false;
$curplayer = '';

if( isSet( $_GET['logout'] ))
{
    session_destroy();
    print 'Kilépve.';

}
else 
{
    // save player at login (only once)
    if( isSet( $_POST['playernamelogin'] ))
    {
        $_SESSION['playername'] = $_POST['playernamelogin'];
    }

    if( isSet($_SESSION['playername']) )
    {
        $curplayer = $_SESSION['playername'];
        $loggedin = true;
    }
}

// check if player is logged in. 
if(!$loggedin ) 
{
    //if not, display login page.
    echo '<form id="loginform" method="post" action="admin.php">';

    echo 'Név:';
    echo '<input id="playernamelogin" name="playernamelogin" type="text" value="" cols="16"/> <br/><br/>'; 
    
    echo '<input id="loginbutton" class="loginbutton" name="submitbutton" type="submit" value="Belépés"/> ';

    echo '</form>';
}
else 
{
    echo 'Belépve mint: '.$curplayer.'</br>';
    echo '<a href="admin.php?logout=1">Kilépés</a></br>';
    echo '<a href="scrabble.php">Régi játék folytatása</a></br>';

    echo '</br>';
    echo '</br>';
    print "<div class=\"div_newgame\">";
    print "Új játék létrehozása";
    echo '<form id="newgameform" method="post" action="newgame.php">';

    echo 'Első játékos neve:';
    echo '<input id="player1" name="player1" type="text" value="" cols="16"/> <br/><br/>'; 
    echo 'Második játékos neve:';
    echo '<input id="player2" name="player2" type="text" value="" cols="16"/> <br/><br/>'; 
    
    echo '<input id="loginbutton" class="loginbutton" name="submitbutton" type="submit" value="Új játék létrehozása"/> ';

    echo '</form>';
    
    print "</div>";
    

}

?>

</body>
</html>

