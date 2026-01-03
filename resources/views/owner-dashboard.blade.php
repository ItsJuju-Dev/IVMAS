<h1>Owner Dashboard</h1>
<p>Welcome, Owner</p>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>