<?php
session_start();

error_reporting(0);

include('includes/config.php');

if(strlen($_SESSION['alogin'])==""){

    header("Location: index.php");

}else{

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request_type']) == '_class_subject') {
        $class_id = $_POST['class_id'];
        $status = 1;

        $sql = "SELECT s.* from tblsubjectcombination sc left join tblsubjects s on s.id = sc.SubjectId where sc.ClassId=:class_id and sc.status=:status";
        $query = $dbh->prepare($sql);
        $query->bindParam(':class_id',$class_id,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0) {
            echo json_encode($results);
        } else {
            echo "";
        }
    }
}
?>