async function loadFacultyDropdown() {
  const res = await fetch("get_faculty_list.php");
  const data = await res.json();
  const dropdown = document.getElementById("facultyDropdown");
  dropdown.innerHTML = `<option value="">-- Select Faculty --</option>`;
  data.forEach((f) => {
    dropdown.innerHTML += `<option value="${f.id}">${f.name}</option>`;
  });
}

async function loadFacultySubjectsById(facultyId) {
  const res = await fetch(
    `admin_get_faculty_subjects_by_id.php?faculty_id=${facultyId}`
  );
  const subjects = await res.json();

  const container = document.getElementById("facultySubjectsContainer");
  if (!subjects.length) {
    container.innerHTML = `<div class="alert alert-warning">No subjects assigned to this faculty.</div>`;
    return;
  }

  const grouped = { 1: [], 2: [], 3: [] };
  subjects.forEach((s) => grouped[s.semester].push(s));

  let html = "";

  for (const sem of ["1", "2", "3"]) {
    if (grouped[sem].length > 0) {
      html += `
          <div class="card mb-3">
            <div class="card-header bg-primary text-white">Semester ${sem}</div>
            <ul class="list-group list-group-flush">
              ${grouped[sem]
                .map(
                  (
                    s
                  ) => `<li class="list-group-item d-flex justify-content-between align-items-center">
                          <div>
                            <strong>${s.code}</strong> - ${s.name}
                            <div class="text-muted small">${s.course_name} (${s.school_year})</div>
                          </div>
                          <button class="btn btn-sm btn-danger" onclick="removeFacultySubject(${s.assignment_id})">🗑 Remove</button>
                        </li>`
                )
                .join("")}
            </ul>
          </div>
        `;
    }
  }

  container.innerHTML = html;
}

function removeFacultySubject(id) {
  if (
    !confirm("Are you sure you want to remove this subject from the faculty?")
  )
    return;

  fetch("remove_faculty_subject.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "id=" + id,
  })
    .then((res) => res.json())
    .then((data) => {
      alert(data.message);
      const facultyId = document.getElementById("facultyDropdown").value;
      if (facultyId) loadFacultySubjectsById(facultyId);
    });
}

// Events
document
  .getElementById("facultyDropdown")
  .addEventListener("change", function () {
    const facultyId = this.value;
    if (facultyId) loadFacultySubjectsById(facultyId);
    else document.getElementById("facultySubjectsContainer").innerHTML = "";
  });

// Real-time refresh
setInterval(() => {
  if ($("#editFacultySubjects-page").is(":visible")) {
    const fid = $("#facultyDropdown").val();
    if (fid) loadFacultySubjectsById(fid);
  }
}, 5000);

// On page load
loadFacultyDropdown();
