<?php
     if(!isset($_SESSION)){
        session_start();
    }
    date_default_timezone_set('Asia/Manila');
    $pdo = require '../lms-student-portal/configuration/connect.php';
    require '../lms-student-portal/function/login_student.php';
    if(isset($_POST['submit'])){
        $srcode = trim(htmlspecialchars($_POST['srcode']));
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $result = login($pdo, $srcode, $date, $time);
        if( $result == 'unidentified'){
            $_SESSION['status'] = "error";
            $_SESSION['icon'] = "error";
            $_SESSION['title'] = "Error";
            $_SESSION['text'] = "Unidentified srcode. Please register first.";
        }else if($result == 'success'){
            $_SESSION['status'] = "success";
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Login Successful";
            $_SESSION['text'] = "You have successfully logged in.";
            header('Location: ../lms-student-portal/index.php');
            exit();
        }else{
            $_SESSION['status'] = "error";
            $_SESSION['icon'] = "error";
            $_SESSION['title'] = "Error";
            $_SESSION['text'] = $result;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../lms-student-portal/node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
        <title>LMS Student Portal</title>
    </head>
    <body>
        <main>
            <div class="overlay">
                <div class="card border-0 card-form">
                    <div class="row">
                        <div class="col-6 bg-danger px-4">
                            <div class="info py-3 pt-5 px-4 mb-2">
                                <h5 class="display-6 fw-bold text-light mb-5">Information</h5>
                                <p class="text-light fw-lighter">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet leo eget elit euismod lacinia vel sit amet ex.
                                Sed eleifend urna a porta dictum. Suspendisse nunc quam, molestie eget dui dictum, dapibus blandit arcu. Sed suscipit vehicula aliquet. ed lacus nunc, euismod eu nibh quis, pellentesque ultrices enim. Nunc nec tortor sit amet nunc iaculis sollicitudin.
                            </p>
                            </div>
                            <img src="../lms-student-portal/assets/books.svg" alt="welcome" class="welcome-banner img-fluid mb-2">
                        </div>
                        <div class="col-6">
                            <div class="form py-3 pt-5 px-4 mb-3">
                                <h5 class="display-6 fw-bold text-danger mb-5">Login Account</h5>
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"class="login-form">
                                    <div class="mb-3">
                                        <label for="srcode" class="form-label fw-bold text-secondary">Srcode</label>
                                        <input type="text" class="form-control" id="srcode" name="srcode" placeholder="ex. 12-34567">
                                        <small class="error-message text-danger"></small>
                                    </div>
                                    <span>No account yet? <a href="../lms-student-portal/signup.php">Sign up here.</a></span>
                                    <button class="btn btn-danger fw-lighter d-block mt-5" type="submit" id="btnSubmit" name="submit" disabled>Register</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script src="../lms-student-portal/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../lms-student-portal/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../lms-student-portal/function/loginValidation.js"></script>

        <script>
            <?php if(isset($_SESSION['status'])):?>
                Swal.fire({
                icon: '<?php echo $_SESSION['icon']?>',
                title: '<?php echo $_SESSION['title']?>',
                text: '<?php echo $_SESSION['text']?>'
            })
            <?php endif;?>
        </script>
        <?php
            unset($_SESSION['status']);
            unset($_SESSION['icon']);
            unset($_SESSION['title']);
            unset($_SESSION['text']);
        ?>
    </body>
</html>