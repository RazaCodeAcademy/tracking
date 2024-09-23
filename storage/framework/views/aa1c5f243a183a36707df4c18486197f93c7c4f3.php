<!-- sidebar -->
<aside class="sidebar">
    <nav class="navigation">
        <ul class="navigation__list">
            <li class="navigation__item active">
                <a href="#" class="navigation__link">
                    <i class="fa fa-desktop fa-fw" aria-hidden="true"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="navigation__item">
                <a href="#" class="navigation__link">
                    <i class="fa fa-map-marker fa-fw" aria-hidden="true"></i>
                    <span>Tracking</span>
                </a>
                <ul class="sub-navigation">
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-map-marker fa-fw" aria-hidden="true"></i>
                            <span>Live Tracking</span>
                        </a>
                    </li>

                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-exclamation-triangle fa-fw" aria-hidden="true"></i>
                            <span>Alerts</span>
                        </a>
                    </li>
                    
                </ul>
            </li>
            
            
            <li class="navigation__item">
                <a href="#" class="navigation__link">
                    <i class="fa fa-envelope-open fa-fw" aria-hidden="true"></i>
                    <span>SMS</span>
                </a>
                <ul class="sub-navigation">
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-comment fa-fw" aria-hidden="true"></i>
                            <span>SMS Logs</span>
                        </a>
                    </li>
                    
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-bell fa-fw" aria-hidden="true"></i>
                            <span>Commands Logs</span>
                        </a>
                    </li>
                    
                </ul>
            </li>
            <li class="navigation__item">
                <a href="#" class="navigation__link">
                    <i class="fa fa-usd fa-fw" aria-hidden="true"></i>
                    <span>Finance</span>
                </a>
                <ul class="sub-navigation">
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-usd fa-fw" aria-hidden="true"></i>
                            <span>Finance Dashboard</span>
                        </a>
                    </li>
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-line-chart fa-fw" aria-hidden="true"></i>
                            <span>Chart of Accounts</span>
                        </a>
                    </li>
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-book fa-fw" aria-hidden="true"></i>
                            <span>Account Jobs</span>
                        </a>
                    </li>
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-paper-plane-o fa-fw" aria-hidden="true"></i>
                            <span>Sale Invoices</span>
                        </a>
                    </li>
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-shopping-bag fa-fw" aria-hidden="true"></i>
                            <span>Purchase Invoices</span>
                        </a>
                    </li>
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-money fa-fw" aria-hidden="true"></i>
                            <span>Cash Receipt</span>
                        </a>
                    </li>
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-credit-card-alt fa-fw" aria-hidden="true"></i>
                            <span>Cash Payment</span>
                        </a>
                    </li>
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-window-close fa-fw" aria-hidden="true"></i>
                            <span>Sale Return</span>
                        </a>
                    </li>
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-bug fa-fw" aria-hidden="true"></i>
                            <span>Purchase Return</span>
                        </a>
                    </li>
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-binoculars fa-fw" aria-hidden="true"></i>
                            <span>Journal Voucher</span>
                        </a>
                    </li>
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-money fa-fw" aria-hidden="true"></i>
                            <span>Cheque Records</span>
                        </a>
                    </li>
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-university fa-fw" aria-hidden="true"></i>
                            <span>Banks</span>
                        </a>
                    </li>
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-file fa-fw" aria-hidden="true"></i>
                            <span>Ledger</span>
                        </a>
                    </li>
                    <li class="sub-navigation__item">
                        <a href="#" class="sub-navigation__link">
                            <i class="fa fa-pie-chart fa-fw" aria-hidden="true"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                </ul>
            </li>
            
        </ul>
    </nav>
</aside>



<!-- Tracking sidebar -->
<div class="tracking-portion" >
    <div class="tracking-sidebar" id="draggable">
        <div class="tracking-controls">
            <div class="track track-toggle-sidebar" id="resize-handle">
                <i class="fa fa-fw fa-outdent" aria-hidden="true"></i>
            </div>
            <div class="map__control-bar">
                <ul class="map__controls">
                    <li>
                        <a href="#" class="track track__map-controls" id="zoomInBtn">
                            <i class="fa fa-plus" aria-hidden="true" title="Zoom In Map"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="track track__map-controls" id="zoomOutBtn">
                            <i class="fa fa-minus" aria-hidden="true" title="Zoom Out Map"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="track track__map-controls" onclick="checkboxAll(true)">
                            <i class="fa fa-car" aria-hidden="true" title="Check All Checkboxes"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="track track__map-controls" onclick="showLabels()">
                            <i class="fa fa-tags" aria-hidden="true" title="Show Titles"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="track track__map-controls" onclick="hideLabels()">
                            <i class="fa fa-tags" aria-hidden="true" title="Hide Titles"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="track track__map-controls" onclick="showCurrentLocation()">
                            <i class="fa fa-eercast" aria-hidden="true" title="Your Location"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="track track__map-controls">
                            <i class="fa fa fa-road" aria-hidden="true" onclick="playRouteWithMarker()"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="track track__map-controls" onclick="reGroupClusters()">
                            <i class="fa fa-asterisk" aria-hidden="true" title="Add Cluster"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="track track__map-controls" onclick="unGroupClusters(true)">
                            <i class="fa fa-snowflake-o" aria-hidden="true" title="Remove Cluster"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="track track__map-controls" onclick="zoomOutMap()">
                            <i class="fa fa-arrows" aria-hidden="true" title="Reset Zoom Map"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tracking-sidebar__grid mb-3">
            <form class="tracking-sidebar__form" autocomplete="off">
                <div class="input-group">
                    <input id="search" type="text" autocomplete="off" class="form-control"
                        placeholder="Search Object" aria-label="Search Object"
                        aria-describedby="search-button-addon2" value="" />
                    <button class="theme-search-btn" type="button" id="search-button-addon2"
                        onclick="clearSearch()">
                        <i class="fa fa-fw fa-remove" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
            <div class="tracking-sidebar__tracklist">
                <div class="track"><i class="fa fa-fw fa-pause"></i></div>
                <div class="track"><i class="fa fa-fw fa-retweet"></i></div>
                <div class="track"><i class="fa fa-fw fa-filter"></i></div>
            </div>
        </div>
        <div class="tracking-sidebar__inner">
            <div class="inner-scroll-object">

            <table class="tracking-sidebar__table ts-table-width table" id="scrollableDiv">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" id="checkboxAll" onclick="checkboxAll()" checked="true" />
                        </th>
                        <th scope="col" class="w-50">Tracker</th>
                        
                        <th scope="col" class="w-25">Tracker Time</th>
                        <th scope="col" class="w-25"></th>
                    </tr>
                </thead>
                <tbody id="data-container">
                </tbody>
            </table>
        </div>

        </div>
        <div class="tracking-sidebar__footer">
            <div class="d-flex align-items-center mb-3">
                <select id="items-per-page" class="p-2 me-3">
                    <option>25</option>
                    <option>50</option>
                    <option>75</option>
                    <option>100</option>
                </select>

                
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center" id="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="#">9</a></li>
                        <li class="page-item"><a class="page-link" href="#">10</a></li>
                        <li class="page-item"><a class="page-link" href="#">11</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\tracking\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>