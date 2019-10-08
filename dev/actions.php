<?php

// actions file for scrabble


// includes
require_once("config.php");
require_once("players.php");

class CAction
{
    var $m_playername = "";
    var $m_hasmoved = "no";
    var $m_hasconfirmed = "no";
}

class CActions
{
    
    var $m_filename="actions.txt";
//    var $m_filename="actions.txt";

    var $m_actions = array();

	function clear()
	{
		$ff = fopen($this->m_filename,'w+');
        fwrite($ff, "");
        fclose($ff);
	}

    function open()
    {
        $rows = file($this->m_filename, FILE_IGNORE_NEW_LINES); // get as array of lines
        for($y=0;$y<count($rows); $y++)
        {
            $row = $rows[$y];
			
            $line = explode("|", $row);
			if( count($line) == 3 )
			{
				$this->m_actions[] = new CAction();
				$c = count($this->m_actions) - 1 ;
				$this->m_actions[$c]->m_playername = $line[0];
				$this->m_actions[$c]->m_hasconfirmed = $line[1];
				$this->m_actions[$c]->m_hasmoved = $line[2];
			}
        }
    }

    function save()
    {
        $rows = "";
        for($y=0;$y<count($this->m_actions); $y++)
        {
            $line = $this->m_actions[$y]->m_playername . "|" ;
            $line = $line . $this->m_actions[$y]->m_hasconfirmed . "|" ;
            $line = $line . $this->m_actions[$y]->m_hasmoved ;
            $rows = $rows . $line . "\n";
        }
        $ff = fopen($this->m_filename,'w+');
        fwrite($ff, $rows);
        fclose($ff);
    }

    /// saves the move of a player
    function playermoved($f_playername)
    {
        $this->m_actions[] = new CAction();
        $c = count($this->m_actions) - 1;
        $this->m_actions[$c]->m_playername = $f_playername;
        $this->m_actions[$c]->m_hasconfirmed = "yes";
        $this->m_actions[$c]->m_hasmoved = "yes";
    }
	
    function playerpassed($f_playername)
    {
        $this->m_actions[] = new CAction();
        $c = count($this->m_actions) - 1;
        $this->m_actions[$c]->m_playername = $f_playername;
        $this->m_actions[$c]->m_hasconfirmed = "yes";
        $this->m_actions[$c]->m_hasmoved = "yes";
    }
    
    
    function getlastplayername()
    {
        $c = count($this->m_actions)-1;
        if($c==-1)
        {
          // no one had a turn yet
          return "";
        }
        else
        {
          return $this->m_actions[$c]->m_playername;
        }
    }

    /// returns the player which is next to move.
    function getcurrentplayername($f_players)
    {
      $curplayer = $this->getlastplayername();
      if( $curplayer =="")
      {
        // no one had a turn yet, return first player
        return $f_players->getfirstplayername();
      }
      else
      {
        return $f_players->getnextplayername($curplayer);
      }
    }

}


?>