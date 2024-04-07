<?php
require_once '../../db/config.php';

// Escape user inputs for security
$id = isset($_REQUEST['id']) ? mysqli_real_escape_string($link, $_REQUEST['id']) : '';
$title = isset($_REQUEST['title']) ? mysqli_real_escape_string($link, $_REQUEST['title']) : '';
$description = isset($_REQUEST['description']) ? mysqli_real_escape_string($link, $_REQUEST['description']) : '';
$address = isset($_REQUEST['address']) ? mysqli_real_escape_string($link, $_REQUEST['address']) : '';
$lat = isset($_REQUEST['lat']) ? mysqli_real_escape_string($link, $_REQUEST['lat']) : '';
$lng = isset($_REQUEST['lng']) ? mysqli_real_escape_string($link, $_REQUEST['lng']) : '';
$price = isset($_REQUEST['price']) ? mysqli_real_escape_string($link, $_REQUEST['price']) : '';
$available_rooms = isset($_REQUEST['available_rooms']) ? mysqli_real_escape_string($link, $_REQUEST['available_rooms']) : '';
$contact = isset($_REQUEST['contact']) ? mysqli_real_escape_string($link, $_REQUEST['contact']) : '';

// Check if there are uploaded images
if (!empty($id) && (isset($_FILES['image1']) || isset($_FILES['image2']) || isset($_FILES['image3']) || isset($_FILES['image4']) || isset($_FILES['image5']))) {
    // Handle image uploads
    $errors = array();

    // Function to validate and process image upload
    function processImageUpload($fieldName, $id, $link)
    {
        global $errors;
        if ($_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES[$fieldName]['tmp_name'];

            // Move the uploaded image to a folder
            $file_name = $_FILES[$fieldName]['name'];
            $folder = '../../images/' . $file_name;
            move_uploaded_file($tmpName, $folder);

            // Insert image path into the database
            $sql = "INSERT INTO images (place_id, image_path) VALUES ('$id', '$file_name')";
            if (!mysqli_query($link, $sql)) {
                $errors[] = "Error inserting image: " . mysqli_error($link);
            }
        } elseif ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_NO_FILE) {
            $errors[] = 'Error uploading ' . $fieldName . ' image: ' . $_FILES[$fieldName]['error'];
        }
    }

    // Validate and process each image upload
    for ($i = 1; $i <= 5; $i++) {
        // Check if the file field is not empty
        if (!empty($_FILES['image' . $i]['name'])) {
            processImageUpload('image' . $i, $id, $link);
        }
    }

    // Check for errors before proceeding
    if (!empty($errors)) {
        // Handle errors (e.g., display error messages or redirect back to the form)
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        exit(); // Exit script if there are errors
    }
}

// Perform query to update place details
$sql = "UPDATE places SET title='$title', description='$description', address='$address', lat='$lat', lng='$lng', price='$price', available_rooms='$available_rooms', contact='$contact' WHERE id='$id'";

// Return status
if (mysqli_query($link, $sql)) {
    echo "200";
} else {
    echo "ERROR: Unable to execute $sql. " . mysqli_error($link);
}

// Close connection
mysqli_close($link);
?>
