<h1>Staff Dashboard</h1>
<p>Welcome, Staff</p>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>