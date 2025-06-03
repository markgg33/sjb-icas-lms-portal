$("#enrollForm").submit(function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    type: "POST",
    url: "enroll_student.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      if (response.status === "success") {
        // Show School ID to user
        $("#schoolIdText").text(response.school_id);
        $("#schoolIdModal").modal("show");
        $("#enrollForm")[0].reset();
      } else {
        alert("Error: " + response.message);
      }
    },
    error: function () {
      alert("Unexpected error occurred.");
    },
  });
});
