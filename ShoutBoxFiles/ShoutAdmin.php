<?php
session_start();
include 'shoutoptions.php';
#used for the database variables

include 'shoutfunctions.php';
#used for lefts() cuts down on the message if over 400.
#Just in case people decide to let the limit be higher than that
?>
<html><head>
<title>Admin Section</title>
<link href="shout.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
if($_SESSION['level']=='Admin'){
#if the session variable level is set to Admin

echo '<a href="logout.php">Logout?</a><br />';

$db = mysql_connect("$dbHost", "$dbUser", "$dbPass") or die("Unable to connect!");
#connect to the database

mysql_select_db($dbname,$db);
#select the database

if ($_GET['ban']!=NULL)
#if the variable Ban is not null
{

$IP = $_GET['ban'];
#since we sent an IP we're calling our variable $IP

echo 'Banned, <br />';
$i=0;

$requete = "SELECT IP FROM ShoutBoxBanned WHERE IP='$IP'";
$result = mysql_query ($requete,$db);
if ($pollart = mysql_fetch_object($result)!=NULL)
{
#If he's already been banned, let's not add him again
$i=1;
}
if($i==0){
	$sql="INSERT INTO ShoutBoxBanned (IP) VALUES ('$IP')";
	#insert the guy into the shoutbox banned table

	mysql_query($sql, $db);
	#our query
	}
}

if ($_GET['unban']!=NULL)
#if the variable unban is not null
		{

		$unban = $_GET['unban'];
		#get the unban, it's an IP, but I called it unban

		$requete2 = "DELETE FROM ShoutBoxBanned WHERE ID='$unban'";
		#our query to delete him from the database

		mysql_query ($requete2,$db);
		#executing query
		}
if ($_GET['del']!=NULL)
		#if del does no equal null
		{

		$del = $_GET['del'];
		#get our variable

		$requete2 = "DELETE FROM ShoutBox WHERE ID='$del'";
		#our query to delete the message

		mysql_query ($requete2,$db);
		#executing it
		}

$db = mysql_connect("$dbHost", "$dbUser", "$dbPass") or die("Unable to connect!");
#connecting to database

mysql_select_db($dbname,$db);
#select the database

$requete = "SELECT ID, Name, Message, IP FROM ShoutBox ORDER BY Date DESC";
#our query

$result = mysql_query ($requete,$db);
#executing the query

	echo '<h4>Messages</h4>';
$i=0;
#we're using it as a switch

while ($pollart = mysql_fetch_object($result)) 
#while there are rows
	{

	if (($Alternate==1)&&($i==0))
		#will only display if i is 0 and alternate mode, set in shoutoptions, is on
		{
		echo '<div class="shoutentry2">';
		echo $pollart->Name.' - <a href="'.$_SERVER['SCRIPT_NAME'].'?del='.$pollart->ID.'">Delete Message</a> -  <a href="'.$_SERVER['SCRIPT_NAME'].'?ban='.$pollart->IP.'">Ban User</a><br />'.lefts($pollart->Message, 400).'<br /></div>';
		$i=1;
		}
	else	{
		echo '<div class="shoutentry">';
		echo $pollart->Name.' - <a href="'.$_SERVER['SCRIPT_NAME'].'?del='.$pollart->ID.'">Delete Message</a> -  <a href="'.$_SERVER['SCRIPT_NAME'].'?ban='.$pollart->IP.'">Ban User</a><br />'.lefts($pollart->Message, 400).'<br /></div>';
		$i=0;
		}
	}
mysql_free_result($result);
#free the result... sometimes I forget this... it's not needed, when it finishes it frees it anyhow

$requete = "SELECT ID,IP FROM ShoutBoxBanned ORDER BY IP DESC";
#query to select the IP and IDs of who has been banned

$result = mysql_query ($requete,$db);
#query that query

	echo '<h4>Current Banned IPs</h4>';
while ($pollart = mysql_fetch_object($result)) 
	{
	echo $pollart->IP.' <a href="'.$_SERVER['SCRIPT_NAME'].'?unban='.$pollart->ID.'">Unban</a><br />';
	}
mysql_free_result($result);
}
else
{
echo 'Sorry, you don\'t have clearance to view this page.';
#if they're not logged in
}
?>
</body>
</html>
