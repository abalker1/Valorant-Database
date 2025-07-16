<?php

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["imgUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file is an image
$check = getimagesize($_FILES["imgUpload"]["tmp_name"]);
if ($check === false) {
    echo json_encode(['success' => false]);
    exit;
}

// Check file size
if ($_FILES["imgUpload"]["size"] > 5000000) {
    echo json_encode(['success' => false]);
    exit;
}

// Allow only certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png") {
    echo json_encode(['success' => false]);
    exit;
}

// Upload the file
if (move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_file)) {
    echo json_encode(['success' => true, 'filePath' => $target_file]);
} else {
    echo json_encode(['success' => false]);
}
