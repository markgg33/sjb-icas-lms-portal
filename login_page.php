<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJB ICAS Learning Management System</title>
    <script src="https://kit.fontawesome.com/92cde7fc6f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Madimi+One&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/x-icon" href="images/sjb-logo.ico">
    <!----AOS LIBRARY---->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    <div class="login-page-container">

        <div class="login-left" data-aos="fade-right">
            <div class="login-form">
                <img src="css/sjb-logo.png" alt="" width="150px">
                <br>
                <form method="POST" action="login.php">
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" required>
                            <span class="input-group-text toggle-password" onclick="togglePassword('password')">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <!-- User Type -->
                    <select name="user_type" class="form-select" required>
                        <option value="">Select User Type</option>
                        <option value="admin">Admin</option>
                        <option value="faculty">Faculty</option>
                        <option value="student">Student</option>
                    </select>

                    <br>
                    <button type="submit" class="btn-login w-100">Login</button>
                </form>
                <br>
                <a href="registration_page.php">Don't have an account yet? Create one now!</a>
                <br>
                <p>All rights reserved &copy 2025</p>

            </div>
        </div>

        <div class="image-right" data-aos="fade-left">

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

</body>

</html>