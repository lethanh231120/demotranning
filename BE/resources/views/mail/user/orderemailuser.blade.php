<h2></h2>Thống kê mua hàng tháng</h2>
<h4>--- {{ date('d-m-Y') }} ---</h4>
<table border="1">
    <thead>
        <tr>
            <th>Tổng số lượng</th>
            <th>Tổng giá</th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $data['totalQuantity'] }}</td>
            <td>{{ $data['totalPrice'] }} đ</td>
        </tr>
    </tbody>
</table>