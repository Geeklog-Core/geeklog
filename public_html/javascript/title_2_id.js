/*******************************************
 ** Title 2 ID  ****************************
 ** Auto generate ID based on title **
 *******************************************/

function TitleToId(getTitle, setTl2ID, size) {

    // Set defaults if needed
    getTitle = typeof getTitle !== 'undefined' ? getTitle : 'title';
    setTl2ID = typeof setTl2ID !== 'undefined' ? setTl2ID : 'id';
    size = typeof size !== 'undefined' ? size : 128;
    
	var Separ = "-";
	var Sch = ["ă", "â", "î", "ş", "ţ", "à", "á", "ã", "ä", "å", "æ", "ç", "œ", "ð", "è", "é", "ê", "ë", "ì", "í", "ï", "ñ", "û", "ù", "ú", "ü", "ž", "ý", "ÿ", "ò", "ó", "õ", "ô", "ö", "ø", "š"];
	var Nch = ["a", "a", "i", "s", "t", "a", "a", "a", "a", "a", "a", "c", "oe", "d", "e", "e", "e", "e", "i", "i", "i", "n", "u", "u", "u", "u", "z", "y", "y", "o", "o", "o", "o", "o", "o", "s"];

	var Title = document.getElementById(getTitle).value.toLowerCase();
	for(x=0; x<Title.length; x++) {
		for(i=0; i<Sch.length; i++) {
		Title = Title.replace(Sch[i], Nch[i]);
		}
	}
	var urlID = Title.replace(/\s\s+/g, " ").replace(/\s/g, "_").replace(/\W/g, Separ).replace(/_/g, Separ).replace(/^-+|-+$/g, ""); // Final replace trim any leading and trailing dashes
	
	var T2ID = document.getElementById(setTl2ID);
	
	T2ID.value = urlID.slice(0, size); // Max size of id
	
	
}