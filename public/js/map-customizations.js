// create element and return it back
const ele = (id) => {
    return document.getElementById(id);
}

const getFunctionObjectData = async () => {
    let response = await $.ajax({
        url: routes.funcObject,
        type: "GET"
    });
    global.objectData = response ? JSON.parse(response) : null;
    global.fitbounds = true;
    await objectPlotting();
    setInterval(() => {
        getObjectPlottingData();
    }, 10000);

    setInterval(() => {
        getEventsData();
    }, 30000);

}

// icons urls
const icons = {
    arrowRed: "public/icons/markers/arrow-red.png",
    arrowGreen: "public/icons/markers/arrow-green.png",
    defaultMarkerUrl: "public/icons/markers/arrow_red.png",
    movingMarkerIcon: "public/icons/markers/arrow_green_1.png",
    startMarkerIcon: "public/icons/start-marker.png",
    endMarkerIcon: "public/icons/end-marker.png",
    clusterIcon: 'public/icons/markers/clusters/objects.svg',
    arrowBlue: 'public/icons/markers/arrow-blue.svg',
    routeEvent: 'public/icons/markers/route-event.svg',
    routeStart: 'public/icons/markers/route-start.svg',
    routeStop: 'public/icons/markers/route-stop.svg',
    engineStart: 'public/images/engine-on.svg',
    engineStop: 'public/images/engine.svg',
    connectionOn: 'public/images/connection-gsm-gps.svg',
    connectionMid: 'public/images/connection-gsm.svg',
    connectionOff: 'public/images/connection-no.svg',
}

// create marker icons
const createMarkerIcon = (h, w, url) => {
    return L.icon({
        iconUrl: url,
        iconSize: [h, w], // Adjust the size of the icon as needed
        iconAnchor: [15, 30], // Adjust the anchor point if needed
        popupAnchor: [0, -30] // Adjust the popup anchor if needed
    });
}

// global variables
const global = {
    // map area
    map: '',

    // markers area
    markers: '',
    individualMarkers: [],
    polylineGroup: '',
    startMarker: '',
    endMarker: '',
    markersByDeviceId: {},
    oldEventMarker: '',
    oldHistoryMarker: '',

    // data area
    settingObjectData: '',
    objectData: '',
    routeData: '',
    routeCoordinates: [],
    eventsData: [],

    // additional variables
    isFocussed: false,
    focussedObjectId: '',
    isClustered: true,
    itemsPerPage: 25,
    currentPage: 1,
    isShowLabel: false,
    last_events_data: [],
    event_last_id: '',
    isPolygonDisplayed: false,
    resolveEventId: '',
    groupList: [],
    fitbounds: false,
    focusedZoomLevel: 15,

    // markers icons area
    arrowRed: createMarkerIcon(20, 30, icons.arrowRed),
    arrowGreen: createMarkerIcon(20, 30, icons.arrowGreen),
    defaultIcon: createMarkerIcon(20, 30, icons.defaultMarkerUrl),
    movingMarkerIcon: createMarkerIcon(20, 30, icons.movingMarkerIcon),
    startMarkerIcon: createMarkerIcon(80, 80, icons.startMarkerIcon),
    endMarkerIcon: createMarkerIcon(80, 80, icons.endMarkerIcon),
    clusterIcon: createMarkerIcon(80, 80, icons.clusterIcon),
    arrowBlue: createMarkerIcon(20, 20, icons.arrowBlue),
    routeEvent: createMarkerIcon(30, 30, icons.routeEvent),
}

// this is data parser
const dataParser = (data) => {
    return JSON.parse(data);
}

// display spinner
const displaySpinner = () => {
    // Display the overlay and spinner
    overlay.style.display = "block";
    spinner.style.display = "block";
}

// hide spinner
const hideSpinner = () => {
    overlay.style.display = "none";
    spinner.style.display = "none";
}

// fetching data and parse it
// var setting_object_data = ele('setting_object_data').innerText;
// var object_data = ele('object_data').innerText;
// global.settingObjectData = dataParser(setting_object_data);
// global.objectData = dataParser(object_data);


// Initialize the map outside of the loop
global.map = L.map('map').setView([0, 0], 2);;

