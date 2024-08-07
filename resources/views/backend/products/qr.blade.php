<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Image</title>
</head>
<style>
    html,
    body {
        height: 100vh;
    }

    body {
        display: grid;
        place-items: center;
    }
</style>

<body>
    <div>

        {!! $qr !!}
        {{-- <div>
            <h3>Product Name - {{ $name }}</h3>
            <p>Product Type - {{ $type }}</p>
            <p>Buy Date - {{ $buy_date }}</p>
            <p>Sell Date - {{ $sell_date }}</p>
            <p>Origin - {{ $origin }}</p>
        </div> --}}
    </div>
</body>

</html>