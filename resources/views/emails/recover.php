<strong>reset password</strong>
<?php
$string = "http://localhost/gamingforum/recover/".$email."/".$token;
$link = "<a href=".$string.">click here to reset your password!</a>";
echo $link;
?>