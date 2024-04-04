<!-- Tracking sidebar -->
<div class="tracking-portion">
    <div class="tracking-events-sidebar">
        <div class="tracking-controls">
            <div class="track track-events-toggle-sidebar">
                <i class="fa fa-fw fa-outdent" aria-hidden="true"></i>
            </div>
        </div>
        <div class="tracking-events-sidebar__grid mb-3">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#events">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#places">Places</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#history">History</a>
                </li>
            </ul>
        </div>
        <hr>
        <div class="tracking-sidebar__inner">
            <div id="events" class="tab-content">
                <div class="p-2">
                    <button style="display: none" id="resolve-popup" type="button" class="btn btn-primary"
                        data-bs-toggle="modal" data-bs-target="#exampleModal1">
                        Launch Modal
                    </button>
                    <button style="display: none" id="whatsapp-popup" type="button" class="btn btn-primary"
                        data-bs-toggle="modal" data-bs-target="#exampleModal2">
                        Launch Modal
                    </button>
                    <div class="modal fade mx-2" style="width: 98%" id="exampleModal1" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="false">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #892e34;">
                                    <h5 class="modal-title text-white" id="exampleModalLabel">Resolve Event</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Modal body content goes here -->
                                    <h4>Are you sure, you want to resolve event?</h4>
                                    <input type="hidden" id="resolve-event-id">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="close-resolve-btn" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="resolveEvent()">Resolve</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade mx-2" style="width: 98%" id="exampleModal2" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="false">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #892e34;">
                                    <h5 class="modal-title text-white" id="exampleModalLabel">Whatapp Message</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Phone Number</label>
                                                    <input type="text" id="group-id" class="form-control">
                                                </div>
                                                
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Your Message</label>
                                                    <textarea type="text" rows="8" id="event-message" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="message-event" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" onclick="sendMessage()" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="tracking-sidebar__table table">
                    <thead>
                        <tr>
                            <th scope="col">Time</th>
                            <th scope="col">Object</th>
                            <th scope="col">Event</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="event-data-container">

                    </tbody>
                </table>
            </div>

            <div id="places" class="tab-content" style="display:none;">
                <h3>Places Content Goes Here</h3>
            </div>

            <div id="history" class="tab-content" style="display:none;">
                <div class="m-3">
                    <form action="">
                        <div class="row my-2">
                            <div class="col-3">Object</div>
                            <div class="col-9">
                                <select name="" id="imei" class="form-select">
                                    @foreach ($settingObjects as $key => $data)
                                        <option value="{{ $key }}" {{ $loop->iteration == 2 ? 'selected' : '' }}>{{ $data[4] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-3">Filter</div>
                            <div class="col-9">
                                <select name="" id="filter" class="form-select">
                                    <option value="last_hour">Last Hour</option>
                                    <option value="today">Today</option>
                                    <option value="yesterday">Yesterday</option>
                                    <option value="before_2_day">Before 2 Day</option>
                                    <option value="before_3_day">Before 3 Day</option>
                                    <option value="this_week">This Week</option>
                                    <option value="last_week">Last Week</option>
                                    <option value="this_month" selected>This Month</option>
                                    <option value="last_month">Last Month</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-3">Time From</div>
                            <div class="col-9">
                                <input type="datetime-local" id="time_from" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-3">Time To</div>
                            <div class="col-9">
                                <input type="datetime-local" id="time_to" class="form-control">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-3">Stops</div>
                            <div class="col-9">
                                <select name="" id="stops" class="form-select">
                                    <option value="1">> 1 min</option>
                                    <option value="2">> 2 min</option>
                                    <option value="5">> 5 min</option>
                                    <option value="10">> 10 min</option>
                                    <option value="20">> 20 min</option>
                                    <option value="30">> 30 min</option>
                                    <option value="60">> 1 h</option>
                                    <option value="120">> 2 h</option>
                                    <option value="300">> 5 h</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-3"></div>
                            <div class="col-8">
                                <button type="button" id="show-history" onclick="getHistoryData()"
                                    class="btn btn-success">Show</button>
                                <button type="button" id="hide-history" onclick="cleanPolygon(true)"
                                    class="btn btn-danger">Hide</button>
                                <button type="button" id="hide-history"
                                    class="btn btn-primary">Import/Export</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="inner-scroll-event">
                    <table class="tracking-sidebar__table table">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Time</th>
                                <th scope="col">Information</th>
                            </tr>
                        </thead>
                        <tbody id="history-data-container">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>
