@extends('admin.adminPage')

@section('content')
<style>
* {
    margin: 0;
    font-family: "Montserrat", sans-serif;
}


header {
    position: relative;
    top: 0;
    width: 100%;
    height: 60px;
    background-color: #3131D4;
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
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

/* User table styles */
.user-table-container {
    margin: 32px 0;
}
.user-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 16px;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.user-table th, .user-table td {
    border: 1px solid #ddd;
    padding: 8px 12px;
    text-align: left;
}
.user-table th {
    background: #f4f4f4;
    font-weight: bold;
}
#userSearch {
    margin-bottom: 16px;
    padding: 8px;
    width: 300px;
    border-radius: 4px;
    border: 1px solid #ccc;
}
</style>

<div class="user-table-container">
    <input type="text" id="userSearch" placeholder="Search users...">

    <table class="user-table" id="usersTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? '-' }}</td>
                <td>{{ $user->address ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
document.getElementById('userSearch').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#usersTable tbody tr');
    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>
@endsection