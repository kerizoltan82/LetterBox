<?php

// ************* CDisplay ****************
require_once("config.php");

class CDisplay
{
    // writes html table
    function writeField($field)
    {
        global $FIELD_MAX_Y;
        global $FIELD_MAX_X;
		
        print("<table class=\"scfield\">\n");
        for($y=0; $y<$FIELD_MAX_Y; $y++)
        {
            print("<tr>\n");
            for($x=0; $x<$FIELD_MAX_X; $x++)
            {
                $letter = $field->getfield($x, $y);
				$tdid = "cell" . $x . "." . $y;
				$tdjsevent = "OnCellClicked($x,$y)";
				$xtra = "id=\"$tdid\" name=\"$letter\" onClick=\"$tdjsevent\" onKeyPress=\"OnCellKeyPressed()\"";
				if( ($letter != "") && ($letter != " ") )
				{
					print("<td class=\"letter\" $xtra>$letter</td>");
				}
				else
				{
					print("<td class=\"empty\" $xtra></td>");
				}

            }
            print("\n</tr>\n");
        }
        print("</table>\n\n");
    }
	
	function writeButtons()
	{
		//print("<span class=\"button\" onclick=\"OnClickClearButton()\">Törl&eacute;s</span>\n");
		print("<br /><br /><br />");
		print("<div class=\"button\" onclick=\"OnClickOrientButton(0)\"><img src=\"res/arrow_right.png\" width=\"32px\" /></div>\n");
		//print("<br /><br />");
		print("<div class=\"button\" onclick=\"OnClickOrientButton(1)\"><img src=\"res/arrow_down.png\" width=\"32px\" /></div>\n");
		//print("<br /><br />");
	}

    function writeLetters($lar)
    {
        //print("A jatekos betui:");
        print("<div class=\"playerletters\">\n");
		print("<table>");
		for($i=0; $i< count($lar); $i++)
		{
		  $arv = $lar[$i];
		  if( ($arv!='') && ($arv!=' ') )
		  {
		    print("<tr>\n");
		    print ("<td class=\"ourletter_unused\" id=\"l$i\" onclick=\"OnLetterClick('l$i')\">$arv</td>\n");
		    print("</tr>");
		  }
		}
		print("</table>\n");
        print("</div>\n\n");
    }

    function writeTurn($ourturn, $curplayer_str, $playersClass)
    {
        // get other player's name
        $curplayer_str_jav =  $playersClass->getnextplayername($curplayer_str);
        
		print("<div class=\"actionpanel\">\n");
		if($ourturn)
		{
			print ('Te jössz!');
		}
		else
		{
			print ("Most $curplayer_str_jav lép!");
		}
        print(" (<a href=\"admin.php\">Adminisztráció</a>)\n");
        
		print("</div>\n");
        
        // help button
		print("<div class=\"helpbutton\" onclick=\"DisplayHelp()\">HELP\n");
        print("</div>\n");
        
    }
}
?>