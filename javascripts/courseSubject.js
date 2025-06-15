$(document).ready(function () {
  // ================================
  // Load All Courses on Page Load
  // ================================
  function loadCourses() {
    $.get("get_courses.php", function (data) {
      $("#courseSelect").html(data);
    });
  }

  // ================================
  // Load Subjects by Selected Semester
  // ================================
  $("#semesterSelect").change(function () {
    const semester = $(this).val();
    loadSubjectsBySemester(semester);
  });

  function loadSubjectsBySemester(semester) {
    if (!semester) {
      $("#subjectCheckboxes").html("");
      return;
    }

    $.get("get_subjects_by_sem.php?semester=" + semester, function (data) {
      $("#subjectCheckboxes").html(data);
    });
  }

  // ================================
  // Load Courses Dynamically Based on Selected Year Level
  // ================================
  $("#year_level").change(function () {
    const yearLevel = $(this).val();
    if (yearLevel) {
      $.ajax({
        url: "get_courses_by_year.php",
        method: "GET",
        data: { year_level: yearLevel },
        success: function (response) {
          $("#courseSelect").html(
            '<option value="">Select Course</option>' + response
          );
        },
        error: function () {
          alert("Failed to load courses.");
        },
      });
    } else {
      $("#courseSelect").html('<option value="">Select Course</option>');
    }
  });

  // ================================
  // Handle Course Form Submission
  // ================================
  $("#courseForm").submit(function (e) {
    e.preventDefault();
    $.post("add_course.php", $(this).serialize(), function (res) {
      if (res === "duplicate") {
        alert("Course already exists.");
      } else {
        alert("Course added successfully.");
        $("#courseForm")[0].reset();
        loadCourses();
      }
    });
  });

  // ================================
  // Handle Subject Form Submission
  // ================================
  $("#subjectForm").submit(function (e) {
    e.preventDefault();

    if (!confirm("Confirm added subjects?")) return;

    const data = $(this).serialize();
    $.post("add_subject.php", data, function (res) {
      const result = JSON.parse(res);
      alert(
        `Added: ${result.inserted}, Skipped (duplicates): ${result.skipped}`
      );
      $("#subjectForm")[0].reset();
      $("#subjectForm .subject-group-creation").slice(1).remove();
    });
  });

  // ================================
  // Assign Subjects to Course by Semester
  // ================================
  $("#assignForm").submit(function (e) {
    e.preventDefault();
    const course_id = $("#courseSelect").val();
    const semester = $("#semesterSelect").val();
    const subject_ids = $('input[name="subject_ids[]"]:checked')
      .map(function () {
        return this.value;
      })
      .get();

    if (!course_id || !semester || subject_ids.length === 0) {
      alert("Please select a course, semester, and subjects.");
      return;
    }

    $.post(
      "assign_subject.php",
      {
        course_id: course_id,
        semester: semester,
        subject_ids: subject_ids,
      },
      function (res) {
        if (res === "success") {
          alert("Subjects assigned!");
        } else if (res === "no_changes") {
          alert("All selected subjects are already assigned.");
        } else {
          alert("Failed to assign subjects.");
        }
        $("#assignForm")[0].reset();
      }
    );
  });

  // ================================
  // Add New Subject Input Row
  // ================================
  $("#addMoreSubject").click(function () {
    const html = `
  <div class="row subject-group-creation mt-2">
    <div class="col-3">
      <input type="text" name="subject_codes[]" class="form-control" placeholder="Subject Code" required>
    </div>
    <div class="col-3">
      <input type="text" name="subject_names[]" class="form-control" placeholder="Subject Name" required>
    </div>
    <div class="col-3">
      <select name="subject_semesters[]" class="form-control" required>
        <option value="">Select Semester</option>
        <option value="1">1st Sem</option>
        <option value="2">2nd Sem</option>
        <option value="3">3rd Sem</option>
      </select>
    </div>
    <div class="col-2">
      <input type="number" name="subject_units[]" class="form-control" placeholder="Units" min="2" max="9" required>
    </div>
    <div class="col">
      <button type="button" class="btn btn-danger removeSubject"><i class="fa-solid fa-trash"></i></button>
    </div>
  </div>
`;
    $("#subjectFormRows").append(html);
  });

  // ================================
  // Remove Subject Input Row
  // ================================
  $(document).on("click", ".removeSubject", function () {
    $(this).closest(".subject-group-creation").remove();
  });

  // Initial Load

  if ($("#courseSelect").length > 0 && $("#year_level").length === 0) {
    loadCourses(); // Load all courses only if #year_level is NOT present (e.g. course management page)
  }
});

