<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $keyword = 'null';
    $book_per_page = 10;
    $page_num = 1;
    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
    }
    if(isset($_GET['page'])){
        $page_num = htmlspecialchars($_GET['page']);
    }
    $offset = ($page_num - 1) * $book_per_page;
    $previous_page = $page_num - 1;
    $next_page = $page_num + 1;
    $totalBooks = getNumberOfPages($pdo, $keyword);
    $totalNumberOfPage = ceil($totalBooks/$book_per_page);
    $secondToLast = $totalNumberOfPage - 1;
    $books = getBooks($pdo, $offset, $book_per_page, $keyword);
?>
<?php if($books):?>
    <div class="d-flex justify-content-end mx-2 my-2">
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
                    <td><?php echo htmlspecialchars($book['id'])?></td>
                    <td><?php echo htmlspecialchars($book['callnum'])?></td>
                    <td><?php echo htmlspecialchars($book['title'])?></td>
                    <td>
                        <a 
                        href="../lms-student-portal/viewBook.php?id=<?php echo htmlspecialchars($book['id'])?>"
                        class="btn btn-lg">
                            <i class="bi-eye-fill text-danger"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

    <!-- pagination-->
    <div class="d-flex justify-content-between mx-1">
        <div class="page_info fw-bold">
            Page <?php echo $page_num. " of ".$totalNumberOfPage;?>
        </div>
        <nav aria-label="Book pagination">
            <ul class="pagination">
                <!-- Previous Link -->
                <?php if($page_num == 1):?>
                    <li class="page-item disabled"><a class="page-link">Previous</a></li>
                <?php else:?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $previous_page;?>&keyword=<?php echo $keyword;?>">Previous</a></li>
                <?php endif;?>
                
                <!-- Page numbers link -->
                <?php if($totalNumberOfPage <= 10):?>
                    <?php for($counter = 1; $counter <= $totalNumberOfPage; $counter++):?>
                        <?php if($counter == $page_num):?>
                            <li class="page-item active"><a class="page-link"><?php echo $counter;?></a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $counter;?>&keyword=<?php echo $keyword;?>"><?php echo $counter;?></a></li>
                        <?php endif;?>
                    <?php endfor;?>
                <?php elseif($totalNumberOfPage > 10):?>
                    <?php if($page_num <= 4):?>
                        <?php for($counter = 1; $counter <= 8; $counter++):?>
                            <?php if($counter == $page_num):?>
                                <li class="page-item active"><a class="page-link"><?php echo $counter;?></a></li>
                            <?php else:?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo $counter;?>&keyword=<?php echo $keyword;?>"><?php echo $counter;?></a></li>
                            <?php endif;?>
                        <?php endfor;?>
                        <li class="page-item"><a class="page-link">.....</a></li>
                        <?php if($page_num == $secondToLast):?>
                            <li class="page-item active"><a class="page-link"><?php echo $secondToLast;?></a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $secondToLast;?>&keyword=<?php echo $keyword;?>"><?php echo $secondToLast;?></a></li>
                        <?php endif;?>
                        <?php if($page_num == $totalNumberOfPage):?>
                            <li class="page-item active"><a class="page-link"><?php echo $totalNumberOfPage;?></a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $totalNumberOfPage;?>&keyword=<?php echo $keyword;?>"><?php echo $totalNumberOfPage;?></a></li>
                        <?php endif;?>
                    <?php elseif($page_num > 4 && $page_num < $totalNumberOfPage - 4):?>
                        <?php if($page_num == 1):?>
                            <li class="page-item active"><a class="page-link">1</a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=1&keyword=<?php echo $keyword;?>">1</a></li>
                        <?php endif;?>
                        <?php if($page_num == 2):?>
                            <li class="page-item active"><a class="page-link">2</a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=2&keyword=<?php echo $keyword;?>">2</a></li>
                        <?php endif;?>
                        <li class="page-item"><a class="page-link">.....</a></li>
                        <?php for($counter = $page_num - 2; $counter <= $page_num + 2; $counter++):?>
                            <?php if($counter == $page_num):?>
                                <li class="page-item active"><a class="page-link"><?php echo $counter;?></a></li>
                            <?php else:?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo $counter;?>&keyword=<?php echo $keyword;?>"><?php echo $counter;?></a></li>
                            <?php endif;?>
                        <?php endfor;?>
                        <li class="page-item"><a class="page-link">.....</a></li>
                        <?php if($page_num == $secondToLast):?>
                            <li class="page-item active"><a class="page-link"><?php echo $secondToLast;?></a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $secondToLast;?>&keyword=<?php echo $keyword;?>"><?php echo $secondToLast;?></a></li>
                        <?php endif;?>
                        <?php if($page_num == $totalNumberOfPage):?>
                            <li class="page-item active"><a class="page-link"><?php echo $totalNumberOfPage;?></a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $totalNumberOfPage;?>&keyword=<?php echo $keyword;?>"><?php echo $totalNumberOfPage;?></a></li>
                        <?php endif;?>
                    <?php else:?>
                        <?php if($page_num == 1):?>
                            <li class="page-item active"><a class="page-link">1</a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=1&keyword=<?php echo $keyword;?>">1</a></li>
                        <?php endif;?>
                        <?php if($page_num == 2):?>
                            <li class="page-item active"><a class="page-link">2</a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=2&keyword=<?php echo $keyword;?>">2</a></li>
                        <?php endif;?>
                        <li class="page-item"><a class="page-link">.....</a></li>
                        <?php for($counter = $totalNumberOfPage - 6; $counter <= $totalNumberOfPage; $counter++):?>
                            <?php if($counter == $page_num):?>
                                <li class="page-item active"><a class="page-link"><?php echo $counter;?></a></li>
                            <?php else:?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo $counter;?>&keyword=<?php echo $keyword;?>"><?php echo $counter;?></a></li>
                            <?php endif;?>
                        <?php endfor;?>
                    <?php endif;?>    
                <?php endif;?>

                <!-- Next page link -->
                <?php if($page_num == $totalNumberOfPage):?>
                    <li class="page-item disabled"><a class="page-link">Next</a></li>
                <?php else:?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $next_page;?>&keyword=<?php echo $keyword;?>">Next</a></li>
                <?php endif;?>
            </ul>
        </nav>
    </div>
<?php else:?>
    <h4 class="text-center">Sorry, No book available at this moment.</h4>
<?php endif;?>