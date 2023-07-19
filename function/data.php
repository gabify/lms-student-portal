<?php
    function getBooks($pdo, $offset, $pages, $keyword){
        $keyword = '%'.$keyword.'%';
        $stmt = $pdo->prepare('CALL getAllBooks(:opset, :pages, :keyword)');
        $stmt->bindParam(':opset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':pages', $pages, PDO::PARAM_INT);
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $books;
    }

    function getNumberOfPages($pdo, $keyword){
        if($keyword == 'null'){
            $stmt = $pdo->query("SELECT COUNT(*) AS totalRecords FROM books WHERE is_deleted = 0");
            $totalRecords = $stmt->fetch(PDO::FETCH_ASSOC);
            return $totalRecords['totalRecords'];
        }else{
            $keyword = '%'.$keyword.'%';
            $stmt = $pdo->prepare("SELECT COUNT(*) AS totalPages FROM books
            LEFT JOIN book_data
            ON books.book_Info_id = book_data.id
            LEFT JOIN author
            ON book_data.author_id = author.id
            LEFT JOIN publisher
            ON book_data.publisher_id = publisher.id
            WHERE book_data.callnum LIKE :keyword
            OR book_data.title LIKE :keyword
            OR author.author_name LIKE :keyword
            OR publisher.publisher_name LIKE :keyword
            AND books.is_deleted = 0");
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['totalPages'];
        }
    }
?>