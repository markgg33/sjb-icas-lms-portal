<?php
require 'config.php';

$search = $_GET['search'] ?? '';
$course_id = $_GET['course_id'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Base query
$sql = "
  SELECT 
    students.*, 
    courses.name AS course_name, 
    courses.year_level AS course_year
  FROM students
  JOIN courses ON students.course_id = courses.id
  WHERE 1
";

// Filters
$params = [];
$types = '';

if ($search) {
  $sql .= " AND (students.first_name LIKE ? OR students.last_name LIKE ? OR students.email LIKE ?)";
  $searchTerm = "%" . $search . "%";
  $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
  $types .= 'sss';
}

if ($course_id) {
  $sql .= " AND students.course_id = ?";
  $params[] = $course_id;
  $types .= 'i';
}

$sql .= " ORDER BY students.last_name ASC LIMIT $limit OFFSET $offset";

$stmt = $conn->prepare($sql);
if ($params) {
  $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$students = [];

while ($row = $result->fetch_assoc()) {
  $students[] = [
    'id' => $row['id'],
    'full_name' => $row['last_name'] . ', ' . $row['first_name'] . ' ' . $row['middle_name'],
    'email' => $row['email'],
    'photo' => $row['photo'],
    'year_level' => $row['year_level'],
    'course' => $row['course_name'] . " - Year " . $row['course_year']
  ];
}

// Get total count for pagination
$count_sql = "SELECT COUNT(*) as total FROM students JOIN courses ON students.course_id = courses.id WHERE 1";
if ($search) {
  $count_sql .= " AND (students.first_name LIKE '%$search%' OR students.last_name LIKE '%$search%' OR students.email LIKE '%$search%')";
}
if ($course_id) {
  $count_sql .= " AND students.course_id = " . intval($course_id);
}

$count_result = $conn->query($count_sql);
$total = $count_result->fetch_assoc()['total'];

echo json_encode([
  'students' => $students,
  'total' => $total,
  'limit' => $limit,
  'page' => intval($page)
]);
