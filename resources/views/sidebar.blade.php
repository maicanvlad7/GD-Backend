<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html"><img src="https://gddever.b-cdn.net/logo/logoGd2.png" alt="Logo" srcset="" style="height: auto!important;" width="200px"></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Meniu</li>

                <li class="sidebar-item {{ request()->is('dash*') ? 'active' : ''}}">
                    <a href="{{url('dash')}}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Content Editor</li>

                <li class="sidebar-item {{ request()->is('user*') ? 'active' : ''}}">
                    <a href="{{url('users')}}" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Utilizatori</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('course*') ? 'active' : ''}}">
                    <a href="{{url('courses')}}" class='sidebar-link'>
                        <i class="bi bi-camera-reels-fill"></i>
                        <span>Cursuri</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('stories*') ? 'active' : ''}}">
                    <a href="{{url('stories')}}" class='sidebar-link'>
                        <i class="bi bi-alarm"></i>
                        <span>Povești de succes</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('book*') ? 'active' : ''}}">
                    <a href="{{url('books')}}" class='sidebar-link'>
                        <i class="bi bi-book"></i>
                        <span>Rezumate carti</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('new*') ? 'active' : ''}}">
                    <a href="{{url('news')}}" class='sidebar-link'>
                        <i class="bi bi-arrow-left-right"></i>
                        <span>News Carousel</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('teacher*') ? 'active' : ''}}">
                    <a href="{{url('teachers')}}" class='sidebar-link'>
                        <i class="bi bi-award"></i>
                        <span>Teachers</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('comment*') ? 'active' : ''}}">
                    <a href="{{url('comments')}}" class='sidebar-link'>
                        <i class="bi bi-chat-quote"></i>
                        <span>Comments</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('payout*') ? 'active' : ''}}">
                    <a href="{{url('payouts')}}" class='sidebar-link'>
                        <i class="bi bi-cash-stack"></i>
                        <span>Payouts</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('landing*') ? 'active' : ''}}">
                    <a href="{{url('landings')}}" class='sidebar-link'>
                        <i class="bi bi-cart"></i>
                        <span>Landing Pages</span>
                    </a>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
