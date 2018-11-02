@if (session('admin_status'))
    <div class="alert alert-success">
        {{ session('admin_status') }}
    </div>
@endif
