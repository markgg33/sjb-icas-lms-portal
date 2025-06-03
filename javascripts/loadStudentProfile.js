console.log("✅ loadStudentProfile.js loaded");

function loadStudentProfile() {
  showLoading();

  fetch("get_loggedin_student.php")
    .then((res) => res.json())
    .then((s) => {
      if (s.error) {
        alert("Not logged in");
        return;
      }

      console.log("🎯 Student Profile:", s);

      $("#editProfileId").val(s.id);
      $("#editProfileFirstName").val(s.first_name);
      $("#editProfileMiddleName").val(s.middle_name);
      $("#editProfileLastName").val(s.last_name);
      $("#editProfileEmail").val(s.email);

      $("#editProfileSchoolId").val(s.school_id);
      $("#editProfileCourse").val(s.course_name);
      $("#editProfileYear").val("Year " + s.year_level);

      const photoSrc =
        s.photo && s.photo !== "" ? s.photo : "uploads/students/default.png";
      $("#editProfilePhotoPreview").attr("src", photoSrc);
    })
    .catch((err) => {
      console.error("❌ Failed to load profile:", err);
      alert("Could not load your profile.");
    })
    .finally(() => setTimeout(hideLoading, 300));
}

// On form submit
$("#editProfileForm").submit(function (e) {
  e.preventDefault();

  if (!confirm("Save changes to your profile?")) return;

  const formData = new FormData(this);

  showLoading();

  fetch("update_student.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      alert(data.message);
      if (data.status === "success") loadStudentProfile(); // reload preview
    })
    .catch((err) => {
      console.error("❌ Update error:", err);
      alert("An error occurred while saving.");
    })
    .finally(() => setTimeout(hideLoading, 300));
});
