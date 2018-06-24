<?php
session_start();
#required when using sessions to put that at the top of each page

include 'shoutfunctions.php';
#used for dbinsans

include 'shoutoptions.php';
#used for database vars


mysql_connect("$dbHost", "$dbUser", "$dbPass") or die("Unable to connect!");
#connect


mysql_select_db ($dbname);
#select the database

$PW = md5(dbinsans($_POST['password']));
#md5 encryption on password

$User = dbinsans($_POST['username']);
#only does the hacker hole closing on username

$result = mysql_query("SELECT * FROM ShoutAdmin WHERE username='$User' AND password='$PW'");
#creates and executes query returns result

$row =mysql_fetch_array($result);
#fetches a row


if ($row['password']!= md5($_POST['password'])){
#if the passwords don't match
    } else {
	$r=1;
	#we're using it to tell we got a match

        $_SESSION['username'] = $row['username'];
	#set the session variable username to the users name

        $_SESSION['password'] = $row['password'];
	#set the session variable password to the users password

        $_SESSION['level'] = $row['level'];
	#set the session variable level to the level
 }
if ($r!=1)
echo 'Sorry, your password is incorrect. Remember, it\'s case sensitive.';
else
echo 'Thank you for logging in, <a href="ShoutAdmin.php">Click Here</a> to continue.';
?>