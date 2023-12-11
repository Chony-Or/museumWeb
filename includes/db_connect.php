<?php
$host = 'sql.freedb.tech';
$username = 'freedb_chony';
$password = '9794JEye2?efKJH';
$database = 'freedb_abytesized';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}