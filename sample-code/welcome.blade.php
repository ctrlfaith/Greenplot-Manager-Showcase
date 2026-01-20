<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenPlot - ระบบจัดการแปลงเพาะปลูก</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&family=Sarabun:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sarabun', 'Kanit', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            flex-grow: 1;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: transparent;
        }

        .nav {
            position: absolute;
            top: 0;
            right: 0;
            padding: 32px 48px;
            z-index: 20;
            display: flex;
            gap: 24px;
        }

        .nav a {
            color: #1f2937;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 10px 20px;
            border-radius: 25px;
            position: relative;
            overflow: hidden;
        }

        .nav a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #f3f4f6;
            border-radius: 25px;
            transform: scale(0);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: -1;
        }

        .nav a:hover::before {
            transform: scale(1);
        }

        .nav a:hover {
            transform: translateY(-2px);
            color: #16a34a;
        }

        .content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 0 24px;
            max-width: 900px;
        }

        .logo {
            font-family: 'Kanit', sans-serif;
            font-size: 96px;
            font-weight: 700;
            background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 24px;
            line-height: 1;
            letter-spacing: -2px;
        }

        .tagline {
            font-size: 20px;
            color: #6b7280;
            margin-bottom: 56px;
            line-height: 1.7;
            font-weight: 400;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .button-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-bottom: 80px;
        }

        .btn {
            padding: 18px 56px;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-block;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 20px rgba(22, 163, 74, 0.3);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(22, 163, 74, 0.5);
        }

        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
            max-width: 800px;
            margin: 0 auto;
        }

        .feature-card {
            background: #f9fafb;
            padding: 32px 24px;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            background: #f3f4f6;
            border-color: #16a34a;
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(22, 163, 74, 0.1);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;
        }

        .feature-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: brightness(0) saturate(100%) invert(38%) sepia(65%) saturate(612%) hue-rotate(94deg) brightness(94%) contrast(90%);
        }

        .feature-title {
            color: #1f2937;
            font-size: 18px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="overlay"></div>
        
        <nav class="nav">
            <a href="/login">เข้าสู่ระบบ</a>
            <a href="/register">สมัครสมาชิก</a>
        </nav>

        <div class="content">
            <h1 class="logo">GreenPlot</h1>
            
            <p class="tagline">
                บันทึก ติดตาม และวิเคราะห์ข้อมูลการเพาะปลูกของคุณได้อย่างเป็นระบบ<br>
                พร้อมคำนวณต้นทุน รายรับ และกำไร เพื่อวางแผนการเกษตรที่ดีขึ้น
            </p>

            <div class="button-group">
                <a href="/register" class="btn btn-primary">เริ่มต้นใช้งานฟรี</a>
            </div>

            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="/images/icons/activities.png" alt="บันทึกกิจกรรม">
                    </div>
                    <div class="feature-title">บันทึกกิจกรรม</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="/images/icons/efficiency.png" alt="คำนวณต้นทุน-กำไร">
                    </div>
                    <div class="feature-title">คำนวณต้นทุน-กำไร</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="/images/icons/business-analysis.png" alt="วิเคราะห์ผลผลิต">
                    </div>
                    <div class="feature-title">วิเคราะห์ผลผลิต</div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')
</body>
</html>