// Add a tile layer (you can use other tile providers)
// L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
//     attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
//     // maxZoom: 18
// }).addTo(global.map);
// L.tileLayer('https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}', {
//     // attribution: '© OpenStreetMap contributors'
// }).addTo(global.map);

// Define the tile layers
var openStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
});

var googleMaps = L.tileLayer('https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}', {
    attribution: 'Map data © Google'
});

var googleHybrid = L.tileLayer('http://mt0.google.com/vt/lyrs=y,traffic&hl=sl&x={x}&y={y}&z={z}', {
    attribution: 'Map data © Google Hybrid'
});


// Add the OpenStreetMap layer to the map by default
googleMaps.addTo(global.map);

// Create an object with the layers for the control
var baseLayers = {
    "OpenStreetMap": openStreetMap,
    "Google Street": googleMaps,
    "Google Hybrid": googleHybrid,
};

// Add the layer control to the map
L.control.layers(baseLayers).addTo(global.map);

// Create a marker cluster group
global.markers = L.markerClusterGroup({
    iconCreateFunction: function (cluster) {
        var childMarkers = cluster.getAllChildMarkers();
        var childCount = childMarkers.length;

        // Create a new HTML element for the cluster icon with image and count
        var htmlElement = document.createElement('div');
        htmlElement.className = 'custom-cluster-icon';
        htmlElement.innerHTML += '<span class="cluster-count">' + childCount + '</span>';
        htmlElement.innerHTML += `<img src="${icons.clusterIcon}" alt="Cluster Icon" class="cluster-icon-img">`;

        var customIcon = L.divIcon({ html: htmlElement, className: 'custom-cluster-icon' });

        return customIcon;
    }
});

// Add the marker cluster group to the map
global.map.addLayer(global.markers);

// create marker here
const makeMarker = (device) => {
    var lat = parseFloat(device.d[0][2]);
    var lng = parseFloat(device.d[0][3]);

    if (isNaN(lat) || isNaN(lng)) {
        console.warn(`Invalid coordinates for device: ${device.id}`);
        return;
    }

    // Create a marker and add it to the cluster group
    var marker = L.marker([lat, lng], {
        // icon: device.st == 'm' ? global.movingMarkerIcon : global.defaultIcon,
        icon: L.divIcon({
            className: 'rotated-marker',
            html: `<div class="arrow"><img src="${device.st == 'm' ? icons.arrowGreen : icons.arrowRed}" alt="Arrow Icon"></div>`,
        }),
        title: device.title,
    });

    // Bind a popup to the marker
    marker.bindPopup(
        '<b>Object</b> :  ' + device.title +
        '<br><b>Position</b> :  ' + `<a target="_blank" href="https://maps.google.com/maps?q=${lat},${lng}&t=m'">${lat} , ${lng}</a>` +
        '<br><b>Altitude</b> :  ' + device.d[0][4] +
        '<br><b>Angle</b> :  ' + device.d[0][5] +
        '<br><b>Speed</b> :  ' + device.d[0][6] + ' KM' +
        '<br><b>Time</b> :  ' + device.d[0][0] +
        '<br><b>Odometer</b> :  ' + device.o
    );

    if (global.isShowLabel) {
        marker.bindTooltip(device.title, { permanent: true }).openTooltip();
    }

    marker.addTo(global.markers);

    setRotationAngle(marker, device.d[0][5]);
    if (global.isFocussed && device.id == global.focussedObjectId) {
        global.focusedZoomLevel = global.map.getZoom()
        global.map.setView([lat, lng], global.focusedZoomLevel);
    }
}

const setRotationAngle = (marker, angle) => {
    // Set rotation angle
    var arrow = marker.getElement()?.getElementsByClassName('arrow')[0];
    if (arrow) {
        // L.DomUtil.setStyle(arrow, 'transform', 'rotate(' + device.d[0][4] + 'deg)');
        arrow.style.transform = 'rotate(' + angle + 'deg)';
    }
}

