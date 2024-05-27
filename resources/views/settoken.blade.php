
<script src="{{ asset('business/js/jquery.min.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
<script>
       $(document).ready(function() {
        initFirebaseMessagingRegistration();
       
      
    });
    function initFirebaseMessagingRegistration() {
        var firebaseConfig = {
            apiKey: "AIzaSyB5xJ-79-dh1PYZEFg1fawSbBTviQUajqI",
            authDomain: "booking-services-2ae12.firebaseapp.com",
            projectId: "booking-services-2ae12",
            storageBucket: "booking-services-2ae12.appspot.com",
            messagingSenderId: "610198799984",
            appId: "1:610198799984:web:5c83d136560225714556b5",
            measurementId: "G-CFZR5NXGEJ"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
            messaging
                .requestPermission()

                .then(function() {
                    return messaging.getToken()
                })
                .then(function(token) {
                    console.log(token);
                    console.log('here');
                    $.ajax({
                        url: '{{ route("save-token") }}',
                        type: 'POST',
                        data : {_token : '{{ csrf_token() }}' ,device_token: token },
                        
                            success:function(response){
                               window.location.href = "{{route('business-dashboard')}}";
                            },
                            error: function(err) {
                            console.log('User Chat Token Error' + err);
                            }
                    });

            }).catch(function(err) {

                console.log('User Chat Token Errorsss' + err);
            });
        }

        // messaging.onMessage(function(payload) {
        // const noteTitle = payload.notification.title;
        // const noteOptions = {
        //     body: payload.notification.body,
        //     icon: payload.notification.icon,
        // };
        // new Notification(noteTitle, noteOptions);
        // });
        
    </script>
  
    <script>
        

       

    </script>