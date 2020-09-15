<!DOCTYPE html>
<html>
<body>

<h2>code: {{ $code }}</h2>

<form action="{{ route('line_token') }}" method="GET">
    <input type="hidden" name="code" value="{{ $code }}">
    <input type="submit" value="Submit">
</form>


<form action="https://api.line.me/oauth2/v2.1/token" method="POST" enctype="application/x-www-form-urlencoded">
    <input type="hidden" name="grant_type" value="authorization_code">
    <input type="hidden" name="code" value="{{ $code }}">
    <input type="hidden" name="redirect_uri" value="{{ route('line_verify') }}">
    <input type="hidden" name="client_id" value="1654923778">
    <input type="hidden" name="client_secret" value="04f226eb9eae8a57cdcb9fe361c52047">
    <input type="submit" value="Submit">
</form>

</body>
</html>