<div class="container-fluid card">
    <div class="m-1">
        <input type="text" class="search" id="partialSearch" placeholder="Search By Name, Email or Gender" value="{{ $query ?? '' }}" style="width: 300px;">
    </div>
    <h3 class="card-header">Users List</h3>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th scope="col">Image</th>
                    <th scope="col">File</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $key => $user)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>{{ $user->image }}</td>
                        <td>{{ '.' . pathinfo($user->file, PATHINFO_EXTENSION) }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm edit" data-id="{{ $user->id }}">Edit</button>
                            <button class="btn btn-danger btn-sm delete-partial" data-id="{{ $user->id }}">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">No Data Available</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).on('click', '.delete-partial', function () {
        let userId = $(this).data('id');
        var userName = $(this).closest('tr').find('td:nth-child(2)').text();

        if (confirm('Are you sure you want to delete user: '+ userName + '?')) {
            $.ajax({
                url: `/users/${userId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    alert('User Delete successfully!');
                    $(`button.delete-partial[data-id="${userId}"]`).closest('tr').remove();
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        }
    });

    $(document).on('input', '.search', function () {
        let query = $(this).val().trim();
        // clearTimeout(searchTimeout);

        searchTimeout = setTimeout(function () {
            if (query.length > 0) {
                $.ajax({
                    url: '{{ route("users.index") }}',
                    type: 'GET',
                    data: { search: query },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('#content-page').html(response);
                    }
                });
            }
        }, 500);
    });

</script>