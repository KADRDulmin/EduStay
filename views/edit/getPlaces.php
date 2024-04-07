<?php
require_once '../../db/config.php';

// Perform query
$sql = "SELECT * FROM places ORDER BY id ASC";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        // Print table
        echo "<table class='table table-hover table-sm'>";
        echo "<thead class='thead-light'>";
        echo "<tr class='d-flex'>";
        echo "<th class='col-1'>#</th>";
        echo "<th class='col-xs-6 col-sm-4 col-md-3 col-lg-3'>Title</th>";
        echo "<th class='d-none d-sm-block col-sm-4 col-md-5 col-lg-5'>Description</th>";
        echo "<th class='col-xs-5 col-sm-3 col-md-3 col-lg-3 text-right'><span class='mr-2'>Actions</span></th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Fetch and display places in a loop
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr class='d-flex'>";
            echo "<td class='col-1'>" . $row['id'] . "</td>";
            echo "<td class='col-xs-6 col-sm-4 col-md-3 col-lg-3'>" . $row['title'] . "</td>";
            echo "<td class='d-none d-sm-block col-sm-4 col-md-5 col-lg-5 text-truncate'>" . $row['description'] . "</td>";
            $parameters = $row['id'] . ",\"" . $row['title'] . "\",\"" . $row['description'] . "\",\"" . $row['price'] . "\",\"" . $row['available_rooms'] . "\",\"" . $row['lat'] . "\",\"" . $row['lng'] . "\"";
            echo "<td class='col-xs-5 col-sm-3 col-md-3 col-lg-3 text-right'>
                            <button class='btn btn-link btn-sm' data-toggle='collapse' data-target='#infoRow" . $row['id'] . "' aria-expanded='false' aria-controls='infoRow" . $row['id'] . "'>
                                <i class='fas fa-info-circle'></i>
                            </button> | 
                            <button class='btn btn-link btn-sm' onclick='openEditForm(" . $parameters . ")'>
                                <i class='far fa-edit'></i>
                            </button> | 
                            <button class='btn btn-link btn-sm' data-toggle='collapse' data-target='#deletePromptRow" . $row['id'] . "' aria-expanded='false' aria-controls='deletePromptRow" . $row['id'] . "'>
                                <i class='far fa-trash-alt'></i>
                            </button>
                        </td>";
            echo "</tr>";

            // Place data display row
            echo "<tr class='collapse' id='infoRow" . $row['id'] . "'>";
            echo "<td colspan='4'>";
            echo "<div class='card'>";
            echo "<div class='card-body'>";

            // Title
            echo "<h5 class='card-title'>" . $row['title'] . "</h5>";

            // Price and Rooms
            echo "<p class='card-text'><strong>Price:</strong> Rs. " . $row['price'] . "</p>";
            echo "<p class='card-text'><strong>Available Rooms:</strong> " . $row['available_rooms'] . "</p>";

            // Location
            echo "<p class='card-text'><strong>Location:</strong> " . $row['lat'] . ", " . $row['lng'] . "</p>";

            // Description for smaller devices
            echo "<p class='card-text d-block d-sm-none'><strong>Description:</strong> " . $row['description'] . "</p>";

            // Images Carousel
            $placeId = $row['id'];
            $sqlImages = "SELECT image_path FROM images WHERE place_id = $placeId";
            if ($imageResult = mysqli_query($link, $sqlImages)) {
                $images = [];
                while ($imageRow = mysqli_fetch_assoc($imageResult)) {
                    $images[] = $imageRow['image_path'];
                }

                if (!empty($images)) {
                    echo "<div id='carouselExampleControls$placeId' class='carousel slide' data-ride='carousel'>";
                    echo "<div class='carousel-inner'>";
                    foreach ($images as $key => $image) {
                        $activeClass = ($key == 0) ? 'active' : '';
                        echo "<div class='carousel-item $activeClass'>";
                        echo "<img class='d-block w-100' src='images/$image' alt='Slide'>";
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "<a class='carousel-control-prev' href='#carouselExampleControls$placeId' role='button' data-slide='prev'>";
                    echo "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
                    echo "<span class='sr-only'>Previous</span>";
                    echo "</a>";
                    echo "<a class='carousel-control-next' href='#carouselExampleControls$placeId' role='button' data-slide='next'>";
                    echo "<span class='carousel-control-next-icon' aria-hidden='true'></span>";
                    echo "<span class='sr-only'>Next</span>";
                    echo "</a>";
                    echo "</div>"; // Close carousel
                }
            } // Close if for image results

            // Action Buttons
            echo "<div class='text-right mt-3'>";
            echo "<button class='btn btn-success' onclick='acceptPlace(" . $row['id'] . ")'>Accept</button> ";
            echo "<button class='btn btn-danger' onclick='rejectPlace(" . $row['id'] . ")'>Reject</button>";
            echo "</div>"; // Close action buttons div

            echo "</div>"; // Close card-body
            echo "</div>"; // Close card
            echo "</td>"; // Close td colspan
            echo "</tr>"; // Close tr for info row

            // Deletion confirmation prompt row
            echo "<tr class='table-warning text-center collapse' id='deletePromptRow" . $row['id'] . "'>";
            echo "<td colspan='4'>";
            echo "Are you sure you want to delete " . $row['title'] . "? ";
            echo "<button class='btn btn-outline-danger btn-sm ml-2' onclick='deletePlace(" . $row['id'] . ")'>Delete</button> ";
            echo "<button class='btn btn-default btn-sm ml-2' data-toggle='collapse' data-target='#deletePromptRow" . $row['id'] . "' aria-expanded='false' aria-controls='deletePromptRow" . $row['id'] . "'>Cancel</button>";
            echo "</td>"; // Close td colspan
            echo "</tr>"; // Close tr for delete prompt
        } // End of while loop

        echo "</tbody>";
        echo "</table>";
        mysqli_free_result($result);
    } else {
        echo "<div class='alert alert-warning' role='alert'>No places were found in the database!</div>";
    }
} else {
    echo "ERROR: Unable to execute $sql. " . mysqli_error($link);
}
mysqli_close($link);
?>
