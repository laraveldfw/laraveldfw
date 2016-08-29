<html>
<head>

</head>
<body>
    <h3>
        Pending Slack Invite Request
    </h3> <br>
    <h4>
        <b>Name:</b> {{ $invited->name }}
    </h4>
    <h4>
        <b>Email:</b> {{ $invited->email }}
    </h4> <br>
    <h4>
        <a href="{{ $invited->generateConfirmationURL() }}">Click here to confirm the invite</a>
    </h4>
</body>
</html>