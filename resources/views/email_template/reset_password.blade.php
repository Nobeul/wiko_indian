<html>
    <body>
        <h4>Hi {{ $user_name }},</h4> <br> 
        <p>Your registered email id: {{ $email }}. Please go to the link below to reset your password,<br><br>
            <a href="{{ $password_reset_url }}">Click Here</a> <br><br>
            If you have any questions, please feel free to reply to this email. <br><br>Regards, <br>
            <b>{{ $company_name }}</b>
        </p>
    </body>
</html>