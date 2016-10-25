<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	
	$txt = file_get_contents('text2.txt');
	$txt = preg_replace('/tm pick/', 'tm', $txt);
	echo htmlspecialchars($txt);
	file_put_contents('text.txt', $txt);

	?>
</body>
</html>