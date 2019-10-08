
// **********   functions   ****************

function DisplayHelp( )
{

    strz = 'A táblán üres mezőre kattintva lehet elkezdeni a betűk lerakását. Az irányt (függőleges vagy vízszintes) a ';
    strz = strz + 'jobbra és le nyilakkal lehet állítani. Ezekkel lehet újrakezdeni a betűk lerakását is, vagy egy másik kockába ' ;
    strz = strz + 'kattintva. A saját betűinkre jobb oldalon kell sorrendben kattintani a szó kirakásához.';
    strz = strz + 'A GO gomb megnyomásával a lépés véglegesedik. A PASS gombot akkor kell megnyomni, ha nem tudunk lépni.' ;
    strz = strz + 'A lépés után egyeztetni kell chaten a másik játékossal, és ha már lépett, újratölteni az oldalt.' ;
    alert(strz);
}


// cross-browser, copied from net
function returnObjById( id )
{
    if (document.getElementById)
        var returnVar = document.getElementById(id);
    else if (document.all)
        var returnVar = document.all[id];
    else if (document.layers)
        var returnVar = document.layers[id];
    return returnVar;
}

function getposx()
{
	var textbox_x = returnObjById('posx');
	return parseInt(textbox_x.value);
}
function getposy()
{
	var textbox_y = returnObjById('posy');
	return parseInt(textbox_y.value);
}
function getcell(x,y)
{
	var cell = returnObjById('cell'+x+'.'+y);
	return cell;
}
function getorient()
{
	return returnObjById('orient').value;
}
function setposition(x, y)
{
	// search for html input fields
	var textbox_x = returnObjById('posx');
	var textbox_y = returnObjById('posy');
	textbox_x.value = x;
	textbox_y.value = y;
}

function setorient(or)
{
	var textbox_or = returnObjById('orient');
	textbox_or.value = or;
}

// clears all letters which the user has entered
function resetfield()
{
	for(var x=0;x<14; x++)
	{
		for(var y=0;y<14; y++)
		{
			var curcell = getcell(x,y);
			if(curcell)
			{
				//if(x==0 && y==0) alert(curcell.getAttribute("class"));
				cclass = curcell.getAttribute("class");
				if (cclass == "empty" )
				{
					curcell.innerHTML = "";
				}
				else
				{
					curcell.innerHTML = curcell.getAttribute("name");
				}
				curcell.style.background="";
				curcell.setAttribute("class", cclass);
			}
			else
			{
				alert("notfound:"+x+" "+y);
			}
		}
	}
	highlightcurrentcell();
}

function highlightcurrentcell()
{
	var x = getposx();
	var y = getposy();
	var curcell = getcell(x,y);
	var orient = getorient();
	for(var i=0; i<14; i++)
	{
		curcell = getcell(x,y);
		if(curcell)
		{
			//curcell.style.background = "#ffa0a0";
			curcell.style.background = "url('res/letter_sel.png')";		
		}
		if( orient==0) x++; else y++;
		if(x>14 || y>14) break;
	}
}

// clears the current word in the field
function clearcurrentword()
{
	var codebox = returnObjById('wordcode');
	codebox.value = "";
	// clear all letters
	for(var i=0; i<7; i++)
	{
		var lobj = returnObjById('l'+i);
		if(lobj)
		{
			lobj.setAttribute("class", "ourletter_unused");
		}
	}
}

function checkoutofboundsnextletter()
{
	var x = getposx();
	var y = getposy();
	var codebox = returnObjById('wordcode');
	var war = codebox.value.split(".");
	var cellout = 0;
	var orient = getorient();
	if( orient==0) 
	{
		cellout = war.length + x+1;
	}
	else 
	{
		cellout = war.length + y+1;
	}
	//alert("valami"+war.length+" sf"+x);
	if(cellout > 14) 
		return false;
	else
		return true;
}


