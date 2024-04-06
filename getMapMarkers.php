<?php
// Include config file
require_once 'db/config.php';

// Function to fetch images for a specific place ID
function getImagesForPlace($placeId, $link) {
    $sql = "SELECT image_path FROM images WHERE place_id = '$placeId'";
    $images = array();
    if($result = mysqli_query($link, $sql)){
        while($row = mysqli_fetch_assoc($result)){
            $images[] = $row['image_path'];
        }
        mysqli_free_result($result);
    }
    return $images;
}

// Perform query
$sql = "SELECT id, lat, lng, title, price, available_rooms, contact FROM places";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        // Fetch associative array
        $locations = array();
        while($row = mysqli_fetch_assoc($result)){
            // Fetch images for this place
            $images = getImagesForPlace($row['id'], $link);
            // Add images to location data
            $row['images'] = $images;
            $locations[] = $row;
        }
        // Return JSON response
        echo json_encode($locations);
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "<div class='alert alert-warning' role='alert'>No places were found in the database!</div>";
    }
} else{
    echo "ERROR: Unable to execute $sql. " . mysqli_error($link);
}
// Close connection
mysqli_close($link);
?>