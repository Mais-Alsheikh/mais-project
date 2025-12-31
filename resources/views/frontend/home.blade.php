<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>أكاديمية شمس</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd, #ffffff);
            font-family: 'Tajawal', sans-serif;
        }

        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .box {
            background: #ffffff;
            padding: 50px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            animation: fadeIn 1s ease;
        }

        .box h1 {
            color: #0d6efd;
            font-weight: 700;
        }

        .btn-main {
            background-color: #0d6efd;
            color: #fff;
            border-radius: 30px;
            padding: 12px 40px;
            font-size: 16px;
        }

        .btn-main:hover {
            background-color: #0b5ed7;
            color: #fff;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="hero">
    <div class="box">
        <h1>أكاديمية شمس</h1>

        <p class="mt-3 text-muted fs-5">
            منصة تعليمية متكاملة لبناء المعرفة وتطوير المهارات
        </p>

        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn btn-main me-2">
                تسجيل الدخول
            </a>

            <a href="{{ route('register') }}" class="btn btn-outline-primary rounded-pill px-4">
                إنشاء حساب
            </a>
        </div>
    </div>
</div>

</body>
</html>
