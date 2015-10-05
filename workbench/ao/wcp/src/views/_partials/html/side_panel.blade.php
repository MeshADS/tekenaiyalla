<!-- BEGIN SIDEBPANEL-->
    <nav class="page-sidebar" data-pages="sidebar">
      <!-- BEGIN SIDEBAR MENU HEADER-->
      <div class="sidebar-header">
        <img src="{{ URL::to($basic_info->logo) }}" style="width:45px;" alt="logo" class="brand" data-src="{{ URL::to($basic_info->logo) }}" data-src-retina="{{ URL::to($basic_info->logo_2x) }}">
      </div>
      <!-- END SIDEBAR MENU HEADER-->
      <!-- START SIDEBAR MENU -->
      <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
          <li class="m-t-30 {{ (@$menu == 1) ? ' active open ' : '' }}">
            <a href="{{ URL::to('admin') }}" class="">
              <span class="title">Dashboard</span>
            </a>
            <span class="icon-thumbnail {{ (@$menu == 1) ? 'bg-success' : '' }}"><i class="pg-home"></i></span>
          </li>
          <li class="{{ (@$menu == 2) ? ' active open ' : '' }}">
            <a href="javascript:;" class="">
              <span class="title">Data</span> <span class=" arrow"></span>
            </a>
            <span class="icon-thumbnail {{ (@$menu == 2) ? 'bg-success' : '' }}"><i class="fa fa-database"></i></span>
            <ul class="sub-menu">
              <li class="{{ (@$submenu == 2.1) ? ' active ' : '' }}">
                <a href="{{ URL::to('admin/menubuilder') }}">Menu Builder</a>
                <span class="icon-thumbnail">mb</span>
              </li>
              <li class="{{ (@$submenu == 2.2) ? ' active ' : '' }}">
                <a href="{{ URL::to('admin/categories') }}">Categories</a>
                <span class="icon-thumbnail">m</span>
              </li>
              <li class="{{ (@$submenu == 2.3) ? ' active ' : '' }}">
                <a href="{{ URL::to('admin/headers') }}">Headers</a>
                <span class="icon-thumbnail">h</span>
              </li>
              <li class="{{ (@$submenu == 2.4) ? ' active ' : '' }}">
                <a href="{{ URL::to('admin/images') }}">Images</a>
                <span class="icon-thumbnail">i</span>
              </li>
              <li class="{{ (@$submenu == 2.5) ? ' active ' : ' ' }}">
                <a href="javascript:;">
                  <span class="title">Content Data</span> <span class=" arrow"></span>
                </a>
                <span class="icon-thumbnail">c</span>
                <ul class="sub-menu">
                  <li class="">
                    <a href="{{ URL::to('admin/content_data') }}">List</a>
                    <span class="icon-thumbnail">l</span>
                  </li>
                  <li class="">
                    <a href="{{ URL::to('admin/content_data/create') }}">Create</a>
                    <span class="icon-thumbnail">c</span>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="{{ (@$menu == 3) ? ' active open ' : '' }}">
            <a href="{{ URL::to('admin/events') }}">
              <span class="title">Events</span>
            </a>
            <span class="icon-thumbnail {{ (@$menu == 3) ? 'bg-success' : '' }}"><i class="pg-calender"></i></span>
          </li>
          <li class="{{ (@$menu == 4) ? ' active open ' : '' }}">
            <a href="javascript:;">
              <span class="title">Posts</span>
              <span class="arrow"></span>
            </a>
            <span class="icon-thumbnail {{ (@$menu == 4) ? 'bg-success' : '' }}"><i class="pg-social"></i></span>
            <ul class="sub-menu">
              <li class="{{ (@$submenu == 4.1) ? ' active ' : '' }}">
                <a href="{{ URL::to('admin/posts') }}">List</a>
                <span class="icon-thumbnail">l</span>
              </li>
              <li class="{{ (@$submenu == 4.2) ? ' active ' : '' }}">
                <a href="{{ URL::to('admin/posts/create') }}">Create</a>
                <span class="icon-thumbnail">C</span>
              </li>
            </ul>
          </li>
          <li class="{{ (@$menu == 5) ? ' active open ' : '' }}">
            <a href="javascript:;">
              <span class="title">Accounts</span>
              <span class="arrow"></span>
            </a>
            <span class="icon-thumbnail {{ (@$menu == 5) ? 'bg-success' : '' }}"><i class="fa fa-users"></i></span>
            <ul class="sub-menu">
              <li class="{{ (@$submenu == 5.1) ? ' active ' : '' }}">
                <a href="{{ URL::to('admin/accounts') }}">List</a>
                <span class="icon-thumbnail">l</span>
              </li>
              <li class="{{ (@$submenu == 5.2) ? ' active ' : '' }}">
                <a href="{{ URL::to('admin/accounts/create') }}">Create</a>
                <span class="icon-thumbnail">c</span>
              </li>
            </ul>
          </li>
          <li class="{{ (@$menu == 6) ? ' active open ' : '' }}">
            <a href="javascript:;">
              <span class="title">Settings</span>
              <span class="arrow"></span>
            </a>
            <span class="icon-thumbnail {{ (@$menu == 6) ? 'bg-success' : '' }}"><i class="pg-settings"></i></span>
            <ul class="sub-menu">
              <li class="{{ (@$submenu == 6.1) ? ' active ' : '' }}">
                <a href="{{ URL::to('admin/basic_info') }}">Basic Info</a>
                <span class="icon-thumbnail">b</span>
              </li>
              <li class="{{ (@$submenu == 6.2) ? ' active ' : '' }}">
                <a href="{{ URL::to('admin/datagroups') }}">Data Groups</a>
                <span class="icon-thumbnail">dg</span>
              </li>
            </ul>
          </li>
          <li class="">
            <a href="javascript:;">
              <span class="title">{{ (!is_null($user_data->first_name)) ? $user_data->first_name." ".$user_data->last_name : $user_data->name }}</span>
              <span class="arrow"></span>
            </a>
            <span class="icon-thumbnail"><i class="fa fa-user"></i></span>
            <ul class="sub-menu">
              <li class="">
                <a href="#" data-toggle="modal" data-target="#myAccountModal">My Account</a>
                <span class="icon-thumbnail">ma</span>
              </li>
              <li class="">
                <a href="#" data-toggle="modal" data-target="#changePasswordModal">Change My Password</a>
                <span class="icon-thumbnail">cp</span>
              </li>
              <li class="">
                <a href="{{ URL::to('admin/accounts/'.$user_data->id) }}">My Profile</a>
                <span class="icon-thumbnail">ma</span>
              </li>
            </ul>
          </li>
          <li class="">
            <a href="{{ URL::to('admin/logout') }}">
              <span class="title">Logout</span>
            </a>
            <span class="icon-thumbnail"><i class="fa fa-sign-out"></i></span>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- END SIDEBAR MENU -->
    </nav>
    <!-- END SIDEBAR -->
    <!-- END SIDEBPANEL