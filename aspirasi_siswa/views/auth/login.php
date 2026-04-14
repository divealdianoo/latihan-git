<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(99,102,241,0.15), transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(14,165,233,0.1), transparent 70%);
            bottom: -100px;
            left: -100px;
            border-radius: 50%;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, -30px); }
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .login-brand {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-brand .brand-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #a78bfa);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 1.6rem;
            color: #fff;
            box-shadow: 0 8px 24px rgba(99,102,241,0.4);
        }

        .login-brand h2 {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #6366f1, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-brand p {
            color: #64748b;
            font-size: 0.88rem;
            margin-top: 4px;
        }

        .login-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }



        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 6px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 0.9rem;
        }

        .input-group-custom input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 12px;
            color: #f1f5f9;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .input-group-custom input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }

        .input-group-custom input::placeholder {
            color: #475569;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 0.92rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(99,102,241,0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Alert */
        .alert-custom {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: rgba(16,185,129,0.12);
            color: #34d399;
            border-left: 3px solid #10b981;
        }

        .alert-error {
            background: rgba(239,68,68,0.12);
            color: #f87171;
            border-left: 3px solid #ef4444;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-brand">
            <div class="brand-icon">
                <i class="fas fa-bullhorn"></i>
            </div>
            <h2><?= APP_NAME ?></h2>
            <p>Sampaikan aspirasimu untuk sekolah yang lebih baik</p>
        </div>

        <div class="login-card">
            <?php if (!empty($flash)): ?>
                <div class="alert-custom alert-<?= $flash['type'] ?>">
                    <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                    <?= $flash['message'] ?>
                </div>
            <?php endif; ?>

            <!-- Form Login -->
            <form action="<?= BASE_URL ?>?action=login-action" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-group-custom">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Masukkan username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Masukkan password" required>
                    </div>
                </div>
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>
