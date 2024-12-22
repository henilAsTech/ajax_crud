<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>@yield('title') | {{ config('app.name') }}</title>
		<link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}?w=16&h=16" />
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.css"> --}}
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		@stack('after-css')
	</head>
    <body>
		<div class="wrapper">
			@include('layouts.header')
			<div id="content-page">
				@yield('content')
			</div>
		</div>
		@include('layouts.footer')
		<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>
		<script>
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('#userListLinkHeader').on('click', function (e) {
				e.preventDefault();

				$.ajax({
					url: '{{ route("users.index") }}',
					type: 'GET',
					success: function (response) {
						$('#content-page').html(response);
						window.history.pushState(null, null, '{{ route("users.index") }}');
					},
					error: function (xhr, status, error) {
						console.error('Error loading the List page:', error);
					}
				});
			});

			$('#userCreateLinkHeader').on('click', function (e) {
				e.preventDefault();

				$.ajax({
					url: '{{ route("users.create") }}',
					type: 'GET',
					success: function (response) {
						$('#content-page').html(response);
						window.history.pushState(null, null, '{{ route("users.create") }}');
					},
					error: function (xhr, status, error) {
						console.error('Error loading Create page:', error);
					}
				});
			});

			$("#myForm").on("submit", function (e) {
				$(this).find("button[type='submit']").prop("disabled", true);
				$(this).find("button[type='submit'] .spinner-border").removeClass("d-none");
			});
		</script>
		@include('layouts.notification')
		@stack('after-js')
	</body>
</html>