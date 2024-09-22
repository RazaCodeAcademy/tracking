$(document).ready(function () {
    //-------------Pagination Area----------//
    var totalPages;
    const tableId = 'data-container'; // Replace with the actual ID of your table element
    // Delegate click event to a parent element that exists when the page loads
    $(document).on('click', '.dropdown-toggle', function () {
        $(this).next('.dropdown-menu').toggle();
    });

    const getSettingObjectData = async () => {
        displaySpinner();
        let response = await $.ajax({
            url: routes.settingObject,
            type: "GET"
        });
        global.settingObjectData = response;
        await appendRowGroup();
        // Initial pagination setup
        updatePagination();
        appendSettingObjectList();
        // Add pagination controls if needed
    }

    setTimeout(() => {
        getSettingObjectData();
        getFunctionObjectData();
    }, 1000);


    // Counter to keep track of the current group
    function appendRowGroup() {
        const deviceIds = Object.keys(global.settingObjectData);
        deviceIds.forEach((deviceId) => {
            const data = global.settingObjectData[deviceId];

            const newRow = document.createElement('tr');
            newRow.classList.add('tracking-sidebar__content', 'table-row');

            newRow.innerHTML = `
                    <textarea name="" id="${deviceId}" cols="30" rows="10" class="d-none">${JSON.stringify(data)}</textarea>
                    <td scope="row">
                        <input type="checkbox" class="checkbox" id="checkbox-${deviceId}" onclick="checkedObject(${deviceId})" checked="true" />
                    </td>
                    <td onclick="objectFocused(${deviceId})">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="m-0 single-line">
                                <span class="tracking-badge">
                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                </span>
                                ${data[4]}
                            </p>
                            <div class="text-right">
                                <span id="${deviceId}_tracker_speed">${data[37] ? data[37] : 0}kph</span>
                                <span ><img src="${icons.engineStart}" width="15"></span>
                                <span ><img src="${icons.engineStop}" width="15"></span>
                                <span ><img src="${icons.connectionOn}" width="15"></span>
                            </div>
                        </div>
                    </td>
                    <td onclick="objectFocused(${deviceId})">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="m-0">
                                ${data[34]}
                            </p>
                        </div>
                    </td>
                    <td onclick="objectFocused(${deviceId})">
                        <div class="d-flex align-items-center justify-content-between">
                            <p id="${deviceId}_tracker_time" class="m-0">
                                ${data[35]}
                            </p>
                        </div>
                    </td>
                    <td onclick="objectFocused(${deviceId})" class="w-100">
                        <div class="d-flex justify-content-between">
                            <span id="${deviceId}_server_time">${data[36]}</span>

                            <div class="dropdown ml-2">
                                <span class=" dropdown-toggle" data-bs-toggle="dropdown" role="button"
                                    id="dropdownMenuLink" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </span>

                                <ul class="dropdown-menu custom-dropdown" aria-labelledby="dropdownMenuLink">
                                    <li class="dropdown dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#"
                                            id="multilevelDropdownMenu1" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">Show History</a>
                                        <ul class="dropdown-menu custom-dropdown"
                                            aria-labelledby="multilevelDropdownMenu1">
                                            <li class="dropdown dropend">
                                                <a href="#" class="dropdown-item"
                                                    onclick="calculateTimeRange(${deviceId}}, 'last_hour')">Last
                                                    Hour</a>
                                                <a href="#" class="dropdown-item"
                                                    onclick="calculateTimeRange(${deviceId}}, 'today')">Today</a>
                                                <a href="#" class="dropdown-item"
                                                    onclick="calculateTimeRange(${deviceId}}, 'yesterday')">Yesterday</a>
                                                <a href="#" class="dropdown-item"
                                                    onclick="calculateTimeRange(${deviceId}}, 'before_2_day')">Before
                                                    2 Day</a>
                                                <a href="#" class="dropdown-item"
                                                    onclick="calculateTimeRange(${deviceId}}, 'before_3_day')">Before
                                                    3 Day</a>
                                                <a href="#" class="dropdown-item"
                                                    onclick="calculateTimeRange(${deviceId}}, 'this_week')">This
                                                    Week</a>
                                                <a href="#" class="dropdown-item"
                                                    onclick="calculateTimeRange(${deviceId}}, 'last_week')">Last
                                                    Week</a>
                                                <a href="#" class="dropdown-item"
                                                    onclick="calculateTimeRange(${deviceId}}, 'this_month')">This
                                                    Month</a>
                                                <a href="#" class="dropdown-item"
                                                    onclick="calculateTimeRange(${deviceId}}, 'last_month')">Last
                                                    Month</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Follow</a></li>
                                    <li><a class="dropdown-item" href="#">Follow (new window)</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Streat View (new
                                            window)</a></li>
                                    <li><a class="dropdown-item" href="#">Send Command</a></li>
                                    <li><a class="dropdown-item" href="#">Edit</a></li>
                                </ul>
                            </div>
                        </div>
                    </td>
                `;

            document.getElementById(tableId).appendChild(newRow);
        });
    }

    function updatePagination() {
        var totalRecords = $('tr.tracking-sidebar__content').length;
        totalPages = Math.ceil(totalRecords / global.itemsPerPage);
        var start = (global.currentPage - 1) * global.itemsPerPage;
        var end = start + global.itemsPerPage;

        $('tr.tracking-sidebar__content').hide().slice(start, end).show();

        var startIndex = (global.currentPage - 1) * global.itemsPerPage + 1;
        var endIndex = Math.min(startIndex + global.itemsPerPage - 1, totalRecords);
        $('#pagination-info').text('Showing ' + startIndex + ' to ' + endIndex + ' of ' + totalRecords + ' entries');

        $('#pagination').empty();
        $('#pagination').append('<li class="page-item"><a class="page-link" href="#">Previous</a></li>');

        // Calculate the range of pages to display
        var pagesToShow = 3;
        var startPage = Math.max(global.currentPage - 1, 1);
        var endPage = Math.min(global.currentPage + 1, totalPages);

        if (startPage > 1) {
            $('#pagination').append('<li class="page-item"><a class="page-link" href="#">1</a></li>');
            if (startPage > 2) {
                $('#pagination').append('<li class="page-item disabled"><span class="page-link">...</span></li>');
            }
        }

        for (var i = startPage; i <= endPage; i++) {
            var pageLink = $('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
            if (i === global.currentPage) {
                pageLink.addClass('active');
            }
            $('#pagination').append(pageLink);
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                $('#pagination').append('<li class="page-item disabled"><span class="page-link">...</span></li>');
            }
            $('#pagination').append('<li class="page-item"><a class="page-link" href="#">' + totalPages + '</a></li>');
        }

        $('#pagination').append('<li class="page-item"><a class="page-link" href="#">Next</a></li>');
    }


    // Handle pagination click event
    $('#pagination').on('click', 'a.page-link', function (e) {
        e.preventDefault();

        var clickedPage = $(this).text();

        if (clickedPage === 'Next') {
            if (global.currentPage < totalPages) {
                global.currentPage++;
                updatePagination();
            }
        } else if (clickedPage === 'Previous') {
            if (global.currentPage > 1) {
                global.currentPage--;
                updatePagination();
            }
        } else {
            global.currentPage = parseInt(clickedPage);
            updatePagination();
        }
    });

    // Change event for items per page
    $('#items-per-page').change(function () {
        global.itemsPerPage = parseInt($(this).val());
        global.currentPage = 1;
        updatePagination();
    });

    //-------------Search Area----------//

    // Add an input event listener to the search input
    $('#search').on('input', function () {
        var searchText = $(this).val().toLowerCase();

        global.isFocussed = false;
        global.focussedObjectId = '';

        objectPlotting();

        // Hide all rows initially
        $('.table-row').hide();

        // Filter and show the rows that match the search text
        $('.table-row').filter(function () {
            return $(this).text().toLowerCase().includes(searchText);
        }).show();
    });

    $('.nav-link').click(function (e) {
        e.preventDefault();
        // Remove 'active' class from all tabs
        $('.nav-link').removeClass('active');
        // Add 'active' class to the clicked tab
        $(this).addClass('active');

        // Hide all tab content
        $('.tab-content').hide();

        // Show the content of the clicked tab
        var targetTab = $(this).attr('href');
        $(targetTab).show();
    });
});

const checkboxAll = (car = false) => {

    var checkboxAll = ele('checkboxAll');
    if (car) {
        checkboxAll.checked = !checkboxAll.checked
    }
    if (checkboxAll.checked) {
        $('.checkbox').prop('checked', true);
    } else {
        $('.checkbox').prop('checked', false);
    }
    objectPlotting();
}

// clear search box
const clearSearch = () => {
    ele('search').value = '';

    global.isFocussed = false;
    global.focussedObjectId = '';

    objectPlotting();

    // Hide all rows initially
    $('tr.tracking-sidebar__content').hide();

    // Filter and show the rows that match the search text within the current page
    var start = (global.currentPage - 1) * global.itemsPerPage;
    var end = start + global.itemsPerPage;

    $('tr.tracking-sidebar__content').filter(function (index) {
        return index >= start && index < end;
    }).show();
}
