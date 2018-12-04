<?php			
// Found at https://css-tricks.com/snippets/php/redirect/
function forceRedirect($url = '/')
{
	if(!headers_sent()) {
		header('HTTP/1.1 301 Moved Permanently');
		header('Location:'.$url);  
		header('Connection: close');
		exit;
	}
	else {
		echo 'location.replace('.$url.');';
	}
	exit;
}
?>