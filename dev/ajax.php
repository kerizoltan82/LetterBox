<?php


function PrintAjaxInteractive($curplayername)
{
        
    print "<script>\n";

    // games are not identified (there is only one)
    print "setupTimer('game', $curplayername);\n";
    print "</script>\n";
}


?>