<header>
    <img src="/img/Logo.png" class="Logo" alt="Logo Smashkart">
</header>
<div class="admin-container">
    <nav class="admin-sidebar">
        <ul>
            <li><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
            <li><a href="{{ url('admin/users') }}">Users</a></li>
            <li><a href="{{ url('admin/report-inventory') }}">Reports</a></li>
            <li><a href="{{ url('admin/orders') }}">Order Management</a></li>
                <form id="logout-form" action="{{ url('admin/logout') }}" method="POST">
                    @csrf
                    <button class="logout-button" type="submit">Logout</button>
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
    color: #222;
    padding: 20px 0;
}
.admin-sidebar ul {
    list-style: none;
    padding: 0;
    font-weight: 500;
}
.logout-button {
    width: 100%;
    padding: 10px 20px;
    color: #222;
    border: none;
    border-radius: 4px;
    font-weight: 600;
    cursor: pointer;
    text-align: left;
    margin-top: 10px;
    transition: background 0.2s;
    font-size: 16px;
    display: block;
}

.logout-button:hover {
    background: #ddd; }

.admin-sidebar li {
    margin: 20px 0;
}
.admin-sidebar a {
    color: #222; 
    text-decoration: none;
    padding: 10px 20px;
    display: block;
}
.admin-sidebar a:hover {
    background: #ddd; 
}
.admin-content {
    flex: 1;
    padding: 40px;
    background: #f4f4f4;
}
</style>
