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
          icon: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAACXBIWXMAAAsTAAALEwEAmpwYAAAJpUlEQVR4nO2aeVAU2R3Hp5JKZVO1SaqS2qSSVDapyiZ/mM3WmlVkPaNYCoIXIJcIszAM9zAIcgviDQse4IHgfcYD5HDxFpWZblQQA96uokj3ANM9IOKxIn5T7+kQjplhYEFxM9+qb73+9cx096d/r9/7dfdIJBZZZJFFFllk0f+l1Dr+T4zAezMCn8iKfAYj8CtYgVMwIm9bUlPzgeSHoJKamg9YkfNjBa6aFXkYMyNyrWfu38wNC5YpnaxHuth+/slHkvdNZTpuHCvyd0yB6l1wUYWEsCCcP34YF84Wv0oOC6j9ys7OS/K+iBG4UEbg2o0BFlWwSF+VgtTU5Si8XIYEZTCeP21A+8umDicrg+rei0wzomaBqWzuPVGENUsWopG/g/q6W0hNiMae7IwusMQXzh6F94xpy13GWctsP/3bZ5KhKLXITTWVWeLkqHC8fCF2gXvZputY1mnvQav5FlXl57BkfmhbJXsK2alLtL52U2MlQ0klDQ0fMiKnMTowaeuwLXcfksKCINTf7ZFRvZu0NaiuOA8C2nl9rK/3A78Z9pvmWFv/QzIUxAh8UnfISNk8yBym0uXFCTEoKc7Ds1YNLpUeQ+3dKqPQxBWqEyg9fhjsmSMd68hlkBIdzntOGj/9ncIeAH5sKLvLIoOROt8fB0tP49DO7C5ATx5rTALrfaOKgepEPm5Vl73u/i9EKN1dKt8KWDFu/7RM4KawAp/wunjg0g6UnowNnD37UqIyDN0dPdcJyb7u8LO1hXLmdKyerzDqzLgokyehc6YTA/3uDH4BIfDxrMCL3bOYuCACW91kOO8f38PL3OcgxccD5/zj4TXCCqccXKGa4WHQ2VMcsDY6oteMk5MS7DxLPaglISvwlw0NRMeuX4HMZjJ0CVloWriph5e7zUGSmxNd3u3qh82THfBobohBN88NQdTEScjbsQk3q1mDVp0saAv3dLs1w+rzYYMCW97Y+DtW4L41NvLGKxU46htlEJb4TGAsCnyUdLkhbj18razBufkbha5x8YPnaGtkbMxA1vacLk6Mi9w/0+qLWROGDftQMlhiBK7YGGxxVTlkNjZGs2vI/3YPQJaNvVFg4iMOLgiXehmqt+sZkYsqB34yKLCsyNsZgy2sYKHw9sRu9wBUhC422xeDF2HeyJEonemBSkcvo46cMBEp6Sto2dlj/wJfWarjPh54YIEvNAS7NjsTwc5jETVvFKK9rHvxqB5+/TvzTPaTkZPZM9sCX8sItX8YMFgAP2JFrsUQMDmAwNmjEfuVeY7xNgweTdabstcoBMz6Epmb1xkuUwVeTY7ze8Oqm+qGkznWVD28PG0l0kK8oNq+ss8+m7MU0glWOBrjaNJLXSfS/Zi8jxZ4736DqrTanzMCt4sRuFe93b9mbsvGodQovLpWhJQIfyxS+NGWxNtXRtN4sUIGUb0Xx7JX0Ji4On8DnlXmQT55NKq/nofCGGdEekxHnMc0Gqf5zaLxtlAnrPOZSvdj8lgEvn8VF1Nb+zPSRfQbqnnyCFXNWrOAg0ODEFNxlbYkXqDwp3FIejpuFW2koCRW5Bbi0JrELsDrA2fR9XKZlMah3i70uwTaLGCa5X5cy4zIr7mkq0f98ydoeGNzgX29PelBk5bESn8pjf1i4zqASeyfudEgMFnv7eZM40D31yegL8BqncbBLEgAaQA2tbW376p/2tquB73eInZkmH/WahC+M3DR+mQKQloSl+5Ko3HumoVovXSQdmMSE9eV7OgCXJLkQqGzg2bQeG+4I41JVzc/w324jgHYNz5/svVyUwNutIiofqTF3dbmHiafD1VgszNMBOAvN1rEHRd1GlxpbqTQN1tEVD3SdjH5XL+Ds7V3sCJ9JQ6mLBgaXVrUfCrpi1iRX01+SKBINkmWjW18fc4GpCXFYeeG1YjxcsP9E1vf9aDFkXvxvgELXFhvZ1FfTm7NTOu4TXvaWo9YqRsi5rkhIcAX8z3noL260OS0dLVgo8FpKd7Druu0pDBvWiIP8/sES8Q2Pvyrqbn3m+pyJEQoEODqhGuXVV3uTbkH1zoeyKmO52PPsgia1XtHs2m2uTPbaSyo9qCtuoAuXz2cCb83wHqrk91osVG5cm5H4ZE616Z3YJE73a+3FozIHeq+sfN8DTKyMhHq6Y5m8QG+e9bY42ljZ/MPrsFn6iTsXzEfxzckUeCyXak4sjYeNwo20AGMLOenx0A26csuwN9EOyJHZgt1sittiRMdx5s5SnNpfQZm6+t/ywr8g04bwcIIRcdzpN7cJNwHc6oINXeuYGmwDx5fOkCBDblzlzZlU1365mNdR73APW1pJ8cv6TN0k+bPpFTTd+Ndm3o+HDdm8tag7YVAl8tLTyBorgsUUg9wJdvpNU0GMqVcSqeszsDHYp2Q5DjeoOUTR2JpyjJaA+jhOpsUSZXNjbTlnj5eL+mPyIjHChrpybvXz6QvintpLnBn527LgmLfIbNGaXMzrK8CDRVFxE0vnv2HFFFvPLNf8H4O0+JToucL+Xu3IX/f/1ycu4cOVo3cLZw4vBcPa6qQu3ML9m9ej61fJyNwziwK6yOX4XZRFh2tSUzm5by1XYG3yO0QMtkaUfZj4Tn6n7T1GjO81y6tL5D09UG/rmNDyrt41jGPPYdc9myHi8pV2L1/N45vScO903uwOnYhsjMKoXSbR6ch/chMTEZmMkLrYzJwdQbO8rVFjtwe+ZHOCLcdQ1sC3RtweVM9LYjK3sRlIi+XDIRIFdPbzUO8bxAOH7xKW2MDlbFBqzPwZrmD2cDd5uLvVNoHvx8QYHpNi1zD2wCOchjXL2BW5FZJBlKsyG/R19D6br105RJEutgjK1oO6RQbBMycTVsSd/dG4qg3bbQc6yJ94T5mBH2iEWE/GtLxX0D2r5FwGvEZbT3HDKefBU62ovsh+1M3PjRWeJSQtyEDCswIGitSiZGpipxxYnLzEKkMMcuBUk/4OM/uYrmHa4/vBftKe6wj+yH7Iye7ezdmBC59wGH1YkXugDn19qBY4KoYkQ94fZPDrSL/GSEvCCSDqVId97Gha/kt+Bmjq38374NZHTeWdKXvC8EI3N0yrWYSK/I3TH5P5OrVYt1oybuUWltnY+gNotmwIn/7olj3R7ItcpdDXp2wIn+zGyjPiNwStUbzG8lQENNQ+wkrcOf6mNV2RuTWlQnCLwxt83wL/9EFUfN3prn2V5KhKkZXN51MC6zAvTQB+oIV+TxW0IyS/FB04VHdr1mxzrVM5CPJ415qgYsjJ6Rcp/vluz4+iyyyyCKLLLJI8k70X6FcGOL5C4wtAAAAAElFTkSuQmCC',
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