<?php
session_start();
echo $_SESSION['id-number'] . "<br>";
echo $_POST['center-id']."<br>";
require_once "./pdo.php";

$vid = $_POST['center-id'];
$stmt = $pdo->query("SELECT vac_dose from vac_center where vac_center_id = $vid");
$rows = $stmt->fetch();
$date = date("d F Y");
$dose_taken = 'b';
$vac_dose = $rows['vac_dose'];

if($vac_dose == 0) {
    echo $vac_dose;
    header("Location: schedule_2.php?status=0");
    return;
}
$vac_dose = $vac_dose-1;


$sql = "UPDATE vac_center SET vac_dose=:vd WHERE vac_center_id = :vid";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':vid' => $_POST['center-id'],':vd'=> $vac_dose));

$sql = "UPDATE vac_user SET dose_2_taken=:vdt,dose_2_center=:cen,dose_2_date=:dat WHERE id_number = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':id' => $_SESSION['id-number'],':vdt'=> $dose_taken,':cen'=>$_POST['center-id'],':dat'=>$date));

header("Location: index.php");
// "update vac_user join vac_center on vac_user"
// $sql = "UPDATE vac_user SET vac_dose=:vd WHERE vac_center_id = :vid";
// $stmt = $pdo->prepare($sql);
// $stmt->execute(array(':vid' => $_POST['id-number'],':vd'=> $vac_dose));
// center-id --> decrement-dose from database
// link center-id with vac_user database with current date
?>