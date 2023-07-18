<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $pdo = require '../lms-student-portal/configuration/connect.php';
    require '../lms-student-portal/function/data.php';
    $keyword = 'null';
    $opset = 0;
    $pages = 10;
    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
    }
    if(isset($_GET['pages'])){
        $pages = htmlspecialchars($_GET['pages']);
    }
    $books = getBooks($pdo, $opset, $pages, $keyword);
?>
<div class="d-flex justify-content-between mx-2 my-2">
    <div class="d-flex justify-content-evenly">
        <div class="lead">Show</div>
        <select name="limit" id="limit" class="form-select mx-1">
            <option value="10" selected>10</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <div class="lead">Books</div>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="GET">
        <div class="search-box d-flex justify-content-between">
            <input 
                type="text" 
                class="form-control rounded-0 rounded-start" 
                placeholder="Search here..." 
                aria-label="searchBook" 
                aria-describedby="basic-addon1"
                name="keyword"/>
                <button 
                    type="submit"
                    class="btn btn-danger rounded-0 rounded-end"
                    name="submit">
                    <i class="bi-search"></i>
                </button>
        </div>
    </form>
</div>
<table class="table table-hover table-bordered text-center" id="bookTable">
    <thead class="fs-6">
        <th scope="col">Accession Number</th>
        <th scope="col">Call Number</th>
        <th scope="col" class="w-50">Title</th>
        <th scope="col">Action</th>
    </thead>
    <tbody>
        <?php foreach($books as $book):?>
            <tr id="<?php echo htmlspecialchars($book['id'])?>">
                <td><?php echo htmlspecialchars($book['accessnum'])?></td>
                <td><?php echo htmlspecialchars($book['callnum'])?></td>
                <td><?php echo htmlspecialchars($book['title'])?></td>
                <td>
                    <a 
                    href="../lms-student-portal/viewBook.php?id=<?php echo htmlspecialchars($book['accessnum'])?>"
                    class="btn btn-lg">
                        <i class="bi-eye-fill text-danger"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>