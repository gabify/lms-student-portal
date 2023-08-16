<?php
    //insert student on user table
    function insertUser($pdo, $lastname, $firstname, $usertype){
        $stmt = $pdo->prepare("INSERT INTO user(first_name, last_name, user_type)
        VALUES(:firstname, :lastname, :usertype)");
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':usertype', $usertype, PDO::PARAM_STR);
        $stmt->execute();
        return $pdo->lastInsertId();
    }

    //insert student on student table
    function insertStudent($pdo, $srcode, $program, $uid, $course){
        $stmt = $pdo->prepare("INSERT INTO student(srcode, program, course, user_id)
        VALUES(:srcode, :program, :course, :userid)");
        $stmt->bindParam(':srcode', $srcode, PDO::PARAM_STR);
        $stmt->bindParam(':program', $program, PDO::PARAM_STR);
        $stmt->bindParam(':course', $course, PDO::PARAM_STR);
        $stmt->bindParam(':userid', $uid, PDO::PARAM_INT);
        $stmt->execute();
    }

    //creating student transaction
    function createStudent($pdo, $student){
        try{
            $pdo->beginTransaction();
            $uid = insertUser($pdo, $student['lastname'], $student['firstname'], "student");
            if(!$uid){
                $pdo->rollBack();
                return "An error occured during operation.";
            }
            insertStudent($pdo, $student['srcode'], $student['program'], $uid, $student['course']);
            $pdo->commit();
        }catch(\PDOException $e){
            $pdo->rollBack();
            return $e->getMessage();
        }
        return 'success';
    }
?>