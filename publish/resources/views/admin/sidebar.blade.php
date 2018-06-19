<div class="col-md-3">

    <div class="card">
        <div class="card-header">
            Backend
        </div>
        <div class="card-body">
            <ul class="nav flex-column" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('admin') }}">Home</a>
                </li>
            </ul>
        </div>
    </div>

    <br/>

    @if (auth()->check() && auth()->user()->hasRole('admin'))
        YOU ARE ADMIN
    @endif

    <br/>

    <div class="card">
        <div class="card-header">
            Users
        </div>
        <div class="card-body">
            <ul class="nav flex-column" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('admin.users.index') }}">Show all</a>
                    <a href="{{ route('admin.users.create') }}">Create</a>
                </li>
            </ul>
        </div>
    </div>

    <br/>

    <div class="card">
        <div class="card-header">
            Roles
        </div>
        <div class="card-body">
            <ul class="nav flex-column" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('admin.roles.index') }}">Show all</a>
                    <a href="{{ route('admin.roles.create') }}">Create</a>
                </li>
            </ul>
        </div>
    </div>

</div>
