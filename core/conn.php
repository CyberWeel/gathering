<?php
$dbname = 'gathering';
$host = 'localhost';
$login = 'root';
$password = 'root';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $login, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
