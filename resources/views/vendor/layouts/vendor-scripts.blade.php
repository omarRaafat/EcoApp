<script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/feather-icons/feather-icons.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/plugins/lord-icon-2.1.0.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery-3.6.3.min.js') }}"></script>
<!-- flatpickr.js -->
<script type='text/javascript' src='{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}'></script>
@yield('script')
<script>
    $('button:not([type="submit"])').on('click', function(){
        $(this).attr('disabled',true);
        setTimeout(() => {
            $(this).attr('disabled',false);
        }, 3000);
    });
</script>
<script>
    (function(){
    $('form').on('submit', function(){
        $('button[type="submit"]').attr('disabled',true);
    })
    })();
</script>

@yield('script-bottom')

 