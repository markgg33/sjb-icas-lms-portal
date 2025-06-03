document.addEventListener("DOMContentLoaded", () => {
  fetch("get_dashboard_counts.php")
    .then((res) => res.json())
    .then((data) => {
      document.getElementById("studentsEnrolledCount").textContent = data.students;
      document.getElementById("subjectsCount").textContent = data.subjects;
      document.getElementById("coursesCount").textContent = data.courses;
    })
    .catch((err) => {
      console.error("Error fetching dashboard counts:", err);
      document.getElementById("studentsEnrolledCount").textContent = "Error";
      document.getElementById("subjectsCount").textContent = "Error";
      document.getElementById("coursesCount").textContent = "Error";
    });
});
