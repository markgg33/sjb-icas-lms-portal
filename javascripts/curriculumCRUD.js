function loadCurriculum() {
  fetch("get_curriculum.php")
    .then((res) => res.json())
    .then((data) => {
      const container = document.getElementById("curriculumContainer");
      container.innerHTML = "";

      data.forEach((course) => {
        const col = document.createElement("div");
        col.className = "col-md-6 mb-4"; // 2 per row on md screens, adjust as needed

        const card = document.createElement("div");
        card.className = "card h-100"; // Make sure all cards are same height

        col.appendChild(card);

        const header = document.createElement("div");
        header.className = "card-header";
        header.innerHTML = `📘 <strong>${course.name}</strong>`;

        const body = document.createElement("div");
        body.className = "card-body";

        // Loop through semesters 1 to 3
        for (let sem = 1; sem <= 3; sem++) {
          const semSubjects = course.subjects[sem.toString()] || [];

          const semHeader = document.createElement("h5");
          semHeader.textContent = `📚 ${sem} Semester`;
          body.appendChild(semHeader);

          const ul = document.createElement("ul");
          ul.className = "list-group mb-3";

          semSubjects.forEach((subject) => {
            const li = document.createElement("li");
            li.className =
              "list-group-item d-flex justify-content-between align-items-center";
            li.innerHTML = `
       <span><strong>${subject.code}</strong> - ${subject.name}</span>
      <button class="btn btn-sm btn-danger" onclick="removeCourseSubject(${course.course_id}, ${subject.subject_id}, ${sem})">Remove ❌</button>
    `;
            ul.appendChild(li);
          });

          if (semSubjects.length === 0) {
            const empty = document.createElement("p");
            empty.textContent = "No subjects assigned.";
            body.appendChild(empty);
          } else {
            body.appendChild(ul);
          }
        }

        card.appendChild(header);
        card.appendChild(body);
        container.appendChild(col); // instead of container.appendChild(card)
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