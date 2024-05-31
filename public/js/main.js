const toggler = document.querySelector(".bottom-bar__toggler");
const bottomBar = document.querySelector(".bottom-bar");
const sidebarToggler = document.querySelector(".track-toggle-sidebar");
const sidebar = document.querySelector(".tracking-sidebar");

const eventSidebarToggler = document.querySelector(".track-events-toggle-sidebar");
const eventSidebar = document.querySelector(".tracking-events-sidebar");

toggler.addEventListener("click", (e) => {
    e.target.classList.toggle("active");
    bottomBar.classList.toggle("show");
});

sidebarToggler.addEventListener("click", (e) => {
    sidebarToggler.classList.toggle("rotate");
    sidebar.classList.toggle("show");
});

eventSidebarToggler.addEventListener("click", (e) => {
    eventSidebarToggler.classList.toggle("rotate");
    eventSidebar.classList.toggle("show");
});

const appendGroupList = () => {
    var html = '';
    if (global.groupList.length > 0) {
        global.groupList.forEach((group) => {
            html += `
            <a class="dropdown-item" href="#" onclick="bindDropdownItemClick()" data-value="${group.whatsapp_number}" data-tokens="${group.whatsapp_number}">${group.whatsapp_group}</a>

            `;
        })
    }
    ele('dropdownMenuItems').innerHTML = html;
}

const appendSettingObjectList = () => {
    var html = '';
    const deviceIds = Object.keys(global.settingObjectData);
    deviceIds.forEach((deviceId) => {
        const data = global.settingObjectData[deviceId];
        html += `
            <a class="dropdown-item" href="#" onclick="bindDropdownObjectItemClick()" data-value="${deviceId}" data-tokens="${deviceId}">${data[4]}</a>

            `;
    });
    ele('dropdownObjectMenuItems').innerHTML = html;
}

$(document).ready(function () {
    $('#dropdownSearch').on('input', function () {
        var filter = $(this).val().toLowerCase();
        $('#dropdownMenuItems a').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(filter) > -1);
        });
    });

    $('#dropdownObjectSearch').on('input', function () {
        var filter = $(this).val().toLowerCase();
        $('#dropdownObjectMenuItems a').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(filter) > -1);
        });
    });
});

const bindDropdownItemClick = () => {
    $('#dropdownMenuItems a').on('click', function () {
        var selectedText = $(this).text();
        var selectedValue = $(this).data('value');
        console.log(selectedText, selectedValue);
        $('#dropdownMenuButton').text(selectedText);
        $('#event-send-to').val(selectedValue);
        // $('#dropdownMenuButton').dropdown('toggle');
        $('.dropdown-menu').css('display', 'none');
    });
}

const bindDropdownObjectItemClick = () => {
    $('#dropdownObjectMenuItems a').on('click', function () {
        var selectedText = $(this).text();
        var selectedValue = $(this).data('value');
        console.log(selectedText, selectedValue);
        $('#dropdownObjectMenuButton').text(selectedText);
        $('#imei').val(selectedValue);
        // $('#dropdownMenuButton').dropdown('toggle');
        $('.dropdown-menu').css('display', 'none');
    });
}

const appendEventData = (data, index) => {
    global.last_events_data[data.event_id] = data;
    var notify_system = data.notify_system.split(',');
    if (notify_system[0] == true) {
        displayToasterMessages(data, index, notify_system[1]);
    }
    return `<tr class="tracking-events-sidebar__content cursor" onclick="showEvent(${data.event_id})" id="${data.event_id}">
		<td>
			${data.dt_tracker}
		</td>
		<td>
			<p class="m-0 single-line">
				${data.name}
			</p>
		</td>
		<td>
			${data.event_desc}
		</td>
		<td>
			<div class="d-flex">
				<svg onclick="showResolvePopup(${data.event_id})" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0,0,256,256">
					<g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(0.5,0.5)"><path d="M504.1,256c0,-137 -111.1,-248.1 -248.1,-248.1c-137,0 -248.1,111.1 -248.1,248.1c0,137 111.1,248.1 248.1,248.1c137,0 248.1,-111.1 248.1,-248.1z" fill="#be4f32"></path><path d="M416.2,275.3v-38.6l-36.6,-11.5c-3.1,-12.4 -8,-24.1 -14.5,-34.8l17.8,-34.1l-27.3,-27.3l-34.2,17.8c-10.6,-6.4 -22.2,-11.2 -34.6,-14.3l-11.6,-36.8h-38.7l-11.6,36.8c-12.3,3.1 -24,7.9 -34.6,14.3l-33.9,-17.8l-27.4,27.4l17.8,34.1c-6.4,10.7 -11.4,22.3 -14.5,34.8l-36.6,11.5v38.6l36.4,11.5c3.1,12.5 8,24.3 14.5,35.1l-17.6,33.6l27.3,27.3l33.7,-17.6c10.8,6.5 22.7,11.5 35.3,14.6l11.4,36.2h38.7l11.4,-36.2c12.6,-3.1 24.4,-8.1 35.3,-14.6l33.7,17.6l27.3,-27.3l-17.6,-33.8c6.5,-10.8 11.4,-22.6 14.5,-35.1zM256,340.8c-46.7,0 -84.6,-37.9 -84.6,-84.6c0,-46.7 37.9,-84.6 84.6,-84.6c46.7,0 84.5,37.9 84.5,84.6c0,46.8 -37.8,84.6 -84.5,84.6z" fill="#ffffff"></path></g></g>
				</svg>
				<svg onclick="showWhatsappPopup(${index})" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 48 48">
					<path fill="#fff" d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z"></path><path fill="#fff" d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z"></path><path fill="#cfd8dc" d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z"></path><path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z"></path><path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd"></path>
				</svg>
			</div>
		</td>
	</tr>`;
}

