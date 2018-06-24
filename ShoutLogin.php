<html><head>
<title>Admin Login Script</title>
<link href="ShoutBoxFiles/shout.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php

include 'ShoutBoxFiles/shoutoptions.php';
#Holds our database info

include 'ShoutBoxFiles/shoutfunctions.php';
#we use the function dbinsans in this file

if ($_POST['submit']!=NULL)
#if the submit button has been pressed
{
$db = mysql_connect("$dbHost", "$dbUser", "$dbPass") or die("Unable to connect!");
#connect

mysql_select_db ($dbname);
#select the database

$requete = "SELECT * FROM ShoutAdmin"; 
#our query

$result = mysql_query ($requete, $db); 
#sending the query

if ($result->username==NULL)
#if there is no row returned (Admin is not in database)
{
$PW = md5(dbinsans($_POST['password']));
#md5 encryption on the password

$USER = dbinsans($_POST['username']);
#only doing the dbinsans to block holes hackers exploit

$LEVEL = 'Admin';
# Setting user level to Admin...

$sql = "INSERT INTO ShoutAdmin (level, username, password) VALUES ('$LEVEL', '$USER', '$PW')"; 
#Creates the insert query string.

mysql_query($sql, $db); 
echo 'Thank you for setting the values, now you can login!<br />';
}
else
{
echo 'Sorry there already is an admin.';
#In case someone tries to post to this page... Crafty people...
}
}

$db = mysql_connect("$dbHost", "$dbUser", "$dbPass") or die("Unable to connect!");
#Connect to the database

mysql_select_db ($dbname);
#Select database

mysql_query("
CREATE TABLE IF NOT EXISTS `ShoutAdmin` (
  `id` int(11) NOT NULL auto_increment,
  `level` text NOT NULL,
  `password` text NOT NULL,
  `username` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) TYPE=MyISAM AUTO_INCREMENT=0
");
#If the shoutadmin table does not exist build it.. Autosetup code

mysql_query("
CREATE TABLE IF NOT EXISTS `ShoutBox` (
  `ID` int(11) NOT NULL auto_increment,
  `IP` text NOT NULL,
  `Name` text NOT NULL,
  `Date` int(11) NOT NULL default '0',
  `Message` text NOT NULL,
  `URL` text NOT NULL,
  KEY `ID` (`ID`)
) TYPE=MyISAM AUTO_INCREMENT=0
");
#If the shoutbox table does not exist build it.. Autosetup code

mysql_query("
CREATE TABLE IF NOT EXISTS `ShoutBoxBanned` (
`ID` INT NOT NULL AUTO_INCREMENT ,
`IP` TEXT NOT NULL ,
INDEX ( `ID` ) 
)
");
#If the shoutboxbanned table does not exist build it.. Autosetup code


$requete = "SELECT * FROM ShoutAdmin";
#select all the rows from shoutadmin
 
$result = mysql_query ($requete, $db); 
#returns result

$article = mysql_fetch_object($result);
#creates an object from result

if ($article->username==NULL)
#if there isn't a user in the admin table
{
echo 'You currently do not have an Admin, please enter the following information...<br />'; 
?>

<form method="post" name="shoutbox" action="<?php echo $_SERVER['SCRIPT_NAME'];?>" />
<span class="shoutinput">User Name : </span><br /><input type="text" name="username" /><br />
<br />
<span class="shoutinput">Choose Password (Case Sensitive) : </span><br /><input type="password" name="password" /><br />
<br />
<input type="submit" name="submit" value="Submit" />
</form>

<?php

}
else
{
#Already have an admin.

?>

<form method="post" name="shoutbox" action="ShoutBoxFiles/login.php" />
<span class="shoutinput">Your User Name : </span><br /><input type="text" name="username" /><br />
<br />
<span class="shoutinput">Enter Your Password (Case Sensitive) : </span><br /><input type="password" name="password" /><br />
<br />
<input type="submit" name="submit" value="Submit" />
</form>

<?php

}
?>
</body>
</html>