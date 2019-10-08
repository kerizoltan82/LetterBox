<?php
// ********* Scrabble field class ************
require_once("config.php");

class CNewWord {
    var $posx = 0;
    var $posy = 0;
    var $orient = 0;
    var $word = "";
}

class CScField {
    var $field = array(99=>"");
    var $m_filename="data/field1.txt";
    // $m_prevfilename="field0.txt"

    function clearfield()
    {
        for ($i=0; $i<(15*15)-1; $i=$i+1)
        {
            $this->field[$i] = " ";
        }
    }

    function getfield($x,$y)
    {
        return $this->field[$y*15+$x];
    }

    function setfield($x,$y,$letter)
    {
        $this->field[$y*15+$x]=$letter;
    }

    // debug
    function write()
    {
        print ("field: ");
        for ($i=0; $i<(15*15)-1; $i=$i+1)
        {
             print $this->field[$i];
        }
    }

    /// adds a new word to the field.
	/// returns a struct
    function addtofield($newword)
    {
		$war = explode(".", $newword->word);
		$ret = array();
		for($i=0; $i<count($war); $i=$i+1)
		{
			$old = "";
			if($newword->orient == 0)
			{
				$old = $this->getfield($i + $newword->posx, $newword->posy);
				$this->setfield($i + $newword->posx, $newword->posy, $war[$i] );
			}
			else
			{
                                $old = $this->getfield($newword->posx, $i + $newword->posy);
				$this->setfield($newword->posx, $i + $newword->posy, $war[$i] );
			}
			if($old == " " || $old == "")
			{
				$ret[$i] = "+";
			}
			else
			{
				// check if correct letter here
                                if( $old == $war[$i] )
                                {
				   $ret[$i] = "-";
                                 }
                                else
                                {
                                   $ret[$i] = "x"; // error
                                   $this->logerror($war,$newword->orient);
                                }
			}
        }
		return implode(".", $ret);
    }

     function checknewword($newword)
    {
        // not implemented
    }

    // --- file operations ---

     function openfield()
    {
        $rows = file($this->m_filename, FILE_IGNORE_NEW_LINES); // get as array of lines
        for($y=0;$y<15; $y++)
        {
            $row = $rows[$y];
            $line = explode(".", $row);
            for($x=0; $x<15; $x++)
            {
                $this->setfield($x, $y, $line[$x]);
            }
        }
    }

    function savefield()
    {
        $rows = "";
        for($y=0;$y<15; $y++)
        {
            $line = "" ;
            for($x=0; $x<15; $x++)
            {
                $line = $line . $this->getfield($x, $y) . ".";
            }
            $rows = $rows . $line . "\n";
        }
        $ff = fopen($this->m_filename,'w+');
        fwrite($ff, $rows);
        fclose($ff);
    }

} // end class CScField
?>
