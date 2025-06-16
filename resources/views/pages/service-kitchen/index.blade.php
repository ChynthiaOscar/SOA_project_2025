<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kitchen Orders</title>
    <style>
        body {
            background-color: #131313;
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #F8CB4A;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .order {
            background-color: #65090D;
            border: 4px solid #ddd;
            padding: 16px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            width: calc(25% - 20px);
            box-sizing: border-box;
        }

        .order h3 {
            margin-top: 0;
            color: #F8CB4A;
        }

        .order p {
            margin: 6px 0;
            color: #E4C788;
        }

        .label {
            font-weight: bold;
            color: #F8CB4A;
        }

        select {
            background-color: #7F160C;
            color: #E4C788;
            padding: 6px;
            border: 2px solid #E2BB4D;
            font-weight: bold;
        }

        .assign-button {
            margin-top: 8px;
            padding: 5px 10px;
            background-color: #F8CB4A;
            color: #000;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h1>Kitchen Order List</h1>

    <div class="container">
        @foreach ($orders as $order)
        <div class="order">
            <h3>Order #{{ $order['order_id'] }}</h3>
            @foreach ($order['order_details'] as $detail)
            <div style="margin-bottom: 12px;">
                <span><span class="label">{{ $detail['order_detail_quantity'] }}</span>x {{ $detail['menu']['menu_name'] }}</span>
                <p>{{ $detail['order_detail_note'] }}</p>

                <form action="{{ route('kitchen.assign') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_detail_id" value="{{ $detail['order_detail_id'] }}">
                    <input type="hidden" name="order_id" value="{{ $order['order_id'] }}">
                    <input type="hidden" name="menu_id" value="{{ $detail['menu_id'] }}">
                    <input type="hidden" name="quantity" value="{{ $detail['order_detail_quantity'] }}">
                    <input type="hidden" name="notes" value="{{ $detail['order_detail_note'] }}">

                    <label for="chef_id"><span class="label">Chef:</span></label>
                    <select name="chef" required>
                        <option value="">Pilih Chef</option>
                        @foreach ($chefs as $chef)
                        <option value="{{ $chef['employee_id'] }}">{{ $chef['employee_name'] }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="assign-button">Assign</button>
                </form>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>

</body>

</html>
