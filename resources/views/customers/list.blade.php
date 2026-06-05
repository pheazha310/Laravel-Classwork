<!DOCTYPE html>
<html>

<head>
    <title>Customers</title>
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
            <th>Phone</th>
            <th>Email</th>
            <th>Gender</th>
        </tr>

        @forelse ($customers as $customer)
            <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->gender }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No customers found.</td>
            </tr>
        @endforelse
    </table>

</body>

</html>
