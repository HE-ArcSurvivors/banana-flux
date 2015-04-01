<?php

//Database configuration
define( 'DB_HOST', getenv('IP') ); // MySQL Database host
define( 'DB_NAME', 'serie9ex1' ); // MySQL database name
define( 'DB_USER', 'root' ); // MySQL username
define( 'DB_PASSWORD', '' ); // MySQL password

//Toggle file or database connection
define( 'toggle_connect', 'db' ); // 'file' or 'db'

?>