// Function to remove a marker by title
const removeMarkerByTitle = (title) => {
    global.map.eachLayer(function (layer) {
        if (layer instanceof L.Marker) {
            var markerTitle = layer.options.title || layer.feature.properties.title;
            if (markerTitle === title) {
                global.map.removeLayer(layer);
            }
        }
    });
}

// Object plotting code with marker clustering
const objectPlotting = () => {
    // Clear existing markers
    global.markers.clearLayers();
    const deviceIds = Object.keys(global.objectData);
    const lastIndex = deviceIds.length - 1;

    // Function to make markers for a group of devices
    deviceIds.forEach((deviceId, index) => {
        var device = global.objectData[deviceId];
        if (global.settingObjectData[deviceId]) {
            device.id = deviceId;
            device.title = global.settingObjectData[deviceId][4];
            var checkbox = ele(`checkbox-${deviceId}`);
            var searchText = ele('search').value;

            if (searchText.length > 0) {
                var markerTitle = device.title.trim().toLowerCase();
                if (markerTitle.includes(searchText.trim().toLowerCase())) {
                    updateLeftSidebarData(device, deviceId);
                    makeMarker(device);
                }
            } else if (device.d[0] !== undefined && checkbox.checked) {
                updateLeftSidebarData(device, deviceId);
                makeMarker(device);
            }

            if (index === lastIndex) {
                hideSpinner();
                if (global.fitbounds == true) {
                    global.map.fitBounds(global.markers.getBounds());
                    global.fitbounds = false;
                }
            }
        }
    });

};

// const update left sidebar data
const updateLeftSidebarData = (device, deviceId) => {
    ele(`${deviceId}_tracker_speed`).innerText = `${device.d[0][6]}kph`;
    ele(`${deviceId}_tracker_time`).innerText = device.d[0][0];
    // ele(`${deviceId}_server_time`).innerText = device.d[0][1];
}

// check and uncheck object from the list
const checkedObject = (deviceId) => {
    var checkbox = ele(`checkbox-${deviceId}`);
    if (checkbox.checked) {
        addOrRemoveMarker('add', deviceId);
    } else {
        global.focussedObjectId = '';
        addOrRemoveMarker('remove', deviceId);
    }
}

// select object from the list
const objectFocused = (deviceId) => {
    let object = ele(deviceId).innerText;
    object = object ? JSON.parse(object) : null;
    updateFooter(object, global.objectData[deviceId]);

    // Retrieve the marker data from the hidden textarea
    var markerData = global.objectData[deviceId];

    // Get the coordinates of the marker
    var lat = parseFloat(markerData.d[0][2]);
    var lng = parseFloat(markerData.d[0][3]);

    addOrRemoveMarker('add', deviceId);
    show3dMapIframe(lat, lng);

    global.isFocussed = true;
    global.focussedObjectId = deviceId;

    // Set the view of the map to the coordinates of the selected marker
    global.map.setView([lat, lng], 15); // You can adjust the zoom level (15 in this case) as needed
}

// Function to show labels on all markers, including those within clusters
const showLabels = () => {
    global.markers.eachLayer(cluster => {
        // Check if the layer is a cluster
        if (cluster instanceof L.MarkerCluster) {
            // Get all child markers within the cluster
            var childMarkers = cluster.getAllChildMarkers();

            // Iterate through each child marker and update its tooltip
            childMarkers.forEach(marker => {
                if (marker.options.title) {
                    // Create or update tooltip on the marker
                    marker.bindTooltip(marker.options.title, { permanent: true }).openTooltip();
                }
            });
        } else {
            // For individual markers (not within a cluster)
            if (cluster.options.title) {
                // Create or update tooltip on the marker
                cluster.bindTooltip(cluster.options.title, { permanent: true }).openTooltip();
            }
        }
    });
    global.isShowLabel = true;
};

// Function to hide labels on all markers, including those within clusters
const hideLabels = () => {
    global.markers.eachLayer(cluster => {
        // Check if the layer is a cluster
        if (cluster instanceof L.MarkerCluster) {
            // Get all child markers within the cluster
            var childMarkers = cluster.getAllChildMarkers();

            // Iterate through each child marker and close its tooltip
            childMarkers.forEach(marker => {
                marker.closeTooltip();
            });
        } else {
            // For individual markers (not within a cluster), close the tooltip
            cluster.closeTooltip();
        }
    });

    global.isShowLabel = false;
};

