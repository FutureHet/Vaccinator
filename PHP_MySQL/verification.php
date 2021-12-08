<?php
$id_num = $_POST['id-number'];
$sec_code =  $_POST['secret-code'];
$dose_no = $_POST['dose-no'];
require_once "./pdo.php";
$stmt1 = $pdo->query("SELECT id_number,sec_code,dose_1_taken,dose_2_taken from vac_user where id_number=$id_num");
$rows1 = $stmt1->fetch();
if($rows1)
{
    if($rows1['dose_1_taken']=='b' && $rows1['sec_code']==$sec_code && $dose_no==1)
    {
        $sql = "UPDATE vac_user set dose_1_taken=:t where id_number=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => $id_num,':t'=> 't'));
        header("Location: http://localhost:8000/vaccine/checked_status/1");
    }
    else if($rows1['dose_2_taken']=='b' && $rows1['sec_code']==$sec_code && $dose_no==2)
    {
        $sql = "UPDATE vac_user set dose_2_taken=:t where id_number=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => $id_num,':t'=> 't'));
        header("Location: http://localhost:8000/vaccine/checked_status/2");
    }
    else if($rows1['dose_1_taken']=='t' && $rows1['sec_code']==$sec_code && $dose_no==1)
        header("Location: http://localhost:8000/vaccine/checked_status/3");
    else if($rows1['dose_2_taken']=='t' && $rows1['sec_code']==$sec_code && $dose_no==2)
        header("Location: http://localhost:8000/vaccine/checked_status/4");
    else
        header("Location: http://localhost:8000/vaccine/checked_status/5");
}
else
{
    header("Location: http://localhost:8000/vaccine/checked_status/0");
}
?>