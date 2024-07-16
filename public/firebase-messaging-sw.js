importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');
$.getJSON("{{ URL::asset('') }}firebase.config.json", function(firebaseConfig) {
    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();
    messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
        return self.registration.showNotification(title,{body,icon});
    });
});
