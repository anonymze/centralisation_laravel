@section('footer.js')
    @parent
    <script type="text/javascript">
        // on écoute le dom de la page
        $(document).ready(function () {
            // on dit écoute cette classe et quand elle se ferme tu fais cette function ajax
            $('.state_flash_messages').on('closed.bs.alert', function () {
                // dans cette requete ajax on précise l'url où va la requete, que c'est du POST qu'on transform en PUT, et que le state passe  à 0
                $.ajax({
                    url: $(this).data('action'),
                    method: 'POST',
                    data: {
                        _method: 'PUT',
                        state: 0,
                    }
                });
            })
        });
    </script>
@endsection
<script>
    toastr.options.closeMethod = 'fadeOut';
    toastr.options.closeEasing = 'swing';
    toastr.options.closeDuration = 1000;
    toastr.options.timeOut = 1000;
    toastr.options.showDuration = 0;

            @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
</script>