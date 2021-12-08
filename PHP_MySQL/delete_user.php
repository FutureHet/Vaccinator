<?php
// echo $_POST['id-number'];
require_once "./pdo.php";
$sql = "DELETE FROM vac_user WHERE id_number = :zip";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':zip' => $_POST['id-number']));
$sql = "UPDATE aadhar_info SET status='f' WHERE aadhar_number = :zip";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':zip' => $_POST['id-number']));
header("Location: index.php");
?>