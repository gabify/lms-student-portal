<?php
    if(!isset($_SESSION)){
        session_start();
    }

    $pdo = require '../lms-student-portal/configuration/connect.php';
    require '../lms-student-portal/function/create_student.php';
    $student = array("srcode" => "", "program" => "", "firstname" => "", "lastname" =>"");
    
    if(isset($_POST['submit'])){
        $student['srcode'] = trim(htmlspecialchars($_POST['srcode']));
        $student['program'] = trim(htmlspecialchars($_POST['program']));
        $student['firstname'] = trim(htmlspecialchars($_POST['firstname']));
        $student['lastname'] = trim(htmlspecialchars($_POST['lastname']));
        
        $result = createStudent($pdo, $student);
        if($result == 'success'){
            $_SESSION['status'] = "success";
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Operation Successful";
            $_SESSION['text'] = "New account has been created";
            header('Location: ../lms-student-portal/index.php');
            exit();
        }else{
            $_SESSION['status'] = "error";
            $_SESSION['icon'] = "error";
            $_SESSION['title'] = "Error";
            $_SESSION['text'] = "An error occured. Please try again later.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../lms-student-portal/node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../lms-student-portal/node_modules/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="style.css">
        <title>LMS Student Portal</title>
    </head>
    <body>
        <main>
            <div class="overlay">
                <div class="card border-0 card-form">
                    <div class="row">
                        <div class="col-6 bg-danger">
                            <div class="info py-3 pt-5 px-4 mb-3">
                                <h5 class="display-6 fw-bold text-light mb-5">Information</h5>
                                <p class="text-light fw-lighter">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet leo eget elit euismod lacinia vel sit amet ex.
                                Sed eleifend urna a porta dictum. Suspendisse nunc quam, molestie eget dui dictum, dapibus blandit arcu. Sed suscipit vehicula aliquet.
                                ed lacus nunc, euismod eu nibh quis, pellentesque ultrices enim. Nunc nec tortor sit amet nunc iaculis sollicitudin.
                                </p>
                            </div>
                            <img src="../lms-student-portal/assets/welcome.svg" alt="welcome" class="welcome-banner">
                        </div>
                        <div class="col-6">
                            <div class="form py-3 pt-5 px-4 mb-3">
                                <h5 class="display-6 fw-bold text-danger mb-5">Sign up Form</h5>
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" id="signupform" novalidate>
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="me-1">
                                            <label for="srcode" class="form-label fw-bold text-secondary">Srcode</label>
                                            <input type="text" class="form-control" id="srcode" name="srcode" placeholder="ex. 12-34567" required>
                                            <small class="error-message text-danger"></small>
                                        </div>
                                        <div class="ms-1">
                                            <label for="program" class="form-label fw-bold text-secondary">Program</label>
                                            <select class="form-select" aria-label="Programs" id="program" name="program" required>
                                                <option selected disabled value="">Choose program..</option>
                                                <option value="BIT">BIT</option>
                                                <option value="BTVTED">CTE</option>
                                                <option value="CICS">CICS</option>
                                            </select>
                                            <small class="error-message text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label fw-bold text-secondary">First Name</label>
                                        <input type="text" class="form-control ms-1" id="firstname" name="firstname" placeholder="ex. Juan" required>
                                        <small class="error-message text-danger"></small>
                                    </div>
                                    <div class="mb-4">
                                        <label for="lastname" class="form-label fw-bold text-secondary">Last Name</label>
                                        <input type="text" class="form-control ms-1" id="lastname" name="lastname" placeholder="ex. Dela Cruz" required>
                                        <small class="error-message text-danger"></small>
                                    </div>
                                    <span class="mt-2">Already have an account? <a href="../lms-student-portal/login.php">Log in here.</a></span>
                                    <span class="d-block">Go back to <a href="../lms-student-portal/index.php">Library catalog.</a></span>
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
        <script src="../lms-student-portal/function/validate.js"></script>
        
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