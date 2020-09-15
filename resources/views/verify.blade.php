<!DOCTYPE html>
<html>
<body>

<h2>code: {{ $code }}</h2>

<form action="{{ route('line_token') }}" method="GET">
    <input type="hidden" name="code" value="{{ $code }}">
    <input type="submit" value="Submit">
</form>

</body>
</html>