//FUNCTION FOR ENROLLCOURSESELECT

// Load courses into enrollCourseSelect
$.get("get_courses.php", function (data) {
  $("#enrollCourseSelect").append(data);
});

// When course or semester changes, load subjects
$("#enrollCourseSelect, #enrollSemesterSelect").change(function () {
  const courseId = $("#enrollCourseSelect").val();
  const semester = $("#enrollSemesterSelect").val();

  if (courseId && semester) {
    $.get(
      "get_subjects_by_course_sem.php",
      { course_id: courseId, semester: semester },
      function (data) {
        $("#enrollSubjectCheckboxes").html(data);
      }
    );
  } else {
    $("#enrollSubjectCheckboxes").html("");
  }
});

//Second version
$("#enrollSubjectsForm").submit(function (e) {
  e.preventDefault();

  const studentId = $("#selectedStudentId").val();
  const semester = $("#enrollSemesterSelect").val();
  const subjectIds = $('input[name="subject_ids[]"]:checked')
    .map(function () {
      return this.value;
    })
    .get();

  if (!studentId) {
    alert("Please select a student before enrolling subjects.");
    return;
  }

  if (!semester) {
    alert("Please select a semester.");
    return;
  }

  if (subjectIds.length === 0) {
    alert("Please select at least one subject.");
    return;
  }

  $.post(
    "enroll_subjects.php",
    {
      student_id: studentId,
      semester: semester,
      subject_ids: subjectIds,
    },
    function (res) {
      try {
        const result = JSON.parse(res);
        alert(
          `Enrolled: ${result.inserted}, Skipped (already enrolled): ${result.skipped}`
        );
        $("#enrollSubjectsForm")[0].reset();
        $("#enrollSubjectCheckboxes").html("");
        $("#selectedStudentName").text("None");
        $("#selectedStudentId").val("");
        $("#studentSearchResults").html("");
      } catch (err) {
        console.error("JSON Parse error:", err, res);
        alert("Unexpected response from server. Check console for details.");
      }
    }
  ).fail(function (xhr) {
    console.error("AJAX error:", xhr.responseText);
    alert("Failed to enroll subjects. Check console for errors.");
  });
});

//FOR LOADING SUBJECTS TO STUDENTDASHBOARD

document.addEventListener("DOMContentLoaded", () => {
  fetch("get_student_subjects.php")
    .then((res) => res.json())
    .then((data) => {
      const subjectList = document.getElementById("subjectList");
      subjectList.innerHTML = "";

      // Add course title
      const courseTitle = document.createElement("h2");
      courseTitle.textContent = `Course: ${data.course_name}`;
      courseTitle.classList.add("course-title");
      subjectList.parentElement.insertBefore(courseTitle, subjectList);

      // 📘 Group grades by semester + SY
      const grouped = {};
      data.subjects.forEach((sub) => {
        const groupKey = `${sub.semester} - S.Y. ${sub.school_year}`;
        if (!grouped[groupKey]) {
          grouped[groupKey] = [];
        }
        grouped[groupKey].push(sub);
      });

      // Render each group as a modern table
      for (const groupTitle in grouped) {
        const groupBlock = document.createElement("div");
        groupBlock.className = "semester-block";

        groupBlock.innerHTML = `
          <h3 class="semester-title">${groupTitle}</h3>
          <div class="subjects-table-wrapper">
            <table class="subjects-table">
              <thead>
                <tr>
                  <th>Subject Code</th>
                  <th>Subject Name</th>
                  <th>Date Enrolled</th>
                </tr>
              </thead>
              <tbody>
                ${grouped[groupTitle]
                  .map(
                    (sub) => `
                    <tr>
                      <td>${sub.code}</td>
                      <td>${sub.name}</td>
                      <td>${sub.date_enrolled}</td>
                    </tr>
                  `
                  )
                  .join("")}
              </tbody>
            </table>
          </div>
        `;

        subjectList.appendChild(groupBlock);
      }
    })
    .catch((err) => {
      console.error("Error loading subjects:", err);
      subjectList.innerHTML = `<div class="error-message">Failed to load subjects.</div>`;
    });
});

