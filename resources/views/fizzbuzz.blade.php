<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FizzBuzz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <h1>FizzBuzz</h1>
</div>

<br>

@if (is_array($errors))
    <div class="container">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="container">
    <form action="/fizzbuzz" method="get">
        <div class="mb-3">
            <label for="min" class="form-label">Minimum</label>
            <input style="max-width: 100px;" type="text" class="form-control" id="min" name="minimum"
                   value="{{ $min }}">
        </div>
        <div class="mb-3">
            <label for="max" class="form-label">Maximum</label>
            <input style="max-width: 100px;" type="text" class="form-control" id="max" name="maximum"
                   value="{{ $max }}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<br><br>

<div class="container">
    <h2>Output</h2>
</div>

<br>

@if (is_array($results))
    <div class="container">
        @foreach ($results as $result)
            @if($result == 'Fizz')
                <div class="alert alert-primary">{{ $result }}</div>
            @elseif($result == 'Buzz')
                <div class="alert alert-secondary">{{ $result }}</div>
            @elseif($result == 'FizzBuzz')
                <div class="alert alert-success">{{ $result }}</div>
            @else
                <div class="alert alert-light">{{ $result }}</div>
            @endif
        @endforeach
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
