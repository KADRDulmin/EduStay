/* Scripts */

// Variable for coordinate picking mode
var coordinatePickingMode = false;

// Test locations
var testResults = [{ lat: 6.8252900707790305, lng: 80.0374803460151 }, { lat: 60.169497, lng: 24.933689 }, { lat: 60.170768, lng: 24.941535 }, { lat: 60.175841, lng: 24.804531 }];

// Main variable for fetched places
var locationsFromDB = [];

// AJAX content loading
function loadAjax(page) {
  switch (page) {
    case "new":
      $("#addPlace").load("./views/new/addNew.html");
      break;
    case "edit":
      $("#listPlaces").load("./views/edit/edit.html");
      break;
    default:
    // Do nothing basically
  }
}

// Get added places locations from database and place them on map
function fetchMarkersFromDB() {
  loadAjax('new');
  $.ajax({
    type: "GET",
    url: "getMapMarkers.php",
    dataType: 'json',
    success: function (response) {
      locationsFromDB = response;
      console.log(locationsFromDB);
      // Init map
      initMap();
    },

    error: function (response) {
      toastr.error('response: ' + response, 'Fetching map markers from database failed :(');
      // Init map anyways
      initMap();
    }
  });
}

// Call fetchMarkersFromDB() when page has loaded
$(document).ready(function () {
  fetchMarkersFromDB();
});

// Initialize map
function initMap() {
  console.log("init map here");
  var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      gestureHandling: "greedy",
      center: new google.maps.LatLng(6.820961730343091, 80.0397629733186)
  });

// Loop locations to map
for (var i = 0; i < locationsFromDB.length; i++) {
  var imagesHTML = ''; // Initialize the variable to store images HTML
  // Loop through images for the current place
  for (var j = 0; j < locationsFromDB[i].images.length; j++) {
      imagesHTML += '<div class="carousel-item' + (j === 0 ? ' active' : '') + '">' +
          '<img src="data:image/jpeg;base64,' + locationsFromDB[i].images[j] + '" class="carousel-image" style="width: auto; height: 250px;" />' +
          '</div>';
  }
  // Construct the content with carousel
  var contentString = '<div style="text-align: center;">' + // Center align the carousel
      '<div id="carouselExampleControls_' + i + '" class="carousel slide" data-bs-ride="carousel">' +
      '<div class="carousel-inner">' +
      imagesHTML +
      '</div>' +
      '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls_' + i + '" data-bs-slide="prev" style="background-color: transparent; border: none;">' +
      '<span class="carousel-control-prev-icon" aria-hidden="true"></span>' +
      '<span class="sr-only">Previous</span>' +
      '</button>' +
      '<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls_' + i + '" data-bs-slide="next" style="background-color: transparent; border: none;">' +
      '<span class="carousel-control-next-icon" aria-hidden="true"></span>' +
      '<span class="sr-only">Next</span>' +
      '</button>' +
      '</div>' +
      '</div>' +
      '<h4 style="text-align: center;">' + locationsFromDB[i].title + '</h4>' +
      '<p>Price: ' + locationsFromDB[i].price + '</p>' +
      '<p>Available Rooms: ' + locationsFromDB[i].available_rooms + '</p>' +
      '<p>Contact: <a href="tel:' + locationsFromDB[i].contact + '">' + locationsFromDB[i].contact + '</a></p>';

      var marker = new google.maps.Marker({
          position: new google.maps.LatLng(locationsFromDB[i].lat, locationsFromDB[i].lng),
          map: map,
          title: locationsFromDB[i].title,
          icon: '',
          content: contentString // Assign the constructed content to marker's content
      });

      // click event listener to marker to show info window when clicked
      marker.addListener('click', function () {
          var infoWindow = new google.maps.InfoWindow({
              content: this.content
          });
          infoWindow.open(map, this);
      });
  }
  
  

  // Click event for coordinate picking
  map.addListener('click', function (e) {
    if (coordinatePickingMode === true) {
      GetCoordinatesFromMap(e.latLng, map);
    } else {
      // do nothing so that map can be operated normally
    }
  });
}

// Function for getting coordinates from map
function GetCoordinatesFromMap(latLng, map) {
  //Optional code for if we want to add a marker on the map too
  var marker = new google.maps.Marker({
    position: latLng,
    map: map
  });
  map.panTo(latLng);
  console.log("New map marker added, lat: " + latLng.lat() + " lng: " + latLng.lng());
  // Insert picked coordinates to form fields
  $("#lat").val(latLng.lat());
  $("#lng").val(latLng.lng());
  // Disable coordinatePickingMode
  coordinatePickingMode = false;
  // Reset button state
  $("#pickFromMapBtn").html("Pick from map");
  $("#map").removeClass("pickingModeActive");
  // Inform user
  toastr.info('lat: ' + latLng.lat() + ', lng: ' + latLng.lng(), 'Coordinates picked from map!');
}

//We only want to pick coordinates when button is pressed so we handle that with this function for now
function setPickingMode() {
  if (coordinatePickingMode === false) {
    coordinatePickingMode = true;
    $("#pickFromMapBtn").html("Cancel picking");
    $("#map").addClass("pickingModeActive");
  } else {
    coordinatePickingMode = false;
    $("#pickFromMapBtn").html("Pick from map");
    $("#map").removeClass("pickingModeActive");
  }
}