//FETCH GRADES FOR FRONTEND
fetch("get_grades.php")
  .then((res) => res.json())
  .then((data) => {
    const gradeContainer = document.getElementById("gradesContainer");
    gradeContainer.innerHTML = "";

    if (data.blocked) {
      gradeContainer.innerHTML = `<div class="balance-warning">${data.message}</div>`;
      return;
    }

    if (data.error) {
      gradeContainer.innerHTML = `<div class="error-message">${data.error}</div>`;
      return;
    }

    if (!data.length) {
      gradeContainer.innerHTML = `<div class="no-grades">No grades found.</div>`;
      return;
    }

    // 🏷️ Display course title once at the top
    const courseTitle = document.createElement("h2");
    courseTitle.className = "course-title";
    courseTitle.textContent = `Course: ${data[0].name}`;
    gradeContainer.appendChild(courseTitle);

    // 📘 Group grades by semester + SY
    const grouped = {};
    data.forEach((grade) => {
      const key = `${grade.semester} - S.Y. ${grade.school_year}`;
      if (!grouped[key]) grouped[key] = [];
      grouped[key].push(grade);
    });

    // 📊 Render each semester block with a modern table
    for (const group in grouped) {
      const semesterSection = document.createElement("div");
      semesterSection.className = "semester-block";

      semesterSection.innerHTML = `
        <h3 class="semester-title">${group}</h3>
        <div class="table-responsive">
          <table class="grades-table modern">
            <thead>
              <tr>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Grade</th>
              </tr>
            </thead>
            <tbody>
              ${grouped[group]
                .map(
                  (g) => `
                    <tr>
                      <td>${g.code}</td>
                      <td>${g.subject_name}</td>
                      <td class="${g.grade ? "" : "missing-grade"}">
                        ${g.grade ?? "Not yet recorded"}
                      </td>
                    </tr>`
                )
                .join("")}
            </tbody>
          </table>
        </div>
      `;

      gradeContainer.appendChild(semesterSection);
    }
  })
  .catch((err) => {
    console.error("Grade fetch failed", err);
    document.getElementById(
      "gradesContainer"
    ).innerHTML = `<div class="error-message">Failed to load grades.</div>`;
  });

//REGISTER FACULTIES AND ADMIN

document.getElementById("addUserForm").addEventListener("submit", function (e) {
  e.preventDefault();

  if (!confirm("Are you sure you want to add this user?")) return;

  showLoading();

  const formData = new FormData(this);

  fetch("add_user.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      const result = document.getElementById("addUserResult");
      result.textContent = data.message;
      result.className =
        data.status === "success" ? "text-success" : "text-danger";

      // Delay hiding the overlay for better visual feedback
      setTimeout(() => {
        hideLoading();
        if (data.status === "success") {
          document.getElementById("addUserForm").reset();
          loadUsers(); // refresh table if implemented
        }
      }, 500);
    })
    .catch((err) => {
      console.error("Fetch error:", err);
      hideLoading();
      const result = document.getElementById("addUserResult");
      result.textContent = "Something went wrong. Please try again.";
      result.className = "text-danger";
    });
});

//LOAD USERS INTO TABLE

