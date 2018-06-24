<html><head><link href="shout.css" rel="stylesheet" type="text/css" />
</head><body>
<?php
$IP = $_SERVER["REMOTE_ADDR"];
#logs user IP (used for many different parts)

$Outside = 1;
include 'shoutoptions.php';
#User info file 
#(contains variables these functions and entries function with)

include 'shoutfunctions.php';
#ShoutFunctions file, contains functions used in this script.


$ShoutDisplay = $ShowNormal;
#ShowDisplay is a variable in the shoutoptions page.
#ShoutDisplay is a variable called in the the shoutentries page
#ShoutDisplay determines how many are shown

include 'shoutentries.php';


?>

</body></html>