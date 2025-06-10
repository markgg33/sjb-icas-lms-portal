<?php

session_start();
include "config.php";
include "session_check.php";

?>


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
    <link rel="icon" type="image/x-icon" href="images/sjb-logo.ico">
    <!---------------------------->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script src="javascripts/sidebar.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Madimi+One&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>

<body>

    <div class="grid-container">

        <!-----HEADER------>

        <header class="header">
            <div class="info-title">
                Welcome, <?= htmlspecialchars($_SESSION['name']) ?>
            </div>
            <ul class="header-list">
                <li class="nav-item dropdown">
                    <a class="btn-items nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bell"></i>
                        <span id="notifCount" class="badge bg-danger ms-1 d-none">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" id="notifList">
                        <li><a class="dropdown-item text-muted">Loading...</a></li>
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
            <BR></BR>
            <ul class="sidebar-list">
                <!----GENERAL DASHBOARD---->
                <li>
                    <a class="sidebar-dropdown d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#generalSubmenu" role="button" aria-expanded="false" aria-controls="generalSubmenu">
                        <span><i class="fa-solid fa-chart-line"></i>GENERAL</span>
                        <i class="fa-solid fa-caret-down"></i>
                    </a>

                    <ul class="collapse sidebar-submenu list-unstyled ps-3" id="generalSubmenu">
                        <li class="sidebar-list-item" data-page="dashboard" onclick="changePage('dashboard')">Dashboard</li>
                        <li class="sidebar-list-item" data-page="students" onclick="changePage('studentList')">Students List</li>
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
                        <li class="sidebar-list-item" data-page="editStudent" onclick="changePage('editStudent')">Edit Student Subject & Balance</li>
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
                        <li class="sidebar-list-item" data-page="enrollSubject" onclick="changePage('enrollSubject')">Enroll Subjects to Student</li>
                        <li class="sidebar-list-item" data-page="editSubjects" onclick="changePage('editSubjects')">Edit Subjects</li>
                    </ul>
                </li>

            </ul>
            <hr>
        </aside>

        <main class="main-container">

            <!---DASHBOARD PAGE--->
            <div id="dashboard-page" class="page-content">
                <div class="main-title">
                    <h1>DASHBOARD</h1>
                </div>

                <div class="main-cards">
                    <div class="card">
                        <div class="card-inner">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <p>STUDENTS ENROLLED</p>
                        </div>
                        <h2 id="studentsEnrolledCount">Loading...</h2>
                    </div>
                    <div class="card">
                        <div class="card-inner">
                            <i class="fa-solid fa-book"></i>
                            <p>SUBJECTS</p>
                        </div>
                        <h2 id="subjectsCount">Loading...</h2>
                    </div>
                    <div class="card">
                        <div class="card-inner">
                            <i class="fa-solid fa-layer-group"></i>
                            <p>COURSES / PROGRAMS</p>
                        </div>
                        <h2 id="coursesCount">Loading...</h2>
                    </div>
                </div>

            </div>

            <!---STUDENT LIST PAGE--->
            <div id="studentList-page" class="page-content">
                <div class="main-title">
                    <h1>STUDENT LIST</h1>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input
                                type="text"
                                id="studentSearchInput"
                                class="form-control"
                                placeholder="Search by name or email"
                                aria-label="Search Student"
                                aria-describedby="searchStudentBtn" />
                            <button
                                class="btn btn-outline-primary"
                                type="button"
                                id="searchStudentBtn"
                                title="Search">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select id="courseFilter" class="form-select">
                            <option value="">All Courses</option>
                            <!-- Populated dynamically -->
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger w-100" id="clearStudentFilters">
                            <i class="fa-solid fa-trash"></i> Clear
                        </button>
                    </div>
                </div>


                <div id="studentTableContainer"></div>

                <div class="mt-4" id="paginationContainer"></div>
            </div>



            <!---USERS/FACULTY PAGE--->
            <div id="addUser-page" class="page-content">
                <div class="main-title">
                    <h1>ADD USERS & FACULTY</h1>
                </div>

                <div id="course-page-container">
                    <form id="addUserForm" enctype="multipart/form-data" class="mt-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" required />
                            </div>
                            <div class="col-md-4">
                                <label>Middle Name</label>
                                <input type="text" name="middle_name" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" required />
                            </div>
                            <div class="col-md-4 mt-3">
                                <label>Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">Select gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required />
                            </div>
                            <div class="col-md-4 mt-3">
                                <label>Role</label>
                                <select name="role" class="form-control" required>
                                    <option value="">Select role</option>
                                    <option value="admin">Admin</option>
                                    <option value="faculty">Faculty</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label>Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" required />
                                    <span class="input-group-text toggle-password" onclick="togglePassword('password')">
                                        <i class="fa-solid fa-eye"></i>
                                    </span>
                                </div>

                            </div>
                            <div class="col-md-6 mt-3">
                                <label>Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required />
                                    <span class="input-group-text toggle-password" onclick="togglePassword('confirm_password')">
                                        <i class="fa-solid fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Upload Photo</label>
                            <input type="file" name="photo" class="form-control" />
                        </div>

                        <button type="submit" class="btn btn-primary mt-4"><i class="fa-solid fa-plus"></i> Add User</button>
                    </form>

                    <div id="addUserResult" class="mt-3"></div>
                </div>

                <div class="mt-5">
                    <h3>📋 All Users</h3>
                    <table class="table table-bordered table-hover mt-3" id="usersTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Full Name</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!---EDIT SUBJECTS PAGE--->
            <div id="editSubjects-page" class="page-content">
                <div class="main-title">
                    <h1>EDIT SUBJECTS</h1>
                </div>

                <div class="mb-3">
                    <label for="editCourseSelect" class="form-label">Select Course</label>
                    <select id="editCourseSelect" class="form-select">
                        <option value="">-- Select a Course --</option>
                    </select>
                </div>

                <div id="editSubjectsTableContainer"></div>

                <div id="editSubjectsActions" class="mt-3" style="display:none;">
                    <button id="saveAllSubjectsBtn" class="btn btn-primary">💾 Save All Changes</button>
                </div>
            </div>


            <!---EDIT STUDENTS PAGE--->
            <div id="editStudent-page" class="page-content">
                <div class="main-title">
                    <h1>EDIT STUDENTS</h1>
                </div>

                <!-- Search Form -->
                <div class="input-group mb-4">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search student by name or course...">
                    <button id="searchBtn" class="btn btn-primary">Search</button>
                </div>

                <!-- Search Results -->
                <div id="studentResults" class="list-group mb-4"></div>

                <!-- Student Info Panel -->
                <div id="studentInfo" class="card d-none">
                    <div class="card-header">
                        <strong id="studentName"></strong> <span class="text-muted" id="studentCourseYear"></span>
                    </div>
                    <div class="card-body">
                        <!-- Balance Update -->
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Balance (₱)</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="balanceInput" step="0.01">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-success" id="saveBalanceBtn">Save Balance</button>
                            </div>
                        </div>

                        <!-- Enrolled Subjects -->
                        <h5 class="mt-4">Enrolled Subjects</h5>
                        <table class="table table-bordered mt-2" id="subjectTable">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Semester</th>
                                    <th>School Year</th>
                                    <th>Date Enrolled</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!---ALL COURSES & SUBJECTS PAGE--->
            <div id="allCourses-page" class="page-content">
                <div class="main-title">
                    <h1>PROGRAMS & SUBJECTS</h1>
                </div>

                <!-- Curriculum will be loaded here -->
                <div class="container mt-4">
                    <div id="curriculumContainer" class="row"></div>
                </div>
            </div>

            <!---ASSIGN FACULTY PAGE--->
            <div id="assignFaculty-page" class="page-content">
                <div class="main-title">
                    <h1>ASSIGN FACULTY TO SUBJECTS</h1>
                </div>

                <div class="container bg-white p-4 rounded shadow-sm mt-4">
                    <!-- Assign Faculty Form -->
                    <form id="assignFacultyForm">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Select Course</label>
                                <select class="form-select" id="facultyCourseSelect" name="course_id" required>
                                    <option value="">-- Select Course --</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Select Semester</label>
                                <select class="form-select" id="facultySemesterSelect" name="semester" required>
                                    <option value="">-- Select Semester --</option>
                                    <option value="1">1st Semester</option>
                                    <option value="2">2nd Semester</option>
                                    <option value="3">3rd Semester</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Select Faculty</label>
                                <select class="form-select" id="facultySelect" name="faculty_id" required>
                                    <option value="">-- Select Faculty --</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4" id="facultySubjectCheckboxesContainer">
                            <!-- Subject checkboxes will load here -->
                        </div>

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">Assign Subjects</button>
                        </div>
                    </form>
                </div>
            </div>


            <!---ENROLL SUBJECT PAGE--->
            <div id="enrollSubject-page" class="page-content">
                <div class="main-title">
                    <h1>ENROLL SUBJECTS TO STUDENT</h1>
                </div>

                <div id="course-page-container">
                    <form id="enrollSubjectsForm">
                        <div class="row">
                            <div class="col">
                                <label>Select Course:</label>
                                <select id="enrollCourseSelect" class="form-control" required>
                                    <option value="">Select Course</option>
                                    <!-- Options loaded by JS -->
                                </select>
                            </div>
                            <div class="col">
                                <label>Select Semester:</label>
                                <select id="enrollSemesterSelect" class="form-control" required>
                                    <option value="">Select Semester</option>
                                    <option value="1">1st Sem</option>
                                    <option value="2">2nd Sem</option>
                                    <option value="3">3rd Sem</option>
                                </select>
                            </div>
                            <div class="mb-3"></div>
                        </div>

                        <div class="row">
                            <div class="col-9">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        id="studentNameInput"
                                        class="form-control"
                                        placeholder="Please enter student's name"
                                        aria-label="Student Name"
                                        aria-describedby="searchEnrollStudentBtn" />
                                    <button
                                        class="btn btn-outline-secondary"
                                        type="button"
                                        id="searchEnrollStudentBtn"
                                        title="Search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-3">
                                <button type="button" id="clearStudentSelection" class="btn btn-danger w-100">Remove <i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>


                        <div id="enrollSubjectCheckboxes" class="mt-3"></div>

                        <button type="submit" class="btn btn-primary mt-3">Enroll Subjects</button>

                        <!-- Put the search results and selected student info here -->
                        <div id="studentSearchResults" class="mt-2"></div>

                        <input type="hidden" id="selectedStudentId" name="student_id">

                        <p>Selected student: <span id="selectedStudentName">None</span></p>
                    </form>
                </div>
            </div>


            <!---ADD COURSES PAGE--->
            <div id="addCourse-page" class="page-content">
                <div class="main-title">
                    <h1>COURSE MANAGEMENT</h1>
                </div>

                <div id="course-page-container">
                    <h2>ADD COURSE</h2>

                    <form id="courseForm">
                        <div class="row">
                            <div class="col">
                                <input type="text" name="name" class="form-control" placeholder="Course Name" required>
                            </div>
                            <div class="col">
                                <select name="year_level" class="form-select" required>
                                    <option value="">Select Year Level</option>
                                    <option value="12">Grade 12</option>
                                    <option value="1">1st Year</option>
                                    <option value="2">2nd Year</option>
                                    <option value="3">3rd Year</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-success" onclick="return confirm('Confirm added Course?')"><i class="fa-solid fa-plus"></i></button>
                        <div class="mb-3"></div>
                    </form>
                </div>

                <div id="course-page-container">
                    <h2>SUBJECT MANAGEMENT</h2>

                    <form id="subjectForm">
                        <div id="subjectFormRows">
                            <div class="row subject-group-creation">
                                <div class="col-4">
                                    <input type="text" name="subject_codes[]" class="form-control" placeholder="Subject Code" required>
                                </div>
                                <div class="col-4">
                                    <input type="text" name="subject_names[]" class="form-control" placeholder="Subject Name" required>
                                </div>
                                <div class="col-3">
                                    <select name="subject_semesters[]" class="form-control" required>
                                        <option value="">Select Semester</option>
                                        <option value="1">1st Sem</option>
                                        <option value="2">2nd Sem</option>
                                        <option value="3">3rd Sem</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-danger removeSubject"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Add More Button (should be after the rows) -->
                        <div class="row">
                            <div class="col mt-3">
                                <button type="button" id="addMoreSubject" class="btn btn-success"><i class="fa-solid fa-plus"></i></button>
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i></button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="course-page-container">
                    <h2>ASSIGN SUBJECT TO COURSE</h2>
                    <div class="mb-2"></div>
                    <form id="assignForm">
                        <div class="row">
                            <div class="col">
                                <label for="courseSelect">Select Course:</label>
                                <select id="courseSelect" name="course_id" class="form-control" required>
                                    <option value="">Select Course</option>
                                </select>
                            </div>
                            <div class="col">
                                <label>Select Semester:</label>
                                <select id="semesterSelect" name="semester" class="form-control" required>
                                    <option value="">Select Semester</option>
                                    <option value="1">1st Sem</option>
                                    <option value="2">2nd Sem</option>
                                    <option value="3">3rd Sem</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label>Select Subjects:</label>
                            <div id="subjectCheckboxes"></div>
                        </div>

                        <button type="submit" class="btn btn-success">ASSIGN SUBJECTS</button>
                    </form>
                </div>

            </div>

        </main> <!---END OF MAIN CONTAINER--->
    </div> <!---END OF GRID CONTAINER--->

    <!-- Global loading overlay -->
    <div id="loadingOverlay">
        <div class="spinner-border text-light" role="status"></div>
    </div>

    <!---OTHER MODALS HERE--->

    <?php include "modals/editUserModal.php"; ?>
    <?php include "modals/editStudentModal.php" ?>
    <?php include "modals/successModal.php" ?>

    <!---FOR SUBJECT MANAGEMENT JS--->
    <script src="javascripts/loadingOverlay.js"></script>
    <script src="javascripts/courseSubject.js"></script>
    <script src="javascripts/togglePassword.js"></script>
    <script src="javascripts/studentSearch.js"></script>
    <script src="javascripts/curriculumCRUD.js"></script>
    <script src="javascripts/forEditStudents.js"></script>
    <script src="javascripts/adminDashboardCounts.js"></script>
    <script src="javascripts/assignFacultySubjects.js"></script>


    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 100, // Start animation 100px before the section is in view
            duration: 800, // Animation duration in milliseconds
            easing: 'ease-in-out', // Smooth transition effect
        });
    </script>

</body>

</html>