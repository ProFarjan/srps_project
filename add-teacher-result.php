<?php
session_start();

error_reporting(0);

include('includes/config.php');

if (strlen($_SESSION['tlogin']) == "") {
    header("Location: index.php");
} else {

    if (isset($_POST['submit'])) {
        $marks = array();
        $class_id = $_POST['class_id'];
        $subject_id = $_POST['subject_id'];
        $marks = $_POST['mark'];
        $teacher_id = $_SESSION['teacher_id'];
        $std = $_POST['std'];

        $msg = [];

        foreach ($marks as $student_id => $mark) {
            $sql = "SELECT count(*) as total FROM tblresult where StudentId=:student_id and ClassId=:class_id and SubjectId=:subject_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
            $query->bindParam(':subject_id', $subject_id, PDO::PARAM_STR);
            $query->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetch(PDO::FETCH_OBJ);
            if ($results->total == 0) {
                $sql = "INSERT INTO  tblresult(StudentId,ClassId,SubjectId,marks,teacher_id) VALUES (:student_id,:class_id,:subject_id,:mark,:teacher_id)";
                $query1 = $dbh->prepare($sql);
                $query1->bindParam(':student_id', $student_id, PDO::PARAM_STR);
                $query1->bindParam(':class_id', $class_id, PDO::PARAM_STR);
                $query1->bindParam(':subject_id', $subject_id, PDO::PARAM_STR);
                $query1->bindParam(':mark', $mark, PDO::PARAM_STR);
                $query1->bindParam(':teacher_id', $teacher_id, PDO::PARAM_STR);
                $query1->execute();
                $lastInsertId = $dbh->lastInsertId();

                if ($lastInsertId) {
                    $msg[] = '<div class="alert alert-success"><strong>' . $std[$student_id] . '</strong> result info added successfully</div>';
                } else {
                    $msg[] = '<div class="alert alert-warning"><strong>' . $std[$student_id] . '</strong> something went wrong. Please try again</div>';
                }
            } else {
                $msg[] = '<div class="alert alert-danger"><strong>' . $std[$student_id] . '</strong> mark already submitted!.</div>';
            }
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SRM Teacher| Add Result </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/prism/prism.css" media="screen">
        <link rel="stylesheet" href="css/select2/select2.min.css">
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
        <script>
            function getStudent(val) {
                $.ajax({
                    type: "POST",
                    url: "get_student",
                    data: 'classid=' + val,
                    success: function(data) {
                        $("#studentid").html(data);

                    }
                });
                $.ajax({
                    type: "POST",
                    url: "get_student",
                    data: 'classid1=' + val,
                    success: function(data) {
                        $("#subject").html(data);

                    }
                });
            }
        </script>
        <script>
            function getresult(val, clid) {

                var clid = $(".clid").val();

                var val = $(".stid").val();

                var abh = clid + '$' + val;

                $.ajax({
                    type: "POST",
                    url: "get_student.php",
                    data: 'studclass=' + abh,
                    success: function(data) {
                        $("#reslt").html(data);

                    }

                });

            }
        </script>
    </head>

    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
            <?php include('includes/topbar.php'); ?>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                    <?php include('includes/leftbar.php'); ?>
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Declare Result</h2>

                                </div>

                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard"><i class="fa fa-home"></i> Home</a></li>

                                        <li class="active">Student Result</li>
                                    </ul>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">

                                        <div class="panel-body">

                                            <?php

                                            if (count($msg)) {

                                            ?>
                                                <?php foreach ($msg as $m) : ?>
                                                    <?= $m; ?>
                                                <?php endforeach; ?>
                                            <?php

                                            } elseif ($error) {

                                            ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php

                                            }

                                            ?>
                                            <form class="form-horizontal" method="post">

                                                <div class="form-group">

                                                    <label for="default" class="col-sm-2 control-label">Class</label>
                                                    <div class="col-sm-10">
                                                        <select name="class_id" class="form-control clid" id="class_id" onChange="getTeacherSubject(this);" required="required">
                                                            <option value="">Select Class</option>
                                                            <?php
                                                            $sql = "SELECT DISTINCT c.id,c.ClassName,c.Section from teachercombination tc left join tblclasses c on tc.class_id = c.id";

                                                            $query = $dbh->prepare($sql);

                                                            $query->execute();

                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                            if ($query->rowCount() > 0) {

                                                                foreach ($results as $result) {

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

                                                    <label for="date" class="col-sm-2 control-label">Subjects</label>

                                                    <div class="col-sm-10">

                                                        <select id="subject_id" class="form-control" name="subject_id">
                                                            <option value="">Select Subject</option>
                                                        </select>

                                                    </div>

                                                </div>



                                                <div class="form-group">

                                                    <div class="col-sm-offset-2 col-sm-10">

                                                        <button type="button" class="btn btn-primary" onclick="javascript:searchStudent(this)">Search</button>

                                                    </div>

                                                </div>

                                                <div class="form-group" id="students" style="display: none;">
                                                    <div class="col-sm-12">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>SL</th>
                                                                    <th>Student Name</th>
                                                                    <th>Student Roll</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="data_body">

                                                            </tbody>
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="4" class="text-right">
                                                                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                        </table>
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

                function getTeacherSubject(tag) {
                    let class_id = $(tag).val();
                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: {
                            class_id: class_id,
                            request_type: '_class_subject_teacher'
                        },
                        success: function(data) {
                            if (data) {
                                let options = JSON.parse(data);
                                for (let option of options) {
                                    $('#subject_id').append('<option value="' + option.id + '">' + option.SubjectName + ' Code: ' + option.SubjectCode + '</option>')
                                }
                            }
                        }
                    });
                }

                function searchStudent(tag) {
                    $('#data_body').empty();
                    let class_id = $('#class_id').val();
                    let subject_id = $('#subject_id').val();
                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: {
                            class_id: class_id,
                            subject_id: subject_id,
                            request_type: '_class_subject_teacher_std'
                        },
                        success: function(data) {
                            if (data) {
                                $('#students').slideDown();
                                let stds = JSON.parse(data);
                                let tr = '';
                                let sl = 0;
                                for (let std of stds) {
                                    tr += '<tr>';
                                    tr += '<td>' + (++sl) + '</td>';
                                    tr += '<td>' + std.StudentName + '</td>';
                                    tr += '<td>' + std.RollId + '</td>';
                                    tr += '<td><input type="number" required name="mark[' + std.StudentId + ']" class="form-control" max="100" min="0" step="0.1" /> <input type="hidden" value="' + std.StudentName + '" name="std[' + std.StudentId + ']" /></td>';
                                    tr += '<tr>';
                                }
                                $('#data_body').append(tr);
                            } else {
                                $('#students').hide();
                            }
                        }
                    });
                }
            </script>
    </body>

    </html>
<?php

}

?>