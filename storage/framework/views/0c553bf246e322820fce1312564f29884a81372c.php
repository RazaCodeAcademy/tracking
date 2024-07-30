<?php $__env->startSection('title'); ?>
    Tracking | Dashboard
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="map-container">
        <div id="map"></div>

    </div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        setTimeout(() => {
            ele('search').value = '';
            getGroupList();

            getEventsData();
        }, 1000);

        // get object after 10 second and then plot on map
        const getObjectPlottingData = async () => {
            try {
                let response = await $.ajax({
                    url: "<?php echo e(route('getObjects')); ?>",
                    type: "GET"
                });

                global.objectData = response ? JSON.parse(response) : null;

                if (global.objectData) {
                    objectPlotting();
                }
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        const getDateTimeAtIndex = (array, dateIndex, timeIndex) => {
            const dateString = array[dateIndex];
            const timeString = array[timeIndex];
            const dateTimeString = `${dateString} ${timeString}`;
            return dateTimeString ? new Date(dateTimeString) : null;
        };

        // Function to get the date from a subarray at a specific index
        const getDateAtIndex = (item) => {
            const dateA = item[1];
            const dateB = item[4];
            const dateC = item[6];

            if (isDateString(dateA)) {
                return new Date(dateA);
            }
            if (isDateString(dateB)) {
                return new Date(dateB);
            }
            if (isDateString(dateC)) {
                return new Date(dateC);
            }
            return null;
        };

        // check string is a date or another value
        const isDateString = (value) => {
            const dateTimeRegex = /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/;
            return dateTimeRegex.test(value);
        };

        // sort the array
        const customSort = (mergedArray) => {
            return mergedArray.sort((a, b) => {
                const dateA = getDateAtIndex(a);
                const dateB = getDateAtIndex(b);

                if (!dateA) return -1;
                if (!dateB) return 1;

                return dateB - dateA;
            });
        }

        // get object history api
        const getObjectHistoryData = async (obj) => {
            try {
                displaySpinner();
                const response = await $.ajax({
                    url: `<?php echo e(route('getObjectHistory')); ?>?cmd=${obj.cmd}&imei=${obj.imei}&dtf=${obj.dtf}&dtt=${obj.dtt}&min_stop_duration=${obj.msd}`,
                    type: "GET",
                });

                var data = response ? JSON.parse(response) : null;

                if (data.route.length > 0) {
                    var mergedArray = [...data.stops, ...data.drives, ...data.events];

                    const sortedArray = customSort(mergedArray);

                    // Now, sortedArray is sorted based on the dates at index 6, 1, and 3 across all sub-arrays
                    global.routeData = data.route
                    setObjectRoute()
                    var html = '';
                    sortedArray.forEach((data, index) => {
                        html += appendHistoryData(data, index);
                    })
                    ele('history-data-container').innerHTML = html;
                    hideSpinner()
                } else {
                    hideSpinner()
                }
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        // get events data api
        const getEventsData = async () => {
            try {
                const response = await $.ajax({
                    url: `<?php echo e(route('getEventsList')); ?>` + (global.event_last_id != '' ?
                        `?last_id="${global.event_last_id}"` : ''),
                    type: "GET",
                });

                var data = response ? JSON.parse(response) : null;

                if (data.length > 0) {
                    // console.log(data.length);
                    data.sort((a, b) => new Date(b.dt_tracker) - new Date(a.dt_tracker));
                    global.eventsData = data;
                    global.event_last_id = data[data.length - 1].event_id;
                    var html = '';
                    data.forEach((event, index) => {
                        html += appendEventData(event, index);
                    })
                    ele('event-data-container').innerHTML = html + ele('event-data-container').innerHTML;
                }

            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        // get whatsappp group list api
        const getGroupList = async () => {
            try {
                let message = ele('event-message').value;
                const response = await $.ajax({
                    url: `<?php echo e(route('getGroupList')); ?>`,
                    type: "GET",
                });

                var data = response ? JSON.parse(response) : null;

                if (data.length > 0) {
                    global.groupList = data;
                    appendGroupList();
                }

            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        // send message data api to the whatsapp
        const sendMessage = async () => {
            try {
                displaySpinner();
                let to = ele('event-send-to').value;
                let message = ele('event-message').value;
                const response = await $.ajax({
                    url: `<?php echo e(route('sendMessages')); ?>`,
                    type: "POST",
                    data: {
                        message: message,
                        to: to,
                        last_id: global.resolveEventId
                    }
                });


                var data = response ? JSON.parse(response) : null;

                if (data) {
                    ele('message-event').click();
                    ele(global.resolveEventId).remove();
                    global.resolveEventId = '';
                    hideSpinner();
                }

            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        // get events data api
        const resolveEvent = async () => {
            try {
                const response = await $.ajax({
                    url: `<?php echo e(route('resolveEvent')); ?>?last_id="${global.resolveEventId}"`,
                    type: "GET",
                });

                var data = response ? JSON.parse(response) : null;
                ele(global.resolveEventId).remove();
                global.resolveEventId = '';
                ele('close-resolve-btn').click();

            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        // get elements here
        var overlay = document.getElementById("overlay");
        var spinner = document.getElementById("spinner");

        // click anywhere to hide dropdown
        document.addEventListener('click', function(event) {
            var dropdowns = document.querySelectorAll('.dropdown-toggle');

            dropdowns.forEach((dd) => {
                var dropdownContent = dd.nextElementSibling;

                // Check if the clicked element is inside the dropdown or not
                if (!dropdownContent.contains(event.target) && !dd.contains(event.target)) {
                    // Hide the dropdown
                    dropdownContent.style.display = 'none';
                }
            });
        });

        // dropdown toggler is here
        document.querySelectorAll('.dropdown-toggle').forEach((dd) => {
            dd.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent the click event from reaching the document
                var el = this.nextElementSibling;
                el.style.display = el.style.display === 'block' ? 'none' : 'block';
            });
        });

        // calculate time range to get object route history
        const calculateTimeRange = (imei, timeRange, stop = 1) => {
            var currentDateTime = new Date();
            var startTime = new Date(currentDateTime);
            var endTime = new Date(currentDateTime);

            if (timeRange === 'last_hour') {
                startTime.setHours(currentDateTime.getHours() - 1);
            } else if (timeRange === 'today') {
                startTime.setHours(0, 0, 0, 0);
                endTime = new Date(); // Set to the current date and time
            } else if (timeRange === 'yesterday') {
                startTime.setDate(currentDateTime.getDate() - 1);
                startTime.setHours(0, 0, 0, 0); // Set to the beginning of yesterday
                endTime = new Date(startTime);
                endTime.setHours(23, 59, 59); // Set to the end of yesterday
            } else if (timeRange === 'before_2_day') {
                startTime.setDate(currentDateTime.getDate() - 2);
                startTime.setHours(0, 0, 0, 0);
                endTime = new Date(startTime);
                endTime.setHours(23, 59, 59);
            } else if (timeRange === 'before_3_day') {
                startTime.setDate(currentDateTime.getDate() - 3);
                startTime.setHours(0, 0, 0, 0);
                endTime = new Date(startTime);
                endTime.setHours(23, 59, 59);
            } else if (timeRange === 'this_week') {
                startTime.setDate(currentDateTime.getDate() - currentDateTime.getDay());
            } else if (timeRange === 'last_week') {
                startTime.setDate(currentDateTime.getDate() - currentDateTime.getDay() - 6);
                endTime = new Date(startTime);
                endTime.setDate(startTime.getDate() + 6);
                endTime.setHours(23, 59, 59);
            } else if (timeRange === 'this_month') {
                startTime.setDate(1);
            } else if (timeRange === 'last_month') {
                startTime.setMonth(currentDateTime.getMonth() - 1);
                startTime.setDate(1);
                endTime = new Date(startTime);
                endTime.setMonth(startTime.getMonth() + 1);
                endTime.setDate(0);
                endTime.setHours(23, 59, 59);
            }

            // Format the result as a string (adjust formatting as needed)
            var startTimeString = startTime.toISOString().slice(0, 19).replace("T", " ");
            var endTimeString = endTime.toISOString().slice(0, 19).replace("T", " ");
            var data = {
                cmd: 'load_route_data',
                imei: imei,
                msd: stop,
                dtf: startTimeString,
                dtt: endTimeString
            }

            getObjectHistoryData(data)
        }

        //dragbale sidebar left
        document.addEventListener('DOMContentLoaded', (event) => {
            const draggable = document.getElementById('draggable');

            const resizeHandle = document.getElementById('resize-handle');

            resizeHandle.addEventListener('mousedown', onMouseDown);

            function onMouseDown(event) {
                event.preventDefault();

                let startX = event.clientX;
                let startWidth = parseInt(document.defaultView.getComputedStyle(draggable).width, 10);

                function onMouseMove(event) {
                    let newWidth = startWidth + (event.clientX - startX);
                    draggable.style.width = newWidth + 'px';
                }

                function onMouseUp() {
                    document.removeEventListener('mousemove', onMouseMove);
                    document.removeEventListener('mouseup', onMouseUp);
                }

                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
            }

            draggable.ondragstart = function() {
                return false; // Prevent default drag and drop behavior
            };
        });

        //dragbale sidebar right
        document.addEventListener('DOMContentLoaded', (event) => {
            const draggable = document.getElementById('draggable-right');

            const resizeHandle = document.getElementById('resize-handle-right');

            resizeHandle.addEventListener('mousedown', onMouseDown);

            function onMouseDown(event) {
                event.preventDefault();

                let startX = event.clientX;
                let startWidth = parseInt(document.defaultView.getComputedStyle(draggable).width, 10);

                function onMouseMove(event) {
                    let diffX = event.clientX - startX;
                    let newWidth = startWidth + diffX;
                    draggable.style.width = newWidth + 'px';
                    startX = event.clientX;;
                }

                function onMouseUp() {
                    document.removeEventListener('mousemove', onMouseMove);
                    document.removeEventListener('mouseup', onMouseUp);
                }

                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
            }

            draggable.ondragstart = function() {
                return false; // Prevent default drag and drop behavior
            };
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/tracking/resources/views/pages/index.blade.php ENDPATH**/ ?>