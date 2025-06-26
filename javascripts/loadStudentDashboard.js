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
        type: "pie",
        data: {
          labels: labels,
          datasets: [
            {
              label: "Enrolled Subjects",
              data: values,
              backgroundColor: [
                "rgba(75, 192, 192, 0.6)",
                "rgba(255, 99, 132, 0.6)",
                "rgba(255, 206, 86, 0.6)",
                "rgba(153, 102, 255, 0.6)",
                "rgba(54, 162, 235, 0.6)",
                "rgba(255, 159, 64, 0.6)",
              ],
              borderColor: "#fff",
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: "bottom",
              labels: {
                padding: 20,
                boxWidth: 20,
              },
            },
            tooltip: {
              callbacks: {
                label: function (context) {
                  return `${context.label}: ${context.raw} subjects`;
                },
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
