function changePage(page) {
  const targetId = page.endsWith("-page") ? page : `${page}-page`;

  // Hide all pages
  document
    .querySelectorAll(".page-content")
    .forEach((el) => (el.style.display = "none"));

  // Show the selected page
  const target = document.getElementById(targetId);
  if (target) {
    target.style.display = "block";
  }

  // Highlight active sidebar item
  document
    .querySelectorAll(".sidebar-list-item")
    .forEach((el) =>
      el.classList.toggle("active", el.getAttribute("data-page") === page)
    );

  // ✅ Load student profile only when the edit profile page is shown
  if (page === "editProfile") {
    loadStudentProfile();
  }

  // ✅ Load faculty subjects if the admin is editing faculty assignments
  if (page === "editFacultySubjects") {
    loadFacultySubjects();
  }
}

// Set the default page to be the dashboard page
document.addEventListener("DOMContentLoaded", function () {
  changePage("dashboard");
});

document.addEventListener("DOMContentLoaded", function () {
  const sidebarItems = document.querySelectorAll(".sidebar-list-item");

  sidebarItems.forEach((item) => {
    item.addEventListener("click", function () {
      // Remove the "active" class from all sidebar items
      sidebarItems.forEach((item) => {
        item.classList.remove("active");
      });

      // Add the "active" class to the clicked sidebar item
      this.classList.add("active");
    });
  });
});
