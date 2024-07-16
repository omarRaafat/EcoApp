
<script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/feather-icons/feather-icons.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/plugins/lord-icon-2.1.0.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery-3.6.3.min.js') }}"></script>
@stack('custom-scripts')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@yield('script')
@yield('script-bottom')
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js"></script>
@if(app()->isProduction())
<script>
    $.getJSON("{{ URL::asset('/') }}firebase.config.json", function(firebaseConfig) {
        if(firebaseConfig && firebaseConfig.projectId != '')
        {
            // Initialize Firebase
            firebase.initializeApp(firebaseConfig);

            const messaging = firebase.messaging();

            function initFirebaseMessagingRegistration()
            {
                messaging.requestPermission().then(function () {
                    return messaging.getToken()
                }).then(function(token) {
                    $.post("{{ route('admin.notifications.fcmToken') }}", {
                        _method:"PATCH",
                        token,
                        "_token": "{{ csrf_token() }}"
                    }, function (data)
                    {
                    }, "json");
                }).catch(function (err) {
                    console.log(`Token Error :: ${err}`);
                });
            }

            initFirebaseMessagingRegistration();

            messaging.onMessage(function({data:{body,title}}){
                new Notification(title, {body});
            });
        }
    });
</script>
@endif

<script>
    $('button:not([type="submit"]):not(.btnrejectproduct):not(.showRejectNote)').on('click', function(){
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
