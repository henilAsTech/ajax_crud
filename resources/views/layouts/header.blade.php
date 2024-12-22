<div class="header">
    <a href="{{ route('users.index') }}" class="logo">Practical</a>
    <div class="header-right">
        @php 
            $lastSegment = Illuminate\Support\Str::afterLast(request()->path(), '/');
        @endphp
        <a href="#" id="userListLinkHeader" class="iq-waves-effect {{ (empty($lastSegment) || $lastSegment == 'users') ? 'active' : '' }}">List</a>
        <a href="#" id="userCreateLinkHeader" class="iq-waves-effect {{ $lastSegment == 'create' ? 'active' : '' }}">Create</a>
    </div>
</div>