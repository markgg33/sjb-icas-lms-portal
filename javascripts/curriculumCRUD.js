function loadCurriculum() {
  fetch("get_curriculum.php")
    .then((res) => res.json())
    .then((data) => {
      const container = document.getElementById("curriculumContainer");
      container.innerHTML = "";

      data.forEach((course) => {
        const col = document.createElement("div");
        col.className = "col-md-6 mb-4";

        const card = document.createElement("div");
        card.className = "card h-100";

        const header = document.createElement("div");
        header.className = "card-header";
        header.innerHTML = `📘 <strong>${course.name}</strong>`;

        const body = document.createElement("div");
        body.className = "card-body";

        for (let sem = 1; sem <= 3; sem++) {
          const semSubjects = course.subjects[sem.toString()] || [];

          const totalUnits = semSubjects.reduce(
            (sum, s) => sum + parseInt(s.units || 0),
            0
          );

          const semHeader = document.createElement("h5");
          semHeader.innerHTML = `${sem} Semester <span class="badge bg-secondary ms-2">${totalUnits} unit${
            totalUnits !== 1 ? "s" : ""
          }</span>`;
          body.appendChild(semHeader);

          if (semSubjects.length === 0) {
            const empty = document.createElement("p");
            empty.textContent = "No subjects assigned.";
            body.appendChild(empty);
          } else {
            const ul = document.createElement("ul");
            ul.className = "list-group mb-3";

            semSubjects.forEach((subject) => {
              const li = document.createElement("li");
              li.className =
                "list-group-item d-flex justify-content-between align-items-center";
              li.innerHTML = `
                <span><strong>${subject.code}</strong> - ${subject.name}</span>
                <span class="badge bg-info text-dark">${subject.units} unit${
                subject.units > 1 ? "s" : ""
              }</span>
              `;
              ul.appendChild(li);
            });

            body.appendChild(ul);
          }
        }

        card.appendChild(header);
        card.appendChild(body);
        col.appendChild(card);
        container.appendChild(col);
      });
    });
}

// Curriculum version
function removeCourseSubject(course_id, subject_id, semester) {
  if (
    confirm("Are you sure you want to remove this subject from the course?")
  ) {
    fetch("remove_subject.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `course_id=${course_id}&subject_id=${subject_id}&semester=${semester}`,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          loadCurriculum(); // Refresh view
        } else {
          alert("Failed to remove subject: " + data.message);
        }
      });
  }
}

// Initial load
loadCurriculum();

//get_curriculum.php and remove_subject.php are used
