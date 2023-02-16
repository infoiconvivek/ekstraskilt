<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{url('admin/dashboard')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{URL::asset('admin/images/logo.png')}}" alt="" height="56">
            </span>
            <span class="logo-lg">
                <img src="{{URL::asset('admin/images/logo.png')}}" alt="" height="50">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{url('admin/dashboard')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{URL::asset('admin/images/logo.png')}}" alt="" height="56">
            </span>
            <span class="logo-lg">
                <img src="{{URL::asset('admin/images/logo.png')}}" alt="" height="50">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{url('admin/dashboard')}}">
                        <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>

                </li> <!-- end Dashboard Menu -->



                <li class="nav-item">
                    <a class="nav-link menu-link" href="#userData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="userData">
                    <i class="mdi mdi-account-circle-outline"></i> <span data-key="t-authentication">Manage Users</span>
                    </a>
                    <div class="collapse menu-dropdown" id="userData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/user/create')}}" class="nav-link"> Create User </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/user')}}" class="nav-link"> User List </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#groupsData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="groupsData">
                    <i class="mdi mdi-account-circle-outline"></i> <span data-key="t-authentication">Manage Groups</span>
                    </a>
                    <div class="collapse menu-dropdown" id="groupsData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/facility/create')}}" class="nav-link"> Create Facility </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/facility')}}" class="nav-link"> Facility List </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#positionData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="positionData">
                    <i class="mdi mdi-account-circle-outline"></i> <span data-key="t-authentication">Manage Position</span>
                    </a>
                    <div class="collapse menu-dropdown" id="positionData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/position/create')}}" class="nav-link"> Create Position </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/position')}}" class="nav-link"> Position List </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#bookingData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="bookingData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Booking</span>
                    </a>
                    <div class="collapse menu-dropdown" id="bookingData">
                        <ul class="nav nav-sm flex-column">


                            <li class="nav-item">
                                <a href="{{url('admin/booking')}}" class="nav-link"> Booking List </a>
                            </li>
                        </ul>
                    </div>
                </li>

                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#jobData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="jobData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Job</span>
                    </a>
                    <div class="collapse menu-dropdown" id="jobData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/job/create')}}" class="nav-link"> Create Job </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/job')}}" class="nav-link">Job List </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#slotData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="categoryData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Slots</span>
                    </a>
                    <div class="collapse menu-dropdown" id="slotData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/slot/create')}}" class="nav-link"> Create Slot </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/slot')}}" class="nav-link"> Slot List </a>
                            </li>
                        </ul>
                    </div>
                </li>


                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#categoryData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="categoryData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Objective</span>
                    </a>
                    <div class="collapse menu-dropdown" id="categoryData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/category/create')}}" class="nav-link"> Create Objective </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/category')}}" class="nav-link"> Objective List </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#vaccineData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="vaccineData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Vaccines</span>
                    </a>
                    <div class="collapse menu-dropdown" id="vaccineData">
                        <ul class="nav nav-sm flex-column">

                           
                            <li class="nav-item">
                                <a href="{{url('admin/vaccine/create')}}" class="nav-link"> Create Vaccine </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/vaccine')}}" class="nav-link"> Vaccine List </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#providedData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="providedData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage UserProvided</span>
                    </a>
                    <div class="collapse menu-dropdown" id="providedData">
                        <ul class="nav nav-sm flex-column">

                           
                            <li class="nav-item">
                                <a href="{{url('admin/provided/create')}}" class="nav-link"> Create UserProvided </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/provided')}}" class="nav-link"> UserProvided List </a>
                            </li>

                        </ul>
                    </div>
                </li>

                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#cmsData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="cmsData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage CMS</span>
                    </a>
                    <div class="collapse menu-dropdown" id="cmsData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/page/create')}}" class="nav-link"> Create Page </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/page')}}" class="nav-link"> Page List </a>
                            </li>

                           

                        </ul>
                    </div>
                </li>

               




                <li class="nav-item">
                    <a class="nav-link menu-link" href="#settingData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="settingData">
                        <i class="mdi mdi-puzzle-outline"></i> <span data-key="t-authentication">Setting</span>
                    </a>
                    <div class="collapse menu-dropdown" id="settingData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/setting')}}" class="nav-link"> My Profile </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{url('admin/admin-logout')}}" class="nav-link"> Logout </a>
                            </li>

                        </ul>
                    </div>
                </li>





            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>