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
        <h1>Chef: {{ $chef['name'] }}</h1>

        <div class="container">
            @foreach ($tasks as $task)
            <div class="order">
                <h3>Order #{{ $task['kitchen_task_id'] }}</h3>
                <form method="POST" action="{{ route('kitchen.updateStatus') }}">
                    @csrf
                    <input type="hidden" name="task_id" value="{{ $task['kitchen_task_id'] }}">
                    <input type="hidden" name="menu" value="{{ $task['menu'] }}">
                    <input type="hidden" name="quantity" value="{{ $task['quantity'] }}">
                    <label class="menu-item">
                        <input type="checkbox" name="status" onchange="this.form.submit()" {{ $task['status'] == 'done' ? 'checked' : '' }}>
                        <span><span class="label">{{ $task['quantity'] }}</span>x {{ $task['menu'] }}</span>
                    </label>
                    <p style="margin-left: 26px;">{{ $task['notes'] }}</p>
                </form>

            </div>
            @endforeach
        </div>
    </body>

    </html>
