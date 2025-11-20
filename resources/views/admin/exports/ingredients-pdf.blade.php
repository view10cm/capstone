<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ingredients List - {{ $exportDate }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f97316;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #f97316;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .info-item {
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #f97316;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .availability-in-stock {
            color: #059669;
            font-weight: bold;
        }
        .availability-low-stock {
            color: #d97706;
            font-weight: bold;
        }
        .availability-out-of-stock {
            color: #dc2626;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Caffe Arabica - Ingredients Inventory</h1>
        <p>Generated on: {{ $exportDate }}</p>
    </div>

    <div class="info-section">
        <div>
            <div class="info-item"><strong>Total Items:</strong> {{ $totalItems }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Availability</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ingredients as $ingredient)
            <tr>
                <td>{{ $ingredient['item_id'] }}</td>
                <td>{{ $ingredient['name'] }}</td>
                <td>{{ $ingredient['category'] }}</td>
                <td>{{ $ingredient['quantity'] }} {{ $ingredient['unit'] }}</td>
                <td>
                    @if($ingredient['availability'] == 'In Stock')
                        <span class="availability-in-stock">In Stock</span>
                    @elseif($ingredient['availability'] == 'Low Stock')
                        <span class="availability-low-stock">Low Stock</span>
                    @else
                        <span class="availability-out-of-stock">Out of Stock</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} Caffe Arabica. All rights reserved.</p>
        <p>This report was generated automatically from the inventory management system.</p>
    </div>
</body>
</html>