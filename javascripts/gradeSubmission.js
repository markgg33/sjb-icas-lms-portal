console.log("📘 gradeSubmission.js loaded");

document.addEventListener("DOMContentLoaded", function () {
  loadFacultyCourses();

  // When course or semester changes, update subject dropdown
  $("#gradeCourseFilter, #gradeSemesterFilter").change(function () {
    const courseId = $("#gradeCourseFilter").val();
    const semester = $("#gradeSemesterFilter").val();

    if (courseId && semester) {
      fetchSubjectsForFaculty(courseId, semester);
    } else {
      $("#gradeSubjectFilter").html('<option value="">Select Subject</option>');
    }
  });

  // When subject changes, load students in that subject
  $("#gradeSubjectFilter").change(function () {
    const courseId = $("#gradeCourseFilter").val();
    const semester = $("#gradeSemesterFilter").val();
    const subjectId = $(this).val();

    if (courseId && semester && subjectId) {
      loadStudentsInSubject(courseId, semester, subjectId);
    } else {
      $("#gradesSubmissionContainer").html("");
    }
  });

  // Handle submit button click
  $(document).on("click", "#submitGradesBtn", function () {
    if (!confirm("Are you sure you want to submit these grades?")) return;

    const grades = [];

    $("#gradesTable tbody tr").each(function () {
      const row = $(this);
      grades.push({
        student_id: row.data("student-id"),
        grade: row.find(".grade-input").val().trim(),
      });
    });

    const subjectId = $("#gradeSubjectFilter").val();
    const semester = $("#gradeSemesterFilter").val();
    const courseId = $("#gradeCourseFilter").val();
    const schoolYear =
      new Date().getFullYear() + "-" + (new Date().getFullYear() + 1);

    showLoading();

    fetch("submit_grades.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        grades,
        subject_id: subjectId,
        semester,
        school_year: schoolYear,
        course_id: courseId,
      }),
    })
      .then((res) => res.json())
      .then((data) => {
        alert(data.message);
      })
      .catch((err) => {
        console.error("Grade submission error:", err);
        alert("Something went wrong. Please try again.");
      })
      .finally(() => setTimeout(hideLoading, 300));
  });
});

// Load faculty courses for dropdown
function loadFacultyCourses() {
  $.get("get_faculty_courses.php", function (res) {
    const courses = JSON.parse(res);
    let options = '<option value="">Select Course</option>';
    courses.forEach((c) => {
      options += `<option value="${c.id}">${c.name} - Year ${c.year_level}</option>`;
    });
    $("#gradeCourseFilter").html(options);
  });
}

// Load subjects based on course and semester
function fetchSubjectsForFaculty(courseId, semester) {
  $.get(
    "get_faculty_subjects_by_course_sem.php",
    { course_id: courseId, semester },
    function (res) {
      const subjects = JSON.parse(res);
      let options = '<option value="">Select Subject</option>';
      subjects.forEach((s) => {
        options += `<option value="${s.id}">${s.code} - ${s.name}</option>`;
      });
      $("#gradeSubjectFilter").html(options);
    }
  );
}

// Load students enrolled in the selected subject
function loadStudentsInSubject(courseId, semester, subjectId) {
  const schoolYear =
    new Date().getFullYear() + "-" + (new Date().getFullYear() + 1);

  showLoading();

  $.get(
    "get_students_in_subject.php",
    {
      course_id: courseId,
      semester: semester,
      subject_id: subjectId,
      school_year: schoolYear,
    },
    function (res) {
      const students = JSON.parse(res);

      if (!students.length) {
        $("#gradesSubmissionContainer").html(
          `<div class="alert alert-warning">No students enrolled in this subject.</div>`
        );
        return;
      }

      let html = `
        <div class="table-responsive mt-4">
          <table class="table table-bordered" id="gradesTable">
            <thead class="table-light">
              <tr>
                <th>School ID</th>
                <th>Full Name</th>
                <th>Grade</th>
              </tr>
            </thead>
            <tbody>
              ${students
                .map(
                  (s) => `
                <tr data-student-id="${s.id}">
                  <td>${s.school_id}</td>
                  <td>${s.full_name}</td>
                  <td><input type="text" class="form-control grade-input" value="${
                    s.grade || ""
                  }" /></td>
                </tr>`
                )
                .join("")}
            </tbody>
          </table>
        </div>
        <div class="mt-3 text-end">
          <button class="btn btn-primary" id="submitGradesBtn">📤 Submit Grades</button>
        </div>
      `;

      $("#gradesSubmissionContainer").html(html);
    }
  ).always(() => setTimeout(hideLoading, 300));
}
