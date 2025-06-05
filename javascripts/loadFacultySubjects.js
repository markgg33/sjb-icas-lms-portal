$(document).ready(function () {
  fetch("get_faculty_subjects.php")
    .then((res) => res.json())
    .then((subjects) => {
      const container = $("#subjectList");
      if (subjects.length === 0) {
        container.html("<p>No subjects assigned.</p>");
        return;
      }

      const cards = subjects
        .map(
          (s) => `
        <div class="subject-card">
          <h4>${s.code}</h4>
          <p>${s.name}</p>
          <small>${s.course_name} - Semester ${s.semester}</small>
        </div>
      `
        )
        .join("");

      container.html(cards);
    });
});
