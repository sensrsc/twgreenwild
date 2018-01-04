<ul class="page-sidebar-menu light page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
    <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
    <li class="sidebar-toggler-wrapper hide">
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <div class="sidebar-toggler">
            
        </div>
        <!-- END SIDEBAR TOGGLER BUTTON -->
    </li>
    <!-- <li class="nav-item start ">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-home"></i>
            <span class="title">Dashboard</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item start ">
                <a href="index.html" class="nav-link ">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Dashboard 1</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="dashboard_2.html" class="nav-link ">
                    <i class="icon-bulb"></i>
                    <span class="title">Dashboard 2</span>
                    <span class="badge badge-success">1</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="dashboard_3.html" class="nav-link ">
                    <i class="icon-graph"></i>
                    <span class="title">Dashboard 3</span>
                    <span class="badge badge-danger">5</span>
                </a>
            </li>
        </ul>
    </li> -->
    <li class="heading">
        <h3 class="uppercase">功能選單</h3>
    </li>
    <!-- <li class="nav-item  ">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-diamond"></i>
            <span class="title">UI Features</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">           
            <li class="nav-item  ">
                <a href="ui_blockui.html" class="nav-link ">
                    <span class="title">Block UI</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="ui_bootstrap_growl.html" class="nav-link ">
                    <span class="title">Bootstrap Growl Notifications</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="ui_notific8.html" class="nav-link ">
                    <span class="title">Notific8 Notifications</span>
                </a>
            </li>            
        </ul>
    </li> -->
    @if (config('common.menu'))
        @foreach (config('common.menu') as $ctr => $m_data)
            <li class="nav-item {{ strpos('/' . Request::path(), $m_data['link']) !== false  ? 'active' : '' }}">
                <a href="{{ url($m_data['link']) }}" class="nav-link ">
                    <span class="title">{{ $m_data['title'] }}</span>
                </a>
            </li>
        @endforeach
    @endif
</ul>