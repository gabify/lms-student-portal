<?php
    $pdo = require '../configuration/connect.php';

    if(isset($_GET['srcode'])){
        $srcode = htmlspecialchars($_GET['srcode']);
        echo checksrcode($pdo, $srcode);
    }

    function checksrcode($pdo, $srcode){
        $stmt = $pdo->prepare("SELECT id FROM student WHERE srcode = :srcode");
        $stmt->bindParam(':srcode', $srcode, PDO::PARAM_STR);
        $stmt->execute();
        $id = $stmt->fetch(PDO::FETCH_ASSOC);

        if($id){
            return 'registered';
        }
        return 'not registered';
    }
?>