<?php

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB', 'SRP');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB)
OR die('Could not connect to DATABASE '. mysqli_connect_error());

?>