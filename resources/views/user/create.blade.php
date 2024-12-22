@extends('layouts.app')

@section('title','User')

@push('after-css')
@endpush

@section('content')
    <div class="d-flex justify-content-center align-items-center">
        <form class="p-4 border rounded shadow form-area row" id="validationForm" enctype="multipart/form-data">
            <div class="form-group mt-2 col-md-6">
                <label for="name">Name <span class="danger"> *</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                <div class="error errorName danger"></div>
            </div>
            <div class="form-group mt-2 col-md-6">
                <label for="email">Email address <span class="danger"> *</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                <div class="error errorEmail danger"></div>
            </div>
            <div class="form-group mt-2 col-md-6">
                <label for="phone">Phone <span class="danger"> *</span></label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number">
                <div class="error errorPhone danger"></div>
            </div>

            <div class="form-group mt-2 col-md-6">
                <label for="gender">Gender <span class="danger"> *</span></label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                    <label class="form-check-label" for="female">Female</label>
                </div>
                <div class="error errorGender danger"></div>
            </div>

            <div class="form-group mt-2 col-md-6">
                <label for="image">Image <span class="danger"> *</span></label>
                <input type="file" class="form-control" name="image" id="image">
                <div class="error errorImage danger"></div>
            </div>

            <div class="form-group mt-2 col-md-6">
                <label for="file">File</label>
                <input type="file" class="form-control" name="file" id="file">
                <div class="error errorFile danger"></div>
            </div>

            <div class="d-inline-block w-100">
                <button type="reset" class="btn btn-danger float-right mt-4 reset">Reset</button>
                <button type="submit" class="btn btn-primary float-right mt-4">
                    <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                    {{ 'Create' }}
                </button>
            </div>
        </form>
    </div>
@endsection

@push('after-js')
    <script>
        $('.reset').on('click', function() {
            $('#name, #email, #phone, #image, #file').removeClass('is-invalid is-valid');
            $('.errorName, .errorEmail, .errorPhone, .errorGender, .errorImage, .errorFile').html('');
        });
       
        $('#validationForm').on('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const name = $('#name').val().trim();
            if (!name) {
                $('#name').addClass('is-invalid');
                $('.errorName').html('Name is required.');
                isValid = false;
            } else {
                $('#name').removeClass('is-invalid').addClass('is-valid');
                $('.errorName').html('');
            }

            const email = $('#email').val();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email || !emailRegex.test(email)) {
                $('#email').addClass('is-invalid');
                $('.errorEmail').html('Please enter a valid email address.');
                isValid = false;
            } else {
                $('#email').removeClass('is-invalid').addClass('is-valid');
                $('.errorEmail').html('');
            }

            const mobile = $('#phone').val().trim();
            const mobileRegex = /^[0-9]{10}$/;
            if (!mobile || !mobileRegex.test(mobile)) {
                $('#phone').addClass('is-invalid');
                $('.errorPhone').html('Mobile number must be 10 digits.');
                isValid = false;
            } else {
                $('#phone').removeClass('is-invalid').addClass('is-valid');
                $('.errorPhone').html('');
            }

            if ($('input[name="gender"]:checked').length == 0) {
                $('.errorGender').html('Please select your gender.');
                isValid = false;
            } else {
                $('.errorGender').html('');
            }

            const imageInput = $('#image')[0];
            const image = imageInput.files[0];
            const allowedImageExtensions = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
            if (image) {
                const fileType = image.type;
                if (!allowedImageExtensions.includes(fileType)) {
                    $('#image').addClass('is-invalid');
                    $('.errorImage').html('Please upload a valid image file (.png, .jpeg, .jpg, .webp)');
                    isValid = false;
                } else {
                    $('#image').removeClass('is-invalid').addClass('is-valid');
                    $('.errorImage').html('');
                }
            } else {
                $('#image').addClass('is-invalid');
                $('.errorImage').html('Please select an image.');
                isValid = false;
            }

            const fileInput = $('#file')[0];
            const file = fileInput.files[0];
            const allowedFileExtensions = ['application/pdf', 'application/csv', 'application/docx', 'application/xls'];
            if (file) {
                const fileType = file.type;
                if (!allowedFileExtensions.includes(fileType)) {
                    $('#file').addClass('is-invalid');
                    $('.errorFile').html('Please upload a valid file (.pdf, .csv, .docx, .xls)');
                    isValid = false;
                } else {
                    $('#file').removeClass('is-invalid').addClass('is-valid');
                    $('.errorFile').html('');
                }
            } else {
                $('#file').addClass('is-invalid');
                $('.errorFile').html('Please select a file.');
                isValid = false;
            }

            if (isValid) {
                var formData = new FormData($('#validationForm')[0]);
                $.ajax({
                    url: '{{ route("users.store") }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        alert('User created successfully!');
                        $.notify({
                            message: result.message
                        }, {
                            type: 'success'
                        });
                    },
                    error: function(xhr, status, error) {
                        alert(error);
                    }
                });
            }
        });

        $('#name, #email, #phone, #gender, #image #file').on('input', function () {
            $(this).removeClass('is-invalid is-valid');
        });
    </script>
@endpush