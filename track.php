<?php
$location = "nowhere";
?><html>
<head></head>
<body>
<form action="track.php" method="post">
You are here: <?php echo $location; ?><br />
<input type="text" name="code" value="" autofocus="true" /><input type="submit" value="OK" />
</form>
</body>
</html>