<html><head><link href="shout.css" rel="stylesheet" type="text/css" />
</head><body>
<?php
$Outside = 1;
include 'shoutoptions.php';
#User info file 
#(contains variables these functions and entries function with)

include 'shoutfunctions.php';
#ShoutFunctions file, contains functions used in this script.


$ShoutDisplay = $ShowArchived;
#ShowArchived is a variable in the shoutoptions page.
#ShoutDisplay is a variable called in the the shoutentries page
#ShoutDisplay determines how many are shown

include 'shoutentries.php';
echo '</div>';

#closes the fullshout div opened in shout entries
?>

</body></html>