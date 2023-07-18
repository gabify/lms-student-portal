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
?>