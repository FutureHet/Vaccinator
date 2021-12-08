<?php 
require_once "pdo.php";
// if(!$_COOKIE['token']) {
//   header("Location: http://localhost:3000/Login");
// }
session_start();

if(isset($_POST['pid_number']) && isset($_POST['pid_proof']) && isset($_POST['birth_year']) && isset($_POST['pid_name']))
{
    if($_POST['pid_proof']!='Aadhar Card' || strlen($_POST['pid_number'])<1 || strlen($_POST['birth_year'])<1 || strlen($_POST['pid_name'])<1 || ($_POST['user_gender']!='male' && $_POST['user_gender']!='female' && $_POST['user_gender']!='other'))
    {
        $_SESSION['error'] = "All fields are required";
        header('Location: register.php');
        return;
    }
    elseif($_POST['pid_number']<100000000000 || $_POST['pid_number']>999999999999)
    {
        $_SESSION['error'] = "Aadhar number must be 12 digit";
        header('Location: register.php');
        return;
    }
    elseif($_POST['birth_year']<1900 || $_POST['birth_year']>2003)
    {
        $_SESSION['error'] = "You are not eligible with birth criteria";
        header('Location: register.php');
        return;
    }
    else
    {
        $flag = FALSE;
        $stmt = $pdo->query("SELECT aadhar_number,status from aadhar_info");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row)
        {
            if($_POST['pid_number']==$row['aadhar_number'] && $row['status']=='f')
            {
                $flag=TRUE;
                break;
            }
        }
        if($flag)
        {
            $x1 = rand(1000000000,9999999999);
            $x2 = rand(1000,9999);
            $x3 = $x1*10000+$x2;
            $token = $_COOKIE['token'];
            $decode_token = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))), true);
            $x4 = $decode_token['register']['mobile'];
            // $x4 = 919099989065;
            $stmt = $pdo->prepare('INSERT INTO vac_user
            (id_proof, id_number, user_name, gender, birth_year, ref_id, sec_code, phone_no)
            VALUES ( :proof, :num, :un, :gen, :biy, :rid, :sc, :pn)');

            $stmt->execute(array(
            ':proof' => $_POST['pid_proof'],
            ':num' => $_POST['pid_number'],
            ':un' => $_POST['pid_name'],
            ':gen' => $_POST['user_gender'],
            ':biy' => $_POST['birth_year'],
            ':rid' => $x3,
            ':sc' => $x2,
            ':pn' => $x4)
            );
            
            $stmt = $pdo->prepare('UPDATE aadhar_info SET status=:occ WHERE aadhar_number=:num');
            $stmt->execute(array(
            ':num' => $_POST['pid_number'],
            ':occ' => 'o')
            );
            $_SESSION['success'] = "Profile added";
            header('Location: index.php');
            return;
        }
        else
        {
            $_SESSION['error'] = "Invalid Aadhar Number";
            header('Location: register.php');
            return;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cowin Registration</title>
    <?php require_once "style.php"; ?>
    <style>
        .main_div{
            border: 1px solid rgba(0, 0, 0, 0.404);
            border-radius: 10px;
        }
        .not_vaccinated{
            border-radius: 20px;
            margin-top: -25px;
            
        }
    </style>
</head>
<body>
<?php require_once "Header.php"?>
<section class="vh-100 gradient-custom bg-light">
  <div class="container py-5 h-120">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
            <div class="d-flex mb-4 align-items-center w-100">
            <a href="./index.php"><i class="bi bi-arrow-left-square-fill" style="color:#001f60"></i></a>
            <h4 class="text-center w-100" style="color:#001f60">Register for Vaccination</h4>
            </div>
            <form method="POST">
                <?php
                    if(isset($_SESSION['error'])){
                        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                        unset($_SESSION['error']);
                    }
                ?>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <select class="form-control" name="pid_proof">
                        <option selected>Photo ID Proof</option>
                        <option value="Aadhar Card">Aadhar Card</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Photo ID Number" name="pid_number">
                </div>

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Name" name="pid_name">
                </div>

              <div class="row">
                <div class="col-md-6 mb-4">
                  <h6 class="mb-2 pb-1" style="color:#001f60">Gender</h6>
                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="user_gender"
                      id="maleGender"
                      value="male"
                    />
                    <label class="form-check-label" for="maleGender">Male</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="user_gender"
                      id="femaleGender"
                      value="female"
                    />
                    <label class="form-check-label" for="femaleGender">Female</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="user_gender"
                      id="otherGender"
                      value="other"
                    />
                    <label class="form-check-label" for="otherGender">Other</label>
                  </div>
                </div>
              </div>
                
                <div class="input-group mb-3">
                    <input type="number" class="form-control" placeholder="Year of Birth" name="birth_year">
                </div>

              <!-- <div class="mt-4 pt-2">
                <input class="btn btn-primary btn-lg" type="submit" value="Submit" />
              </div> -->
              <div class="col-12 mt-4 text-center">
              <input type="submit" value="Add" class="btn px-4" style="color:white;background-color:#001f60;" role="button">
              </div>
            </form>
            <!-- <a class="btn btn-outline-light" style="border-color:#191557;border-width:2px;font-size:15px;color:#191557;margin-left:200px;margin-top:200px;" href="./register.php" role="button">+ Add Member</a> -->
                        
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require_once "Footer.php"?>
<?php require_once "script.php"?>
</body>
</html>