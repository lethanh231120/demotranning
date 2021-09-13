
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Danh sách sản phẩm</title>
    <style>
        body {
            font-family: Dejavu Sans;
        }

        table,td,th {
            border: 1px solid rgb(102, 88, 88);
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

    </style>
</head>

<body>
    <h2>Danh sách sản phẩm</h2>
    <h4>{{ date('d-m-Y') }}</h4>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Stock</th>
                <th>Hạn sản phẩm</th>
                <th>Tên danh mục</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $pro)
                <tr>
                  <td>{{$pro->id}}</td>
                  <td>{{$pro->name}}</td>
                  <td>{{$pro->stock}}</td>
                  <td>{{$pro->exprired_at}}</td>
                  <td>{{$pro->category_name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>