<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('qa_c.dashboard') }}"><i class="icon-home"></i><span class="hide-menu">Dashboard</span></a>
                </li>
                <li>
                    <a class="waves-effect waves-dark {{ in_array(Route::currentRouteName(),['qa_c.staff.list','qa_c.staff.idea.list','idea.detail']) ? 'active' : '' }}" href="{{ route('qa_c.staff.list') }}"><i class="mdi mdi-account-card-details" ></i><span class="hide-menu">Staff</span></a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('qa_c.idea_report') }}"><i class="icons-Light-Bulb"></i><span class="hide-menu">Idea Report</span></a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
