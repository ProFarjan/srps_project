<div class="left-sidebar bg-black-300 box-shadow ">
    <div class="sidebar-content">
        <div class="user-info closed">
            <img src="images/user.png" alt="John Doe" class="img-circle profile-img">
            <h6 class="title">a-coder</h6>
            <small class="info">Envato Market Place</small>
        </div>
        <!-- /.user-info -->

        <div class="sidebar-nav">
            <ul class="side-nav color-gray">
                <?php if (isset($_SESSION['alogin'])) : ?>
                    <li class="nav-header">
                        <span class="">Admin Login</span>
                    </li>
                    <li>
                        <a href="dashboard"><span class="glyphicon glyphicon-home"></span> <span> Home </span> </a>

                    </li>

                    <li class="nav-header">
                        <span class="">Appearance</span>
                    </li>
                    <li class="has-children">
                        <a href="#"><span class="glyphicon glyphicon-user"></span> <span>Students</span> <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <ul class="child-nav">
                            <li><a href="add-students"><span class="glyphicon glyphicon-plus-sign"></span> <span>Add Students</span></a></li>
                            <li><a href="manage-students"><span class="glyphicon glyphicon-cog"></span> <span>Manage Students</span></a></li>

                        </ul>
                    </li>
                    <li class="has-children">
                        <a href="#"><span class="glyphicon glyphicon-user"></span> <span>Teachers</span> <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <ul class="child-nav">
                            <li><a href="add-teachers"><span class="glyphicon glyphicon-plus-sign"></span> <span>Add Teachers</span></a></li>
                            <li><a href="manage-teachers"><span class="glyphicon glyphicon-cog"></span> <span>Manage Teachers</span></a></li>
                            <li><a href="add-teachercombination"><span class="glyphicon glyphicon-plus-sign"></span> <span>Add Teacher Combination </span></a></li>
                            <a href="manage-teachercombination"><span class="glyphicon glyphicon-cog"></span> <span>Manage Teacher Combination </span></a>
                    </li>
            </ul>
            </li>
            <li class="has-children">
                <a href="#"><span class="glyphicon glyphicon-list-alt"></span> <span>Student Classes / Courses </span> <span class="glyphicon glyphicon-chevron-right"></span></a>
                <ul class="child-nav">
                    <li><a href="create-class"><span class="glyphicon glyphicon-plus"></span> <span>Create Class / Course</span></a></li>
                    <li><a href="manage-classes"><span class="glyphicon glyphicon-cog"></span> <span>Manage Classes / Courses</span></a></li>

                </ul>
            </li>
            <li class="has-children">
                <a href="#"><span class="glyphicon glyphicon-book"></span> <span>Subjects</span> <span class="glyphicon glyphicon-chevron-right"></span></a>
                <ul class="child-nav">
                    <li><a href="create-subject"><span class="glyphicon glyphicon-plus"></span> <span>Create Subject</span></a></li>
                    <li><a href="manage-subjects"><span class="glyphicon glyphicon-cog"></span> <span>Manage Subjects</span></a></li>
                    <li><a href="add-subjectcombination"><span class="glyphicon glyphicon-plus-sign"></span> <span>Add Subject Combination </span></a></li>
                    <a href="manage-subjectcombination"><span class="glyphicon glyphicon-cog"></span> <span>Manage Subject Combination </span></a>
            </li>
            </ul>
            </li>
            <li class="has-children">
                <a href="#"><span class="glyphicon glyphicon-education"></span> <span>Result</span> <span class="glyphicon glyphicon-chevron-right"></span></a>
                <ul class="child-nav">
                    <li><a href="add-result"><span class="glyphicon glyphicon-plus-sign"></span> <span>Add Result</span></a></li>
                    <li><a href="manage-results"><span class="glyphicon glyphicon-cog"></span> <span>Manage Result</span></a></li>

                </ul>

            </li>

            <li><a href="change-password"><span class="glyphicon glyphicon-cog"></span> <span>Change Password</span></a></li>
        <?php endif; ?>

        <?php if (isset($_SESSION['tlogin']) && $_SESSION['tlogin'] == true) : ?>
            <li class="nav-header">
                <span class="">Teacher Login</span>
            </li>
            <li>
                <a href="teacher-dashboard"><span class="glyphicon glyphicon-home"></span> <span> Home </span> </a>

            </li>
            <li class="has-children">
                <a href="#"><span class="glyphicon glyphicon-education"></span> <span>Result</span> <span class="glyphicon glyphicon-chevron-right"></span></a>
                <ul class="child-nav">
                    <li><a href="add-teacher-result"><span class="glyphicon glyphicon-plus-sign"></span> <span>Add Result</span></a></li>
                    <li><a href="manage-teacher-results"><span class="glyphicon glyphicon-cog"></span> <span>Manage Result</span></a></li>
                </ul>
            </li>
        <?php endif; ?>

        </div>
        <!-- /.sidebar-nav -->
    </div>
    <!-- /.sidebar-content -->
</div>