<?php
#Database Options...

$dbHost = localhost; 
#Your db host

$dbUser = qrak; 
#username

$dbPass = ij6thnmg; 
#Pass

$dbname = qrak; 
#Name of the database.

#User Options...

$ShoutWait = 30;
#Seconds between posts. Flood Control. Turn to 0 seconds to turn off.

$smilies = 1; 
#smiley support 1=yes

$colors = 1; 
#color support 1=yes

$swear = 1; 
#swear filter 1=yes

$SelfDelete = 1; 
#if 1 allows people to delete their own entries while they are in the normal mode

$directory = "smilies/"; 
#Smiley folder, if you used my zip to unzip you don't have to worry about this


#Display Options

$IFRAME = 0; #Setting to 1 will turn on IFrame Mode

$WordWrap = 50;
#If 0 no wordwrap is used, this helps with keeping people from writing long strings
#The long strings would really mess up the page...
#Set it to how many characters max you want to display per line...
#I suggest guess and checking until you get it right. Just make a really long line.

$Alternate = 1; 
#if 1 varies the CSS behind each piece of entry.

$NameCutOff = 14;
#how many characters before name is cut off?

$MessageCutOff = 250; 
#Characters max determines how many characters a user can type...

$ShowNormal = 6; 
#how many entries do you want to show on your main page

$ShowArchived = 20; 
#how many archived entries do you want to show

$MaxRows = 40; 
#Delete after this many rows. This helps keep the database from being cluttered.

#End Options
?>