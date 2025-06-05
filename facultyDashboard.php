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
    <title>Faculty Dashboard</title>
    <script src="https://kit.fontawesome.com/92cde7fc6f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/x-icon" href="images/sjb-logo.ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Madimi+One&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="grid-container">

        <!-----HEADER------>

        <header class="header">
            <div class="info-title">
                Welcome, <?= htmlspecialchars($_SESSION['name']) ?>
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
            <br>
            <ul class="sidebar-list">
                <!----GENERAL DASHBOARD---->
                <li>
                    <a class="sidebar-dropdown d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#generalSubmenu" role="button" aria-expanded="false" aria-controls="generalSubmenu">
                        <span><i class="fa-solid fa-chart-line"></i>GENERAL</span>
                        <i class="fa-solid fa-caret-down"></i>
                    </a>

                    <ul class="collapse sidebar-submenu list-unstyled ps-3" id="generalSubmenu">
                        <li class="sidebar-list-item" data-page="dashboard" onclick="changePage('dashboard')">Dashboard</li>
                        <li class="sidebar-list-item" data-page="students" onclick="changePage('mySubjects')">Subjects</li>
                        <li class="sidebar-list-item" data-page="gradeSubmission" onclick="changePage('gradeSubmission')">Grade Submission</li>

                    </ul>
                </li>

                <!----COURSE MANAGEMENT---->
                <li>
                    <a class="sidebar-dropdown d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#systemSettingsSubMenu" role="button" aria-expanded="false" aria-controls="systemSettingsSubMenu">
                        <span><i class="fa-solid fa-school"></i>SYSTEM SETTINGS</span>
                        <i class="fa-solid fa-caret-down"></i>
                    </a>

                    <ul class="collapse sidebar-submenu list-unstyled ps-3" id="systemSettingsSubMenu">
                        <li class="sidebar-list-item" data-page="editFacultyProfile" onclick="changePage('editFacultyProfile')">Edit Profile</li>
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
            </div>

            <!---SUBJECTS PAGE--->
            <div id="mySubjects-page" class="page-content">
                <div class="main-title">
                    <h1>MY SUBJECTS</h1>
                </div>

                <div id="subjectList" class="subject-grid">
                    <!-- Cards will be loaded here -->
                </div>
            </div>

            <!---MY GRADES PAGE--->
            <div id="gradeSubmission-page" class="page-content">
                <div class="main-title">
                    <h1>GRADES SUBMISSION</h1>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Course</label>
                        <select id="gradeCourseFilter" class="form-select">
                            <option value="">Select Course</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Semester</label>
                        <select id="gradeSemesterFilter" class="form-select">
                            <option value="">Select Semester</option>
                            <option value="1">1st</option>
                            <option value="2">2nd</option>
                            <option value="3">3rd</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Subject</label>
                        <select id="gradeSubjectFilter" class="form-select">
                            <option value="">Select Subject</option>
                        </select>
                    </div>
                </div>

                <div id="gradesSubmissionContainer"></div>

            </div>

            <!---EDIT PROFILE PAGE--->
            <div id="editFacultyProfile-page" class="page-content">
                <div class="main-title">
                    <h1>EDIT PROFILE</h1>
                </div>
                <div class="container mt-4">
                    <form id="editProfileForm" enctype="multipart/form-data" class="card p-4 shadow-sm">
                        <input type="hidden" name="id" id="editProfileId" />

                        <div class="text-center mb-3">
                            <img id="editProfilePhotoPreview" src="uploads/students/default.png" class="rounded-circle" width="120" height="120" style="object-fit: cover;" />
                            <div class="mt-2">
                                <input type="file" name="photo" id="editProfilePhoto" class="form-control form-control-sm" />
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Editable Fields -->
                            <div class="col-md-6">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="first_name" id="editProfileFirstName" required />
                            </div>
                            <div class="col-md-6">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" name="middle_name" id="editProfileMiddleName" />
                            </div>
                            <div class="col-md-6">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="editProfileLastName" required />
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" id="editProfileEmail" required />
                            </div>
                            <div class="col-md-6">
                                <label>New Password (optional)</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="editProfilePassword" />
                                    <span class="input-group-text toggle-password" onclick="togglePassword('editProfilePassword')">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Non-editable Fields (Separate Row for Balance) -->
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label>School ID</label>
                                <input type="text" class="form-control" id="editProfileSchoolId" disabled />
                            </div>
                            <div class="col-md-4">
                                <label>Course</label>
                                <input type="text" class="form-control" id="editProfileCourse" disabled />
                            </div>
                            <div class="col-md-4">
                                <label>Year Level</label>
                                <input type="text" class="form-control" id="editProfileYear" disabled />
                            </div>
                        </div>


                        <div class="mt-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">💾 Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>



        </main> <!---END OF MAIN CONTAINER--->
    </div> <!---END OF GRID CONTAINER--->

    <!-- Global loading overlay -->
    <div id="loadingOverlay">
        <div class="spinner-border text-light" role="status"></div>
    </div>

    <!-- Order is important! -->
    <script src="javascripts/loadFacultySubjects.js"></script> <!-- required first -->
    <script src="javascripts/gradeSubmission.js"></script> <!-- required first -->
    <script src="javascripts/loadingOverlay.js"></script> <!-- required first -->
    <script src="javascripts/courseSubject.js"></script>
    <script src="javascripts/sidebar.js"></script>
    <script src="javascripts/togglePassword.js"></script>


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