const checkDataLength = (data) => {
    var len = data.length;
    if (len == 8) { // events
        return [
            icons.routeEvent,
            data[1],
            data[4],
        ]
    }
    else if (len == 13) { // stops
        return [
            icons.routeStop,
            data[6],
            data[8],
        ]
    } else if (len == 15) { //drives
        return [
            icons.routeStart,
            data[4],
            data[6],
        ]
    }
}

const appendHistoryData = (data, index) => {
    data = checkDataLength(data);
    return `<tr class="tracking-events-sidebar__content cursor" onmouseover="showPopup(${index})" onmouseout="hidePopup(${index})" onclick="showEvent()">
		<td>
			<div class="popup" id="popup-${index}">
				<p>Route Length: ${index}</p>
				<p>Move Duration: ${index}</p>
				<p>Stop Duration: ${index}</p>
				<p>Top Speed: ${index}</p>
				<p>Average Speed: ${index}</p>
				<p>Engine Work: ${index}</p>
				<p>Engine Idle: ${index}</p>
			</div>
			<img src="${data[0]}" width="30" />
		</td>
		<td>
			<p class="m-0">
				${data[1]}
			</p>
		</td>
		<td>
			${data[2]}
		</td>
	</tr>
	`;
}

const getHistoryData = () => {
    let imei = ele('imei').value;
    let filter = ele('filter').value;
    let time_from = ele('time_from').value;
    let time_to = ele('time_to').value;
    let stops = ele('stops').value;
    if (filter) {
        calculateTimeRange(imei, filter, stops);
    } else {
        var data = {
            cmd: 'load_route_data',
            imei: imei,
            msd: stops,
            dtf: time_from,
            dtt: time_to
        }
        getObjectHistoryData(data);
    }
}

const showEvent = (id) => {
    var event = global.last_events_data[id];
    if (global.oldEventMarker) {
        global.map.removeLayer(global.oldEventMarker);
    }
    if (event) {
        var marker = L.marker([event.lat, event.lng], {
            icon: global.routeEvent,
            title: event.name,
        });

        marker.bindPopup(
            '<b>Object</b> :  ' + event.name +
            '<br><b>Event</b> :  ' + event.event_desc +
            '<br><b>Address</b> :  ' + '' +
            '<br><b>Position</b> :  ' + event.lat + ', ' + event.lng +
            '<br><b>Altitude</b> :  ' + event.altitude +
            '<br><b>Angle</b> :  ' + event.angle +
            '<br><b>Speed</b> :  ' + event.speed + ' KM' +
            '<br><b>Time</b> :  ' + event.dt_tracker
        );

        global.map.addLayer(marker);
        marker.openPopup();
        global.oldEventMarker = marker;
    }
}

const displayToasterMessages = (event, index, autoHide) => {
    message = `<div class="notification-header">New Event</div>
	<div class="notification-content">
		<div class="row">
			<div class="col-3">Object :</div>
			<div class="col-9">${event.name}</div>
		</div>
		<div class="row">
			<div class="col-3">Event :</div>
			<div class="col-9">${event.event_desc}</div>
		</div>
		<div class="row">
			<div class="col-3">Position :</div>
			<div class="col-9">${event.lat + ', ' + event.lng}</div>
		</div>
		<div class="row">
			<div class="col-3">Time :</div>
			<div class="col-9">${event.dt_tracker}</div>
		</div>
		<div class="row">
			<div class="col-4"></div>
			<div class="col-8">Show event</div>
		</div>

	</div>`
    var delayInMilliseconds = 0;
    if (autoHide == true) {
        delayInMilliseconds = (5000 + (index * 20))
    }
    showEventNotification(message, delayInMilliseconds)
}

const showEventNotification = (message, delayInMilliseconds) => {
    toastr.options = {
        "closeButton": true,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": delayInMilliseconds,
        "extendedTimeOut": delayInMilliseconds,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "escapeHtml": false,
    };

    toastr.error(message);
}

const showPopup = (index) => {
    const popup = document.getElementById(`popup-${index}`);
    // console.log(popup);
    popup.style.display = 'block';
}

const hidePopup = (index) => {
    const popup = document.getElementById(`popup-${index}`);
    popup.style.display = 'none';
    // console.log(popup);

}

const showWhatsappPopup = (index) => {
    getGroupList();
    let message = messageFormat(index);
    ele('whatsapp-popup').click();
    ele('event-message').value = message
}

const messageFormat = (index) => {

    let event = global.eventsData[index];
    global.resolveEventId = event.event_id;
    var url = encodeURIComponent(`https://maps.google.com/maps?q=${event.lat},${event.lng}&t=m`);
    const formattedMessage = `
    << DIGITRACK >>
Name  : ${event.name}
Event : ${event.event_desc}
Date  : ${event.dt_tracker}
Lat   : ${event.lat}
Lng   : ${event.lng}
GMAP  : 'https://maps.google.com/maps?q=${event.lat},${event.lng}&t=m'
`;

    return formattedMessage;
}

const showResolvePopup = (event_id) => {
    ele('resolve-popup').click();
    global.resolveEventId = event_id;
}
