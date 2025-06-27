<div class="vertical-menu">

                <div data-simplebar="init" class="h-100"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -17px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                    <div id="sidebar-menu" class="mm-active">
                        <ul class="metismenu list-unstyled mm-show" id="side-menu">
                            <li class="menu-title" key="t-menu">Menu</li>
                            @if (Auth::user()->grant_role === 'full_control')
                            <li>
                                <a href="{{ route('dashboard')}}" class="waves-effect">
                                    <i class="bx bx-home-circle"></i>
                                    <span key="t-dashboards">Dashboard</span>
                                </a>
                            </li>
                            @endif

                            <li>
                                <a class="has-arrow waves-effect">
                                    <!--upload icon in i tag-->
                                    <i class="bx bx-git-pull-request"></i>
                                    <span key="t-ecommerce">Drop Record</span>
                                </a>
                                <ul class="sub-menu mm-collapse" aria-expanded="false">
                                    @if (Auth::user()->grant_role === 'full_control' || Auth::user()->grant_role === 'modify')
                                    <li><a href="{{ route('storage.create')}}" key="t-product-detail">Add Drop File</a></li>
                                    @endif
                                    <li><a href="{{ route('storage.index')}}" key="t-products">Drop List</a></li>
                                    <!-- <li><a href="{{ route('storage.list')}}" key="t-products">Shift list</a></li> -->
                                </ul>
                            </li>

                            <!--Transactions-->
                            <li>
                                <a class="has-arrow waves-effect">
                                    <!--money icon in i tag-->
                                    <i class="bx bx-money"></i>
                                    <span key="t-ecommerce">Cashier Record</span>
                                </a>
                                <ul class="sub-menu mm-collapse" aria-expanded="false">
                                    @if (Auth::user()->grant_role === 'full_control' || Auth::user()->grant_role === 'modify')
                                    <li><a href="{{ route('transaction.create')}}" key="t-product-detail">Add Cashier Record</a></li>
                                    @endif
                                    <li><a href="{{ route('storage.list')}}" key="t-products">Cashier Record List</a></li>
                                </ul>
                            </li>

                            <li>
                                <a  class="has-arrow waves-effect">
                                    <i class="bx bx-user"></i>
                                    <span key="t-tasks">Attendants</span>
                                </a>
                                <ul class="sub-menu mm-collapse" aria-expanded="false">
                                    <li><a href="{{ route('attendant.index') }}" key="t-task-list">Attendant List</a></li>
                                    <li><a href="{{ route('attendant.create') }}" key="t-create-task">Create Attendant</a></li>
                                    <li><a href="{{ route('card-assignment.index') }}" key="t-card-assignment">Card Assignment</a></li>
                                    <li><a href="{{ route('card.index') }}" key="t-card-list">Cards</a></li>
                                    <li><a href="{{ route('card.create') }}" key="t-create-card">Create Card</a></li>
                                    @if (Auth::user()->grant_role === 'full_control')
                                    <li><a href="{{ route('attendant.performance') }}" key="t-create-task">Attendants Performance</a></li>
                                    @endif
                                </ul>
                            </li>


                            <li>
                                <a class="has-arrow waves-effect">
                                    <i class="bx bx-file"></i>
                                    <span key="t-tasks">Reports</span>
                                </a>
                                <ul class="sub-menu mm-collapse" aria-expanded="false">
                                    <li><a href="{{ route('reports.transactions')}}" key="t-products">Cashier Report</a></li>
                                    <li><a href="{{ route('reports.periodic')}}" key="t-products">Periodic Report</a></li>
                                </ul>

                            </li>
                            @if (Auth::user()->grant_role === 'full_control') 
                            <li>
                                <a  class="has-arrow waves-effect">
                                    <i class="bx bx-user"></i>
                                    <span key="t-tasks">Users</span>
                                </a>
                                <ul class="sub-menu mm-collapse" aria-expanded="false">
                                    <li><a href="{{ route('users.index') }}" key="t-task-list">User List</a></li>
                                    <li><a href="{{ route('users.create') }}" key="t-create-task">Create User</a></li>
                                </ul>
                            </li>
                            @endif
            
                        </ul>
                    </div>
                </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 576px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 125px; transform: translate3d(0px, 7px, 0px); display: block;"></div></div></div>
            </div>