<?php

class ArrayWriter {

	var $filename;		//file name
	var $AName;			//array name minus $
	var $buff;			//array
	
	/**
	*
	* Constructor
	*/
	function ArrayWriter($fname, $name , $Abuf) {
		$this->filename = $fname;
		$this->Aname = $name;
		$this->buff = $Abuf;
	}
	/**
	*
	* Here the work is done
	*
	* return true if successful false otherwise
	*/
	function WriteArray() {
		
		$fp = fopen($this->filename,"w");
		if ($fp) {
			fputs($fp,"<?php\n" . '$' . $this->Aname . ' = array(' . "\n");
			$comma="";
			foreach($this->buff as $e){
				if ($comma == "") {
					$comma=",\n";
				} else {
					fputs($fp,$comma);
				}
				if ($e != '') {
					fputs($fp,"'$e'");
				}
			}
			fputs($fp,");\n?>");
			fclose($fp);
			$ret = 1;
		} else {
			$ret = 0;
		}
		return $ret;
	}
}
?>