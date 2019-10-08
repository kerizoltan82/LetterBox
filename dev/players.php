<?php

// players file for scrabble

// later this information could be saved in a afile

class CPlayer
{
    var $m_name = "";
    //var $m_
}

class CPlayers
{

  var $m_players = array();
  // file contains two rows: one for each player name.
  var $m_filename="data/players.txt";
  
  function saveplayers($p1name, $p2name) 
  {
    $rows = $p1name."\n".$p2name;
    $ff = fopen($this->m_filename,'w+');
    fwrite($ff, $rows);
    fclose($ff);
  }
  
  function loadplayers() 
  {
  
    $rows = file($this->m_filename, FILE_IGNORE_NEW_LINES); // get as array of lines
    $this->m_players[0] = new CPlayer();
    $this->m_players[0]->m_name = $rows[0];
    $this->m_players[1] = new CPlayer();
    $this->m_players[1]->m_name = $rows[1];
  }

  // obsolete - don't use
  function init()
  {
  
    $this->m_players[0] = new CPlayer();
    $this->m_players[0]->m_name = "Zoli";
    $this->m_players[1] = new CPlayer();
    $this->m_players[1]->m_name = "Agi";
    //print("jaticonst:".$this->m_players[0]->m_name);

  }

  function playerfromindex($f_ind)
  {
  }

  function findfromname($f_name)
  {
      for($i=0; $i<count($this->m_players); $i++)
      {
        //print("jat:".$f_name);
        //print("jati:".$this->m_players[$i]->m_name);
        if($this->m_players[$i]->m_name == $f_name )
          //return $this->m_players[$i];
          return $i;
      }
      return -1;
  }
  
  function getnextplayername($f_playername)
  {
      if($f_playername == $this->m_players[0]->m_name)
      {
          return $this->m_players[1]->m_name;
      }
      else
      {
          return $this->m_players[0]->m_name;
      }
  }

  function getfirstplayername()
  {
      return $this->m_players[0]->m_name;
  }
}


?>