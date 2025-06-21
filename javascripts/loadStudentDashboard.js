function loadStudentDashboard() {
  fetch("get_loggedin_student.php")
    .then((res) => res.json())
    .then((s) => {
      if (s.error) {
        console.error("Student not logged in");
        return;
      }

      // 🖼️ Photo fallback
      const photoSrc =
        s.photo && s.photo.trim() !== ""
          ? s.photo
          : "uploads/students/default.png";

      // 🎓 Update the student dashboard card
      const studentPhoto = document.getElementById("studentPhoto");
      const studentName = document.getElementById("studentName");
      const studentCourseYear = document.getElementById("studentCourseYear");

      if (studentPhoto) studentPhoto.src = photoSrc;
      if (studentName)
        studentName.textContent = `${s.first_name} ${s.last_name}`;
      if (studentCourseYear)
        studentCourseYear.textContent = `${s.course_name} - Year ${s.year_level}`;
    })
    .catch((err) => {
      console.error("❌ Failed to load dashboard student info:", err);
    });
}

//FOR LOADING STUDENT DASHBOARD CHART

function loadSubjectLoadChart() {
  fetch("get_subjects_per_semester.php")
    .then((res) => res.json())
    .then((data) => {
      const labels = data.map((d) => `Semester ${d.semester}`);
      const values = data.map((d) => d.subject_count);

      const ctx = document.getElementById("subjectLoadChart").getContext("2d");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: labels,
          datasets: [
            {
              label: "Enrolled Subjects",
              data: values,
              backgroundColor: "rgba(75, 192, 192, 0.6)",
              borderColor: "rgba(75, 192, 192, 1)",
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false },
            tooltip: { mode: "index", intersect: false },
          },
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: "Subjects",
              },
            },
            x: {
              title: {
                display: true,
                text: "Semester",
              },
            },
          },
        },
      });
    })
    .catch((err) => {
      console.error("Chart load error:", err);
    });
}

document.addEventListener("DOMContentLoaded", loadSubjectLoadChart);
