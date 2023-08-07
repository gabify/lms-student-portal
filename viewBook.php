<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $pdo = require '../lms-student-portal/configuration/connect.php';
    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $book = getBook($pdo, $id);
    }
    function getBook($pdo, $id){
        $stmt = $pdo->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
                    <?php if($book):?>
                        <div class="card p-2 m-4">
                            <div class="card-body">
                                <h3 class="card-title text-center">
                                    Book Information 
                                </h3>
                                <div class="row mt-4">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3 mx-5">
                                            <label for="accessnum" class="form-label text-secondary fw-bold">Accession Number</label>
                                            <input type="text" 
                                                class="form-control ms-1" 
                                                id="accessnum"
                                                name="accessnum" 
                                                value="<?php echo htmlspecialchars($book['id'])?>"
                                                disabled>
                                        </div>
                                        <div class="mb-3 mx-5">
                                            <label for="author" class="form-label text-secondary fw-bold">Author</label>
                                            <input type="text" 
                                                class="form-control ms-1" 
                                                id="author"
                                                name="author" 
                                                value="<?php echo htmlspecialchars($book['author'])?>"
                                                disabled>
                                        </div>
                                        <div class="mb-3 mx-5">
                                            <label for="title" class="form-label text-secondary fw-bold">Title</label>
                                            <input type="text" 
                                                class="form-control ms-1" 
                                                id="title"
                                                name="title" 
                                                value="<?php echo htmlspecialchars($book['title'])?>"
                                                disabled>
                                        </div>
                                        <div class="mb-3 mx-5">
                                            <label for="copy" class="form-label text-secondary fw-bold">Copy</label>
                                            <input type="text" 
                                                class="form-control ms-1" 
                                                id="copy"
                                                name="copy" 
                                                value="<?php echo htmlspecialchars($book['copy'])?>"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3 mx-5">
                                            <label for="callnum" class="form-label text-secondary fw-bold">Call Number</label>
                                            <input type="text" 
                                                class="form-control ms-1" 
                                                id="callnum"
                                                name="callnum" 
                                                value="<?php echo htmlspecialchars($book['callnum'])?>"
                                                disabled>
                                        </div>
                                        <div class="mb-3 mx-5">
                                            <label for="publisher" class="form-label text-secondary fw-bold">Publisher</label>
                                            <input type="text" 
                                                class="form-control ms-1" 
                                                id="publisher"
                                                name="publisher" 
                                                value="<?php echo htmlspecialchars($book['publisher'])?>"
                                                disabled>
                                        </div>
                                        <div class="mb-3 mx-5">
                                            <label for="copyright" class="form-label text-secondary fw-bold">Copyright Year</label>
                                            <input type="text" 
                                                class="form-control ms-1" 
                                                id="copyright"
                                                name="copyright" 
                                                value="<?php echo htmlspecialchars($book['copyright'])?>"
                                                disabled>
                                        </div>
                                        <div class="mb-3 mx-5">
                                            <label for="status" class="form-label text-secondary fw-bold">Status</label>
                                            <input type="text" 
                                                class="form-control ms-1" 
                                                id="copyright"
                                                name="copyright" 
                                                value="<?php echo htmlspecialchars($book['status'])?>"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card p-2 m-4">
                            <div class="card-body">
                                <h3 class="card-title text-center">Book Preview</h3>
                                <p class="text-center mt-5 fs-5">No preview to show</p>
                                <div class="d-flex justify-content-center">
                                    <img src="../balayanlms/assets/web_search.svg" alt="no history" class="img-fluid w-50">
                                </div>
                            </div>
                        </div>
                    <?php else:?>
                        <?php include '../balayanlms/book/bookNotFound.php';?>    
                    <?php endif;?>
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