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
    <title>Student Dashboard</title>
    <script src="https://kit.fontawesome.com/92cde7fc6f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!---------------------------->
    <link rel="icon" type="image/x-icon" href="images/sjb-logo.ico">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
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
                        <li class="sidebar-list-item" data-page="mySubjects" onclick="changePage('mySubjects')">My Subjects</li>
                        <li class="sidebar-list-item" data-page="myGrades" onclick="changePage('myGrades')">My Grades</li>

                    </ul>
                </li>

                <!----SYSTEM SETTINGS---->
                <li>
                    <a class="sidebar-dropdown d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#systemSettingsSubMenu" role="button" aria-expanded="false" aria-controls="systemSettingsSubMenu">
                        <span><i class="fa-solid fa-school"></i>SYSTEM SETTINGS</span>
                        <i class="fa-solid fa-caret-down"></i>
                    </a>

                    <ul class="collapse sidebar-submenu list-unstyled ps-3" id="systemSettingsSubMenu">
                        <li class="sidebar-list-item" data-page="editProfile" onclick="changePage('editProfile')">Edit Profile</li>
                        <li class="sidebar-list-item" data-page="requests" onclick="changePage('requests')">Request Requirements</li>
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
            <div id="myGrades-page" class="page-content">
                <div class="main-title">
                    <h1>MY GRADES</h1>
                </div>

                <div id="gradesContainer">
                    <!-- Grades or warning will load here -->
                </div>
            </div>

            <!---EDIT PROFILE PAGE--->
            <div id="editProfile-page" class="page-content">
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

            <!-- REQUEST PAGE FOR STUDENTS -->
            <div id="requests-page" class="page-content">
                <div class="main-title">
                    <h1>REQUESTS</h1>
                </div>
                <form id="studentRequestForm" class="card p-3 mb-4">
                    <label>Type</label>
                    <select name="type" class="form-select" required>
                        <option value="Good Moral">Good Moral</option>
                        <option value="TOR">Transcript of Records</option>
                        <option value="Grades">Grades</option>
                    </select>
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                    <button type="submit" class="btn btn-primary mt-3">Submit Request</button>
                </form>
                <div id="studentRequestsList"></div>
            </div>



        </main> <!---END OF MAIN CONTAINER--->
    </div> <!---END OF GRID CONTAINER--->

    <!-- Global loading overlay -->
    <div id="loadingOverlay">
        <div class="spinner-border text-light" role="status"></div>
    </div>

    <!-- Javascripts here -->
    <script src="javascripts/loadingOverlay.js"></script> <!-- required first -->
    <script src="javascripts/loadStudentProfile.js"></script>
    <script src="javascripts/courseSubject.js"></script>
    <script src="javascripts/sidebar.js"></script>
    <script src="javascripts/togglePassword.js"></script>
    <script src="javascripts/requests/notifications.js"></script>
    <script src="javascripts/requests/studentDashboard.js"></script>

    <!-- Requests JS -->

    <script src="javascripts/requests/studentRequests.js"></script>


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