// sets the wod in wordcode textbox to the field
function setwordcodetofield()
{
	resetfield();
	var origx = getposx();
	var origy = getposy();
	var orient = getorient();
	var codebox = returnObjById('wordcode');
	// got thru cells
	var war = codebox.value.split(".");
	var x=origx; 
	var y=origy;
	var curcell = getcell(x,y);
	for(var i=0; i<war.length; i++)
	{
		curcell = getcell(x,y);
		curcell.innerHTML = war[i];
		if( orient==0) x++; else y++;
	}
}


function addlettertowordcode(letter)
{
	var codebox = returnObjById('wordcode');
	if( codebox.value == "" )
	{
		codebox.value = letter;	
	}
	else
	{
		var war = codebox.value.split(".");
		war[war.length] = letter;
		var retstr = war.join(".");
		codebox.value = retstr;	
	}
}

function checkandaddfieldletter()
{
	var origx = getposx();
	var origy = getposy();
	var orient = getorient();
	var codebox = returnObjById('wordcode');
	// go thru cells
	var war = codebox.value.split(".");
	var x=origx; 
	var y=origy;
	var curcell;
	if( codebox.value == "" )
	{
		// nothing - x and y stay the same
	}
	else
	{
		for(var i=0; i<war.length; i++)
		{
			curcell = getcell(x,y);
			//curcell.innerHTML = war[i];
			if( orient==0) x++; else y++;
		}
	}
	
	var t=0;
	while(t<20)
	{
		// check if next letter is in the field
		if( x>14 || y>14)
		{
			// out of bounds
			return;
		}
		curcell = getcell(x,y);
		if(curcell)
		{
			if( curcell.innerHTML =="" || curcell.innerHTML == " ")
			{
				break;
			}
			// there is a letter here, add
			addlettertowordcode(curcell.innerHTML);
		}
		t++;
		if( orient==0) x++; else y++;
	}
}

/// says if there are any words on the field.
function isfirstword()
{
	for(var x=0;x<14; x++)
	{
		for(var y=0;y<14; y++)
		{
			var curcell = getcell(x,y);
			if(curcell)
			{
				cname = curcell.getAttribute("name");
				if(cname!="" && cname!=" ") return false;
			}
		}
	}
	return true;
}

// ********** event handlers ****************

// onsubmit handler
function checkword()
{
	if( isfirstword() ) return true;
	
	var origx = getposx();
	var origy = getposy();
	var orient = getorient();
	var codebox = returnObjById('wordcode');
	// go thru cells
	var war = codebox.value.split(".");
	var x=origx; 
	var y=origy;
	var curcell;
	if( codebox.value == "" )
	{
		alert('Hiba: Nem írt be szót.');
		return false;
	}
	else
	{
		for(var i=0; i<war.length; i++)
		{
			curcell = getcell(x,y);
			if( (curcell.innerHTML == curcell.getAttribute("name"))  )
				return true;
			if( orient==0) x++; else y++;
		}
	}
	// no letter is already in the field of this word
	alert('Hiba: A szó nem kapcsolódik egy másik szóhoz sem a táblán.');
	return false;
}

function OnClickOrientButton(orient)
{
	clearcurrentword();
	setorient(orient);
	resetfield();
	checkandaddfieldletter();
}

function OnClickClearButton()
{
	clearcurrentword();
	var orient = getorient();
	setorient(orient);
	resetfield();
	checkandaddfieldletter();
}

// our letters handler
function OnLetterClick(lettid)
{ 
	var lobj = returnObjById(lettid);
	var used = lobj.getAttribute("class");
	var letter = lobj.innerHTML;
	if(used == "ourletter_used")
	{
		return;
	}
	var ret = checkoutofboundsnextletter();
	if(ret == false)
	{
		// end of field
		return;
	}
	addlettertowordcode(letter);
	// set to used
	lobj.setAttribute("class", "ourletter_used");
	//update field
	setwordcodetofield();
	// check if field is there
	checkandaddfieldletter();
}

// set position in html and highlight
function OnCellClicked(x, y)
{
	clearcurrentword();
	setposition(x, y);
	resetfield();
	checkandaddfieldletter();
	//var textbox = returnObjById('word');
	//textbox.focus();
}
