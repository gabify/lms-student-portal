<?php
    function getBooks($pdo, $offset, $pages, $keyword){
        if($keyword == 'null'){
            $stmt = $pdo->prepare("SELECT books.id,
            books.callnum,
            books.title,
            books.status
            FROM books
            WHERE books.is_deleted = 0
            LIMIT :opset, :pages");
            $stmt->bindParam(':opset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':pages', $pages, PDO::PARAM_INT);
            $stmt->execute();
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if($books){
                return $books;
            }else{
                return 'Some error occurred';
            }
        }else{
            $keyword = '%'.$keyword.'%';
            $stmt = $pdo->prepare("SELECT books.id,
            books.callnum,
            books.title,
            books.status
            FROM books
            WHERE books.callnum LIKE :keyword
            OR books.title LIKE :keyword
            OR books.author LIKE :keyword
            OR books.publisher LIKE :keyword
            AND books.is_deleted = 0
            LIMIT :opset, :pages");
            $stmt->bindParam(':opset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':pages', $pages, PDO::PARAM_INT);
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            $stmt->execute();
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($books){
                return $books;
            }else{
                return 'Some error occurred';
            }
        }
    }

    function getNumberOfPages($pdo, $keyword){
        if($keyword == 'null'){
            $stmt = $pdo->query("SELECT COUNT(*) AS totalRecords FROM books WHERE is_deleted = 0");
            $totalRecords = $stmt->fetch(PDO::FETCH_ASSOC);
            return $totalRecords['totalRecords'];
        }else{
            $keyword = '%'.$keyword.'%';
            $stmt = $pdo->prepare("SELECT COUNT(*) AS totalPages FROM books
            WHERE callnum LIKE :keyword
            OR title LIKE :keyword
            OR author LIKE :keyword
            OR publisher LIKE :keyword
            AND is_deleted = 0");
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['totalPages'];
        }
    }
?>