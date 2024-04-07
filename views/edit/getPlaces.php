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

            // Parameters for update function
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
            echo "<tr class='table-info collapse' id='infoRow" . $row['id'] . "'>";
            echo "<td colspan='4'>";
            echo "<div class='row'>";
            echo "<div class='col-10'>";
            echo "<div class='col-12'>Rs. <span>" . $row['price'] . " </span></div>";
            echo "<div class='col-12'><i class='fa fa-bed' title='rooms'></i> &nbsp <span>" . $row['available_rooms'] . "</span></div>";
            echo "<div class='col-12'><i class='fas fa-map-marker-alt mr-2' title='coordinates'></i><span>" . $row['lat'] . " , " . $row['lng'] . "</span></div>";
            echo "<div class='col-12 d-block d-sm-none'><i class='fas fa-book mr-2'></i><span>" . $row['description'] . "</span></div>";

            // Fetch and display images for the place ID in a carousel
            $placeId = $row['id'];
            $sqlImages = "SELECT image_path FROM images WHERE place_id = $placeId";
            if ($imageResult = mysqli_query($link, $sqlImages)) {
                $images = [];
                while ($imageRow = mysqli_fetch_assoc($imageResult)) {
                    $images[] = $imageRow['image_path'];
                }

                echo "<div class='col-12'>";
                echo "<div id='carouselExampleControls$placeId' class='carousel slide' data-ride='carousel'>";
                echo "<div class='carousel-inner'>";
                foreach ($images as $key => $image) {
                    $activeClass = ($key == 0) ? 'active' : '';
                    echo "<div class='carousel-item $activeClass' style='height: 500px; max-width: auto;'>";
                    echo "<img class='d-block w-100' src='images/$image' alt='Slide' style='display: block; margin: auto; width: 60%;'>";
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
                echo "</div>"; // Close col-12
            } // Close if for image results

            // Add Accept and Reject buttons here
            echo "<div class='col-12 mt-3 text-right'>"; // Use text-right for alignment to the right
            echo "<button class='btn btn-success btn-sm' onclick='acceptPlace(" . $row['id'] . ")'>Accept</button> "; // Space for a small gap between buttons
            echo "<button class='btn btn-danger btn-sm' onclick='rejectPlace(" . $row['id'] . ")'>Reject</button>";
            echo "</div>"; // Close col-12 for buttons

            echo "</div>"; // Close col-10
            echo "<div class='col-2'>";
            echo "<button class='btn btn-light btn-sm mr-3 float-right' data-toggle='collapse' data-target='#infoRow" . $row['id'] . "' aria-expanded='false' aria-controls='infoRow" . $row['id'] . "'>";
            echo "<i class='fas fa-chevron-up'></i>";
            echo "</button>";
            echo "</div>"; // Close col-2
            echo "</div>"; // Close row
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
