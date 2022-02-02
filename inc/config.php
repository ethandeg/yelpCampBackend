<?php
$db['db_host'] = 'localhost';
$db['db_username'] = 'root';
$db['db_password'] = '';
$db['db_database_name'] = 'yelpcamp';

foreach($db as $key => $value){
    define(strtoupper($key), $value);
}
?>