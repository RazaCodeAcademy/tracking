$(document).ready(function () {
    //-------------Pagination Area----------//
    const tableId = 'data-container'; // Replace with the actual ID of your table element
// Delegate click event to a parent element that exists when the page loads
    $(document).on('click', '.dropdown-toggle', function () {
        $(this).next('.dropdown-menu').toggle();
    });
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
                                ${data[4]}faafafafasfasfas afasfasfasf
                            </p>
                            <div class="text-right">
                                <span>${data[37] ? data[37] : 0}kph</span>
                                <span ><img src="${icons.engineStart}" width="15"></span>
                                <span ><img src="${icons.engineStop}" width="15"></span>
                                <span ><img src="${icons.connectionOn}" width="15"></span>
                            </div>
                        </div>
                    </td>
                    <td onclick="objectFocused(${deviceId})">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="m-0">
                                ${data[35]}
                            </p>
                        </div>
                    </td>
                    <td onclick="objectFocused(${deviceId})" class="w-100">
                        <div class="d-flex justify-content-between">
                            <span>${data[36]}</span>

                            <div class="dropdown ml-2">
                                <span class=" dropdown-toggle" data-bs-toggle="dropdown" role="button"
                                    id="dropdownMenuLink" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </span>
                        
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                                    <li class="dropdown dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#"
                                            id="multilevelDropdownMenu1" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">Show History</a>
                                        <ul class="dropdown-menu"
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
    appendRowGroup();
    function updatePagination() {
        var start = (global.currentPage - 1) * global.itemsPerPage;
        var end = start + global.itemsPerPage;

        // Hide all rows and show the ones for the current page
        $('tr.tracking-sidebar__content').hide().slice(start, end).show();

        // Update the content based on the response
        var startIndex = (global.currentPage - 1) * global.itemsPerPage + 1;
        var endIndex = Math.min(startIndex + global.itemsPerPage - 1, totalRecords);
        $('#pagination-info').text('Showing ' + startIndex + ' to ' + endIndex + ' of ' + totalRecords +
            ' entries');

        // Remove previous pagination links
        $('#pagination').empty();

        // Calculate the total number of pages
        var totalPagesToShow = 3; // Display 3 pages

        // Add "Previous" button
        $('#pagination').append('<li class="page-item"><a class="page-link" href="#">Previous</a></li>');

        // Add pagination links dynamically
        if (totalPages <= 6) {
            // Display all pages if total pages are less than or equal to 6
            for (var i = 1; i <= totalPages; i++) {
                var pageLink = $('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
                if (i === global.currentPage) {
                    pageLink.addClass('active');
                }
                $('#pagination').append(pageLink);
            }
        } else {
            // Display first 3 pages
            for (var i = 1; i <= 3; i++) {
                var pageLink = $('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
                if (i === global.currentPage) {
                    pageLink.addClass('active');
                }
                $('#pagination').append(pageLink);
            }

            // Display ellipsis
            $('#pagination').append('<li class="page-item disabled"><span class="page-link">...</span></li>');

            // Display last 3 pages
            for (var i = totalPages - 2; i <= totalPages; i++) {
                var pageLink = $('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
                if (i === global.currentPage) {
                    pageLink.addClass('active');
                }
                $('#pagination').append(pageLink);
            }
        }

        // Add "Next" button
        $('#pagination').append('<li class="page-item"><a class="page-link" href="#">Next</a></li>');
    }

    // Add pagination controls if needed
    var totalRecords = $('tr.tracking-sidebar__content').length;
    var totalPages = Math.ceil(totalRecords / global.itemsPerPage);

    // Handle pagination click event
    $('#pagination').on('click', 'a.page-link', function (e) {
        e.preventDefault();

        var clickedPage = $(this).text();

        if (clickedPage === 'Next') {
            global.currentPage = global.currentPage < totalPages ? global.currentPage + 1 : totalPages;
        } else if (clickedPage === 'Previous') {
            global.currentPage = global.currentPage > 1 ? global.currentPage - 1 : 1;
        } else {
            global.currentPage = parseInt(clickedPage) || global.currentPage;
        }

        updatePagination();
    });

    // Initial pagination setup
    updatePagination();

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
