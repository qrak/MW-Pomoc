<?php
#Shout It! Version 1.0 By Tim Lovett of www.alphibia.com
#You may not take credit for the code...
#You may redistribute if you keep the original zip intact
# www.weborum.com <- if you have any questions regarding the script.

#The smilies are free from an open directory so I have included them.
#http://members.shaw.ca/wenpigsfly/smileys/index.htm
#Some others were made by friends
#One was made by me.
#None were stolen, that open directory grants usage of theirs. :-)
#If you want any more smilies feel free to go there.


include 'ShoutBoxFiles/shoutoptions.php';
#include the shoutoptions.php file with admin's options...

include 'ShoutBoxFiles/shoutfunctions.php';
#includes all of the functions required
$Outside = 0;
$IP = $_SERVER["REMOTE_ADDR"];
#logs user IP (used for many different parts)

if ((isset($_GET['SelfDel']))&&($SelfDelete==1))
	#if selfdel is set and the admin has turned on selfdeleting
	{
	$DelID = dbInsans($_GET['SelfDel']);
	#sets DelID to the SelfDel, it holds the ID of the one you want to delete

	$ShoutDisplay = $ShowNormal;
	#will only get rid of ones being shown

	$db = mysql_connect("$dbHost","$dbUser","$dbPass"); 
	#connect to database

	mysql_select_db($dbname,$db); 
	#select database

	$requete = "SELECT * FROM ShoutBox ORDER BY Date DESC LIMIT 0,$ShoutDisplay"; 
	#We want them only to be able to delete from the group that's up there now...
	#not find the ID of one of their older archived and delete doing this protects that
	#because instead of just grabbing the row, we're grabbing the shown ones and
	#checking to see if we find the ID, if we find the ID and the IPs match, it's nuked

	$result = mysql_query ($requete,$db); 

	while ($article = mysql_fetch_object($result))  
	#while we scroll through current ones
		{
		if($DelID==$article->ID)
		#if ID is in the current ones
			{
			if($IP==$article->IP)
			#if user owns the ID (if IPs match.)
				{
			$requete2 = "DELETE FROM ShoutBox WHERE ID='$DelID'";
			#delete the item where the ID is the DelID

			mysql_query ($requete2,$db);
			#query the database with the query...
				}
			else
			echo '<span class="shoutentry">Your IP does not match.</span>';
			#the IP does not match...
			}
	
		}
	
	}

#the following no script is required for legal reasons
?>
<noscript>
For a free easily customizable shout box/tag board script, head to <a href="www.alphibia.com">www.alphibia.com</a>.
</noscript>
<?php
if (isset($_POST['shoutsubmit']))
	#if the user has clicked the submit button
	{

	$Name = lefts(dbInsans($_POST['ShoutName']),$NameCutOff);
	# Users Name, it's cut off at the name cutoff, useful for formatting restrictions

	$URL = dbInsans($_POST['ShoutURL']);
	#for URL/Email

	$Date = time();
	#Time user is posting...

	$Message = dbInsans(lefts($_POST['Message'], $MessageCutOff));
	#User's message... lefts cuts it off and dbInsans protects againsts hackers
	
	#the next few pieces of code check the user IP against database at ID and the date
	
	$r=0;
	#We're going to use the variable r as a switch to determine if they're in the database.
	
	$db = mysql_connect("$dbHost","$dbUser","$dbPass");
	#connecting to the database area
	
	mysql_select_db($dbname,$db);
	#selecting our database
	
	$requete = "SELECT Date FROM ShoutBox WHERE IP='$IP' ORDER By Date Desc LIMIT 1";
	#A query to pull the last date from the owner of this IP
	
	$result = mysql_query ($requete,$db);
	#Should return ips of voters
	
	$article = mysql_fetch_object($result);
	#since it's only 1 item we want, the first

	$u=0;$y=0;
	if ($Message==NULL)
		$u=1; #if it's empty...
	if (($Date-$article->Date)<$ShoutWait)
		$u=1; #if the article is posted too soon from last
	#That was flood control.

	#Check and see if user is banned. :-X		
	$requete = "SELECT IP FROM ShoutBoxBanned WHERE IP='$IP'";
	#A query to pull our guy if he's there
	
	$result = mysql_query ($requete,$db);
	#Should return ip if he's there
	
	$article = mysql_fetch_object($result);
	if ($article->IP!=NULL)
		$y=1; #if it's not empty, he's there

	if ($u==0)
	#if the message wasn't null and he isn't flooding
 	{
		if($y==0)
		#if he's not banned
		{
		#the following sets his cookies
 		?>
		<script language="JavaScript" type="text/javascript">
		var now = new Date();
		now.setTime(now.getTime() + 365 * 24 * 60 * 60 * 1000);
		setCookie("ShoutName", "<?php echo $Name;?>", now);
		setCookie("ShoutURL", "<?php echo $URL;?>", now);
		</script>
		<?php
		 
		 $sql = "INSERT INTO ShoutBox (Date, URL, IP, Name, Message) VALUES ('$Date', '$URL', '$IP', '$Name', '$Message')"; 
		  #Creates the insert query string.

		  mysql_query($sql, $db); 
		  #Queries the database and adds the user.
		}
		else
		{
		echo '<span class="shoutentry">Sorry the admin banned you from posting.</span><br />';
		#let him know he's been banned
		}

	 }
	else 
	{
	echo '<span class="shoutentry">Flood Protection is enabled, sorry.</span><br />';
	#if he's sending empty messages or flooding, he gets this
	}

}

