<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('staff.dashboard') }}"><i class="icon-home"></i><span class="hide-menu">Dashboard</span></a>
                </li>
                <li>
                    <a class="waves-effect waves-dark {{ in_array(Route::currentRouteName(),['staff.idea.add-info','staff.idea.upload-file','staff.idea.preview-idea','idea.detail']) ? 'active' : '' }}" href="{{ route('staff.ideas') }}"><i class="mdi mdi-lightbulb-on-outline"></i><span class="hide-menu">Ideas</span></a>
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('staff.idea.publishView') }}"><i class="mdi mdi-lightbulb-on"></i><span class="hide-menu">Published Ideas</span></a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ route('staff.idea.draftView') }}"><i class="mdi mdi-library-books"></i><span class="hide-menu">Draft Ideas</span></a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
