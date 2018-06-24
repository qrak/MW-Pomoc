<html><head>
<style type="text/css">
td.header {background-color:#FFF; font-weight:700;text-align:center;}
td.cells {background-color:#FFF;width:50%;text-align:center}
img {border:0;}
a
{
    FONT-SIZE: 11px;
    COLOR: #003366;
    FONT-FAMILY: Arial;
    TEXT-DECORATION: none
}
a:hover
{
    FONT-SIZE: 11px;
    COLOR: black;
    FONT-FAMILY: Arial;
    TEXT-DECORATION: none
}
</style>
<script language="JavaScript" type="text/javascript">
<!--// Displays Deports a value... :-) //-->
function Deporter(value)
{
opener.document.shoutbox.Message.value += ' ' + value + ' ';
}
</script>
</head>
<body>
<table style="background-color:#CCC;width:100%" cellpadding="1">
<?php
include 'shoutoptions.php';
#includes the user options

if ($smilies==1)
#checks to see if smilies is turned on, if so it begins the if statement
{

?>
<tr>
<td colspan="2" class="header">Smilies</td>
</tr>
<?php

$file = file("smilies.txt");
#open the smilies file

foreach($file as $smile)
#When a file is opened in PHP, every line is turned into an array object
#for each loops through the array foreach($nameofarray as $whatthisrowwillbecalled)
#it goes through until the array is fully shown
	{
	echo '<tr><td class="cells">'; #some formatting...

	list($old,$new) = explode("\|/", $smile);
	#In this array object when it finds \|/ it seperates the left and right of it
	#it turns them each into a variable, very useful PHP function
	
	$old = trim($old);
	#trims off the spaces before and after	

	echo '<a href="javascript:Deporter(\''.$old.'\')">'.$old.'</a></td><td class="cells">';
	# displays our Deporter code deporting the old version of the smilie
	#it can be clicked.

	$new = trim($new);
	#trims off the spaces before and after	

	echo '<a href="javascript:Deporter(\''.$old.'\')"><img src="../'.$directory.'/'.$new.'" alt="" /></a></td></tr>';
	#does the same as the old version, but it shows a picture to click
	}

echo '<tr><td colspan="2" style="background-color:#FFF;">&nbsp;</td></tr>';
#the brace following this closes the if statement about the smilies
#the echo above will display an empty row for display purposes if the smilies ran
}
?>

<tr>
<td colspan="2" class="header">Shout-Code</td>
</tr>
<tr><td class="cells"><a href="javascript:Deporter('[b][/b]')">[b]Bold[/b]</a></td><td class="cells"><a href="javascript:Deporter('[b][/b]')"><b>Bold</b></a></td></tr>
<tr><td class="cells"><a href="javascript:Deporter('[u][/u]')">[u]Underline[/u]</a></td><td class="cells"><a href="javascript:Deporter('[u][/u]')"><u>Underline</u></a></td></tr>
<tr><td class="cells"><a href="javascript:Deporter('[i][/i]')">[i]Italics[/i]</a></td><td class="cells"><a href="javascript:Deporter('[i][/i]')"><i>Italics</i></a></td></tr>

<?php
#the above tds are BB code I did by hand, there aren't too many, so I figured I'd do it

if ($colors==1)
#similiar to the smilies only runs if colors is on
	{
	echo '<tr><td colspan="2" style="background-color:#FFF;">&nbsp;</td></tr>';
	#only adds this extra empty row if the colors are on
?>
<tr>
<td colspan="2" class="header">Colors</td>
</tr>
<?php
	$file = file("colors.txt");
	#opens the file

	foreach($file as $color)
	#like the smilie one, read there to understand
		{
		list($old,$new) = explode("|", $color);
		#similiar to the smilies one, but this one breaks apart at the | 

		$old = trim($old);
		#spaces are removed

		$new = trim($new);
		#spaces are removed

		echo '<tr><td class="cells"><a href="javascript:Deporter(\'[color='.$old.'][/color]\')">[color='.$old.']'.$old.'[/color]</a></td><td class="cells"><a href="javascript:Deporter(\'[color='.$old.'][/color]\')"><span style="color:'.$new.';">'.$old.'</span></a></tr>';
		#I did them both on the same line, but it's similar to the smilies one	
		}

	}
?>

</body>
</html>