// Function to show current location on the map and zoom to it
const showCurrentLocation = () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                // Get the current coordinates
                const { latitude, longitude } = position.coords;

                // Create a marker for the current location
                const currentLocationMarker = L.marker([latitude, longitude], {
                    icon: global.arrowRed,
                    title: 'Current Location'
                })
                    .addTo(global.map)  // Assuming `map` is your Leaflet map instance
                    .bindPopup('Your Current Location')
                    .openPopup();

                // Zoom the map to the current location
                global.map.setView([latitude, longitude], 18); // Adjust the zoom level as needed
            },
            (error) => {
                console.error('Error getting location:', error.message);
            }
        );
    } else {
        console.error('Geolocation is not supported by your browser.');
    }
};

// Function to zoom out the map
const zoomOutMap = () => {
    // Use flyTo for a smooth animation
    global.map.flyTo(global.map.getCenter(), 4, {
        duration: 0.5, // Adjust the duration of the animation (in seconds)
        easeLinearity: 0.25 // Adjust the easing of the animation
    });
};

// Custom zoom in button functionality
ele('zoomInBtn').onclick = function () {
    global.map.zoomIn();
};

// Custom zoom out button functionality
ele('zoomOutBtn').onclick = function () {
    global.map.zoomOut();
};

// marker add or remove
const addOrRemoveMarker = (action, deviceId) => {
    // Extract the specific device
    var device = global.objectData[deviceId];

    if (!device || !device.d || device.d.length === 0) {
        console.error("Invalid device data or no data for device ID:", deviceId);
        return;
    }

    var lat = parseFloat(device.d[0][2]);
    var lng = parseFloat(device.d[0][3]);

    var marker = null;

    // Check if the marker already exists
    global.markers.eachLayer(layer => {
        if (layer instanceof L.Marker && layer.getLatLng().equals([lat, lng])) {
            marker = layer;
            return;
        }
    });

    if (action === 'add') {
        // Add marker if not already added
        if (!marker || global.isPolygonDisplayed) {
            console.log("Adding marker:", lat, lng);
            // marker = L.marker([lat, lng],{
            //     icon: global.startMarkerIcon,
            // }).addTo(global.map);
            // Create a marker and add it to the cluster group
            marker = L.marker([lat, lng], {
                // icon: device.st == 'm' ? global.movingMarkerIcon : global.defaultIcon,
                icon: L.divIcon({
                    className: 'rotated-marker',
                    html: `<div class="arrow"><img src="${device.st == 'm' ? icons.arrowGreen : icons.arrowGreen}" alt="Arrow Icon"></div>`,
                }),
                title: device.title,
            });

            // Bind a popup to the marker
            marker.bindPopup(
                '<b>Object</b> :  ' + device.title +
                '<br><b>Position</b> :  ' + lat + ', ' + lng +
                '<br><b>Altitude</b> :  ' + device.d[0][4] +
                '<br><b>Angle</b> :  ' + device.d[0][5] +
                '<br><b>Speed</b> :  ' + device.d[0][6] + ' KM' +
                '<br><b>Time</b> :  ' + device.d[0][0] +
                '<br><b>Odometer</b> :  ' + device.o
            );

            marker.addTo(global.map);
            return;
        }
        marker.setOpacity(1);
    } else if (action === 'remove') {
        // Remove marker if it exists
        if (marker) {
            console.log("Removing marker:", lat, lng);
            marker.setOpacity(0);
        }
    }

    // Fit the bounds of the marker cluster group on the map
    global.map.fitBounds(global.markers.getBounds());
}