#Code to delete after rows...

$db = mysql_connect("$dbHost","$dbUser","$dbPass");
#connecting to the database area

mysql_select_db($dbname,$db);
#selecting our database

$MaxRows2 = $MaxRows-1;
#used to create limit

$requete = "SELECT Date FROM ShoutBox ORDER By Date Desc LIMIT $MaxRows2,$MaxRows";
#grabs the $MaxRow(set in useroptions)'s entry

$result = mysql_query ($requete,$db);
#Should return the MaxRow's date

$article = mysql_fetch_object($result);
#Only need one article so not looping

$Last = $article->Date;
#We grab his date
	
$requete2 = "DELETE FROM ShoutBox WHERE Date<'$Last'";
#deletes anything before that entry...

mysql_query ($requete2,$db);
#queries the query

$ShoutDisplay = $ShowNormal;
#Set the display to normal, when entries is called ShoutDisplay is used to determine
#how many to show...
if ($IFRAME==1)
	echo '<iframe class="shoutiframe" src="ShoutBoxFiles/shoutiframe.php"></iframe>'; 
else
	include 'ShoutBoxFiles/shoutentries.php';
#include the entries

?>

<a class="shoutlink" href="javascript:shoutbox('ShoutBoxFiles/shoutboxarch.php')">Pokaż Archiwum</a>

<br />
<form method="post" name="shoutbox" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<span class="shoutinput">Nick : </span><br /><input type="text" name="ShoutName" /><br />
<br />
<span class="shoutinput">Wiadomość : </span><br />
<textarea name="Message" rows="3" cols="18" class="shouttextarea" onkeyup="TrackCount(this,'textcount',<?php echo $MessageCutOff;?>)" onkeypress="LimitText(this,<?php echo $MessageCutOff;?>)"></textarea><br />
<span class="shoutinput">Pozostało znaków: </span> <input type="text" name="textcount" size="3" 
value="<?php echo $MessageCutOff;?>" /><br />
<input type="submit" name="shoutsubmit" value="Wyślij" /> &nbsp;<a class="shoutlink" href="javascript:shoutbox('ShoutBoxFiles/shoutboxpopup.php')">Shout-Code!</a>

</form>
<script language="JavaScript" type="text/javascript">
var cookievalu = getCookie("ShoutName");
if (cookievalu!=null)
document.shoutbox.ShoutName.value  = cookievalu;
else
document.shoutbox.ShoutName.value  ="";

var cookieval = getCookie("ShoutURL");
if (cookieval!=null){
document.shoutbox.ShoutURL.value = cookieval;
}
else
document.shoutbox.ShoutURL.value ="";

</script>
</div>