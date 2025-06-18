@extends('layouts.app')

@section('title', 'Create Event Reservation')

@push('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #D6D6D6, #AFAFAF);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-card,
        .validation-card {
            background: #242424;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            border: 3px solid #1E5D8B;
            width: 100%;
        }

        .validation-card {
            display: none;
        }

        .card-title {
            color: #FCD772;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            letter-spacing: 2px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            color: #FCD772;
            font-size: 14px;
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            background: white;
            font-size: 14px;
            color: #333;
        }

        .form-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(252, 215, 114, 0.3);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .addon-section {
            border-top: 2px dashed #666;
            padding-top: 20px;
            margin-top: 20px;
        }

        .addon-label {
            color: #FCD772;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .checkbox-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-input {
            width: 18px;
            height: 18px;
            accent-color: #FCD772;
        }

        .checkbox-label {
            color: white;
            font-size: 14px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            flex: 1;
        }

        .btn-back {
            background: white;
            color: #333;
        }

        .btn-back:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
        }

        .btn-next,
        .btn-continue {
            background: #A88A29;
            color: white;
        }

        .btn-next:hover,
        .btn-continue:hover {
            background: #967A24;
            transform: translateY(-2px);
        }

        .validation-content {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            color: #333;
            position: relative;
        }

        .validation-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .validation-section {
            margin-bottom: 15px;
        }

        .validation-section h4 {
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .validation-section p {
            margin: 3px 0;
            font-size: 14px;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            font-size: 20px;
            color: #666;
            cursor: pointer;
        }

        .error-message {
            color: #ff4757;
            font-size: 12px;
            margin-top: 5px;
        }

        .success-message {
            background: #2ed573;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                max-width: 100%;
            }

            .form-card,
            .validation-card {
                padding: 20px;
            }

            .checkbox-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .button-group {
                flex-direction: column;
            }

            .btn {
                margin-bottom: 10px;
            }

            .card-title {
                font-size: 20px;
            }
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 700px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container max-w-2xl">
        <!-- Form Card -->
        <div class="form-card" id="formCard">
            <h2 class="card-title">FORM EVENTS</h2>

            <form id="eventForm">
                @csrf
                <div class="form-group">
                    <label class="form-label">User</label>
                    <input type="text" name="user" class="form-input" placeholder="eg: John Doe" required>
                    <div class="error-message" id="user-error"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Detail</label>
                    <textarea name="detail" class="form-input form-textarea" placeholder="eg: Michelle's sweet 17 birthday" required></textarea>
                    <div class="error-message" id="detail-error"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-input" required>
                    <div class="error-message" id="date-error"></div>
                </div>

                <div class="addon-section">
                    <div class="addon-label">Add Ons</div>

                    <div class="checkbox-grid">
                        <div class="checkbox-item">
                            <input type="checkbox" name="appetizer" class="checkbox-input" id="appetizer">
                            <label class="checkbox-label" for="appetizer">Appetizer</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="main_course" class="checkbox-input" id="main_course">
                            <label class="checkbox-label" for="main_course">Main Course</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="drink" class="checkbox-input" id="drink">
                            <label class="checkbox-label" for="drink">Drink</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="speaker" class="checkbox-input" id="speaker">
                            <label class="checkbox-label" for="speaker">Speaker</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <textarea name="additional_message" class="form-input form-textarea" placeholder="Additional Message"
                            style="min-height: 100px;"></textarea>
                    </div>
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-back">BACK</button>
                    <button type="submit" class="btn btn-next">NEXT</button>
                </div>
            </form>
        </div>

        <!-- Validation Card -->
        <div class="validation-card" id="validationCard">
            <h2 class="card-title">VALIDATION</h2>

            <div class="validation-content">
                <button class="close-btn" id="closeBtn">&times;</button>
                <div class="validation-title">Please Read Carefully</div>

                <div id="validationDetails">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>

            <div class="button-group">
                <button type="button" class="btn btn-back" id="backToForm">BACK</button>
                <button type="button" class="btn btn-continue" id="continueBtn">CONTINUE</button>
            </div>
        </div>
    </div>
@endsection
