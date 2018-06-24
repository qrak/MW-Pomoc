<?php
$db = mysql_connect("$dbHost","$dbUser","$dbPass"); 
#connect to the database

mysql_select_db($dbname,$db); 
#select our database

$requete = "SELECT * FROM ShoutBox ORDER BY Date DESC LIMIT 0,$ShoutDisplay"; 
#query that grabs all the columns from shoutbox
#it uses the shoutdisplay variable set before the include to limit how many rows
#descending by date because it gives the latests dates

$result = mysql_query ($requete,$db); 
#result of query

echo '<div class="fullshout">&nbsp;';
#This is a little design this div wraps around the whole table.

echo '<div class="halfshout">&nbsp;<br />';
#This is a little design this div wraps around all but the form.


$i=0;
#we're using this variable to create the alternating rows

    while ($article = mysql_fetch_object($result))  
	#looping through our result $article is the row we're on
    {  
	$today = date("F j, Y, g:i a", $article->Date); 
	#Sets up the date

	$URL = $article->URL;
	#grabs the URL/email of poster from the database

	if (mailcheck($URL))
	#defined in the shoutfunctions.php regular expression check
	#determines if this is an email address
		{
		$ShoutURL = '<a';
		#first part of anchor

			if (($Alternate==1)&&($i==0)) 
				$ShoutURL .= ' class="shoutname2"'; 
			else
				$ShoutURL .= ' class="shoutname"';
			#if alternate is on and i is 0, otherwise regular

		$ShoutURL .=' href="mailto:'.$URL.'"';
		#Finishes the beginning anchor tag

		}
	else if (URLcheck($URL))
	#regular expression to determine if url and if starts with http://
	#function found in phpfunctions.php
		{
		$ShoutURL = '<a';
			if (($Alternate==1)&&($i==0))
				$ShoutURL .= ' class="shoutname2"';
			else
				$ShoutURL .= ' class="shoutname"';
		$ShoutURL .=' href="'.$URL.'"';
		}
	else if ($URL!=NULL)
	#as long as URL isn't empty let's just assume they forgot http:// 
		{
		$ShoutURL = '<a';
			if (($Alternate==1)&&($i==0))
				$ShoutURL .= ' class="shoutname2"';
			else
				$ShoutURL .= ' class="shoutname"';
		$ShoutURL .=' href="http://'.$URL.'"';
		}
	else {
	#empty url, we'll give them an empty javascript command
		$ShoutURL = '<a';
			if (($Alternate==1)&&($i==0))
				$ShoutURL .= ' class="shoutname2"';
			else
				$ShoutURL .= ' class="shoutname"';
		$ShoutURL .= ' href="javascript:()" onclick="return false;" onkeypress="return false;"';
		}

	if (($Alternate==1)&&($i==0))
	#will only display if i is 0 and alternate mode, set in shoutoptions, is on
	{
	echo '<div class="shoutentry2">'.$ShoutURL.' title="'.$today.'">'.stripslashes($article->Name).'</a>';
	echo '<div class="shoutmessage2">';
	if ($WordWrap!=0) #only wraps if set
		echo webcode(wrap_text(stripslashes($article->Message),$WordWrap));
	else
		echo webcode(stripslashes($article->Message));
	echo '</div>';

	#webcode() is a function of mine to add smilies color and bb depending on if they're on
	#strip slashes removes the \ that often are used to protect the database when messages are inward
	#it's safe because now they're out in the open

		if ($SelfDelete==1)
		#if in phpoptions.php self delete is on
		{
		if ($article->IP==$IP)
			echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?SelfDel='.$article->ID.'">Skasuj swój post</a>';
		#this if checks if this user owns the message
		#if so it gives them the option of self deleting their post
		#in case you care, $_SERVER['SCRIPT_NAME'] is the main script running
		#the one before includes, I set the $IP before calling this include
		}
	echo '</div><br />';
	$i=1;
	#set i to 1 so it will alternate, remember this only turns on if $Alternate=1
	}
	else {
	#normal execution
	echo '<div class="shoutentry">'.$ShoutURL.' title="'.$today.'">'.stripslashes($article->Name).'</a>';
	echo '<div class="shoutmessage">';

	if ($WordWrap!=0)
		echo webcode(wrap_text(stripslashes($article->Message),$WordWrap));
	else
		echo webcode(stripslashes($article->Message));

	echo '</div>';
		if ($SelfDelete==1)
		#same as above
		{
		if ($article->IP==$IP)
			echo '<a href="'.$_SERVER['SCRIPT_NAME'].'?SelfDel='.$article->ID.'">Skasuj swój post</a>';
		}
	echo '</div><br />';
	$i=0;
	}
    } 

echo '</div>';
#closes halfshout div
?>