<?php
require_once "./pdo.php";
if(!$_COOKIE['token']) {
    header("Location: http://localhost:3000/Login");
}
session_start();
if(isset($_POST['id-number']))
    $_SESSION['id-number'] = $_POST['id-number'];
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
    <?php
        if(isset($_GET['status'])) {
            echo '<div class="container">';
                echo '<div class="row">';
                    echo '<div class="col-12">';
                        echo '<div class="alert alert-danger">';
                            echo '<div class="container">';
                                echo '<div class="d-flex align-items-center">';
                                    echo '<span class="alert-icon d-flex w-75">';
                                        echo '<em class="bi bi-info-square-fill alert-error-icon"></em>';
                                        echo '<p class="mb-0 ml-2 alert-message"><strong>Message: </strong>Vaccination Center is Full please try on Tommorow or Choose different Center</p>';
                                    echo '</span>';
                                    echo '<span class="ml-auto text-right w-25">';
                                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                                            echo '<span aria-hidden="true">';
                                                echo '<em class="bi bi-x alert-close-icon"></em>';
                                            echo '</span>';
                                        echo '</button>';
                                    echo '</span>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    ?>
    <div class='container mb-5'>
        <div class='row justify-content-center'>
            <div class='shadow bg-white col-12 schedule my-5 px-4 pt-4 pb-2 rounded login'>
                <div class='row'>
                    <div class='col-12 h3 login-style-1'>
                        <a href="./index.php"><i class="bi bi-arrow-left-square-fill h6 mr-3" style="color:#001f60"></i></a>
                        Book Appointment for Dose 1
                    </div>
                    <div class='col-12 mt-5'>
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">
                                        <?php
                                            echo date("j M, Y");
                                        ?>
                                    </th>
                                    <th scope="col">
                                        <?php
                                            echo date('j M, Y', strtotime('+1 day'));
                                        ?>
                                    </th>
                                    <th scope="col">
                                        <?php
                                            echo date('j M, Y', strtotime('+2 day'));
                                        ?>
                                    </th>
                                    <th scope="col">
                                        <?php
                                            echo date('j M, Y', strtotime('+3 day'));
                                        ?>
                                    </th>
                                    <th scope="col">
                                        <?php
                                            echo date('j M, Y', strtotime('+4 day'));
                                        ?>
                                    </th>
                                    <th scope="col">
                                        <?php
                                            echo date('j M, Y', strtotime('+5 day'));
                                        ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->query("SELECT * from vac_center");
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($rows as $row) {
                                    echo '<tr>';
                                        echo '<th scope="row">'.$row['vac_center_name'].'<br>'.$row['vac_center_pincode'].'</th>';
                                        echo '<td>';
                                            if($row['vac_dose']>75) {
                                                echo '<form method="POST" action="./book_dose_1.php">';
                                                echo '<input type="text" name="center-id" class="sr-only" value="'.$row['vac_center_id'].'" readonly>';
                                                echo '<button class="btn btn-success w-75">';
                                                echo $row['vac_dose'];
                                                echo '</form>';
                                                echo '</button>';
                                            }
                                            elseif($row['vac_dose']>0) {
                                                echo '<form method="POST" action="./book_dose_1.php">';
                                                echo '<input type="text" name="center-id" class="sr-only" value="'.$row['vac_center_id'].'">';
                                                echo '<button class="btn btn-warning w-75">';
                                                echo $row['vac_dose'];
                                                echo '</form>';
                                                echo '</button>';
                                            }
                                            // elseif($row['vac_dose']>0) {
                                            //     echo '<button class="btn btn-danger w-75">';
                                            //     echo $row['vac_dose'];
                                            // }
                                            else {
                                                // echo '<span class="btn btn-secondary w-75">';
                                                echo '<span class="btn btn-danger w-75">';
                                                echo 'Booked';
                                                echo '<form/>';
                                            }
                                        echo '</td>';
                                        echo '<td>';
                                            echo '<span class="btn btn-light border w-75">';
                                            echo 'NA';
                                        echo '</td>';
                                        echo '<td>';
                                            echo '<span class="btn btn-light border w-75">';
                                            echo 'NA';
                                        echo '</td>';
                                        echo '<td>';
                                            echo '<span class="btn btn-light border w-75">';
                                            echo 'NA';
                                        echo '</td>';
                                        echo '<td>';
                                            echo '<span class="btn btn-light border w-75">';
                                            echo 'NA';
                                        echo '</td>';
                                        echo '<td>';
                                            echo '<span class="btn btn-light border w-75">';
                                            echo 'NA';
                                        echo '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row justify-content-center mb-3 px-3">
                    <div class="col-12 rounded px-4 py-4 mt-4 text-muted" style="background-color: #f6f6f6; font-size: 12px;">
                        <label class='note_title ms-4 my-auto'>
                            <i class="bi bi-info-circle mr-2"></i>
                            On-site registration and vaccination services are now available.
                        </label>
                        <ul class="mt-2">
                            <li class="my-1">
                                Slots are updated by state vaccination centers and private hospitals everyday at 8AM, 12PM, 4PM & 8PM
                            </li>
                            <li class="my-1">
                                You are allowed 20 searches within 15 minutes. Overuse of search can lead to 24 hours ban for your account. Refer to our Terms of Service for more information
                            </li>
                            <li class="my-1">
                                Terminology and Abbreviations
                                <ul>
                                    <li class="my-1">
                                        D1 - Vaccine Dose #1
                                    </li>
                                    <li class="my-1">
                                        D2 - Vaccine Dose #2
                                    </li>
                                    <li class="my-1">
                                        <img class="text-muted" src="./assets/img/walk.svg" style="width: 12px; height: 12px;">
                                        Walk-in available at all vaccination centers – both Government and Private centers for all people aged 18 years or above. For slot availability and timing of walk-ins, please contact the vaccination center directly. However, it is recommended that you book your appointment online for convenience.
                                    </li>
                                </ul>
                            </li>
                            <li class="my-1">
                                At all vaccination centers – both Government and Private.
                            </li>
                            <li class="my-1">
                                For all people aged 18 years or above.
                            </li>
                            <li class="my-1">
                                For slot availability and timing, please contact the vaccination center directly.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "./Footer.php"?>
    <?php require_once "./script.php"?>
    <script>
        function deleteCard(id_num)
        {
            
            <?php 
            $temp = "<script>document.write(id_num)</script>";
            $_SESSION['id'] = $temp;
            ?>
            // confirm();
        }
    </script>
</body>

</html>