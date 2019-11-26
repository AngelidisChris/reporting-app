@auth()
<!-- Sidebar -->
<div class="bg-light border-right " id="sidebar-wrapper">
    <div class="sidebar-heading">Dashboard</div>
    <div class="list-group list-group-flush">
        <a href="/tickets" class="list-group-item list-group-item-action bg-light">Tickets</a>
        <a href="/profile/{{ \Illuminate\Support\Facades\Auth::user()->id }}" class="list-group-item list-group-item-action bg-light">Profile</a>
    </div>
</div>
<!-- /#sidebar-wrapper -->
@endauth

