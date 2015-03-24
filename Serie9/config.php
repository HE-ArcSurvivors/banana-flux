<?php

//Database configuration
define( 'DB_HOST', getenv('IP') ); // MySQL Database host
define( 'DB_NAME', 'Serie9Ex1' ); // MySQL database name
define( 'DB_USER', getenv('C9_USER') ); // MySQL username
define( 'DB_PASSWORD', '' ); // MySQL password

//Toggle file or database connection
define( 'toggle_connect', 'db' ); // 'file' or 'db'

?>