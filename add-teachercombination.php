<?php
session_start();

error_reporting(0);

include('includes/config.php');

if(strlen($_SESSION['alogin'])==""){

    header("Location: index.php");

}else{

    if(isset($_POST['submit'])){

        $teacher_id=$_POST['teacher_id'];
        $class_id=$_POST['class_id'];
        $subject_id=$_POST['subject_id'];
        $status=1;

        $sql="INSERT INTO  teachercombination(teacher_id,class_id,subject_id,status) VALUES(:teacher_id,:class_id,:subject_id,:status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':teacher_id',$teacher_id,PDO::PARAM_STR);
        $query->bindParam(':class_id',$class_id,PDO::PARAM_STR);
        $query->bindParam(':subject_id',$subject_id,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId){

            $msg="Teacher Combination added successfully";

        }else{

            $error="Something went wrong. Please try again";
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SRM Admin Teacher Combination< </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
  <?php include('includes/topbar.php');?> 
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                   <?php include('includes/leftbar.php');?>  
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                     <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Add Teacher Combination</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Teacher</li>
                                        <li class="active">Add Teacher Combination</li>
                                    </ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Add Teacher Combination</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                <form class="form-horizontal" method="post">

<div class="form-group">
                                                        <label for="teacher_id" class="col-sm-2 control-label">Teacher</label>
                                                        <div class="col-sm-10">
 <select name="teacher_id" class="form-control" id="teacher_id" required="required">
<option value="">Select Teacher</option>
<?php

    $sql = "SELECT * from teachers";

    $query = $dbh->prepare($sql);

    $query->execute();

    $results=$query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0){

        foreach($results as $result){

?>
<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->fullanme); ?>&nbsp; ID-<?php echo htmlentities($result->teacher_id); ?></option>
<?php

    }

}

?>
 </select>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label for="class_id" class="col-sm-2 control-label">Class</label>
                                                        <div class="col-sm-10">
 <select name="class_id" class="form-control" id="class_id" onchange="javascript:getSubject(this)" required="required">
<option value="">Select Class</option>
<?php

    $sql = "SELECT * from tblclasses";

    $query = $dbh->prepare($sql);

    $query->execute();

    $results=$query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0){

        foreach($results as $result){

?>
<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp; Section-<?php echo htmlentities($result->Section); ?></option>
<?php

    }

}

?>
 </select>
                                                        </div>
                                                    </div>
<div class="form-group">
    <label for="subject_id" class="col-sm-2 control-label">Subject</label>
        <div class="col-sm-10">
 <select name="subject_id" class="form-control" id="subject_id" required="required">

 </select>
                                                        </div>
                                                    </div>
                                                    

                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="submit" class="btn btn-primary">Add</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-12 -->
                                </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $(".js-states").select2();
                $(".js-states-limit").select2({
                    maximumSelectionLength: 2
                });
                $(".js-states-hide").select2({
                    minimumResultsForSearch: Infinity
                });
            });

            function getSubject(tag) {
                let class_id = $(tag).val();
                 $.ajax({
                    type: "POST",
                    url: 'ajax.php',
                    data: {class_id:class_id,request_type: '_class_subject'},
                    success: function (data) {
                        if(data) {
                            let options = JSON.parse(data);
                            for(let option of options) {
                                $('#subject_id').append('<option value="'+option.id+'">'+option.SubjectName+' Code: '+option.SubjectCode+'</option>')
                            }
                        }
                    }
                });
            }
        </script>
    </body>
</html>
<?PHP } ?>
