<?php

// ********* letters class *********

require("config.php");

class CLetters
{

    var $letters = array( array(), array() );

    var $staple = array( );

    var $m_filename = "data/letters.txt";

    function getlettervalue()
    {
        // not implemented
    }

    function init()
    {
      global $PLAYER_MAX;
        // init players
        for($p=0; $p<$PLAYER_MAX; $p++)
        {
            $this->letters[$p] = array();
        }
		// * 2 ures zseton ("joker"), 0 pont ertekben.
		// * 1 pont: A ×6, E ×6, K ×6, T ×5, Aacute ×4, L ×4, N ×4, R ×4, I ×3, M ×3, O ×3, S ×3
		// * 2 pont: B ×3, D ×3, G ×3, Ó ×3
		// * 3 pont: Eacute ×3, H ×2, SZ ×2, V ×2
		// * 4 pont: F ×2, GY ×2, J ×2, Ö ×2, P ×2, U ×2, Ü ×2, Z ×2
		
		// * 5 pont: C ×1, Iacute ×1, NY ×1
		// * 7 pont: CS ×1, O= ×1, U- ×1, U= ×1
		// * 8 pont: LY ×1, ZS ×1
		// * 10 pont: TY ×1
        $staple[] = "A"; $staple[] = "A"; $staple[] = "A"; $staple[] = "A"; $staple[] = "A"; 
        $staple[] = "E"; $staple[] = "E"; $staple[] = "E"; $staple[] = "E"; $staple[] = "E"; 
        $staple[] = "K"; $staple[] = "K"; $staple[] = "K"; $staple[] = "K"; $staple[] = "K";
        $staple[] = "T"; $staple[] = "T"; $staple[] = "T"; $staple[] = "T";
        $staple[] = "L"; $staple[] = "L"; $staple[] = "L";
        $staple[] = "N"; $staple[] = "N"; $staple[] = "N";
        $staple[] = "M"; $staple[] = "M";
        $staple[] = "O"; $staple[] = "O";
        $staple[] = "R"; $staple[] = "R"; $staple[] = "R";
        $staple[] = "I"; $staple[] = "I"; $staple[] = "I";
        $staple[] = "S"; $staple[] = "S";
        $staple[] = "Á"; $staple[] = "Á"; $staple[] = "Á";//aacute
	
        $staple[] = "B"; $staple[] = "B"; 
        $staple[] = "G"; $staple[] = "G"; 
        $staple[] = "D"; $staple[] = "D"; 
        $staple[] = "Ó"; $staple[] = "Ó"; //hosszu oo

		$staple[] = "É"; // eacute
        $staple[] = "H";
        $staple[] = "SZ";
        $staple[] = "V";

		$staple[] = "F";
        $staple[] = "GY";
        $staple[] = "J";
        $staple[] = "Ö"; //rovid o:
        $staple[] = "P";
        $staple[] = "U";
        $staple[] = "Ü"; // u:
        $staple[] = "Z";

        // init staple with default letter config
        $staple[] = "A";
        $staple[] = "Á"; //aacute
        $staple[] = "B";
        $staple[] = "C";
        $staple[] = "CS";
        $staple[] = "D";
        $staple[] = "E";
        $staple[] = "É"; // eacute
        $staple[] = "F";
        $staple[] = "G";
        $staple[] = "GY";
        $staple[] = "H";
        $staple[] = "I";
        $staple[] = "Í"; // iacute
        $staple[] = "J";
        $staple[] = "K";
        $staple[] = "L";
        $staple[] = "LY";
        $staple[] = "M";
        $staple[] = "N";
        $staple[] = "NY";
        $staple[] = "O";
        $staple[] = "Ó"; //hosszu oo
        $staple[] = "Ö"; //rovid o:
        $staple[] = "Ő"; // 150 ? hosszu o:
        $staple[] = "P";
        $staple[] = "R";
        $staple[] = "S";
        $staple[] = "SZ";
        $staple[] = "T";
        $staple[] = "TY";
        $staple[] = "U";
        $staple[] = "Ú"; // u-
        $staple[] = "Ü"; // u:
        $staple[] = "Ű"; // 170? u=
        $staple[] = "V";
        $staple[] = "Z";
		
        $this->staple = $staple;
    }

    /// new letters for player p from staple
    function newletters($p)
    {
        global $PLAYER_LETTER_MAX;
        for($l=count($this->letters[$p]); $l<$PLAYER_LETTER_MAX; $l++)
        {
            if(count($this->staple) > 0)
            {
                $staple_index = rand(0, count($this->staple)-1); //len($staple)-1;
                $this->letters[$p][$l] = $this->staple[$staple_index];
                // remove from staple
                unset($this->staple[$staple_index]);
                $this->staple = array_values($this->staple);
            }
        }
    }
	/// filters out letters which are "-" in mask
	function maskhaserror($mask)
	{
		$mar = explode(".", $mask);
		for($i=0; $i<count($mar); $i++)
		{
			if($mar[$i]=="x")
			{
				return true;
			}
		}
		return false;
	}

	/// filters out letters which are "-" in mask
	function filter($word, $mask)
	{
		$war = explode(".", $word);
		$mar = explode(".", $mask);
		$retar = array();
		for($i=0; $i<count($war); $i++)
		{
			if($mar[$i]=="+")
			{
				$retar[] = $war[$i];
			}
		}
		return implode(".", $retar);
	}

    /// remove letters from player p, word is .-encoded
    function removeletters($p, $word)
    {
		$war = explode(".", $word);
        for($l=0; $l<count($war); $l++)
        {
            // search for letter
            $needle = $war[$l];
            $pos = array_search($needle, $this->letters[$p]);
            if( $pos === FALSE )
            {
                printf('notfound');
            }
            else
            {
                unset($this->letters[$p][$pos]);
                $this->letters[$p] = array_values($this->letters[$p]);
            }
        }
    }

    // ----- file operations --------

    function openletters()
    {
        global $PLAYER_MAX;
        $fstr = file_get_contents($this->m_filename); // get as array of lines
		$rows = explode("\n", $fstr);
        for($p=0; $p<$PLAYER_MAX; $p++)
        {
            $row = $rows[$p];
            $this->letters[$p] = explode(".",$row);
        }
        $row = $rows[$PLAYER_MAX];
        $this->staple = explode(".",$row);
    }

    function saveletters()
    {
        global $PLAYER_MAX;
        $st = $this->staple[0];
        $fstr = "";
        for($p=0; $p<$PLAYER_MAX; $p++)
        {
            $plet = implode(".", $this->letters[$p]);
            $fstr = $fstr . $plet . "\n";
        }
        // zsak
        $plet = implode(".", $this->staple);
        $fstr = $fstr . $plet . "\n";

        $ff = fopen($this->m_filename,'w');
        fputs($ff, $fstr);
        fclose($ff);
    }

} // end class CLetters
?>