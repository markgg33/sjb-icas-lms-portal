// studentSearch.js

// Debounce function to avoid too many AJAX calls
function debounce(func, wait) {
  let timeout;
  return function (...args) {
    clearTimeout(timeout);
    timeout = setTimeout(() => func.apply(this, args), wait);
  };
}

$(function () {
  // Ensure DOM ready

  $("#searchStudentBtn").on("click", function () {
    const name = $("#studentNameInput").val().trim();

    if (name.length < 2) {
      $("#studentSearchResults").html(
        "<p>Please enter at least 2 characters.</p>"
      );
      return;
    }

    showLoading();

    $.get("search_students.php", { name }, function (data) {
      try {
        const students = JSON.parse(data);
        renderStudentResults(students);

        // Add delay so overlay is visible
        setTimeout(() => {
          hideLoading();
        }, 500); // Adjust delay as needed
      } catch (err) {
        console.error("JSON parse error", err);
        hideLoading();
        $("#studentSearchResults").html("<p>Error parsing results.</p>");
      }
    }).fail(() => {
      hideLoading();
      $("#studentSearchResults").html("<p>Error loading results.</p>");
    });
  });

  function renderStudentResults(students) {
    if (students.length === 0) {
      $("#studentSearchResults").html("<p>No students found.</p>");
      return;
    }

    let html = '<table class="table table-bordered">';
    html +=
      "<thead><tr><th>ID</th><th>Name</th><th>Course</th><th>Year Level</th><th>Select</th></tr></thead><tbody>";
    students.forEach((s) => {
      html += `<tr>
               <td>${s.school_id}</td>
               <td>${s.full_name}</td>
               <td>${s.course_name}</td>
               <td>${s.year_level}</td>
               <td><button class="btn btn-sm btn-primary select-student-btn" data-id="${s.id}" data-name="${s.full_name}">Select</button></td>
             </tr>`;
    });
    html += "</tbody></table>";

    $("#studentSearchResults").html(html);
  }

  // Handle student selection
  $(document).on("click", ".select-student-btn", function () {
    const studentId = $(this).data("id");
    const studentName = $(this).data("name");

    $("#selectedStudentId").val(studentId);
    $("#selectedStudentName").text(studentName);

    $("#studentSearchResults").html("");

    // Enable course/semester selects or load subjects here if needed
    console.log("Selected student:", studentId, studentName);
  });
});

// Clear selected student
$("#clearStudentSelection").on("click", function () {
  $("#selectedStudentId").val("");
  $("#selectedStudentName").text("None");
  $("#studentNameInput").val("");
  $("#studentSearchResults").html("");
  $("#enrollSubjectCheckboxes").html("");
});
