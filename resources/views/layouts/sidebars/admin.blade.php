<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('admin.dashboard') }}"><i class="icon-home"></i><span class="hide-menu">Dashboard</span></a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('admin.staff.index') }}"><i class="mdi mdi-account-card-details"></i><span class="hide-menu">Staff</span></a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('admin.user.index') }}"><i class="icon-user"></i><span class="hide-menu">User</span></a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('admin.academic-year.index') }}"><i class="icon-calender"></i><span class="hide-menu">Academic Year</span></a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('admin.idea_report') }}"><i class="icons-Light-Bulb"></i><span class="hide-menu">Idea Report</span></a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
