<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Danh sách hóa đơn</title>
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
    <h2>{{__('billList')}}</h2>
    <h4>{{ date('d-m-Y') }}</h4>
    <table>
        <thead>
            <tr>
                <th>{{__('ID')}}</th>
                <th>{{__('Product_name')}}</th>
                <th>{{__('Quantity')}}</th>
                <th>{{__('Price')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $rows)
                <tr class="odd">
                    <td class="dtr-control sorting_1" tabindex="1">{{$rows->id}}</td>
                    <td >{{$rows->product_name}}</td>
                    <td >{{$rows->quantity}}</td>
                    <td>{{$rows->price}}</td>
				</tr>
			@endforeach
        </tbody>
    </table>
</body>

</html>