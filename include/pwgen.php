<?php
function passwort_create($zeichen = 8)
	{
	$chars = array_merge(
		range(0, 9),
        range('a', 'z'),
        range('A', 'Z')
    );
    shuffle($chars);
    return implode('', array_slice($chars, 0, $zeichen));
	}
?>