function loadUsers() {
  fetch("get_users.php")
    .then((res) => res.json())
    .then((users) => {
      const tbody = document.querySelector("#usersTable tbody");
      tbody.innerHTML = "";

      users.forEach((user) => {
        const row = document.createElement("tr");
        const photo = user.photo ? user.photo : "uploads/students/default.png";
        row.innerHTML = `
  <td>
    <img src="${photo}" class="rounded-circle me-2" width="40" height="40" style="object-fit:cover;" />
    ${user.full_name}
  </td>
  <td>${user.gender}</td>
  <td>${user.email}</td>
  <td>${user.role}</td>
  <td>
   <button class="btn btn-sm btn-warning me-2" onclick="editUser(${user.id}, '${
          user.first_name
        }', '${user.middle_name}', '${user.last_name}', '${user.gender}', '${
          user.email
        }', '${user.role}', '${user.photo || ""}')">✏️ Edit</button>
    <button class="btn btn-sm btn-danger" onclick="deleteUser(${
      user.id
    })">🗑️ Delete</button>
  </td>
`;
        tbody.appendChild(row);
      });
    });
}

// Load users on page load
loadUsers();

//EDIT USER FUNCTION HERE

function editUser(id, first, middle, last, gender, email, role, photo) {
  document.getElementById("editUserId").value = id;
  document.getElementById("editFirstName").value = first;
  document.getElementById("editMiddleName").value = middle;
  document.getElementById("editLastName").value = last;
  document.getElementById("editGender").value = gender;
  document.getElementById("editEmail").value = email;
  document.getElementById("editRole").value = role;

  // 👇 Update photo preview
  document.getElementById("editUserPhotoPreview").src =
    photo || "uploads/users/default.png";

  new bootstrap.Modal(document.getElementById("editUserModal")).show();
}

//EDIT SUBMISSION HERE

document
  .getElementById("editUserForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch("update_user.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        alert(data.message);
        if (data.status === "success") {
          document.querySelector("#editUserModal .btn-close").click();
          loadUsers();
        }
      });
  });

// DELETE HANDLER HERE

function deleteUser(id) {
  if (confirm("Are you sure you want to delete this user?")) {
    fetch("delete_user.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "id=" + id,
    })
      .then((res) => res.json())
      .then((data) => {
        alert(data.message);
        if (data.status === "success") loadUsers();
      });
  }
}

