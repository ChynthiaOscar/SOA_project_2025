<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" content="width=device-width, initial-scale=1.0">
    <title>KITCHEN</title>
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
            /* border-radius: 8px; */
            padding: 16px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            width: calc(25% - 20px);
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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

        .menu-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        input[type="checkbox"] {
            transform: scale(1.5);
        }
    </style>
</head>

<body>
    @php
    $id = request()->route('id'); // Ambil parameter ID dari URL
    @endphp

    @if ($id == 1)
    <!-- CHEF View -->
    <div class="Chef">
        <h1>CHEF: Budi Santoso</h1>
    </div>
    <div class="container">
        <div class="order">
            <h3>Order #1</h3>
            <div style="margin-bottom: 12px;">
                <label class="menu-item">
                    <input type="checkbox" name="menu1-1">
                    <span><span class="label">2</span>x Spaghetti Carbonara</span>
                </label>
                <p style="margin-left: 26px;">Tanpa keju</p>
            </div>
        </div>

        <div class="order">
            <h3>Order #2</h3>
            <div style="margin-bottom: 12px;">
                <label class="menu-item">
                    <input type="checkbox" name="menu2-1">
                    <span><span class="label">1</span>x Nasi Goreng Jawa</span>
                </label>
                <p style="margin-left: 26px;">Tanpa Sayur</p>
            </div>
        </div>
    </div>
    @else
    <!-- Unknown role -->
    <p style="color: red;">Akses ditolak: ID tidak dikenali.</p>
    @endif

</body>

</html>
