<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Candidate Email Response Tool</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            padding: 40px;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
            font-weight: 600;
        }

        .status-group {
            margin-bottom: 25px;
        }

        .status-group label {
            display: block;
            margin-bottom: 12px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }

        .radio-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .radio-option {
            flex: 1;
            position: relative;
        }

        .radio-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .radio-label {
            display: block;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .radio-option input[type="radio"]:checked + .radio-label {
            border-color: #667eea;
            background: #667eea;
            color: white;
        }

        .radio-option input[type="radio"]:hover + .radio-label {
            border-color: #667eea;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn-container {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .email-preview {
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .email-preview h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .email-preview p {
            color: #666;
            line-height: 1.6;
            white-space: pre-wrap;
            margin-bottom: 10px;
        }

        .error-message {
            color: #d32f2f;
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 25px;
            }

            .radio-container {
                flex-direction: column;
                gap: 10px;
            }

            .btn-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📧 HR Candidate Response</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($preview) && $preview)
            <div class="email-preview">
                <h3>Email Preview:</h3>
                <p><strong>To:</strong> {{ $validated['candidate_email'] }}</p>
                <p><strong>Subject:</strong> {{ $subject }}</p>
                <hr style="margin: 15px 0; border: none; border-top: 1px solid #ddd;">
                @if($validated['status'] === 'selected')
                    <p>Dear {{ $validated['candidate_name'] }},</p>
                    <p>We are pleased to inform you that you have been selected for the position of {{ $validated['position'] }}.</p>
                    <p>Please reply to this email to confirm your acceptance.</p>
                    <p>Best regards,<br>HR Team</p>
                @else
                    <p>Dear {{ $validated['candidate_name'] }},</p>
                    <p>Thank you for applying for the position of {{ $validated['position'] }}.</p>
                    <p>We regret to inform you that we have decided to move forward with other candidates.</p>
                    <p>Best regards,<br>HR Team</p>
                @endif
            </div>
        @endif

        <form action="{{ isset($preview) && $preview ? route('candidate.send') : route('candidate.preview') }}" method="POST">
            @csrf

            @if(isset($preview) && $preview)
                @foreach($validated as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
            @endif

            <div class="status-group">
                <label>Candidate Status *</label>
                <div class="radio-container">
                    <div class="radio-option">
                        <input type="radio" id="selected" name="status" value="selected" {{ (old('status', isset($validated) ? $validated['status'] : '') == 'selected') ? 'checked' : '' }} required>
                        <label for="selected" class="radio-label">✓ Selected</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="rejected" name="status" value="rejected" {{ (old('status', isset($validated) ? $validated['status'] : '') == 'rejected') ? 'checked' : '' }} required>
                        <label for="rejected" class="radio-label">✗ Rejected</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="candidate_name">Candidate Name *</label>
                <input type="text" id="candidate_name" name="candidate_name" value="{{ old('candidate_name', isset($validated) ? $validated['candidate_name'] : '') }}" required>
                @error('candidate_name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="candidate_email">Candidate Email *</label>
                <input type="email" id="candidate_email" name="candidate_email" value="{{ old('candidate_email', isset($validated) ? $validated['candidate_email'] : '') }}" required>
                @error('candidate_email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="position">Position Applied *</label>
                <input type="text" id="position" name="position" value="{{ old('position', isset($validated) ? $validated['position'] : '') }}" required>
                @error('position')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="btn-container">
                @if(isset($preview) && $preview)
                    <button type="submit" class="btn btn-primary">✉️ Send Email</button>
                    <a href="{{ route('candidate.form') }}" class="btn btn-secondary">✏️ Edit</a>
                @else
                    <button type="submit" class="btn btn-primary">👁️ Preview Email</button>
                @endif
            </div>
        </form>
    </div>
</body>
</html>