//FOR EDIT SUBJECTS PAGE
$(document).ready(function () {
  $.get("get_courses.php", function (data) {
    $("#editCourseSelect").append(data);
  });

  // Load subjects by selected course
  $("#editCourseSelect").change(function () {
    const courseId = $(this).val();
    if (!courseId) return $("#editSubjectsTableContainer").html("");

    $.ajax({
      url: "get_subjects_by_course.php",
      type: "POST",
      data: { course_id: courseId },
      dataType: "json",
      success: function (subjects) {
        let html = "";
        let hasSubjects = false;

        for (const sem in subjects) {
          if (subjects[sem].length > 0) {
            hasSubjects = true; // At least one subject exists
          }

          html += `
      <h5 class="mt-4">Semester ${sem}</h5>
      <div class="table-responsive">
        <table class="table table-bordered subject-table">
          <thead>
            <tr>
              <th>Subject Code</th>
              <th>Subject Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            ${subjects[sem]
              .map(
                (sub) => `
              <tr data-id="${sub.id}">
                <td><input class="form-control subject-code" value="${
                  sub.subject_code ?? sub.code
                }"></td>
                <td><input class="form-control subject-name" value="${
                  sub.subject_name ?? sub.name
                }"></td>
                <td>
                  <button class="btn btn-success save-subject">Save</button>
                  <button class="btn btn-danger delete-subject">Delete</button>
                </td>
              </tr>
            `
              )
              .join("")}
          </tbody>
        </table>
      </div>`;
        }

        $("#editSubjectsTableContainer").html(html);

        if (hasSubjects) {
          $("#editSubjectsActions").show();
        } else {
          $("#editSubjectsActions").hide();
        }
      },
      error: function (xhr) {
        console.error("AJAX Error:", xhr.responseText);
        $("#editSubjectsTableContainer").html(
          '<div class="text-danger">Failed to load subjects.</div>'
        );
      },
    });
  });

  // Save single subject
  $(document).on("click", ".save-subject", function () {
    if (!confirm("Are you sure you want to save this subject?")) return;

    const row = $(this).closest("tr");
    const id = row.data("id");
    const code = row.find(".subject-code").val();
    const name = row.find(".subject-name").val();

    showLoading();

    $.post("update_subject_field.php", {
      subject_id: id,
      code: code,
      name: name,
    })
      .done(function (res) {
        if (res === "success") {
          row
            .find("input")
            .addClass("border-success")
            .removeClass("border-danger");
          showSuccessModal("Subject saved successfully.");
        } else {
          row
            .find("input")
            .addClass("border-danger")
            .removeClass("border-success");
          alert("Update failed.");
        }
      })
      .fail(function () {
        row
          .find("input")
          .addClass("border-danger")
          .removeClass("border-success");
        alert("AJAX error during update.");
      })
      .always(function () {
        setTimeout(() => {
          hideLoading();
        }, 500);
      });
  });

  // Save all changes
  $("#saveAllSubjectsBtn").click(function () {
    if (!confirm("Are you sure you want to save all changes?")) return;

    const updates = [];

    $(".subject-table tr").each(function () {
      const row = $(this);
      const id = row.data("id");
      if (!id) return;

      const code = row.find(".subject-code").val();
      const name = row.find(".subject-name").val();
      updates.push({ id, code, name });
    });

    if (updates.length === 0) return;

    showLoading();

    $.ajax({
      url: "update_multiple_subjects.php",
      type: "POST",
      data: { updates: JSON.stringify(updates) },
      success: function (res) {
        showSuccessModal("All changes saved successfully.");
      },
      error: function () {
        alert("Error saving changes.");
      },
      complete: function () {
        setTimeout(() => {
          hideLoading();
        }, 500);
      },
    });
  });

  // Delete subject
  $(document).on("click", ".delete-subject", function () {
    if (!confirm("Are you sure you want to delete this subject?")) return;

    const row = $(this).closest("tr");
    const id = row.data("id");

    showLoading();

    $.post("delete_subject.php", { subject_id: id })
      .done(function (res) {
        if (res === "success") {
          row.remove();
          showSuccessModal("Subject deleted successfully.");
        } else {
          alert("Failed to delete subject.");
        }
      })
      .fail(function () {
        alert("AJAX error while deleting.");
      })
      .always(function () {
        setTimeout(() => {
          hideLoading();
        }, 500);
      });
  });
});

//HELPER FOR SUCCESS MODAL

function showSuccessModal(message) {
  $("#successModalMessage").text(message);
  const modal = new bootstrap.Modal(document.getElementById("successModal"));
  modal.show();
}

//FETCHES THE LIST OF STUDENTS

document.addEventListener("DOMContentLoaded", () => {
  fetch("get_students_by_course.php")
    .then((res) => res.json())
    .then((data) => {
      const container = document.getElementById("studentListContainer");
      container.innerHTML = "";

      for (const courseGroup in data) {
        const section = document.createElement("div");
        section.className = "course-group mb-5";

        section.innerHTML = `
          <h3 class="mb-3">${courseGroup}</h3>
          <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
              <thead class="table-light">
                <tr>
                  <th>Photo</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Year Level</th>
                </tr>
              </thead>
              <tbody>
                ${data[courseGroup]
                  .map(
                    (student) => `
                  <tr>
                    <td>
                      <img src="${
                        student.photo || "uploads/students/default.png"
                      }" class="rounded-circle border" width="60" height="60" style="object-fit: cover;">
                    </td>
                    <td>${student.full_name}</td>
                    <td>${student.email}</td>
                    <td>Year ${student.year_level}</td>
                  </tr>
                `
                  )
                  .join("")}
              </tbody>
            </table>
          </div>
        `;

        container.appendChild(section);
      }
    })
    .catch((error) => {
      console.error("Error loading students:", error);
      document.getElementById("studentListContainer").innerHTML =
        "<div class='text-danger'>Failed to load student list.</div>";
    });
});

