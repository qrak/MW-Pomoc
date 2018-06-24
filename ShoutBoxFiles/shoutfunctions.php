<?php

#function is used to protect users from hackers.
#it filters out a lot of the bad things they can do.
function dbinsans($text) {
$text = strip_tags ($text, "");
$text = str_replace(chr(10),"",$text);
$text = str_replace(chr(13), "<br>", $text);
$text = str_replace("\"","&quot;",$text);
$text = str_replace("'","&#39;",$text);
$text = addslashes($text);
return($text);
}

function stri_replace($find,$replace,$string)
{
#function thanks to bradhuizenga @ softhome.net
#he posted it on php.net
#My server, and many of yours, won't have the PHP str_ireplace function...
#This one he made stri_replace, will allow us to do replaces without care to case
       if(!is_array($find)) $find = array($find);
       if(!is_array($replace))
       {
               if(!is_array($find)) $replace = array($replace);

               else
               {
                       // this will duplicate the string into an array the size of $find
                       $c = count($find);
                       $rString = $replace;
                       unset($replace);
                       for ($i = 0; $i < $c; $i++)
                       {
                               $replace[$i] = $rString;
                       }
               }
       }
       foreach($find as $fKey => $fItem)
       {
               $between = explode(strtolower($fItem),strtolower($string));
               $pos = 0;
               foreach($between as $bKey => $bItem)
               {
                       $between[$bKey] = substr($string,$pos,strlen($bItem));
                       $pos += strlen($bItem) + strlen($fItem);
               }
               $string = implode($replace[$fKey],$between);
       }
       return($string);
}

/* 
Found at http://www.zend.com/codex.php?id=220&single=1

This function wraps text to the given number of characters.  It will only 
wrap on word boundaries, and removes any resulting leading whitespace. 
It also converts all whitespcae characters (tab, cr, space) to a space. 
It accepts two arguments: 
        $text - the text to be wrapped 
        $wrap - the number of characters at which to wrap 

It returns the wrapped text unless $text is null, then it returns void; 
or $wrap is not an integer, then it returns $text untouched. 

*/ 
function wrap_text($text, $wrap) { 
        if (!isset($text)) return;
	#I hate to edit that line from their code, I didn't have the function they
	#Were using, this is equal to what they had though...
        if (!is_integer($wrap)) return $text; 

        $text_array = explode("\n", $text); 

        $i = $j = 0; 
        while ($i < sizeof($text_array)) { 
                $text_array[$i] = preg_replace("/\s/", " ", $text_array[$i]); 
                $length = strlen($text_array[$i]); 
                if ($length <= $wrap) { 
                        $new_text_array[$j] = $text_array[$i]; 
                        $i++; 
                } 
                else { 
                        $tmp = substr($text_array[$i], 0, $wrap); 
                        $spacePos = strrpos($tmp, " "); 
                        if ($spacePos > 0) { 
                                $new_text_array[$j] = substr($text_array[$i], 0, $spacePos+1); 
                                $new_text_array[$j] = ltrim($new_text_array[$j]); 
                                $text_array[$i] = substr($text_array[$i], $spacePos+1); 
                        } 
                        else { 
                                $new_text_array[$j] = $tmp; 
                                $text_array[$i] = substr($text_array[$i], $wrap); 
                        } 
                } 
                $j++; 
        } 
        return (implode("\n", $new_text_array)); 
} 


function Swear_Replace(){
#a little function I crafted :-)
	$swearstring = 4; 
	#how big do we want the swear to show up?
	#like arse to #$%^ that's 4. arse to $%^&* is 5
	$seeder=0;
	if($seeder != 1){
		srand((double)microtime()*1000000);
		#seeds the random value
		$seeder = 1;
		#only do it once, so giving it a value
	}
	$result="";
	$chars = "!@#$%^*";
	for($i=0; $i<$swearstring; $i++){
		#uses the char array and the length
		$result .= substr($chars,rand(0,strlen($chars)-1),1);
		#randomly picks one character between the first, last in char array
	}
	return $result; 
	#returns string of #$%^ like characters
}


function webcode($text) {
#My baby! :-) This does all the switching, BB, Swears, Smilies, all here
global $Outside;
if ($Outside == 1)
include 'shoutoptions.php';
else
include 'ShoutBoxFiles/shoutoptions.php';

if ($swear==1)
	#if swear is activiated in phpoptions.php
	{
	if ($Outside== 1)
	$file = file("swears.txt");
	else
	$file = file("ShoutBoxFiles/swears.txt");
	#opens the swears.txt, every line is turned into an object in an array
	#we called the array $file

	foreach($file as $swear)
	#for each object in file we give loop through setting that object to $swear
		{
		$swear = trim($swear);
		#get rid of the spaces
	
		$random = Swear_Replace();
		#calls the Swear_Replace() I made and fills it with junk !@#$%^&*

		$text = stri_replace($swear,$random,$text);
		#replaces the swear with the junk
	}
}

$text = stri_replace("[Alphibia]","http://www.Alphibia.com",$text);
#a little plug here, don't worry it is only added if people type [Alphibia]
#like that will happen... for legal reasons, don't remove this >:o

$text = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]",
                     "<a href=\"\\0\">\\0</a>", $text);
#This is the regular expression that changes a link beginning with http:// into a link

