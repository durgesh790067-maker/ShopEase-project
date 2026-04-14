<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            min-height: 100vh;
            background: #F7F2EB;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }
        .brand-logo { font-size: 3.5rem; color: #1A1A1A; margin-bottom: 10px; }
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 3rem; font-weight: 700;
            color: #1A1A1A; letter-spacing: 1px; margin-bottom: 6px;
        }
        .brand-tagline {
            font-size: 1rem; color: #888;
            letter-spacing: 2px; text-transform: uppercase; margin-bottom: 50px;
        }
        .role-card {
            background: #FFFFFF;
            border: 2px solid #FFE6CD;
            border-radius: 20px;
            padding: 30px 25px;
            width: 160px; margin: 10px;
            cursor: pointer; text-decoration: none;
            display: inline-flex; flex-direction: column;
            align-items: center; gap: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 18px rgba(0,0,0,0.07);
        }
        .role-card:hover {
            background: #FFE6CD;
            transform: translateY(-6px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-color: #1A1A1A;
        }
        .role-icon { font-size: 2.2rem; color: #1A1A1A; }
        .role-label {
            font-family: 'Playfair Display', serif;
            font-size: 1rem; font-weight: 600; color: #1A1A1A;
        }
        .roles-wrapper { display: flex; flex-wrap: wrap; justify-content: center; }
        .divider {
            width: 60px; height: 3px;
            background: linear-gradient(90deg, #1A1A1A, #FFE6CD);
            border-radius: 2px; margin: 0 auto 20px;
        }
        .select-text {
            font-size: 0.85rem; color: #888;
            text-transform: uppercase; letter-spacing: 2px; margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="brand-logo"><i class="fas fa-shopping-bag"></i></div>
    <h1 class="brand-name">ShopEase</h1>
    <div class="divider"></div>
    <p class="select-text">Please select your role to continue</p>
    <div class="roles-wrapper">
        <a href="./customer_mode/customer_login.php" class="role-card">
            <span class="role-icon"><i class="fas fa-user"></i></span>
            <span class="role-label">Customer</span>
        </a>
        <a href="./admin_mode/admin_login.php" class="role-card">
            <span class="role-icon"><i class="fas fa-user-shield"></i></span>
            <span class="role-label">Admin</span>
        </a>
        <a href="./agent_mode/delivery_login.php" class="role-card">
            <span class="role-icon"><i class="fas fa-truck"></i></span>
            <span class="role-label">Delivery Agent</span>
        </a>
    </div>
    <p style="margin-top:50px; font-size:0.78rem; color:#aaa;">© 2026, Durgesh and Roshni BCA</p>
</body>
</html>
