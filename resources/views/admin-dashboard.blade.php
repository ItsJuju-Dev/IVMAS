<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 40px;
        }

        .dashboard {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            margin-bottom: 30px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            margin: 15px 0;
            background-color: #2563eb;
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            border-radius: 6px;
        }

        .btn.secondary {
            background-color: #4b5563;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <div class="dashboard">
        <h1>Admin Dashboard</h1>

        <a href="{{ url('/manage-user') }}" class="btn">
            Manage Users
        </a>

        <a href="{{ url('/configure-system') }}" class="btn secondary">
            Configure System
        </a>
    </div>

</body>
</html>
