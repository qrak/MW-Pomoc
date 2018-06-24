<?php 
function showlist($directory) { 
 if ($handle = opendir($directory)) { 
  $countfile="0";$countdir="0"; 
  while (false !== ($thing = readdir($handle))) { 
   if (($thing != ".")&&($thing != "..")) { 
    if (is_dir("$directory/$thing")) { $dirname[$countdir]=$thing;$countdir++; } 
    else { $filename[$countfile]=$thing;$countfile++; } 
   } 
   if (($thing == "..")&&(isset($_GET['dir']))) { $dirname[$countdir]=$thing;$countdir++; } 
  } 
  closedir($handle); 
 } 
 if ($countdir != "0") { 
  sort($dirname);$count2="0"; 
  while ($count2 < $countdir) { 
	 echo ('<ul><a href="skrypty/'.$dirname[$count2].'"">'.$dirname[$count2].'</a></ul>');
	 

   $count2++; 
  } 
 } 
 if ($countfile != "0") { sort($filename) ;$count2="0"; 
  while ($count2 < $countfile) { 
	 echo ('<ul><a href="skrypty/'.$filename[$count2].'" TARGET="_blank">'.$filename[$count2].'</a></ul>');
   $count2++; 
  } 
 } 
 if (($countdir =="0")&&($countfile == "0")) { 
  echo "   <tr><td></td><td colspan=\"7\">No Files or Directories In This Folder</td></tr>"; 
 } 
} 
?> 