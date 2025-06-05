$(document).ready(function () {
  // Load courses for faculty assignment
  $.get("get_courses.php", function (data) {
    $("#facultyCourseSelect").append(data);
  });

  // Load faculties
  $.get("get_faculties.php", function (data) {
    $("#facultySelect").append(data);
  });

  // Load subjects on course or semester change
  $("#facultyCourseSelect, #facultySemesterSelect").change(function () {
    const courseId = $("#facultyCourseSelect").val();
    const semester = $("#facultySemesterSelect").val();

    if (courseId && semester) {
      showLoading();
      $.get(
        "get_subjects_by_course_sem.php",
        { course_id: courseId, semester: semester },
        function (html) {
          $("#facultySubjectCheckboxesContainer").html(html);
        }
      ).always(() => setTimeout(hideLoading, 300));
    } else {
      $("#facultySubjectCheckboxesContainer").html("");
    }
  });

  // Submit assignment
  $("#assignFacultyForm").submit(function (e) {
    e.preventDefault();

    if (!confirm("Are you sure you want to assign selected subjects?")) return;

    showLoading();

    const formData = $(this).serialize();

    $.post(
      "assign_faculty_subjects.php",
      formData,
      function (res) {
        alert(res.message);
      },
      "json"
    )
      .fail(() => {
        alert("Assignment failed. Try again.");
      })
      .always(() => setTimeout(hideLoading, 300));
  });
});
