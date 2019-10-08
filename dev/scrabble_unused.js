
// unsused code for scrablle

// textarea handler
function OnWordKeyUp(ev)
{
	var keyChar = String.fromCharCode(ev.which);
	var textbox = returnObjById('word');
	if (keyChar >= 'a' && keyChar <= 'z')
	{
		// update
		var stri = textbox.value;
		fillwordcode(stri);
		setwordcodetofield();
	}
	else
	{
		if (ev.which == 39) //right key
		{
			setorient(0);
			setwordcodetofield();
			return;
		}
		if (ev.which == 40) //down key
		{
			setorient(1);
			setwordcodetofield();
			return;
		}
		// let the user edit
		var stri = textbox.value;
		fillwordcode(stri);
		setwordcodetofield();
	}
}

// encodes the word to wordcode
function fillwordcode(word)
{
	var codebox = returnObjById('wordcode');
	// transform to uppercase, add points
	var war = new Array();
	for(var i=0; i<word.length; i++)
	{
		var w = word.substring(i,i+1);
		war[i] = w.toUpperCase();
	}
	var retstr = war.join(".");
	codebox.value = retstr;
}

// check if word is ok
function checkword()
{
	var origx = getposx();
	var origy = getposy();
	var orient = getorient();
	var codebox = returnObjById('wordcode');
	// got thru cells
	var war = codebox.value.split(".");
	var x=origx; 
	var y=origy;
	var curcell;
	for(var i=0; i<war.length; i++)
	{
		curcell = getcell(x,y);
		var origletter = curcell.getAttribute("name");
		if(origletter != "" && origletter != " ")
		{
			if (war[i] != origletter )
			{
				// double letter check
				//error, word not ok
				return false;
			}
		}
		
		// go to next cell
		if( orient==0) x++; else y++;
	}
}