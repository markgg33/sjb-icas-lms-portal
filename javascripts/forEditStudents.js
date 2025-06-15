let selectedStudentId = null;

document.getElementById("searchBtn").addEventListener("click", () => {
  const query = document.getElementById("searchInput").value.trim();
  if (!query) return;

  showLoading();

  fetch(`search_students.php?name=${encodeURIComponent(query)}`)
    .then((res) => res.json())
    .then((data) => {
      const results = document.getElementById("studentResults");
      results.innerHTML = "";

      // Clear old data
      document.getElementById("studentInfo").classList.add("d-none");
      document.querySelector("#subjectTable tbody").innerHTML = "";
      selectedStudentId = null;

      if (data.length === 0) {
        results.innerHTML = `<div class="text-muted px-2">No students found.</div>`;
      } else {
        data.forEach((student) => {
          const item = document.createElement("button");
          item.className = "list-group-item list-group-item-action";
          item.textContent = `${student.full_name} - ${student.course_name} (${student.year_level})`;
          item.addEventListener("click", () => loadStudentDetails(student));
          results.appendChild(item);
        });
      }

      setTimeout(() => hideLoading(), 500); // Delay for smoother UX
    })
    .catch((err) => {
      console.error("Search error:", err);
      hideLoading();
      alert("An error occurred during search.");
    });
});

function loadStudentDetails(student) {
  selectedStudentId = student.id;
  document.getElementById("studentName").textContent = student.full_name;
  document.getElementById(
    "studentCourseYear"
  ).textContent = `${student.course_name} - ${student.year_level}`;
  document.getElementById("studentInfo").classList.remove("d-none");

  showLoading();

  fetch("get_student_subjects.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `student_id=${student.id}`,
  })
    .then((res) => res.json())
    .then((data) => {
      const tableBody = document.querySelector("#subjectTable tbody");
      tableBody.innerHTML = "";

      // Step 1: Group subjects by semester
      const grouped = {};
      data.subjects.forEach((subject) => {
        if (!grouped[subject.semester]) {
          grouped[subject.semester] = [];
        }
        grouped[subject.semester].push(subject);
      });

      // Step 2: Sort semesters (optional, you can define your own order)
      const sortedSemesters = Object.keys(grouped).sort();

      // Step 3: Render grouped rows
      sortedSemesters.forEach((semester) => {
        // Add semester label row (spanning full table)
        const semesterRow = document.createElement("tr");
        semesterRow.innerHTML = `
          <td colspan="7" class="table-secondary fw-bold text-uppercase">Semester ${semester}</td>
        `;
        tableBody.appendChild(semesterRow);

        // Add subject rows
        grouped[semester].forEach((subject) => {
          const row = document.createElement("tr");
          row.innerHTML = `
  <td>${subject.code}</td>
  <td>${subject.name}</td>
  <td>${subject.units}</td>
  <td>${subject.semester}</td>
  <td>${subject.school_year}</td>
  <td>${subject.date_enrolled}</td>
  <td>
    <button class="btn btn-sm btn-danger remove-subject-btn"
      data-subject="${subject.id}"
      data-code="${subject.code}"
      data-units="${subject.units}"
      data-semester="${subject.semester}">
      Remove
    </button>
  </td>
`;

          tableBody.appendChild(row);
        });
      });

      // Re-bind remove buttons
      document.querySelectorAll(".remove-subject-btn").forEach((button) => {
        button.addEventListener("click", (e) => {
          const subjectId = e.target.getAttribute("data-subject");
          const semester = e.target.getAttribute("data-semester");
          const subjectCode = e.target.getAttribute("data-code");
          if (confirm(`Remove subject ${subjectCode}?`)) {
            removeSubject(subjectId, semester);
          }
        });
      });

      setTimeout(() => hideLoading(), 500);
    });

  // Load balance
  /*fetch(`get_balance.php?student_id=${student.id}`)
    .then((res) => res.json())
    .then((data) => {
      document.getElementById("balanceInput").value = data.balance ?? 0;
    });*/
  fetch(`get_balance.php?student_id=${selectedStudentId}`)
    .then((res) => res.json())
    .then((data) => {
      document.getElementById("balanceInput").value = data.balance ?? 0;
    });
}

function removeSubject(subjectId, semester) {
  showLoading();
  fetch("remove_student_subject.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `student_id=${selectedStudentId}&subject_id=${subjectId}&semester=${semester}`,
  })
    .then((res) => res.json())
    .then((response) => {
      setTimeout(() => {
        hideLoading();
        if (response.status === "success") {
          alert("Subject removed from student.");
          loadStudentDetails({ id: selectedStudentId }); // Refresh subject list
        } else {
          alert("Error: " + response.message);
        }
      }, 500);
    });
}

/*document.getElementById("saveBalanceBtn").addEventListener("click", () => {
  const newBalance = parseFloat(document.getElementById("balanceInput").value);
  showLoading();
  fetch("update_balance.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `student_id=${selectedStudentId}&new_balance=${newBalance}`,
  })
    .then((res) => res.json())
    .then((response) => {
      setTimeout(() => {
        hideLoading();
        if (response.status === "success") {
          alert("Balance updated.");
        } else {
          alert("Error: " + response.message);
        }
      }, 500);
    });
});*/

// PHP USED HERE IN FOR EDITSTUDENTS
// search_student.php, get_student_subjects.php, get_balance.php, remove_student_subject.php, update_balance.php
