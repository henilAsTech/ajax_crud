@extends('layouts.app')

@section('title','User')

@push('after-css')
@endpush

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid card">
            <div class="m-1">
                <input type="text" class="search" placeholder="Search By Name, Email or Gender" style="width: 300px;">
            </div>
            <h3 class="card-header">Users List</h3>
            <div class="card-body">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phome</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Image</th>
                            <th scope="col">File</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $key => $user)
                            <tr>
                                <td>{{++$key }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->gender }}</td>
                                <td>{{ $user->image }}</td>
                                <td>{{ '.' . pathinfo($user->file, PATHINFO_EXTENSION) }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm edit" data-id="{{ $user->id }}">Edit</button>
                                    <button class="btn btn-danger btn-sm delete" data-id="{{ $user->id }}">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">No Data Available</td></tr>
                        @endforelse
                        </tr>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
@endsection

@push('after-js')
    <script>
        reloadTable();

        function reloadTable() {
            $.ajax({
                url: '{{ route("users.index") }}',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    
                    let tableBody = $('#dataTable tbody');
                    tableBody.empty();
                    
                    if (response.data.length > 0) {
                        response.data.forEach(function (item, key) {
                            let row = `
                                <tr>
                                    <td>${++key}</td>
                                    <td>${item.name}</td>
                                    <td>${item.email}</td>
                                    <td>${item.phone}</td>
                                    <td>${item.gender}</td>
                                    <td>${item.image}</td>
                                    <td>${item.file}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm edit" data-id="${item.id}">Edit</button>
                                        <button class="btn btn-danger btn-sm delete" data-id="${item.id}">Delete</button>
                                    </td>
                                </tr>
                            `;
                            tableBody.append(row);
                        });
                    } else {
                        tableBody.append('<tr><td colspan="8" class="text-center">No Data Available</td></tr>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        $(document).on('click', '.edit', function () {
            var userId = $(this).data('id');

            $.ajax({
                url: '/users/' + userId + '/edit',
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        $('#content-page').html(response.html);
                        let userId = response.user.id;
                        window.history.pushState(null, null, `/users/${userId}/edit`);
                    }
                },
                error: function (xhr, status, error) {
                    alert(error);
                }
            });
        });


        $(document).on('click', '.delete', function () {
            let userId = $(this).data('id');
            var userName = $(this).closest('tr').find('td:nth-child(2)').text();

            if (confirm('Are you sure you want to delete user: '+ userName + '?')) {
                $.ajax({
                    url: `/users/${userId}`,
                    type: 'DELETE',
                    success: function(result) {
                        alert('User Delet successfully!');
                        $(`button.delete[data-id="${userId}"]`).closest('tr').remove();
                        reloadTable();
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
@endpush