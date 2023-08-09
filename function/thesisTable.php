<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $keyword = 'null';
    $thesis_per_page = 10;
    $page_num = 1;
    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
    }
    if(isset($_GET['page'])){
        $page_num = htmlspecialchars($_GET['page']);
    }
    $offset = ($page_num - 1) * $thesis_per_page;
    $previous_page = $page_num - 1;
    $next_page = $page_num + 1;
    $totalThesis = getNumberOfThesis($pdo, $keyword);
    $totalPage = ceil($totalThesis/$thesis_per_page);
    $secondLast = $totalPage - 1;
    $theses = getThesis($pdo, $offset, $thesis_per_page, $keyword);
?>
<?php if($theses):?>
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
    <table class="table table-hover table-bordered text-center" id="thesisTable">
        <thead class="fs-6">
        <th scope="col">#</th>
            <th scope="col">Call Number</th>
            <th scope="col">Title</th>
            <th scope="col">Publication Year</th>
        </thead>
        <tbody>
            <?php foreach($theses as $thesis):?>
                <tr>
                    <th scope="row"><?php echo htmlspecialchars($thesis['id'])?></th>
                    <td><?php echo htmlspecialchars($thesis['callnum'])?></td>
                    <td><?php echo htmlspecialchars($thesis['title'])?></td>
                    <td><?php echo htmlspecialchars($thesis['publication_year'])?></td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

    <!-- pagination-->
    <div class="d-flex justify-content-between mx-1">
        <div class="page_info fw-bold">
            Page <?php echo $page_num. " of ".$totalPage;?>
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
                <?php if($totalPage <= 10):?>
                    <?php for($counter = 1; $counter <= $totalPage; $counter++):?>
                        <?php if($counter == $page_num):?>
                            <li class="page-item active"><a class="page-link"><?php echo $counter;?></a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $counter;?>&keyword=<?php echo $keyword;?>"><?php echo $counter;?></a></li>
                        <?php endif;?>
                    <?php endfor;?>
                <?php elseif($totalPage > 10):?>
                    <?php if($page_num <= 4):?>
                        <?php for($counter = 1; $counter <= 8; $counter++):?>
                            <?php if($counter == $page_num):?>
                                <li class="page-item active"><a class="page-link"><?php echo $counter;?></a></li>
                            <?php else:?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo $counter;?>&keyword=<?php echo $keyword;?>"><?php echo $counter;?></a></li>
                            <?php endif;?>
                        <?php endfor;?>
                        <li class="page-item"><a class="page-link">.....</a></li>
                        <?php if($page_num == $secondLast):?>
                            <li class="page-item active"><a class="page-link"><?php echo $secondLast;?></a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $secondLast;?>&keyword=<?php echo $keyword;?>"><?php echo $secondLast;?></a></li>
                        <?php endif;?>
                        <?php if($page_num == $totalPage):?>
                            <li class="page-item active"><a class="page-link"><?php echo $totalPage;?></a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $totalPage;?>&keyword=<?php echo $keyword;?>"><?php echo $totalPage;?></a></li>
                        <?php endif;?>
                    <?php elseif($page_num > 4 && $page_num < $totalPage - 4):?>
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
                        <?php if($page_num == $secondLast):?>
                            <li class="page-item active"><a class="page-link"><?php echo $secondLast;?></a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $secondLast;?>&keyword=<?php echo $keyword;?>"><?php echo $secondLast;?></a></li>
                        <?php endif;?>
                        <?php if($page_num == $totalPage):?>
                            <li class="page-item active"><a class="page-link"><?php echo $totalPage;?></a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $totalPage;?>&keyword=<?php echo $keyword;?>"><?php echo $totalPage;?></a></li>
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
                        <?php for($counter = $totalPage - 6; $counter <= $totalPage; $counter++):?>
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
    <h4 class="text-center">Sorry, No thesis available at this moment.</h4>
<?php endif;?>