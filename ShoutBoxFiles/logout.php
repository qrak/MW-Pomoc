<?php
session_start();
session_destroy();
$_SESSION = array();
#That cleans out the session variables and ends the session
$title = 'Logged Out';
echo '<html><head><title>';
echo $title;
echo '</title>';
echo '</head><body>';
echo '<br />Thank you, you have been logged out. Please come back later.';
echo '<br /><a href="../ShoutLogin.php">Click Here</a> to log back in.';
echo '</body></html>';
?>
