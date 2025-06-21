document.addEventListener("DOMContentLoaded", () => {
  loadFacultyDashboardCards();
  loadFacultySubjectsChart();
});

function loadFacultyDashboardCards() {
  fetch("get_faculty_dashboard_counts.php")
    .then((res) => res.json())
    .then((data) => {
      document.getElementById("assignedSubjectsCount").textContent =
        data.subjects;
      document.getElementById("studentsHandledCount").textContent =
        data.students;
      document.getElementById("pendingFacultyRequestsCount").textContent =
        data.requests;
    });
}

function loadFacultySubjectsChart() {
  fetch("get_students_per_subject_faculty.php")
    .then((res) => res.json())
    .then((data) => {
      const labels = data.map((d) => d.subject_code);
      const values = data.map((d) => d.student_count);
      const ctx = document
        .getElementById("facultySubjectsChart")
        .getContext("2d");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels,
          datasets: [
            {
              label: "Students per Subject",
              data: values,
              backgroundColor: "rgba(153, 102, 255, 0.6)",
              borderColor: "rgba(153, 102, 255, 1)",
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false },
          },
          scales: {
            y: {
              beginAtZero: true,
              title: { display: true, text: "Students" },
            },
            x: {
              title: { display: true, text: "Subjects" },
            },
          },
        },
      });
    });
}
