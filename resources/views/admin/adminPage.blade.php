<header>
    <img src="/img/Logo.png" class="Logo" alt="Logo Smashkart">
</header>
<div class="admin-container">
    <nav class="admin-sidebar">
        <ul>
            <li><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
            <li><a href="{{ url('admin/users') }}">Users</a></li>
            <li><a href="{{ url('admin/settings') }}">Settings</a></li>
            <li><a href="{{ url('admin/reports') }}">Reports</a></li>
            <li><a href="{{ url('admin/adminPage') }}">Admin Page</a></li>
            <li>
                <form id="logout-form" action="{{ url('admin/logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:#fff;padding:10px 20px;width:100%;text-align:left;cursor:pointer;">Logout</button>
                </form>
            </li>
        </ul>
    </nav>
    <main class="admin-content">
        @yield('content')
    </main>
</div>

<style>
header {
    position: relative;
    top: 0;
    width: 100%;
    height: 60px;
    background-color: #3131D4;
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
    width: 100%;
    height: 60px;
}

.logo {
    height: 60px;
}

.admin-container {
    display: flex;
    min-height: 100vh;
}
.admin-sidebar {
    width: 209px;
    background: #F2F2F2;
    color: #222; /* Changed to dark text */
    padding: 20px 0;
}
.admin-sidebar ul {
    list-style: none;
    padding: 0;
    font-weight: 500;
}
.admin-sidebar li {
    margin: 20px 0;
}
.admin-sidebar a {
    color: #222; /* Changed to dark text */
    text-decoration: none;
    padding: 10px 20px;
    display: block;
}
.admin-sidebar a:hover {
    background: #ddd; /* Adjusted for better contrast */
}
.admin-content {
    flex: 1;
    padding: 40px;
    background: #f4f4f4;
}
</style>
