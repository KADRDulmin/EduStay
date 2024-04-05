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
if(isset($_FILES['image1']) && isset($_FILES['image2']) && isset($_FILES['image3']) && isset($_FILES['image4']) && isset($_FILES['image5'])) {
    // Handle image uploads
    $errors = array();
    $imageData = array();

    // Function to validate and process image upload
    function processImageUpload($fieldName) {
        global $errors, $imageData;
        if ($_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES[$fieldName]['tmp_name'];
            $imageData[$fieldName] = file_get_contents($tmpName);
        } elseif ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_NO_FILE) {
            $errors[] = 'Error uploading ' . $fieldName . ' image: ' . $_FILES[$fieldName]['error'];
        }
    }

    // Validate and process each image upload
    for ($i = 1; $i <= 5; $i++) {
        processImageUpload('image' . $i);
    }

    // Check for errors before proceeding
    if (!empty($errors)) {
        // Handle errors (e.g., display error messages or redirect back to the form)
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    } else {
        // Insert images into the database
        $sqlImages = "INSERT INTO images (place_id, image_data) VALUES ";
        $values = array();

        // Process each image
        foreach ($imageData as $fieldName => $data) {
            $values[] = "('$id', '" . mysqli_real_escape_string($link, $data) . "')";
        }

        // Execute the query for image insertion
        if (!empty($values)) {
            $sqlImages .= implode(", ", $values);
            if (!mysqli_query($link, $sqlImages)) {
                echo "Error inserting images: " . mysqli_error($link);
            }
        }
    }
}

// Perform query to update place details
$sql = "UPDATE places SET title='$title', description='$description', address='$address', lat='$lat', lng='$lng', price='$price', available_rooms='$available_rooms', contact='$contact' WHERE id='$id'";

// Return status
if(mysqli_query($link, $sql)){
    echo "200";
} else{
    echo "ERROR: Unable to execute $sql. " . mysqli_error($link);
}

// Close connection
mysqli_close($link);
?>
