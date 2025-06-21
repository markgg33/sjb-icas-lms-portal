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

//FOR BAR GRAPH (WORKING)

/*function loadStudentsPerCourseChart() {
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

document.addEventListener("DOMContentLoaded", loadStudentsPerCourseChart);*/

let studentsChartInstance = null;

function loadStudentsPerCourseChart() {
  if (studentsChartInstance) {
    studentsChartInstance.destroy();
  }

  fetch("get_students_per_course_year.php")
    .then((res) => res.json())
    .then((data) => {
      const labels = data.map((item) => item.label);
      const counts = data.map((item) => item.count);

      const ctx = document
        .getElementById("studentsPerCourseChart")
        .getContext("2d");

      studentsChartInstance = new Chart(ctx, {
        type: "pie",
        data: {
          labels: labels,
          datasets: [
            {
              label: "Number of Students",
              data: counts,
              backgroundColor: generateColors(labels.length),
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            tooltip: {
              callbacks: {
                label: (ctx) => `${ctx.label}: ${ctx.parsed} students`,
              },
            },
            legend: {
              display: false, // Hide built-in legend
            },
          },
        },
        plugins: [generateCustomLegend],
      });
    });
}

function generateColors(length) {
  const palette = [
    "#4dc9f6",
    "#f67019",
    "#f53794",
    "#537bc4",
    "#acc236",
    "#166a8f",
    "#00a950",
    "#58595b",
    "#8549ba",
    "#ffc107",
    "#36a2eb",
    "#ff6384",
  ];
  return Array.from({ length }, (_, i) => palette[i % palette.length]);
}

// Custom legend plugin for cleaner design
const generateCustomLegend = {
  id: "custom_legend",
  afterUpdate(chart) {
    const legendContainer = document.getElementById("chartLegend");
    const labels = chart.data.labels;
    const bgColors = chart.data.datasets[0].backgroundColor;

    legendContainer.innerHTML = labels
      .map(
        (label, i) => `
      <span style="
        display: inline-flex;
        align-items: center;
        margin: 5px 10px;
        white-space: nowrap;
      ">
        <span style="
          display: inline-block;
          width: 12px;
          height: 12px;
          background-color: ${bgColors[i]};
          border-radius: 50%;
          margin-right: 8px;
        "></span>
        ${label}
      </span>
    `
      )
      .join("");
  },
};

document.addEventListener("DOMContentLoaded", loadStudentsPerCourseChart);
