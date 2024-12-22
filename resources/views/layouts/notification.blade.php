<script>
    @if(Session::has('success'))
        $.notify({
            message: "{{ Session::get('success') }}"
        },{
            type: 'success'
        });
        @php
            Session::forget('success');
        @endphp
    @endif
    @if(Session::has('error'))
        $.notify({
            message: "{{ Session::get('error') }}"
        },{
            type: 'danger'
        });
        @php
            Session::forget('error');
        @endphp
    @endif
    @if($errors->any())
        @foreach($errors->all() as $error)
            $.notify({
                message: "{{ $error }}"
            },{
                type: 'danger'
            });
        @endforeach
    @endif
</script>