<strong>verify your email</strong>
<?php
$string = "http://localhost/gamingforum/verify/".$email."/".$token;
$link = "<a href=".$string.">click here to verify your email!</a>";
echo $link;
?>