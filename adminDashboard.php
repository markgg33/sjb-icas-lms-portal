<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJB Admin</title>
    <link rel="icon" type="image/x-icon" href="images/sjb-logo.ico">
    <!----BOOTSTRAP ESSENTIALS WITH FONTAWESOME LIBRARY---->
    <script src="https://kit.fontawesome.com/92cde7fc6f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!---------------------------->
    <link rel="stylesheet" href="css/styles.css">
    <script src="javascripts/sidebar.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Madimi+One&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>

<body>

    <div class="grid-container">

        <!-----HEADER------>


        <header class="header">
            <div class="info-title">
                Welcome, User
            </div>
            <ul class="header-list">
                <li>
                    <a href="#" class="btn-items" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-bell"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">No Notifications</a></li>
                    </ul>
                </li>
                <li>
                    <a href="logout.php" class="btn-items"><i class="fa-solid fa-right-from-bracket"></i></a>
                </li>
            </ul>
        </header>


        <!-----END OF HEADER------>

        <aside id="sidebar">

            <div class="sidebar-logo">
                <img src="css/sjb-logo.png" alt="Sidebar Logo of school here" height="150px">
            </div>

            <ul class="sidebar-list">
                <!----GENERAL DASHBOARD---->
                <li>
                    <a class="sidebar-dropdown d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#generalSubmenu" role="button" aria-expanded="false" aria-controls="generalSubmenu">
                        <span><i class="fa-solid fa-chart-line"></i>GENERAL</span>
                        <i class="fa-solid fa-caret-down"></i>
                    </a>

                    <ul class="collapse sidebar-submenu list-unstyled ps-3" id="generalSubmenu">
                        <li class="sidebar-list-item" data-page="dashboard" onclick="changePage('dashboard')">Dashboard</li>
                        <li class="sidebar-list-item" data-page="students" onclick="changePage('students')">Students List</li>
                        <li class="sidebar-list-item" data-page="faculty" onclick="changePage('faculty')">Faculty List</li>
                    </ul>
                </li>

                <!----USER MANAGEMENT---->
                <li>
                    <a class="sidebar-dropdown d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#userManagementSubMenu" role="button" aria-expanded="false" aria-controls="userManagementSubMenu">
                        <span><i class="fa-solid fa-user"></i>USER MANAGEMENT</span>
                        <i class="fa-solid fa-caret-down"></i>
                    </a>

                    <ul class="collapse sidebar-submenu list-unstyled ps-3" id="userManagementSubMenu">
                        <li class="sidebar-list-item" data-page="addUser" onclick="changePage('addUser')">Add Users</li>
                        <li class="sidebar-list-item" data-page="addStudents" onclick="changePage('addStudents')">Enroll Students</li>
                    </ul>
                </li>

                <!----COURSE MANAGEMENT---->
                <li>
                    <a class="sidebar-dropdown d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#courseManagementSubMenu" role="button" aria-expanded="false" aria-controls="courseManagementSubMenu">
                        <span><i class="fa-solid fa-school"></i>COURSE MANAGEMENT</span>
                        <i class="fa-solid fa-caret-down"></i>
                    </a>

                    <ul class="collapse sidebar-submenu list-unstyled ps-3" id="courseManagementSubMenu">
                        <li class="sidebar-list-item" data-page="allCourses" onclick="changePage('allCourses')">All Courses</li>
                        <li class="sidebar-list-item" data-page="addCourse" onclick="changePage('addCourse')">Add Course</li>
                        <li class="sidebar-list-item" data-page="assignFaculty" onclick="changePage('assignFaculty')">Assign Faculty</li>
                    </ul>
                </li>

            </ul>
        </aside>
        
    </div>

</body>

</html>