//FOR FILTER AND PAGINATIONS

// Load courses into dropdown
function loadCoursesToFilter() {
  $.get("get_courses.php", function (data) {
    $("#courseFilter").append(data);
  });
}

// Load students by filters
function loadStudents(page = 1) {
  const search = $("#studentSearchInput").val();
  const courseId = $("#courseFilter").val();

  showLoading(); // Show overlay

  $.get(
    "get_filtered_students.php",
    {
      search: search,
      course_id: courseId,
      page: page,
    },
    function (res) {
      const data = JSON.parse(res);
      const students = data.students;
      const total = data.total;
      const limit = data.limit;
      const currentPage = data.page;

      let tableHtml = `
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>Photo</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Course</th>
              <th>Year Level</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            ${
              students.length > 0
                ? students
                    .map(
                      (s) => `
<tr>
  <td><img src="${
    s.photo || "uploads/students/default.png"
  }" width="50" height="50" class="rounded-circle" style="object-fit: cover;"></td>
  <td>${s.full_name}</td>
  <td>${s.email}</td>
  <td>${s.course}</td>
  <td>Year ${s.year_level}</td>
  <td>
    <button class="btn btn-sm btn-warning edit-student-btn" data-id="${s.id}">
      ✏️ Edit
    </button>
    <button class="btn btn-sm btn-danger delete-student-btn" data-id="${s.id}">
      🗑️ Delete
    </button>
  </td>
</tr>
`
                    )

                    .join("")
                : '<tr><td colspan="5" class="text-center">No students found.</td></tr>'
            }
          </tbody>
        </table>
      </div>
    `;

      $("#studentTableContainer").html(tableHtml);

      // Pagination
      const totalPages = Math.ceil(total / limit);
      let paginationHtml =
        '<nav><ul class="pagination justify-content-center">';

      for (let i = 1; i <= totalPages; i++) {
        paginationHtml += `
        <li class="page-item ${i === currentPage ? "active" : ""}">
          <button class="page-link" onclick="loadStudents(${i})">${i}</button>
        </li>
      `;
      }

      paginationHtml += "</ul></nav>";
      $("#paginationContainer").html(paginationHtml);
    }
  ).always(() => {
    setTimeout(() => hideLoading(), 300); // Delay for better UX
  });
}

// When search button is clicked
$("#searchStudentBtn").click(function () {
  loadStudents(1);
});

// Optional: Enter key triggers search
$("#studentSearchInput").on("keypress", function (e) {
  if (e.which === 13) $("#searchStudentBtn").click();
});

// Clear search and filter
$("#clearStudentFilters").click(function () {
  $("#studentSearchInput").val("");
  $("#courseFilter").val("");
  loadStudents(1);
});

//EDIT DELETE BUTTONS FOR STUDENT LIST / MODAL

// Open modal with data
$(document).on("click", ".edit-student-btn", function () {
  const studentId = $(this).data("id");

  showLoading();
  $.get("get_single_student.php", { id: studentId }, function (res) {
    const s = JSON.parse(res);

    $("#editStudentId").val(s.id);
    $("#studentFirstName").val(s.first_name);
    $("#studentMiddleName").val(s.middle_name);
    $("#studentLastName").val(s.last_name);
    $("#studentEmail").val(s.email);
    $("#studentPassword").val("");
    $("#editStudentPhotoPreview").attr(
      "src",
      s.photo || "uploads/students/default.png"
    );

    $("#editStudentModal").modal("show");
  }).always(() => setTimeout(hideLoading, 300));
});

// Submit edit
$("#editStudentForm").submit(function (e) {
  e.preventDefault();

  if (!confirm("Save changes to student?")) return;

  const formData = new FormData(this);

  showLoading();
  fetch("update_student.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      alert(data.message);
      if (data.status === "success") {
        $("#editStudentModal").modal("hide");
        loadStudents();
      }
    })
    .finally(() => setTimeout(hideLoading, 300));
});

// Initial load
loadCoursesToFilter();
loadStudents();