// footer data is here
const updateFooter = (settingObject, object) => {
    // overview
    ele('protocol').innerText = settingObject[0]
    ele('username').innerText = settingObject[4]
    ele('device').innerText = settingObject[10]
    ele('sim_no').innerText = settingObject[11]
    ele('model').innerText = settingObject[12]
    ele('vin').innerText = settingObject[13]
    ele('plate_no').innerText = settingObject[14]
    ele('odometer_type').innerText = settingObject[17]
    ele('engine_hour').innerText = settingObject[18]
    // ele('object_expire_date').innerText = settingObject[33]

    // synopsis
    ele('server_date_time').innerText = object.d[0][0]
    ele('tracker_date_time').innerText = object.d[0][0]
    ele('average_speed').innerText = object.d[0][6]
    ele('running_duration').innerText = object.d[0][0]
    ele('stop_duration').innerText = object.ststr
    ele('connect_status').innerText = object.d[0][0]
    ele('current_address').innerText = object.d[0][0]
    ele('maximum_speed').innerText = object.d[0][0]
    ele('idle_duration').innerText = object.d[0][0]
    ele('nr_duration').innerText = object.d[0][0]
    ele('heart_beat_time').innerText = object.d[0][0]
    ele('current_speed').innerText = object.d[0][6]
    ele('distance_speed').innerText = object.d[0][0]
    ele('odometer').innerText = object.o
    ele('driver').innerText = object.d[0][0]
    ele('status').innerText = object.st
    ele('sn_protocol').innerText = object.p
    ele('vehicle_status').innerText = object.st
    ele('vehicle_stop').innerText = object.ststr
    ele('vehicle_iddle').innerText = object.st == "i" ? "i" : ""
    // ele('odometer').innerText = object.d[0][0]
}

// Function to unGroup clusters
const unGroupClusters = () => {
    // display the spinner
    displaySpinner();
    global.isClustered = false;

    // Remove the marker cluster group from the map
    global.map.removeLayer(global.markers);

    // Retrieve individual markers from the marker cluster group
    global.markers.eachLayer(function (layer) {
        if (layer instanceof L.Marker) {
            global.individualMarkers.push(layer);
        }
    });

    // clear markers from the layers
    global.markers.clearLayers();

    // add all markers to the map
    global.individualMarkers.forEach(function (marker) {
        global.map.addLayer(marker);
    });

    // Hide the spinner after all markers are plotted
    setTimeout(() => {
        hideSpinner();
    }, 500);
}

// Function to regroup clusters
const reGroupClusters = () => {
    // display a spinner
    displaySpinner();
    global.isClustered = true;

    // clear markers from the layers
    global.markers.clearLayers();

    // Collect individual markers and add them to the new cluster group
    global.map.eachLayer(function (layer) {
        if (layer instanceof L.Marker) {
            global.individualMarkers.push(layer);
            global.markers.addLayer(layer);
        }
    });

    // remove all old markers
    global.individualMarkers.forEach(function (marker) {
        global.map.removeLayer(marker);
    });

    // Add the new marker cluster group to the map
    global.map.addLayer(global.markers);

    // Hide the spinner after all markers are plotted
    setTimeout(() => {
        hideSpinner();
    }, 500);
};

// set object routes
const setObjectRoute = () => {
    global.map.removeLayer(global.markers);
    global.markers.clearLayers();
    cleanPolygon();
    // Create an array to store LatLng objects for the route
    var polylines = [];

    global.routeData.forEach(function (point, index) {
        var latlng = L.latLng(parseFloat(point[1]), parseFloat(point[2]));
        global.routeCoordinates.push([point[1], point[2]]);
        // global.routeCoordinates.push({lat: point[1], lng: point[2]});
        var speed = parseFloat(point[5]);
        var color;

        if (speed <= 40) {
            color = 'green';
        } else if (speed <= 80) {
            color = 'blue';
        } else if (speed <= 120) {
            color = 'maroon';
        } else {
            color = 'red';
        }

        // Create a segment polyline for each point (except the first one)
        if (index > 0) {
            var previousLatlng = L.latLng(parseFloat(global.routeData[index - 1][1]), parseFloat(global.routeData[index - 1][2]));
            var segmentPolyline = L.polyline([previousLatlng, latlng], { color: color });
            polylines.push(segmentPolyline);
        }
    });

    // Create markers for the start and end points
    global.startMarker = L.marker([parseFloat(global.routeData[0][1]), parseFloat(global.routeData[0][2])], {
        icon: global.startMarkerIcon,
    }).addTo(global.map);

    global.endMarker = L.marker([parseFloat(global.routeData[global.routeData.length - 1][1]), parseFloat(global.routeData[global.routeData.length - 1][2])], {
        icon: global.endMarkerIcon,
    }).addTo(global.map);

    // Create a layer group for all segment polylines
    global.polylineGroup = L.layerGroup(polylines);

    // Add the layer group to the map
    global.polylineGroup.addTo(global.map);

    // Calculate the bounds by iterating over each polyline
    var bounds = new L.LatLngBounds();
    polylines.forEach(function (polyline) {
        bounds.extend(polyline.getBounds().getNorthEast());
        bounds.extend(polyline.getBounds().getSouthWest());
    });

    // Extend bounds to include start and end markers
    bounds.extend(global.startMarker.getLatLng());
    bounds.extend(global.endMarker.getLatLng());
    global.isPolygonDisplayed = true;
    // Fit the map view to the calculated bounds
    global.map.fitBounds(bounds);
}

