<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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

        select {
            background-color: #7F160C;
            color: #E4C788;
            padding: 6px;
            /* border-radius: 4px; */
            border: 2px solid #ccc;
            border-color: #E2BB4D;
            font-weight: bold;
        }

        option {
            background-color: #7F160C;
            color: #E4C788;
        }

        .order-footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <div class="Order Lists">
        <h1>Order Lists</h1>
    </div>
    <div class="container">
        <!-- Order 1 -->
        <div class="order">
            <h3>Order #1</h3>

            <!-- Menu 1 -->
            <div style="margin-bottom: 12px;">
                <span><span class="label">2</span>x Spaghetti Carbonara</span>
                <p>Tanpa keju</p>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <label for="chef1-1"><span class="label">Chef:</span></label>
                    <select id="chef1-1" name="chef1-1">
                        <option selected>...</option>
                        <option value="budi">Budi Santoso</option>
                        <option value="andi">Andi Saputra</option>
                        <option value="rina">Rina Ayu</option>
                    </select>
                </div>
            </div>

            <!-- Menu 2 -->
            <div style="margin-bottom: 12px;">
                <span><span class="label">1</span>x Chicken Katsu</span>
                <p>Tambah saus</p>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <label for="chef1-2"><span class="label">Chef:</span></label>
                    <select id="chef1-2" name="chef1-2">
                        <option selected>...</option>
                        <option value="budi">Budi Santoso</option>
                        <option value="andi" selected>Andi Saputra</option>
                        <option value="rina">Rina Ayu</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Order 2 -->
        <div class="order">
            <h3>Order #2</h3>

            <!-- Menu 1 -->
            <div style="margin-bottom: 12px;">
                <span><span class="label">1</span>x Nasi Goreng Jawa</span>
                <p>Tanpa Sayur</p>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <label for="chef1-1"><span class="label">Chef:</span></label>
                    <select id="chef1-1" name="chef1-1">
                        <option selected>...</option>
                        <option value="budi" selected>Budi Santoso</option>
                        <option value="andi">Andi Saputra</option>
                        <option value="rina">Rina Ayu</option>
                    </select>
                </div>
            </div>

            <!-- Menu 2 -->
            <div style="margin-bottom: 12px;">
                <span><span class="label">1</span>x Sate Taichan</span>
                <p></p>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <label for="chef1-2"><span class="label">Chef:</span></label>
                    <select id="chef1-2" name="chef1-2">
                        <option selected>...</option>
                        <option value="budi">Budi Santoso</option>
                        <option value="andi">Andi Saputra</option>
                        <option value="rina">Rina Ayu</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
