<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saint John Bosco x Infotech College of Arts and Sciences</title>
    <script src="https://kit.fontawesome.com/92cde7fc6f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Madimi+One&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/registration.css">
    <!----AOS LIBRARY---->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    <div class="bg-image"></div>

    <div class="registration-page-container">
        <div class="registration-form" data-aos="fade-right">
            <img src="css/sjb-logo.png" alt="" width="150px">
            <br>
            <form id="enrollForm" enctype="multipart/form-data" method="POST" action="enroll_students.php">
                <div class="row">
                    <div class="col">
                        <label>First Name</label>
                        <div class="input-group">
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col">
                        <label>Middle Name</label>
                        <div class="input-group">
                            <input type="text" name="middle_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col">
                        <label>Last Name</label>
                        <div class="input-group">
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3"></div>
                </div>


                <div class="row">
                    <div class="col">
                        <label>Year Level</label>
                        <select id="year_level" name="year_level" class="form-select" required>
                            <option value="">Select Year Level</option>
                            <option value="12">Grade 12</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                        </select>
                    </div>
                    <div class="col">
                        <label>Course</label>
                        <select id="courseSelect" name="course_id" class="form-select" required>
                            <option value="">Select Course</option>
                            <!---?php include 'get_courses.php'; ?--->
                        </select>
                    </div>
                    <div class="mb-3"></div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" class="form-control" required>
                    </div>
                    <div class="mb-3"></div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" required>
                            <span class="input-group-text toggle-password" onclick="togglePassword('password')">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col">
                        <label>Confirm Password</label>
                        <div class="input-group">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                            <span class="input-group-text toggle-password" onclick="togglePassword('confirm_password')">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3"></div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Student Photo</label>
                        <input type="file" name="photo" class="form-control">
                    </div>
                    <div class="col">

                    </div>
                    <div class="mb-3"></div>
                </div>
                <div class="mb-3"></div>
                <div class="register-btn-container">
                    <a href="login_page.php">Already have an account? Login now!</a>
                    <div class="mb-3"></div>
                    <button type="submit" class="btn-enroll"><i class="fa-solid fa-clipboard-check"></i>Enroll Student</button>
                </div>
            </form>
        </div>
    </div>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 100, // Start animation 100px before the section is in view
            duration: 800, // Animation duration in milliseconds
            easing: 'ease-in-out', // Smooth transition effect
        });
    </script>
    <script src="javascripts/togglePassword.js"></script>
    <script src="javascripts/courseSubject.js"></script>
    <script src="javascripts/studentRegistration.js"></script>
    <?php include "registrationModal.php" ?>

</body>

</html>