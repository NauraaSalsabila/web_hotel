<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin_home') }}">Admin Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin_home') }}"></a>
        </div>

        <ul class="sidebar-menu">

            <li class="{{ Request::is('admin/home') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_home') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>

            <li class="{{ Request::is('admin/setting') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_setting') }}"><i class="fa fa-cog"></i> <span>Setting</span></a></li>

            <li class="nav-item dropdown {{ Request::is('admin/amenity/view')||Request::is('admin/room/view') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-superpowers"></i><span>Room Section</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/amenity/view') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_amenity_view') }}"><i class="fa fa-angle-right"></i> Amenities</a></li>

                    <li class="{{ Request::is('admin/room/view') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_room_view') }}"><i class="fa fa-angle-right"></i> Rooms</a></li>
                </ul>
            </li>


            <li class="{{ Request::is('admin/datewise-rooms') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_datewise_rooms') }}"><i class="fa fa-calendar"></i> <span>Datewise Rooms</span></a></li>


            <li class="nav-item dropdown {{ Request::is('admin/page/contact')||Request::is('admin/page/room')||Request::is('admin/page/cart')||Request::is('admin/page/checkout')||Request::is('admin/page/signup')||Request::is('admin/page/signin')||Request::is('admin/page/forget-password')||Request::is('admin/page/reset-password') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-arrows"></i><span>Pages</span></a>
                <ul class="dropdown-menu">

                    <li class="{{ Request::is('admin/page/contact') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_page_contact') }}"><i class="fa fa-angle-right"></i> Contact</a></li>


                    <li class="{{ Request::is('admin/page/room') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_page_room') }}"><i class="fa fa-angle-right"></i> Room</a></li>

                    <li class="{{ Request::is('admin/page/cart') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_page_cart') }}"><i class="fa fa-angle-right"></i> Cart</a></li>

                    <li class="{{ Request::is('admin/page/checkout') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_page_checkout') }}"><i class="fa fa-angle-right"></i> Checkout</a></li>


                    <li class="{{ Request::is('admin/page/signup') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_page_signup') }}"><i class="fa fa-angle-right"></i> Sign Up</a></li>

                    <li class="{{ Request::is('admin/page/signin') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_page_signin') }}"><i class="fa fa-angle-right"></i> Sign In</a></li>


                    <li class="{{ Request::is('admin/page/reset-password') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_page_reset_password') }}"><i class="fa fa-angle-right"></i> Reset Password</a></li>
                </ul>
            </li>

            <li class="{{ Request::is('admin/customers') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin_customer') }}"><i class="fa fa-user-plus"></i> <span>Customers</span></a></li>

        </ul>
    </aside>
</div>