/*******************************************
 ** Title 2 ID  ****************************
 ** Auto generate ID based on title **
 *******************************************/

function vNoE(param) {
	var param = param.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	var rgxpt = "[\\?&]" + param + "=([^&#]*)";
	var regex = new RegExp(rgxpt);
	var result = regex.exec(window.location.href);
	if(result == null) return ""; else return result[1];
}

function vChkID() { 
	var chkSID = vNoE("sid"); 
	if (chkSID == "") return false; 
}

function TitleToId(getTitle = 'title', setTl2ID = 'id') {

	if(vChkID()==false) {
	
	// vars - set your own variables.
	// edit here!
	// var getTitle = "title";
	// var setTl2ID = "id";
	var useDigits = false;
	var Separ = "-";
	var Sch = ["ă", "â", "î", "ş", "ţ", "à", "á", "ã", "ä", "å", "æ", "ç", "œ", "ð", "è", "é", "ê", "ë", "ì", "í", "ï", "ñ", "û", "ù", "ú", "ü", "ž", "ý", "ÿ", "ò", "ó", "õ", "ô", "ö", "ø", "š"];
	var Nch = ["a", "a", "i", "s", "t", "a", "a", "a", "a", "a", "a", "c", "oe", "d", "e", "e", "e", "e", "i", "i", "i", "n", "u", "u", "u", "u", "z", "y", "y", "o", "o", "o", "o", "o", "o", "s"];
	// done!

	// do not edit below
	var Title = document.getElementById(getTitle).value.toLowerCase();
	for(x=0; x<Title.length; x++) {
		for(i=0; i<Sch.length; i++) {
		Title = Title.replace(Sch[i], Nch[i]);
		}
	}
	var urlID = Title.replace(/\s\s+/g, " ").replace(/\s/g, "_").replace(/\W/g, Separ).replace(/_/g, Separ);
	var T2ID = document.getElementById(setTl2ID);
	if(useDigits==true) {
		var gDigit = new Date();
		var gD1 = gDigit.getDate();
		var gD2 = gDigit.getMonth();
		if (gD1 < 10) gD1 = "0" + gD1;
		if (gD2 < 10) gD2 = "0" + gD2;
		yondigit = Separ + gD1 + gD2;
		nr = 35;
	} else {
		yondigit = "";
		nr = 40;
	}
	T2ID.value = urlID.slice(0, nr) + yondigit;

	} // end
}