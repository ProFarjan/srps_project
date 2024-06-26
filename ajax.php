<?php
session_start();

error_reporting(0);

include('includes/config.php');

if (isset($_SESSION['alogin']) || isset($_SESSION['tlogin'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['request_type'] == '_class_subject') {
        $class_id = $_POST['class_id'];
        $status = 1;

        $sql = "SELECT s.* from tblsubjectcombination sc left join tblsubjects s on s.id = sc.SubjectId where sc.ClassId=:class_id and sc.status=:status";
        $query = $dbh->prepare($sql);
        $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            echo json_encode($results);
        } else {
            echo "";
        }
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['request_type'] == '_class_subject_teacher') {
        $class_id = $_POST['class_id'];
        $status = 1;
        $teacher_id = $_SESSION['teacher_id'];

        $sql = "SELECT s.* from teachercombination tc left join tblsubjects s on s.id = tc.subject_id where tc.class_id=:class_id and tc.status=:status and tc.teacher_id=:teacher_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':teacher_id', $teacher_id, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            echo json_encode($results);
        } else {
            echo "";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['request_type'] == '_class_subject_teacher_std') {
        $class_id = $_POST['class_id'];
        $status = 1;

        $sql = "SELECT * from tblstudents where ClassId=:class_id and status=:status";
        $query = $dbh->prepare($sql);
        $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            echo json_encode($results);
        } else {
            echo "";
        }
    }
} else {
    header("Location: index.php");
}
