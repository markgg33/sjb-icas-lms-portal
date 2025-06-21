document.addEventListener("DOMContentLoaded", () => {
  fetch("get_dashboard_counts.php")
    .then((res) => res.json())
    .then((data) => {
      document.getElementById("studentsEnrolledCount").textContent =
        data.students;
      document.getElementById("subjectsCount").textContent = data.subjects;
      document.getElementById("coursesCount").textContent = data.courses;
      document.getElementById("pendingRequestsCount").textContent =
        data.pending_requests;
      document.getElementById("assignedFacultyCount").textContent =
        data.assigned_faculty;
    })
    .catch((err) => {
      console.error("Error fetching dashboard counts:", err);
      const fields = [
        "studentsEnrolledCount",
        "subjectsCount",
        "coursesCount",
        "pendingRequestsCount",
        "assignedFacultyCount",
      ];
      fields.forEach((id) => {
        const el = document.getElementById(id);
        if (el) el.textContent = "Error";
      });
    });
});

//FOR CHART

function loadStudentsPerCourseChart() {
  fetch("get_students_per_course_year.php")
    .then((res) => res.json())
    .then((data) => {
      const labels = data.map((item) => item.label);
      const counts = data.map((item) => item.count);

      const ctx = document
        .getElementById("studentsPerCourseChart")
        .getContext("2d");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: labels,
          datasets: [
            {
              label: "Number of Students",
              data: counts,
              backgroundColor: "rgba(75, 192, 192, 0.7)",
              borderColor: "rgba(75, 192, 192, 1)",
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            tooltip: {
              callbacks: {
                label: (ctx) => `${ctx.parsed.y} students`,
              },
            },
          },
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: "Students",
              },
            },
            x: {
              title: {
                display: true,
                text: "Course - Year Level",
              },
            },
          },
        },
      });
    });
}

document.addEventListener("DOMContentLoaded", loadStudentsPerCourseChart);
