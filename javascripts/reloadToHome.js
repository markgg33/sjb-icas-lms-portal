// JavaScript function to redirect to login.php after 3 seconds
function redirectToHome() {
  setTimeout(function () {
    window.location.href = "login_page.php";
  }, 3000); // 1000 milliseconds = 1 second
}

// Call the redirectToHome function when the page loads
window.onload = redirectToHome;
