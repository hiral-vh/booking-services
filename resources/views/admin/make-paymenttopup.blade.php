<html>
<link rel="preconnect" href="https://fonts.googleapis.com">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<style>
    .redirecting {
    text-align: center;
}

.redirecting img {
    height: 60px;
}

.redirecting h6 {font-size: 18px;margin: 12px 0;}


body {
    margin: 0;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Poppins', sans-serif;
}

.redirecting p {
    font-size: 12px;
    margin: 0;
}
</style>
<body class="">
    <div class="redirecting">
        <img src="{{url('assets/images/loader.gif')}}">
        <h6>Redirecting For Payment...</h6>
        <p>Please do not Close this Window or press Back Button</p>

    </div>
   
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        let stripe = Stripe('pk_test_51Hf1hEDhoJZw9YjJBx5EBDEbLlV5XZiGAPszzwf7Jt3kwS98f5AhiIKya1vOGz57HmaOaiSYkSLh3by5H6cBF4Uh00qNUm2Qfd');
        let userId = '{{$userId}}';
        let paymentID = '{{$paymentID}}';
        let data = {
            user_id: userId,
            payment_id: paymentID,
            _token: '{{csrf_token()}}',
        };
        fetch('{{route("create-payment-session-topup")}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                    //'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: JSON.stringify(data)
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(session) {
                return stripe.redirectToCheckout({
                    sessionId: session.id
                });
            })
            .then(function(result) {
                // If `redirectToCheckout` fails due to a browser or network
                // error, you should display the localized error message to your
                // customer using `error.message`.
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
    </script>

</body>

</html>