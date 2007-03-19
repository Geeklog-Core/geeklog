<?php

/**
 * This script assumes you have PHP in your PATH (for windows and linux)
 * 
 * @author Tony Bibbs <tony@geeklog.net>
 * 
 */
$glDir = realpath(dirname(__FILE__) . '/../../');
$curDir = dirname(__FILE__);

// Quick OS hack...should probably use a $_SERVER setting or some other superglobal.
if (stristr($curDir, 'C:')) {    
    echo "building Geeklog's PEAR XML...\n";
    $output = '';
    $output = shell_exec("php \"$curDir/buildpackage.php\" make");  
    if (!empty($output)) echo $output;  
    echo "building FCKeditor's PEAR XML...\n";
    $output = '';
    $output = shell_exec("php \"$curDir/buildpackage-fckeditor.php\" make");
    if (!empty($output)) echo $output;
    echo "building Professional Theme's PEAR XML...\n";
    $output = '';
    $output = shell_exec("php \"$curDir/buildpackage-theme-professional.php\" make");
    if (!empty($output)) echo $output;
} else {
    $curDir = str_replace(' ','\ ',$curDir);
    echo "building Geeklog's PEAR XML...\n";
    $output = '';
    $output = shell_exec("php $curDir/buildpackage.php make");
    if (!empty($output)) echo $output;
    echo "building FCKeditor's PEAR XML...\n";
    $output = '';
    $output = shell_exec("php $curDir/buildpackage-fckeditor.php make");
    if (!empty($output)) echo $output;
    echo "building Professional Theme's PEAR XML...\n";
    $output = '';
    $output = shell_exec("php $curDir/buildpackage-theme-professional.php make");
    if (!empty($output)) echo $output;
}

$pluginBuildFiles = getPluginBuildFiles($glDir);

echo "building PEAR XML for plugins found in $glDir/plugins...\n";
foreach ($pluginBuildFiles as $curKey=>$curBuildFile) {    
    echo ("    running PEAR XML build file: $curBuildFile...\n");
    $output = '';
    if (stristr($curDir, 'C:')) {
        $output = shell_exec("php \"$curBuildFile\" make");
    } else {
        $curBuildFile = str_replace(' ','\ ',$curBuildFile);
        $output = shell_exec("php $curBuildFile make");
    }
    if (!empty($output)) echo $output;
}

function getPluginBuildFiles($glDir)
{
    $pluginDir = $glDir . '/plugins/';

    $fd = opendir($pluginDir);
    
    $buildFiles = array();
    while(($dir = @readdir($fd)) == TRUE)
    {    
        $curPluginDir = $pluginDir . $dir;
        if (is_dir($curPluginDir) AND $dir <> '.' AND $dir <> '..' AND $dir <> 'CVS') {
            echo "checking $curPluginDir for buildpackage.php...\n";
            if (file_exists($curPluginDir .'/buildpackage.php')) 
            {
                $buildFiles[] = $curPluginDir . '/buildpackage.php';
            }
        }
    }   
    return $buildFiles;
}

?>