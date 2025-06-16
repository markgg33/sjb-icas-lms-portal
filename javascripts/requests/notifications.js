//WORKING VERSION

/*async function loadNotifications() { 
  const res = await fetch("get_notifications.php");
  const notifs = await res.json();
  const notifList = document.getElementById("notifList");
  const notifCount = document.getElementById("notifCount");

  notifList.innerHTML = "";

  if (notifs.length === 0) {
    notifList.innerHTML =
      '<li><a class="dropdown-item text-muted">No notifications</a></li>';
    notifCount.classList.add("d-none");
    return;
  }

  let unreadCount = 0;

  notifs.forEach((n) => {
    if (!n.is_read) unreadCount++;

    notifList.innerHTML += `
      <li>
        <a href="#" class="dropdown-item notif-link${
          n.is_read ? "" : " fw-bold"
        }" data-target="${n.url.split('#')[1]}">
          <div class="notif-card">
            <div class="notif-msg">${n.message}</div>
            <div class="notif-meta text-muted small">${new Date(
              n.created_at
            ).toLocaleString()}</div>
          </div>
        </a>
      </li>`;
  });

  if (unreadCount > 0) {
    notifCount.classList.remove("d-none");
    notifCount.textContent = unreadCount;
  } else {
    notifCount.classList.add("d-none");
  }
}

// On dropdown open, mark all as read
document
  .querySelector(".dropdown-toggle")
  .addEventListener("click", async () => {
    await fetch("mark_notifications_read.php", { method: "POST" });
    document.getElementById("notifCount").classList.add("d-none");
    loadNotifications();
  });

// Real-time polling
setInterval(loadNotifications, 5000);
loadNotifications(); // initial load

// ✅ Add this AFTER the above code (outside any function)
$(document).on("click", ".notif-link", function (e) {
  e.preventDefault();
  const target = $(this).data("target");
  if (target) changePage(target); // your existing function to navigate to the correct section
  markNotificationsRead(); // optional
});*/

async function loadNotifications() {
  const res = await fetch("get_notifications.php");
  const notifs = await res.json();
  const notifList = document.getElementById("notifList");
  const notifCount = document.getElementById("notifCount");

  notifList.innerHTML = "";

  let unreadCount = 0;
  if (notifs.length === 0) {
    notifList.innerHTML = `<li><span class="dropdown-item text-muted">No notifications</span></li>`;
    notifCount.classList.add("d-none");
    return;
  }

  notifs.forEach((n) => {
    if (!n.is_read) unreadCount++;
    notifList.innerHTML += `
      <li>
        <a href="#" class="dropdown-item notif-link${
          n.is_read ? "" : " fw-bold"
        }" data-target="${n.url?.split("#")[1] || ""}">
          <div class="notif-card">
            <div class="notif-msg">${n.message}</div>
            <div class="notif-meta text-muted small">${new Date(
              n.created_at
            ).toLocaleString()}</div>
          </div>
        </a>
      </li>`;
  });

  if (unreadCount > 0) {
    notifCount.textContent = unreadCount;
    notifCount.classList.remove("d-none");
  } else {
    notifCount.classList.add("d-none");
  }
}

// Mark all as read on dropdown open
document
  .querySelector(".dropdown-toggle")
  .addEventListener("click", async () => {
    await fetch("mark_notifications_read.php", { method: "POST" });
    loadNotifications();
  });

// SPA-friendly page redirection via notif click
$(document).on("click", ".notif-link", function (e) {
  e.preventDefault();
  const target = $(this).data("target");
  if (target) changePage(target);
  markNotificationsRead(); // Optional
});

setInterval(loadNotifications, 5000); // Poll every 5 seconds
loadNotifications();
