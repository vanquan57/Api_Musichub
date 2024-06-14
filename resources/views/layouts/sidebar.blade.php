<aside class="aside is-placed-left is-expanded">
    <div class="aside-tools">
        <div>
            Admin <b class="font-black">MusicHub</b>
        </div>
    </div>
    <div class="menu is-menu-main">
        <p class="menu-label">Tổng Quan</p>
        <ul class="menu-list">
            <li class="{{ request()->route()->getName() == 'home' ? 'active' : '' }}">
                <a href="/api/musichub/">
                    <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
                    <span class="menu-item-label">Tổng Quan Về Ứng Dụng</span>
                </a>
            </li>
        </ul>
        <p class="menu-label">Thành Phần Giao Diện</p>
        <ul class="menu-list">
            
            <li class="--set-active-tables-html {{ request()->route()->getName() == 'songs' ? 'active' : '' }}">
                <a href="/api/musichub/songs">
                    <span class="icon"><i class="fa-solid fa-music"></i></span>
                    <span class="menu-item-label">Quản lý bài hát</span>
                </a>
            </li>
            <li class="--set-active-tables-html {{ request()->route()->getName() == 'musicVideos' ? 'active' : '' }}">
                <a href="/api/musichub/musicVideos">
                    <span class="icon"><i class="fa-brands fa-youtube"></i></span>
                    <span class="menu-item-label">Quản lý Video</span>
                </a>
            </li>
            <li class="--set-active-tables-html {{ request()->route()->getName() == 'artists' ? 'active' : '' }}">
                <a href="/api/musichub/artists">
                    <span class="icon"><i class="fa-solid fa-user-pen"></i></span>
                    <span class="menu-item-label">Quản lý ca sĩ</span>
                </a>
            </li>
            <li class="--set-active-tables-html {{ request()->route()->getName() == 'albums' ? 'active' : '' }}">
                <a href="/api/musichub/albums">
                    <span class="icon"><i class="fa-solid fa-compact-disc"></i></span>
                    <span class="menu-item-label">Quản lý Album</span>
                </a>
            </li>
            <li class="--set-active-profile-html {{ request()->route()->getName() == 'genres' ? 'active' : '' }}">
                <a href="/api/musichub/genres">
                    <span class="icon"><i class="fa-solid fa-strikethrough"></i></span>
                    <span class="menu-item-label">Quản lý thể loại</span>
                </a>
            </li>
            <li class="--set-active-profile-html {{ request()->route()->getName() == 'users' ? 'active' : '' }}">
                <a href="/api/musichub/users">
                    <span class="icon"><i class="fa-solid fa-user-gear"></i></span>
                    <span class="menu-item-label">Quản lý người dùng</span>
                </a>
            </li>
        </ul>
        
    </div>
</aside>