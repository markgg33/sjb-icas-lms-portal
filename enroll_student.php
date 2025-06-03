<?php
include 'config.php';

// ========== 1. Generate School ID ==========
function generateSchoolID($conn)
{
    $year = date('Y');

    $stmt = $conn->prepare("SELECT id FROM students ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();

    $nextID = 1;
    if ($row = $result->fetch_assoc()) {
        $nextID = $row['id'] + 1;
    }
    $stmt->close();

    return 'SJB-' . $year . '-' . str_pad($nextID, 4, '0', STR_PAD_LEFT);
}

// ========== 2. Get and sanitize input ==========
$firstName = trim($_POST['first_name'] ?? '');
$middleName = trim($_POST['middle_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$passwordRaw = $_POST['password'] ?? '';
$courseId = $_POST['course_id'] ?? '';
$yearLevel = $_POST['year_level'] ?? '';
$dob = $_POST['dob'] ?? '';

// ========== 3. Basic validation ==========
if (!$firstName || !$lastName || !$email || !$passwordRaw || !$courseId || !$yearLevel || !$dob) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

$password = password_hash($passwordRaw, PASSWORD_DEFAULT);

// ========== 4. Check for duplicate email ==========
$stmt = $conn->prepare("SELECT id FROM students WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
    $stmt->close();
    exit;
}
$stmt->close();

// ========== 5. Handle Photo Upload ==========
$photoPath = '';
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "uploads/students/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $photoName = basename($_FILES["photo"]["name"]);
    $targetFile = $targetDir . time() . '_' . $photoName;

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
        $photoPath = $targetFile;
    }
}

// ========== 6. Insert into database ==========
$schoolID = generateSchoolID($conn);

$stmt = $conn->prepare("INSERT INTO students (school_id, first_name, middle_name, last_name, email, password, course_id, year_level, dob, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssiiss", $schoolID, $firstName, $middleName, $lastName, $email, $password, $courseId, $yearLevel, $dob, $photoPath);

header('Content-Type: application/json');

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'school_id' => $schoolID]);
    //header("location:login_page.php");
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
