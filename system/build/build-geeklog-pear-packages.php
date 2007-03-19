<?php

/**
 * This script assumes you have PEAR in your PATH (for windows and linux)
 * 
 * @author Tony Bibbs <tony@geeklog.net>
 * 
 */
$glDir = realpath(dirname(__FILE__) . '/../../');
$curDir = dirname(__FILE__);

$xmlFiles = getPEARXMLFiles($glDir);

foreach ($xmlFiles as $curKey=>$curXMLFile) {    
    echo ("    running PEAR package for file: $curXMLFile...\n");
    $output = '';
    if (stristr($curDir, 'C:')) {
        $output = shell_exec("pear package \"$curXMLFile\"");
    } else {
        $curBuildFile = str_replace(' ','\ ',$curXMLFile);
        $output = shell_exec("pear package $curXMLFile");
    }
    if (!empty($output)) echo $output;
    if (isset($argv[1]) AND $argv[1] === 'keepXML') {
        continue;
    } else {
        echo "Removing PEAR package xml $curXMLFile...\n";
        unlink($curXMLFile);
    }
}


function getPEARXMLFiles($glDir)
{
    $buildDir = $glDir . DIRECTORY_SEPARATOR;

    $fd = opendir($buildDir);
    
    $xmlFiles = array();
    
    while(($curFile = @readdir($fd)) == TRUE)
    {    
        $fullFile = $buildDir . $curFile;
        if (is_file($fullFile) AND stristr($curFile,'package') AND stristr($curFile,'.xml')) {
            echo "found PEAR XML file $fullFile...\n";
            $xmlFiles[] = $fullFile;
        }
    }   
    return $xmlFiles;
}

?>