<?php
require_once '../../db/config.php';

// Perform query
$sql = "SELECT * FROM places ORDER BY id ASC";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        // Print table with responsive wrapper
        echo "<div class='table-responsive'>";
        echo "<table class='table table-hover'>";
        echo "<thead style='background-color: rgba(12, 110, 223, 0.726);'>";
        echo "<tr>";
        echo "<th scope='col'>#</th>";
        echo "<th scope='col'>Title</th>";
        echo "<th scope='col' class='d-none d-md-table-cell'>Description</th>";
        echo "<th scope='col' class='text-right'>Actions</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Fetch and display places in a loop
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<th scope='row'>" . $row['id'] . "</th>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td class='d-none d-md-table-cell text-truncate' style='max-width: 250px;'>" . $row['description'] . "</td>";
            $parameters = $row['id'] . ",\"" . $row['title'] . "\",\"" . $row['description'] . "\",\"" . $row['price'] . "\",\"" . $row['available_rooms'] . "\",\"" . $row['lat'] . "\",\"" . $row['lng'] . "\"";
            echo "<td class='text-right'>";
            echo "<button class='btn btn-info btn-sm mr-1' data-toggle='collapse' data-target='#infoRow" . $row['id'] . "' aria-expanded='false' aria-controls='infoRow" . $row['id'] . "'><i class='fas fa-info-circle'></i></button>";
            echo "<button class='btn btn-primary btn-sm mr-1' onclick='openEditForm(" . $parameters . ")'><i class='fas fa-edit'></i></button>";
            echo "<button class='btn btn-danger btn-sm' data-toggle='collapse' data-target='#deletePromptRow" . $row['id'] . "' aria-expanded='false' aria-controls='deletePromptRow" . $row['id'] . "'><i class='fas fa-trash-alt'></i></button>";
            echo "</td>";
            echo "</tr>";

            // Additional details for each place
            echo "<tr class='collapse' id='infoRow" . $row['id'] . "'>";
            echo "<td colspan='4'>";
            echo "<div class='card card-body'>";
            echo "<h5 class='card-title'>" . $row['title'] . "</h5>";
            echo "<p class='card-text'><strong>Price:</strong> Rs. " . $row['price'] . "</p>";
            echo "<p class='card-text'><strong>Available Rooms:</strong> " . $row['available_rooms'] . "</p>";
            echo "<p class='card-text'><strong>Location:</strong> " . $row['lat'] . ", " . $row['lng'] . "</p>";
            echo "<p class='card-text d-block d-md-none'><strong>Description:</strong> " . $row['description'] . "</p>";

            // Carousel for images (if available)
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
                        echo "<img class='d-block w-100' src='images/$image' alt='Image'>";
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

            // Accept and Reject buttons
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
        echo "</div>"; // Close responsive table div
        mysqli_free_result($result);
    } else {
        echo "<div class='alert alert-warning' role='alert'>No places were found in the database!</div>";
    }
} else {
    echo "ERROR: Unable to execute $sql. " . mysqli_error($link);
}
mysqli_close($link);
?>
