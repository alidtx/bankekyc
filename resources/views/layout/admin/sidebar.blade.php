<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <a class="c-header-brand" href="/dashboard" style="background-color: #F8F8F9; width: 100%">
            <img src="{{asset('assets/img/avatars/logo.png')}}" alt="" style="width: 110px;padding: 8px;">
        </a>
    </div>
    <ul class="c-sidebar-nav">
        @can('Report Management')
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/dashboard">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-speedometer"></use>
                    </svg>
                    Dashboard
                    <!-- <span class="badge badge-info">NEW</span> -->
                </a>
            </li>
        @endcan


        @can('Checker Management')
            <li class="c-sidebar-nav-title">Checker</li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a
                    class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="javascript:void(0)">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-puzzle"></use>
                    </svg>
                    Application Status</a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{url('/checker/pending-application')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            Pending
                            <span
                                class="badge badge-warning">{{ApplicationHelper::getCount('pending','checker')}}</span>
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{url('/checker/approved-application')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            Submitted
                            <span
                                class="badge badge-info">{{ApplicationHelper::getCount('approved','checker')}}</span>
                        </a>
                    </li>
                <!--                     <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link"
                                                      href="{{url('/checker/declined-application')}}"><span
                                class="c-sidebar-nav-icon"></span> Declined</a></li> -->
                </ul>
            </li>
        @endcan




        @can('Approver Management')
            <li class="c-sidebar-nav-title">Approver</li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a
                    class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="javascript:void(0)">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-puzzle"></use>
                    </svg>
                    Application Status</a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{url('/approver/pending-application')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            Pending
                            <span
                                class="badge badge-warning">{{ApplicationHelper::getCount('pending','approver')}}</span>
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link"
                                                      href="{{url('/approver/approved-application')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            Approved
                            <span
                                class="badge badge-primary">{{ApplicationHelper::getCount('approved','approver')}}</span>
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{url('/approver/declined-application')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            Declined
                            <span
                                class="badge badge-danger">{{ApplicationHelper::getCount('declined','approver')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        @can(['Role Management','System User Management','Super Admin'])
            <li class="c-sidebar-nav-title">eKYC</li>
        @endcan
        @can('Super Admin')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="/form">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-drop1"></use>
                    </svg>
                    Form-Builder
                </a>
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{url('finger-print-v')}}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-drop1"></use>
                    </svg>
                     Finger Print Verification
                </a>
            </li>


            
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a
                    class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="javascript:void(0)">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-puzzle"></use>
                    </svg>
                    Form Settings</a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{url('/accountType')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            Account Type
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{url('/formType')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            Form Type
                        </a>
                    </li>
                <!--                     <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link"
                                                      href="{{url('/checker/declined-application')}}"><span
                                class="c-sidebar-nav-icon"></span> Declined</a></li> -->
                </ul>
            </li>

            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a
                    class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="javascript:void(0)">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-puzzle"></use>
                    </svg>
                    Sanction Screening</a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{url('/screening')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            Screening List
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{url('/screening/search')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            Search
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="javascript:void(0)">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-puzzle"></use>
                    </svg>
                    Scoring</a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{url('/scoreType')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            Score Type
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{url('/scoreQuestionnariesGroup')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            Score Questionnaries Group
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{url('/scoreQuestionnaries')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            Score Questionnaries
                        </a>
                    </li>
                    
                    
                </ul>
            </li>
            
            
            
        @endcan
        @can('Role Management')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{route('role.index')}}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-list"></use>
                    </svg>
                    Role Management
                </a>
            </li>
        @endcan
        @can('System User Management')
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('system-users.index')}}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                    </svg>
                    User Management</a></li>
        @endcan

        @can('Agent Management')
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('agents.index')}}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                    </svg>
                    Agent Management</a></li>
        @endcan
    </ul>
    {{--    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"--}}
    {{--            data-class="c-sidebar-minimized"></button>--}}
</div>
