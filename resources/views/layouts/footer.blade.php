<footer class="bg-white iq-footer">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6">
			</div>
			<div class="col-lg-6 text-right">
				Copyright {{ \Carbon\Carbon::now()->format('Y') }} <a href="{{ route('users.index') }}">{{ config('app.name') }}</a> Footer Contents.
			</div>
		</div>
	</div>
</footer>