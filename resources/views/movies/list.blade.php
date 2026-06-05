<!DOCTYPE html>
<html>

<head>
    <title>Movies</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 8px 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 28px;
        }

        th,
        td {
            padding: 10px 18px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            font-weight: 700;
        }
    </style>
</head>

<body>
    @include('partials.navbar')

    <table>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Date</th>
            <th>Price</th>
            <th>Author</th>
            <th>Description</th>
        </tr>

        @forelse ($movies as $movie)
            <tr>
                <td>{{ $movie->id }}</td>
                <td>{{ $movie->name }}</td>
                <td>{{ $movie->date }}</td>
                <td>{{ $movie->price }}</td>
                <td>{{ $movie->author }}</td>
                <td>{{ $movie->description }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No movies found.</td>
            </tr>
        @endforelse
    </table>

</body>

</html>
