<?php
    function getId($pdo, $srcode){
        $stmt = $pdo->prepare("SELECT id FROM student WHERE srcode = :srcode");
        $stmt->bindParam(':srcode', $srcode, PDO::PARAM_STR);
        $stmt->execute();
        $id = $stmt->fetch(PDO::FETCH_ASSOC);

        if($id){
            return $id['id'];
        }else{
            return 'unidentified';
        }
    }

    function insertLog($pdo, $id, $date, $time){
        $stmt = $pdo->prepare("INSERT INTO student_log(student_id, date_in, time_in)
        VALUES(:id, :dateIn, :timeIn)");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':dateIn', $date, PDO::PARAM_STR);
        $stmt->bindParam(':timeIn', $time, PDO::PARAM_STR);
        $stmt->execute();
    }

    function login($pdo, $srcode, $date, $time){
        try{
            $pdo->beginTransaction();
            $id = getId($pdo, $srcode);
            if($id == 'unidentified'){
                $pdo->rollBack();
                return 'unidentified';
            }
            insertLog($pdo, $id, $date, $time);
            $pdo->commit();
        }catch(\PDOException $e){
            $pdo->rollBack();
            return $e->getMessage();
        }
        return 'success';
    }
?>