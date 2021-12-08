<?php
$pdo = new PDO('mysql:host=localhost;port=8080;dbname=shubh', 
   'shubh', 'shubh');

// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>