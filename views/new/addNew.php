<?php
// Start a session
session_start();
ob_start();

require_once '../../db/config.php';

// Get the UserID from $_SESSION['UserID']
$id = $_SESSION['UserID'];

// Escape user inputs for security
$title = mysqli_real_escape_string($link, $_REQUEST['title']);
$description = mysqli_real_escape_string($link, $_REQUEST['description']);
$address = mysqli_real_escape_string($link, $_REQUEST['address']);
$lat = mysqli_real_escape_string($link, $_REQUEST['lat']);
$lng = mysqli_real_escape_string($link, $_REQUEST['lng']);
$price = mysqli_real_escape_string($link, $_REQUEST['price']);
$available_rooms = mysqli_real_escape_string($link, $_REQUEST['available_rooms']);
$contact = mysqli_real_escape_string($link, $_REQUEST['contact']);

// Perform query to insert place details
$sql = "INSERT INTO places (id, title, description, address, lat, lng, price, available_rooms, contact, UserID) VALUES (NULL, '$title', '$description', '$address', '$lat', '$lng', '$price', '$available_rooms', '$contact', '$id')";

// Return status
if (mysqli_query($link, $sql)) {
    // Get the ID of the last inserted row
    $lastId = mysqli_insert_id($link);

    // Function to process and insert a single image
    function processAndInsertImage($fieldName, $lastId, $link)
    {
        if ($_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES[$fieldName]['tmp_name'];
            

            // Move the uploaded image to a folder
            $file_name = $_FILES[$fieldName]['name'];
            $folder = '../../images/' . $file_name;
            move_uploaded_file($tmpName, $folder);

            // Insert image path into the database
            $sql = "INSERT INTO images (place_id, image_path) VALUES ('$lastId', '$file_name')";
            if (!mysqli_query($link, $sql)) {
                echo "Error inserting image: " . mysqli_error($link);
            }
        } elseif ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_NO_FILE) {
            echo 'Error uploading ' . $fieldName . ' image: ' . $_FILES[$fieldName]['error'] . "<br>";
        }
    }

    // Validate and process each image upload
    for ($i = 1; $i <= 5; $i++) {
        // Check if the file field is empty
        if (!empty($_FILES['image' . $i]['name'])) {
            processAndInsertImage('image' . $i, $lastId, $link);
        }
    }

    echo "200"; // Success response
} else {
    echo "ERROR: Unable to execute $sql. " . mysqli_error($link); // Error response
}

// Close connection
mysqli_close($link);
