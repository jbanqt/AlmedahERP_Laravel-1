@extends('layouts.app')
@section('content')
    <style>
        .badge-counter {
            color: white;
        }

    </style>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Bootstrap NavBar
        <nav class="navbar navbar-expand-md navbar-dark navbar-bg">

            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img src="images/Banner_Logo_1-3.jpg"
                    style="box-shadow: 0 4px 8px 0 rgba(247, 244, 227, 1), 0 0px 20px 0 rgba(247, 244, 227, 1); height:40px;">
            </a>
        </nav>
        NavBar END -->


    <nav class="navbar navbar-expand navbar-light topbar mb-2 static-top py-5"
        style="z-index:3; box-shadow: 0 0.15rem 1.75rem 0 rgb(58 59 69 / 15%) !important;">
        {{-- <input type="hidden" id="permissions" value="{{ $permissions }}"> --}}
        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>

        <!-- Brand -->
        <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <a class="navbar-brand" href="#">
                <img src="images/company_logo.png" style="width:450px">
            </a>
        </div>

        <!-- Topbar Search -->
        <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input id="search_menu" type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                    aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </div>


        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                    aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter" id="notif_count">0</span>
                </a>
                <!-- Dropdown - Alerts -->

                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Alerts Center
                    </h6>
                    <div id="alert_list_div">
                        <div>


                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>

            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-envelope fa-fw"></i>
                    <!-- Counter - Messages -->
                    <span class="badge badge-danger badge-counter">7</span>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">
                        Message Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                problem I've been having.</div>
                            <div class="small text-gray-500">Emily Fowler · 58m</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                            <div class="status-indicator"></div>
                        </div>
                        <div>
                            <div class="text-truncate">I have the photos that you ordered last month, how
                                would you like them sent to you?</div>
                            <div class="small text-gray-500">Jae Chun · 1d</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                            <div class="status-indicator bg-warning"></div>
                        </div>
                        <div>
                            <div class="text-truncate">Last month's report looks great, I am very happy with
                                the progress so far, keep up the good work!</div>
                            <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div>
                            <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                told me that people say this to all dogs, even if they aren't good...</div>
                            <div class="small text-gray-500">Chicken the Dog · 2w</div>
                        </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    @if (auth()->user())
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->first_name }}
                            {{ auth()->user()->last_name }}</span>
                    @else
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">No User</span>
                    @endif
                    <img class="img-profile rounded-circle" src="images/male.png"
                        style="height: 2rem;width: 2rem;vertical-align: middle; border-style: none;">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="menu dropdown-item">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>
                    {{-- <a href="#" data-parent="hr" class="menu list-group-item list-group-item-action bg-secondary">
                                    <span class="menu-collapsed align-middle">Employee</span> --}}
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                        Settings
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Activity Log
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>

    </nav>




    <!-- Bootstrap row -->
    <div class="row mb-1" id="body-row">
        <!-- Sidebar -->
        <div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
            <!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
            <!-- Bootstrap List Group -->
            <ul class="list-group">
                <!-- Separator with title -->
                <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed"
                    style="border-radius:0">
                    <small>MAIN MENU</small>
                </li>
                <!-- /END Separator -->
                <!-- Collapse Button -->
                <a href="#top" data-toggle="sidebar-colapse"
                    class="bg-dark  list-group-item list-group-item-action d-flex align-items-center">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span id="collapse-icon" class="fa fa-2x mr-3"></span>
                        <span id="collapse-text" class="menu-collapsed">Collapse</span>
                    </div>
                </a>
                <!-- End of Collapse Button -->
                <!-- Menu with submenu -->
                <!-- Dashboard -->
                <a href="#" id="inbox-toggle" class="menu list-group-item list-group-item-action bg-dark ">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-columns fa-fw mr-3"></span>
                        <span class="menu-collapsed align-middle smaller menu">Dashboard</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>

                {{-- User management Menu --}}
                <a href="#submenuUsermanageMent" data-toggle="collapse" aria-expanded="false"
                    class="bg-dark  list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fas fa-users-cog fa-fw mr-3 menu"></span>
                        <span class="menu-collapsed align-middle smaller">User Management</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>

                <!-- End of Menu Item Manufacturing -->
                <!-- Submenu UserManagement content -->
                <div id='submenuUsermanageMent' class="collapse sidebar-submenu">
                    <a href="#" id="inbox-toggle" data-parent="teamsAndRoles"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Roles</span>
                    </a>
                    <a href="#" id="inbox-toggle" data-parent="teamsAndRoles"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Departments</span>
                    </a>
                    <a href="#" id="inbox-toggle" data-parent="teamsAndRoles"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Employment Type</span>
                    </a>
                </div>
                {{-- End of User Management --}}
                <!-- End of dashboard -->
                <!-- Menu Item Messages -->
                <a href="#submenuMessages" data-toggle="collapse" aria-expanded="false"
                    class="bg-dark  list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-envelope-o fa-fw mr-3"></span>
                        <span class="menu-collapsed align-middle smaller">Messaging</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- End of Menu Item Messages -->
                <!-- Submenu Messages content -->
                <div id='submenuMessages' class="collapse sidebar-submenu">
                    <a href="#" id="inbox-toggle" data-parent="messaging"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Inbox</span>
                    </a>
                    <a href="#" id="important-toggle" data-parent="messaging"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Important</span>
                    </a>
                    <a href="#" id="archived-toggle" data-parent="messaging"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Archived</span>
                    </a>
                    <a href="#submenuMalingList" data-toggle="collapse" aria-expanded="false"
                        class="bg-secondary list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-start align-items-center">
                            <span class="menu-collapsed align-middle">Mailing List</span>
                            <span class="submenu-icon ml-auto"></span>
                        </div>
                    </a>
                    <div id='submenuMalingList' class="collapse sidebar-submenu">
                        <a href="#" class="list-group-item list-group-item-action bg-secondary text-light">
                            <span class="menu-collapsed align-middle mx-2">My Mailing List</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action bg-secondary text-light">
                            <span class="menu-collapsed align-middle mx-2">All Mailing List</span>
                        </a>
                    </div>
                </div>
                <!-- End of Submenu Messages content -->
                <!-- Menu Item Manufacturing -->
                <a href="#submenuManufacturing" data-toggle="collapse" aria-expanded="false"
                    class="bg-dark  list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-cogs fa-fw mr-3 menu"></span>
                        <span class="menu-collapsed align-middle smaller menu">Manufacturing</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- End of Menu Item Manufacturing -->
                <!-- Submenu Manufacturing content -->
                <div id='submenuManufacturing' class="collapse sidebar-submenu">
                @if (($permissions['Inventory']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#" id="inbox-toggle" data-parent="manufacturing"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Inventory</span>
                    </a>
                @endif

                @if (($permissions['Product']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#" id="inbox-toggle" data-parent="manufacturing"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Item</span>
                    </a>
                @endif

                @if (($permissions['Component']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#" id="inbox-toggle" data-parent="manufacturing"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Component</span>
                    </a>
                @endif

                @if (($permissions['BOM']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#" id="inbox-toggle" data-parent="BOM"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">BOM</span>
                    </a>
                @endif

                @if (($permissions['Machine_Manual']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#" id="inbox-toggle" data-parent="BOM"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Machine Manual</span>
                    </a>
                @endif

                <a href="#" id="inbox-toggle" data-parent="BOM"
                    class="menu list-group-item list-group-item-action bg-secondary">
                    <span class="menu-collapsed align-middle">Work Center</span>
                </a>

                @if (($permissions['Operations']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#" id="inbox-toggle" data-parent="BOM"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Operations</span>
                    </a>
                @endif

                @if (($permissions['Routings']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#" id="inbox-toggle" data-parent="manufacturing"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Routing</span>
                    </a>
                @endif
               
                <a href="#" id="inbox-toggle" data-parent="BOM"
                    class="menu list-group-item list-group-item-action bg-secondary">
                    <span class="menu-collapsed align-middle">Repair</span>
                </a>

                @if (($permissions['Station']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#" id="inbox-toggle" data-parent="manufacturing"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Workstation</span>
                    </a>
                @endif

                @if (($permissions['Work_Order']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#" id="inbox-toggle" data-parent="manufacturing"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Work Order</span>
                    </a>
                @endif

                @if (($permissions['Job_Scheduling']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#" id="inbox-toggle" data-parent="manufacturing"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Job Scheduling</span>
                    </a>
                @endif
                </div>
                <!-- End of Submenu Manufacturing content -->
                <!-- Menu Item Buying -->
                <a href="#submenuBuying" data-toggle="collapse" aria-expanded="false"
                    class="bg-dark  list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-shopping-cart fa-fw mr-3 menu"></span>
                        <span class="menu-collapsed align-middle smaller menu">Buying</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- End of Menu Item Buying -->
                <!-- Submenu Buying content -->
                <div id='submenuBuying' class="collapse sidebar-submenu">
                    @if (($permissions['Material_Request']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" data-parent="buying" id="inbox-toggle"
                            class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Material Request</span>
                        </a>
                    @endif

                    @if (($permissions['Supplier']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Supplier</span>
                        </a>
                    @endif

                    @if (($permissions['Request_Quotation']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" data-parent="buying" class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Request for Quotation</span>
                        </a>
                    @endif

                    @if (($permissions['Supplier_Quotation']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" data-parent="buying" class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Supplier Quotation</span>
                        </a>
                    @endif

                    @if (($permissions['Purchase_Order']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" data-parent="buying" id="inbox-toggle"
                            class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Purchase Order</span>
                        </a>
                    @endif

                    @if (($permissions['Purchase_Receipt']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" data-parent="buying" class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Purchase Receipt</span>
                        </a>
                    @endif

                    @if (($permissions['Purchase_Invoice']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" data-parent="buying" class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Purchase Invoice</span>
                        </a>
                    @endif

                    @if (($permissions['Pending_Orders']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" data-parent="buying" id="inbox-toggle"
                            class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Pending Orders</span>
                        </a>
                    @endif

                    
                    <!-- <a href="#" data-parent="buying" id="inbox-toggle" data-parent="manufacturing"
                            class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Item</span>
                        </a> -->
                    
                </div>
                <!-- End of Submenu Buying content -->
                <!-- Menu Item Accounting -->
                <a href="#submenuAccounting" data-toggle="collapse" aria-expanded="false"
                    class="bg-dark  list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-calculator fa-fw mr-3 menu"></span>
                        <span class="menu-collapsed align-middle smaller menu">Accounting</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- End of Menu Item Accounting -->
                <!-- Submenu Accounting content -->
                <div id='submenuAccounting' class="collapse sidebar-submenu">
                    <a href="#" id="inbox-toggle" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Sales Invoice</span>
                    </a>
                    @if (($permissions['Customer']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" id="inbox-toggle" class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Customer</span>
                        </a>
                    @endif

                    @if (($permissions['Supplier']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Supplier</span>
                        </a>
                    @endif
                    <a href="#" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Purchase Invoice</span>
                    </a>
                    <a href="#" id="inbox-toggle" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Accounts Payable</span>
                    </a>
                    <a href="#" id="inbox-toggle" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Accounts Receivable</span>
                    </a>
                    <a href="#" id="inbox-toggle" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Chart of Accounts</span>
                    </a>
                    <a href="#" id="inbox-toggle" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">General Ledger</span>
                    </a>
                </div>
                <!-- End of Submenu Accounting content -->
                <!-- Menu Item Selling -->
                <a href="#submenuSelling" data-toggle="collapse" aria-expanded="false"
                    class="bg-dark  list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-calendar fa-fw mr-3 menu"></span>
                        <span class="menu-collapsed align-middle smaller menu">Selling</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- End of Menu Item Selling -->
                <!-- Submenu Item Selling -->
                <div id='submenuSelling' class="collapse sidebar-submenu">
                    @if (($permissions['Customer']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" data-parent="selling" class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Customer</span>
                        </a>
                    @endif

                    @if (($permissions['Sales']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" data-parent="selling" class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Sales Order</span>
                        </a>
                    @endif
                
                </div>
                <!-- End of Submenu Item Selling -->
                <!-- Menu Item Product Releasing -->
                <a href="#submenuProductReleasing" data-toggle="collapse" aria-expanded="false"
                    class="bg-dark  list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fas fa-shipping-fast fa-fw mr-3"></span>
                        <span class="menu-collapsed align-middle smaller">Product Releasing</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- End of Menu Item Product Releasing -->
                <!-- Submenu Item Product Releasing -->
                @if (($permissions['Delivery']['view'] ?? null) === 1 || !auth()->user())
                    <div id='submenuProductReleasing' class="collapse sidebar-submenu">
                        <a href="#" data-parent="productreleasing"
                            class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Delivery</span>
                        </a>
                    </div>
                @endif
                <!-- End of Submenu Item Product Releasing -->
                <!-- Menu Item Stock -->
                <a href="#submenuStock" data-toggle="collapse" aria-expanded="false"
                    class="bg-dark  list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fas fa-boxes fa-fw mr-3 menu"></span>
                        <span class="menu-collapsed align-middle smaller menu">Stock</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- End of Menu Item Stock -->
                <!-- Submenu Item Stock -->
                <div id='submenuStock' class="collapse sidebar-submenu">
                    <a href="#" data-parent="stock" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Stock Entry</span>
                    </a>
                    @if (($permissions['Purchase_Receipt']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#" data-parent="stock" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Purchase Receipt</span>
                    </a>
                    @endif

                    @if (($permissions['Material_Request']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#" data-parent="stock" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Material Request</span>
                    </a>
                    @endif

                    @if (($permissions['Stock_Moves']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" data-parent="stock" class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Stock Moves</span>
                        </a>
                    @endif

                    @if (($permissions['Stock_Traceability']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" data-parent="stock" class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Stock Tracing</span>
                        </a>
                    @endif


                </div>
                <!-- End of Submenu Item Stock -->
                <!-- Menu Item CRM -->
                <a href="#submenuCRM" data-toggle="collapse" aria-expanded="false"
                    class="bg-dark  list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-users fa-fw mr-3 menu"></span>
                        <span class="menu-collapsed align-middle smaller menu">CRM</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- End of Menu Item CRM -->
                <!-- Submenu Item CRM -->
                <div id='submenuCRM' class="collapse sidebar-submenu">
                    <a href="#" data-parent="crm" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Leads</span>
                    </a>
                    @if (($permissions['Customer']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#" data-parent="crm" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Customer</span>
                    </a>
                    @endif
                    <a href="#" data-parent="crm" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Contacts</span>
                    </a>
                    <a href="#" data-parent="crm" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Objectives</span>
                    </a>
                </div>
                <!-- End of Submenu Item CRM -->
                <!-- Menu Item REPORTS -->
                @if (($permissions['Reports']['view'] ?? null) === 1 || !auth()->user())
                    <a href="#submenuREPORTS" data-toggle="collapse" aria-expanded="false"
                        class="bg-dark  list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-start align-items-center">
                            <span class="fa fa-users fa-fw mr-3 menu"></span>
                            <span class="menu-collapsed align-middle smaller menu">Reports</span>
                            <span class="submenu-icon ml-auto"></span>
                        </div>
                    </a>
                @endif
                <!-- End of Menu Item REPORTS -->
                <!-- Submenu Item REPORTS -->
                <div id='submenuREPORTS' class="collapse sidebar-submenu">
                    <a href="#" data-parent="reports" class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Reports Builder</span>
                    </a>
                </div>
                <!-- End of Submenu Item REPORTS -->
                <!-- Menu Item HR -->
                <a href="#submenuHR" data-toggle="collapse" aria-expanded="false"
                    class="bg-dark  list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fas fa-project-diagram fa-fw mr-3 menu"></span>
                        <span class="menu-collapsed align-middle smaller menu">HR</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- End of Menu Item HR -->
                <!-- Submenu Item HR -->
                <div id='submenuHR' class="collapse sidebar-submenu">
                    @if (($permissions['Employee']['view'] ?? null) === 1 || !auth()->user())
                        <a href="#" data-parent="hr" class="menu list-group-item list-group-item-action bg-secondary">
                            <span class="menu-collapsed align-middle">Employee</span>
                        </a>
                    @endif

                    <a href="#" id="inbox-toggle" data-parent="teamsAndRoles"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Departments</span>
                    </a>
                    <a href="#" id="inbox-toggle" data-parent="teamsAndRoles"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Employment Type</span>
                    </a>
                    
                </div>
                <!-- End of Submenu Item HR -->
                <a href="#submenunewUI" data-toggle="collapse" aria-expanded="false"
                    class="bg-dark  list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="menu-collapsed align-middle smaller">NEW USER INTERFACE</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- End of Menu Item Messages -->
                <!-- Submenu Messages content -->
                <div id='submenunewUI' class="collapse sidebar-submenu">
                    <a href="#" id="address-toggle" data-parent="NewUI"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Operators</span>
                    </a>
                    <a href="#" id="address-toggle" data-parent="NewUI"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Address</span>
                    </a>
                    <a href="#" id="Coupon-toggle" data-parent="newUI"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Coupon Code</span>
                    </a>
                    <a href="#" id="Pricing_Rule" data-parent="NewUI"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Pricing Rule</span>
                    </a>
                    <a href="#" id="PricingB-toggle" data-parent="newUI"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Product Bundle</span>
                    </a>
                    <a href="#" id="Shipping_Rule" data-parent="NewUI"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Shipping Rule</span>
                    </a>
                    <a href="#" id="Purchase-toggle" data-parent="newUI"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Purchase Taxes</span>
                    </a>
                    <a href="#" id="Salestaxes-toggle" data-parent="newUI"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Sales Taxes</span>
                    </a>
                    <a href="#" id="suppliergroup-toggle" data-parent="newUI"
                        class="menu list-group-item list-group-item-action bg-secondary">
                        <span class="menu-collapsed align-middle">Supplier Group</span>
                    </a>
                </div>
            </ul>
            <!-- List Group END-->
        </div>
        <!-- sidebar-container END -->
        <!-- MAIN -->
        <div class="col p-3 div-tab" id="divMain" style="overflow: auto">
        </div>
        <!-- Main Col END -->
    </div>
    <!-- body-row END -->


    <footer class="sticky-footer text-light" style="background:#14213D">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright © Almedah Food Machineries, Corp.</span>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/side-nav.js') }}"></script>
    <script src="{{ asset('js/tab-nav.js') }}"></script>
    <script>
        $(function() {
            var menu_list = [
                "Dashboard",
                "Inbox",
                "Important",
                "Archived",
                "Mailing List",
                "My Mailing List",
                "Manufacturing",
                "Bom",
                "Operations",
                "Machine Manual",
                "Work Center",
                "Work Order",
                "Employee",
                "Roles",
                "Department",
                "Reports Builder",
                "Employment Type",
                "Production",
                "Customer",
                "Production Plan",
                "Workstation",
                "Routing",
                "Inventory",
                "Item",
                "Component",
                "Item Attribute",
                "Item Price",
                "Buying",
                "Material Request",
                "Purchase Order",
                "Pending Orders",
                "Purchase Invoice",
                "Purchase Receipt",
                "Request for Quotation",
                "Supplier Quotation"
            ];
            $("#search_menu").autocomplete({
                source: menu_list,
                select: function(event, ui) {
                    //console.log(ui);
                    if (!$("#tabs").length) {
                        $("#divMain").html(
                            `<ul class="nav nav-tabs" id="tabs"></ul>
        <div class="tab-content border-secondary" id="contents"></div>`
                        );
                    }
                    //checks if the clicked item has its tab is shown
                    var menu = ui.item.value.replace(/\s/g, '');
                    var moduleWithSpace = ui.item.value;
                    if (!$(`#tab${menu}`).length) {
                        loadTab(menu, moduleWithSpace);
                    }
                    // if it's active, show it
                    else {
                        $(`#tab${menu}`).tab("show");
                    }
                    //$("#divMain").load("/" + ui.item.value.toLowerCase().replace(/\s/g, ''));
                }
            });
        });

        /*Jerone's Code*/
        // function auto_load(){
        //    $( document ).ready(function() {
        //         $.ajax({
        //             url: "{{ route('get_notifications') }}",
        //             method:"GET",
        //             cache: false,
        //             success: function(data){
        //                 $('#notif_count').html(data.results.length);
        //                 console.log(data.results.length);
        //                 var content = '';
        //                 data.results.forEach(function(item) {
        //                     content+=`
    //                                     <a class="dropdown-item d-flex align-items-center" href="#">
    //                                         <div class="mr-3">
    //                                             <div class="icon-circle bg-primary">
    //                                                 <i class="fas fa-file-alt text-white"></i>
    //                                             </div>
    //                                         </div>
    //                                         <div>
    //                                             <div class="small text-gray-500">${new Date(item.created_at).toDateString()}</div>
    //                                             <span class="font-weight-bold">${item.description}</span>
    //                                         </div>
    //                                     </a>                    
    //                     `;
        //                 });
        //                 $('#alert_list_div').html(content);
        //             }
        //         });
        //    });
        // }
        // auto_load();
        // setInterval(auto_load,5000);

        // 
    </script>
@endsection
