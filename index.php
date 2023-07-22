<?php
    if(!isset($_SESSION)){
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../lms-student-portal/node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../lms-student-portal/node_modules/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="../lms-student-portal/node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="style.css">
        <title>LMS Student Portal</title>
    </head>
    <body>
        <main>
            <div class="overlay">
                <div class="container-fluid bg-light py-3 pt-4 catalog">
                    <div class="card mb-3">
                        <div class="d-flex justify-content-between px-3 py-2">
                            <h1 class="display-6">Library Catalog</h1>
                            <div class="px-3 mt-2">
                                <a href="../lms-student-portal/login.php" class="btn btn-outline-danger mx-1">Log in</a>
                                <a href="../lms-student-portal/signup.php" class="btn btn-outline-danger mx-1">Sign up</a>
                            </div>
                        </div>
                    </div>
                    <div class="card my-2 mx-2">
                        <div class="card-header bg-danger">
                            <ul class="nav nav-tabs card-header-tabs" id="catalogTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button 
                                        class="nav-link active text-light" 
                                        id="book-tab" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#book-tab-pane" 
                                        type="button" role="tab"
                                        aria-controls="book-tab-pane" 
                                        aria-selected="true">
                                        Books
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button 
                                        class="nav-link text-light" 
                                        id="book-tab" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#thesis-tab-pane" 
                                        type="button" role="tab"
                                        aria-controls="thesis-tab-pane">
                                        Theses
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content my-3" id="catalog-tab-content">
                                <div 
                                    class="tab-pane fade show active" 
                                    id="book-tab-pane" 
                                    role="tabpanel" 
                                    aria-labelledby="book-tab" 
                                    tabindex="0">
                                    <?php include '../lms-student-portal/function/bookTable.php'?>
                                </div>
                                <div 
                                    class="tab-pane fade" 
                                    id="thesis-tab-pane" 
                                    role="tabpanel" 
                                    aria-labelledby="thesis-tab" 
                                    tabindex="0">
                                    <?php include '../lms-student-portal/function/thesisTable.php'?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script src="../lms-student-portal/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../lms-student-portal/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        
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