// clear polygon from the map
const cleanPolygon = (show = false) => {

    if (show == true) {
        console.log(global.markers);
        global.markers.addTo(global.map);
    }

    // Remove existing layers if they exist
    if (global.polylineGroup) {
        global.map.removeLayer(global.polylineGroup);
    }

    if (global.startMarker) {
        global.map.removeLayer(global.startMarker);
    }

    if (global.endMarker) {
        global.map.removeLayer(global.endMarker);
    }
    global.isPolygonDisplayed = false;
}

const getAngleBetweenPoints = (latlng1, latlng2) => {
    var lat1 = latlng1.lat;
    var lng1 = latlng1.lng;
    var lat2 = latlng2.lat;
    var lng2 = latlng2.lng;

    var deltaY = lat2 - lat1;
    var deltaX = lng2 - lng1;

    var angle = Math.atan2(deltaY, deltaX) * (180 / Math.PI);

    // Normalize the angle to be in the range [0, 360)
    angle = (angle + 360) % 360;

    return angle.toFixed(2);
}

let movingMarker = null; // Global reference to the marker
let isPaused = false; // Track whether the route is paused

const playRouteWithMarker = () => {
    if (!movingMarker) {
        // Create a moving marker if it doesn't already exist
        movingMarker = L.Marker.movingMarker(global.routeCoordinates, 20000, {
            icon: L.divIcon({
                className: 'rotated-marker',
                html: `<div class="arrow"><img src="${icons.arrowBlue}" alt="Arrow Icon"></div>`,
            }),
            loop: false // Set loop to false so it doesn't automatically restart
        }).addTo(global.map);

        let currentIndex = 0;

        // Update the rotation angle on each move
        movingMarker.on('move', function () {
            const currentPosition = movingMarker.getLatLng();
            const nextPosition = global.routeCoordinates[currentIndex + 1];

            if (nextPosition) {
                const angle = getAngleBetweenPoints(currentPosition, { lat: nextPosition[0], lng: nextPosition[1] });
                setRotationAngle(movingMarker, angle);
            }

            // Increment the index for the next position
            currentIndex++;
        });

        // Start the moving marker
        movingMarker.start();
    }

    if (isPaused) {
        // Resume the animation if it was paused
        movingMarker.resume();
        isPaused = false;
    } else {
        // Start the animation if it's not already running
        movingMarker.start();
        isPaused = false; // Ensure it's marked as not paused
    }
};

// Function to pause the moving marker
const pauseRouteWithMarker = () => {
    if (movingMarker && !isPaused) {
        // Pause the marker's movement
        movingMarker.pause();
        isPaused = true; // Mark it as paused
    }
};

const show3dMapIframe = (lat, lon) => {
    console.log('asdfasf')
    const heading = 0;
    const fov = 50;
    const src = `https://www.google.com/maps/embed?pb=!1m0!4v1629468843264!6m8!1m7!1sCAoSLEFGMVFpcE5sSEc5V0U0QVp5aVplbFprOFd3YzNJaDd2OHBwdXpWWTRRRWh3!2m2!1d${lat}!2d${lon}!3f${heading}!4f0!5f${fov}`;
    ele('street-view-iframe').src = src;
    document.querySelector(".bottom-bar").classList.add('show');
}
