<?php
require_once "./pdo.php";
if(!$_COOKIE['token']) {
    header("Location: http://localhost:3000/Login");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <?php require_once "./style.php"?>
    <style>
        .main_div{
            border: 1px solid rgba(0, 0, 0, 0.404);
            border-radius: 10px;
        }
        .not_vaccinated{
            border-radius: 20px;
            margin-top: -25px;
        }
        .appointment {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <?php require_once "./Header.php"?>
    <div class="container">
        <div class="main_member mt-5 mb-5">
            <div class="row back_color mb-5">
                <div class="col-12 bg-white shadow" style="border-radius:10px">
                    <?php
                    $token = $_COOKIE['token'];
                    $decode_token = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))), true);
                    $phone_no = $decode_token['register']['mobile'];
                    // echo $phone_no;
                    // $phone_no=919099989065;
                    $stmt = $pdo->query("SELECT * from vac_user where phone_no=$phone_no");
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if(sizeof($rows)==0) {
                        echo '<div class="row w-100 jutify-centent-center">';
                            echo '<div class="col-12">';
                                echo '<div class="welcome_svg mt-5">';
                                    echo '<img src="./assets/img/welcome-screen.svg" alt="welcome" /><br />';
                                    echo '<h1 class="pt-3 text-center">Welcome</h1>';
                                    echo '<label class="pt-3 ">You can register 4 members with one mobile number</label>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="row mt-4">';
                            echo '<div class="col-12 ">';
                                echo '<a href="./register.php"><button class="add_member_btn pt-3 pb-3">Register Member</button></a>';
                            echo '</div>';
                        echo '</div>';
                    }
                    else {
                        foreach ($rows as $row) {
                            echo '<div class="row mt-5 px-5">';
                                echo '<div class="col-12 main_div pb-3">';
                                    if($row['dose_1_taken']=='t' && $row['dose_2_taken']=='t')
                                        echo '<div class="btn btn-success not_vaccinated font-weight-bold">Fully Vaccinated</div>';
                                    elseif($row['dose_1_taken']=='t')
                                        echo '<div class="btn btn-info not_vaccinated font-weight-bold">Partially Vaccinated</div>';
                                    else
                                        echo '<div class="btn btn-warning not_vaccinated font-weight-bold">Not Vaccinated</div>';
                                    echo '<div class="info mt-2">';
                                        echo '<div class="d-flex w-100 aligh-item-center"><div style="font-weight:600;font-size:20px">'.$row['user_name'].'</div>
                                            <div class="pl-2 pt-1"> | REF ID : '.substr($row['ref_id'],0,10).'<span class="text-danger">'.$row['sec_code'].'</span>'.' | Secret Code : '.$row['sec_code'].'</div>';
                                        if($row['dose_1_taken']=='r' && $row['dose_2_taken']=='r') {
                                            echo '<form action="./delete_user.php" method="POST">';
                                                echo '<input type="text" class="sr-only" name="id-number" value="'.$row['id_number'].'" readonly>';
                                                echo '<button class="btn btn-danger py-1 px-2" style="font-size: 15px;position: absolute;right: 10px;top:10px;">
                                                <i class="bi bi-trash" style="cursor:pointer"></i></button>';
                                            echo '</form>';
                                        }
                                        echo '</div>';
                                        echo '<div class="row text-dark mt-2" style="font-size:15px">';
                                            echo '<div class="col-4">';
                                                echo 'Year of Birth: '.$row['birth_year'];
                                            echo '</div>';
                                            echo '<div class="col-4">';
                                                echo 'Photo ID: '.$row['id_proof'];
                                            echo '</div>';
                                            echo '<div class="col-4">';
                                                echo 'Id Number: XXXX-XXXX-'.substr($row['id_number'],-4);
                                            echo '</div>';
                                        echo '</div>';
                                        if($row['dose_1_taken']=='r') {
                                            echo '<hr/>';
                                            echo '<div class="dose d-flex align-items-center">';
                                                echo '<div class="bg-danger text-center rounded-circle" style="color: white;height: 20px;width: 20px;font-size: 14px;"><i class="bi bi-hourglass"></i></div>';
                                                echo '<div class="text-danger font-weight-bold ml-2" style="font-size: 15px;">Dose 1</div>';
                                                echo '<form action="./schedule_1.php" method="POST">';
                                                echo '<input type="text" class="sr-only" name="id-number" value="'.$row['id_number'].'" readonly>';
                                                echo '<button class="btn pl-4 pr-4" style="border:1px solid rgb(161, 161, 161);border-radius:20px;position:absolute;right:10px"><span><i class="bi bi-calendar3"></i></span><span class="pl-2">Schedule</span></button>';
                                                echo '</form>';
                                            echo '</div>';
                                            echo '<div class="text-danger mt-2">';
                                                echo 'Appointment not scheduled';
                                            echo '</div>';
                                        }
                                        else if($row['dose_1_taken']=='b') {
                                            echo '<hr/>';
                                            echo '<div class="dose d-flex align-items-center">';
                                                echo '<div class="bg-secondary text-center rounded-circle" style="color: white;height: 20px;width: 20px;font-size: 14px;"><i class="bi bi-hourglass"></i></div>';
                                                echo '<div class="text-muted font-weight-bold ml-2" style="font-size: 15px;">Dose 1</div>';
                                            echo '</div>';
                                            echo '<div class="appointment text-muted mt-1 ml-5">';
                                            $d1cen = $row['dose_1_center'];
                                            $stmt1 = $pdo->query("SELECT vac_center_name,vac_center_pincode from vac_center join vac_user on vac_center.vac_center_id=vac_user.dose_1_center where vac_center.vac_center_id = $d1cen");
                                            $rows1 = $stmt1->fetch();
                                            echo $rows1['vac_center_name'].', '.$rows1['vac_center_pincode'].', '.$row['dose_1_date'];
                                            echo '</div>';
                                        }
                                        else {
                                            echo '<hr/>';
                                            echo '<div class="dose d-flex align-items-center">';
                                                echo '<div class="bg-success text-center rounded-circle" style="color: white;height: 20px;width: 20px;font-size: 14px;"><i class="bi bi-check-lg"></i></div>';
                                                echo '<div class="text-success font-weight-bold ml-2" style="font-size: 15px;">Dose 1</div>';
                                            echo '</div>';
                                            echo '<div class="appointment text-success mt-1 ml-5">';
                                                $d1cen = $row['dose_1_center'];
                                                $stmt1 = $pdo->query("SELECT vac_center_name,vac_center_pincode from vac_center join vac_user on vac_center.vac_center_id=vac_user.dose_1_center where vac_center.vac_center_id = $d1cen");
                                                $rows1 = $stmt1->fetch();
                                                echo $rows1['vac_center_name'].', '.$rows1['vac_center_pincode'].', '.$row['dose_1_date'];
                                            echo '</div>';

                                            if($row['dose_2_taken']=='r') {
                                                echo '<hr/>';
                                                echo '<div class="dose d-flex align-items-center">';
                                                    echo '<div class="bg-danger text-center rounded-circle" style="color: white;height: 20px;width: 20px;font-size: 14px;"><i class="bi bi-hourglass"></i></div>';
                                                    echo '<div class="text-danger font-weight-bold ml-2" style="font-size: 15px;">Dose 2</div>';
                                                    echo '<form action="./schedule_2.php" method="POST">';
                                                    echo '<input type="text" class="sr-only" name="id-number" value="'.$row['id_number'].'" readonly>';
                                                    echo '<button class="btn pl-4 pr-4" style="border:1px solid rgb(161, 161, 161);border-radius:20px;position:absolute;right:10px"><span><i class="bi bi-calendar3"></i></span><span class="pl-2">Schedule</span></button>';
                                                    echo '</form>';
                                                echo '</div>';
                                                echo '<div class="text-danger mt-2">';
                                                    echo 'Appointment not scheduled';
                                                echo '</div>';
                                            }
                                            elseif($row['dose_2_taken']=='b') {
                                                echo '<hr/>';
                                                echo '<div class="dose d-flex align-items-center">';
                                                    echo '<div class="bg-secondary text-center rounded-circle" style="color: white;height: 20px;width: 20px;font-size: 14px;"><i class="bi bi-hourglass"></i></div>';
                                                    echo '<div class="text-muted font-weight-bold ml-2" style="font-size: 15px;">Dose 2</div>';
                                                echo '</div>';
                                                echo '<div class="appointment text-muted mt-1 ml-5">';
                                                    $d2cen = $row['dose_2_center'];
                                                    $stmt2 = $pdo->query("SELECT vac_center_name,vac_center_pincode from vac_center join vac_user on vac_center.vac_center_id=vac_user.dose_2_center where vac_center.vac_center_id = $d2cen");
                                                    $rows2 = $stmt2->fetch();
                                                    echo $rows2['vac_center_name'].', '.$rows2['vac_center_pincode'].', '.$row['dose_2_date'];
                                                echo '</div>';
                                            }
                                            else {
                                                echo '<hr/>';
                                                echo '<div class="dose d-flex align-items-center">';
                                                    echo '<div class="bg-success text-center rounded-circle" style="color: white;height: 20px;width: 20px;font-size: 14px;"><i class="bi bi-check-lg"></i></div>';
                                                    echo '<div class="text-success font-weight-bold ml-2" style="font-size: 15px;">Dose 2</div>';
                                                echo '</div>';
                                                echo '<div class="appointment text-success mt-1 ml-5">';
                                                    $d2cen = $row['dose_2_center'];
                                                    $stmt2 = $pdo->query("SELECT vac_center_name,vac_center_pincode from vac_center join vac_user on vac_center.vac_center_id=vac_user.dose_2_center where vac_center.vac_center_id = $d2cen");
                                                    $rows2 = $stmt2->fetch();
                                                    echo $rows2['vac_center_name'].', '.$rows2['vac_center_pincode'].', '.$row['dose_2_date'];
                                                echo '</div>';
                                            }
                                        }
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                        if(sizeof($rows)<4) {
                            echo '<div class="row my-5">';
                                echo '<div class="col-12 ">';
                                    echo '<a href="./register.php"><button class="add_member_btn pt-3 pb-3">Add Member</button></a>';
                                echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                    <div class="row note mt-5">
                        <div class="col-12 mt-4">
                            <label class='note_title ms-4 my-auto'>
                                <i class="bi bi-info-circle-fill mr-2"></i>
                                Note
                            </label>
                            <ul>
                                <li>
                                    One registration per person is sufficient. Please do not register with multiple
                                    mobile
                                    numbers or different Photo ID Proofs for same individual.
                                </li>
                                <li>Scheduling of Second dose should be done from the same account (same mobile number)
                                    from
                                    which the first dose has been taken, for generation of final certificate. Separate
                                    registration for second dose is not necessary.
                                </li>
                                <li>Please carry the registered mobile phone and the requisite documents, including
                                    appointment slip, the Photo ID card used for registration, Employment Certificate
                                    (HCW/FLW) etc., while visiting the vaccination center, for verification at the time
                                    of
                                    vaccination.
                                </li>
                                <li>Please check for additional eligibility conditions, if any, prescribed by the
                                    respective
                                    State/UT Government for vaccination at Government Vaccination Centers, for 18-44 age
                                    group, and carry the other prescribed documents (e.g. Comorbidity Certificate etc.)
                                    as
                                    suggested by respective State/UT (on their website).
                                </li>
                                <li>The slots availability is displayed in the search (on district, pincode or map)
                                    based on
                                    the schedule populated by the DIOs (for Government Vaccination Centers) and private
                                    hospitals for their vaccination centers.
                                </li>
                                <li>The vaccination schedule published by DIOs and private hospitals displays the list
                                    of
                                    vaccination centers with the following information<br />
                                    <ol type='I'>
                                        <li>
                                            The vaccine type.
                                        </li>
                                        <li>
                                            The age group (18-44/45+ etc.).
                                        </li>
                                        <li>
                                            The number of slots available for dose 1 and dose 2.
                                        </li>
                                        <li>
                                            Whether the service is Free or Paid (Vaccination is free of cost at all the
                                            Government Vaccination Centers).
                                        </li>
                                        <li>
                                            Per dose price charged by a private hospital.
                                        </li>
                                    </ol>
                                </li>
                                <li>
                                    If you are seeking 1st dose vaccination, the system will show you only the available
                                    slots for dose 1. Similarly, if you are due for 2nd dose, the system will show you
                                    the available slots for dose 2 after the minimum period from the date of 1st dose
                                    vaccination has elapsed.
                                </li>
                                <li>
                                    Once a session has been published by the DIO/ private hospital, the session now can
                                    not be cancelled. However, the session may be rescheduled. In case you have booked
                                    an appointment in any such vaccination session that is rescheduled for any reason,
                                    your appointment will also be automatically rescheduled accordingly. You will
                                    receive a confirmation SMS in this regard. On such rescheduling, you would still
                                    have the option of cancelling or further rescheduling such appointment.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "./Footer.php"?>
    <?php require_once "./script.php"?>
</body>

</html>