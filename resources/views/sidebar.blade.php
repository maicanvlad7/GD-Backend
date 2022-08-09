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
                <li class="sidebar-item {{ request()->is('books*') ? 'active' : ''}}">
                    <a href="{{url('books')}}" class='sidebar-link'>
                        <i class="bi bi-book"></i>
                        <span>Rezumate carti</span>
                    </a>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