$text = stri_replace("[Version]","Version 1.0",$text);
#current version, in case people care, will be useful if I release more and you need help

$text = stri_replace(" weborum "," <a href=\"http://forum.weborum.com\">Weborum</a> ", $text);
#Plug, will turn Weborum with a space before and after into a link.

$text = stri_replace("weborum ","<a href=\"http://forum.weborum.com\">Weborum</a> ", $text);
#Plug, will turn weborum followed by a space into a link

$text = stri_replace(" weborum"," <a href=\"http://forum.weborum.com\">Weborum</a>", $text);
#Plug, will turn a space followed by weborum into a link

#feel free to add your own plugs, but don't remove the above for legal reasons.


if ($smilies==1)
#if smilies is turned on
{
	if ($Outside== 1)
	$file = file("smilies.txt");
	else
	$file = file("ShoutBoxFiles/smilies.txt");
#opens the file with smilies and turns it into an array like swears

foreach($file as $smile)
#read the swears one for more info, works the same
	{
	list($old,$new) = explode("\|/", $smile);
	#this turns anything before the \|/ into a var and anything after into another

	$old = trim($old);
	#gets rid of the spaces before and after

	$new = trim($new);
	#gets rid of the spaces before and after
	if ($Outside== 1)
	$text = stri_replace($old,'<img src="../'.$directory.'/'.$new.'" alt="" />',$text);
	else
	$text = stri_replace($old,'<img src="'.$directory.'/'.$new.'" alt="" />',$text);
	#replaces it with the smilie :-)	
	}
}


if ($colors==1)
#if colors is turned on
{
	if ($Outside== 1)
	$file = file("colors.txt");
	else
	$file = file("ShoutBoxFiles/colors.txt");
#opens the colors and turns it into an array...
foreach($file as $color)
#same as the swears one...
	{
	list($old,$new) = explode("|", $color);
	#same as smilies except doing it at the | instead of \|/

	$old = trim($old);
	#gets rid of the spaces before and after

	$new = trim($new);
	#gets rid of the spaces before and after

	$text = stri_replace('[color='.$old.']','<span style="color:'.$new.';">',$text);
	#replaces [color=this] with <span style="color:that;">	
	}

$text = stri_replace("[/color]","</span>",$text);
#replaces all occurences of [/color] with </span>
}

$text = stri_replace("[b]","<b>",$text);
$text = stri_replace("[/b]","</b>",$text);
$text = stri_replace("[u]","<u>",$text);
$text = stri_replace("[/u]","</u>",$text);
$text = stri_replace("[i]","<i>",$text);
$text = stri_replace("[/i]","</i>",$text);
#BB code... simple replaces

return($text);
#returns the outputted text
}

function lefts( $varb, $num ){
#another function... this one cuts off anything after a certain amount of characters...
#useful with hacker kids who want to create their own post to your page and fudge it up
#this stops them :-)
	$dnum = intval($num);
	if (strlen($varb)>$dnum){
	$nvarb = substr($varb, 0, $dnum+3);
	}
	else if (strlen($varb)<$dnum){
	$nvarb=$varb;
	}
	return $nvarb;
}

function mailcheck($emailadr){
#regular expression... used in the entries file returns 1 if it finds it
return eregi("^[a-zA-Z0-9_\.-]+@[a-zA-Z0-9\.-]+\.[a-zA-Z]{2,4}$", $emailadr); 
}

function URLcheck($URL){
#regular expression... used in the entries file returns 1 if it finds it
return eregi("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]", $URL); 
}


#The following functions are in javascript... used for cookie manipulation
#two are also used for the countdown box, and one is used to open popups.
#the noscript is required for legal reasons
?>
<noscript>
For a free easily customizable shout box/tag board script, head to <a href="www.alphibia.com">www.alphibia.com</a>.
</noscript>
<script language="JavaScript" type="text/javascript">

function setCookie(name, value, expires, path, domain, secure) {
  var curCookie = name + "=" + escape(value) +
      ((expires) ? "; expires=" + expires.toGMTString() : "") +
      ((path) ? "; path=" + path : "") +
      ((domain) ? "; domain=" + domain : "") +
      ((secure) ? "; secure" : "");
  document.cookie = curCookie;
}

function getCookie(name) {
  var dc = document.cookie;
  var prefix = name + "=";
  var begin = dc.indexOf("; " + prefix);
  if (begin == -1) {
    begin = dc.indexOf(prefix);
    if (begin != 0) return null;
  } else
    begin += 2;
  var end = document.cookie.indexOf(";", begin);
  if (end == -1)
    end = dc.length;
  return unescape(dc.substring(begin + prefix.length, end));
}

function TrackCount(fieldObj,countFieldName,maxChars)
{
  var countField = eval("fieldObj.form."+countFieldName);
  var diff = maxChars - fieldObj.value.length;

  // Need to check &amp; enforce limit here also in case user pastes data
  if (diff < 0)
  {
    fieldObj.value = fieldObj.value.substring(0,maxChars);
    diff = maxChars - fieldObj.value.length;
  }
  countField.value = diff;
}

function shoutbox(url){
winpops=window.open(url,"","width=400,height=338,scrollbars,resizable,")
}

function LimitText(fieldObj,maxChars)
{
  var result = true;
  if (fieldObj.value.length >= maxChars)
    result = false;
  
  if (window.event)
    window.event.returnValue = result;
  return result;
}
</script>