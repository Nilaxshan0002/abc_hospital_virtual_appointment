<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | ABC Virtual Healthcare</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/about.avif">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * {
            margin: 0; 
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f0ff 0%, #e8f0ff 50%, #f0f5ff 100%);
            color: #1e293b;
            line-height: 1.6;
            position: relative;
            min-height: 100vh;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 30%, rgba(102, 126, 234, 0.08) 0%, transparent 40%),
                        radial-gradient(circle at 80% 70%, rgba(118, 75, 162, 0.08) 0%, transparent 40%);
            pointer-events: none;
            z-index: -1;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ========== NAVIGATION (exact match from index.php) ========== */
        .navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        
        .logo img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
        }
        
        .text-highlight {
            color: #ff6b6b;
        }
        
        .nav-links {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 10px;
        }
        
        .nav-links li a {
            text-decoration: none;
            color: #334155;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 50px;
            transition: 0.3s;
        }
        
        .nav-links li a:hover {
            background: #f1f5f9;
            color: #ff6b6b;
        }
        
        .btn-login {
            border: 2px solid #ff6b6b !important;
            color: #ff6b6b !important;
            background: transparent;
        }
        
        .btn-login:hover {
            background: #ff6b6b !important;
            color: #fff !important;
        }
        
        .btn-register {
            background: #ff6b6b !important;
            border: 2px solid #ff6b6b !important;
            color: #fff !important;
        }
        
        .btn-register:hover {
            background: #ff5252 !important;
        }
        
        .nav-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }
        
        .nav-toggle span {
            width: 25px;
            height: 3px;
            background: #333;
            margin: 3px 0;
            transition: 0.3s;
        }
        
        @media (max-width: 968px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 80px;
                left: 0;
                width: 100%;
                background: rgba(255,255,255,0.95);
                backdrop-filter: blur(10px);
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }
            .nav-links.active {
                display: flex;
            }
            .nav-toggle {
                display: flex;
            }
        }

        /* ========== PAGE HEADER (new beautiful gradient) ========== */
        .page-header {
            background: linear-gradient(145deg, #4158D0 0%, #C850C0 45%, #FFB347 90%);
            color: white;
            padding: 100px 0 120px;
            text-align: center;
            border-radius: 0 0 80px 80px;
            margin-bottom: 60px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 30px 50px -20px rgba(193, 78, 192, 0.5);
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 140%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%);
            animation: rotate 20s linear infinite;
        }
        
        .page-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to top, rgba(255,255,255,0.1), transparent);
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .page-header h1 {
            font-size: 56px;
            font-weight: 800;
            margin-bottom: 25px;
            position: relative;
            text-shadow: 0 10px 20px rgba(0,0,0,0.2);
            animation: fadeInDown 1s ease;
        }
        
        .page-header p {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto;
            opacity: 0.95;
            position: relative;
            background: rgba(255,255,255,0.15);
            padding: 15px 40px;
            border-radius: 60px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.3);
            animation: fadeInUp 1s ease;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========== MISSION SECTION ========== */
        .mission-section {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 60px;
            margin: 60px 0;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.5);
        }
        
        .mission-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }
        
        .mission-content h2 {
            font-size: 42px;
            margin-bottom: 20px;
            color: #1e293b;
        }
        
        .mission-content .highlight {
            background: linear-gradient(135deg, #4158D0, #C850C0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }
        
        .mission-content p {
            color: #475569;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        
        .mission-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        
        .stat-item {
            text-align: center;
            padding: 25px 15px;
            background: linear-gradient(145deg, #ffffff, #f8faff);
            border-radius: 30px;
            transition: 0.4s;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.1);
        }
        
        .stat-item:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 20px 30px rgba(193, 78, 192, 0.2);
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: 800;
            background: linear-gradient(135deg, #4158D0, #C850C0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: block;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }
        
        .mission-image {
            position: relative;
        }
        
        .mission-image img {
            width: 100%;
            border-radius: 40px;
            box-shadow: 0 30px 40px -15px rgba(65, 88, 208, 0.4);
            border: 5px solid white;
            transition: 0.5s;
        }
        
        .mission-image img:hover {
            transform: scale(1.02);
        }
        
        .mission-image::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: -20px;
            bottom: -20px;
            background: linear-gradient(135deg, #4158D0, #C850C0);
            border-radius: 40px;
            z-index: -1;
            opacity: 0.3;
        }

        /* ========== VALUES SECTION ========== */
        .values-section {
            text-align: center;
            margin: 80px 0;
        }
        
        .section-title {
            font-size: 42px;
            margin-bottom: 20px;
            color: #1e293b;
        }
        
        .section-subtitle {
            background: linear-gradient(135deg, #4158D0, #C850C0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 14px;
            margin-bottom: 10px;
            display: block;
        }
        
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .value-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 50px 30px;
            border-radius: 40px;
            box-shadow: 0 20px 30px rgba(0,0,0,0.1);
            transition: 0.4s;
            border: 1px solid rgba(255,255,255,0.5);
        }
        
        .value-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 30px 40px rgba(193, 78, 192, 0.2);
            border-color: #C850C0;
        }
        
        .value-card i {
            font-size: 56px;
            background: linear-gradient(135deg, #4158D0, #C850C0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 25px;
        }
        
        .value-card h3 {
            font-size: 26px;
            margin-bottom: 15px;
            color: #1e293b;
        }
        
        .value-card p {
            color: #64748b;
            line-height: 1.6;
        }

        /* ========== JOURNEY TIMELINE WITH LOGO CIRCLES ========== */
        .journey-section {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 70px;
            margin: 60px 0;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.5);
        }
        
        .journey-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            margin-top: 50px;
        }
        
        .journey-card {
            text-align: center;
            padding: 40px 25px 30px;
            background: linear-gradient(145deg, #ffffff, #f8faff);
            border-radius: 40px;
            position: relative;
            transition: 0.4s;
            box-shadow: 0 15px 25px rgba(0,0,0,0.05);
        }
        
        .journey-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 35px rgba(193, 78, 192, 0.15);
        }
        
        .journey-year {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .year-circle {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #4158D0, #C850C0, #FFB347);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 15px 25px rgba(193, 78, 192, 0.3);
            transition: 0.5s;
            position: relative;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(193, 78, 192, 0.4);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(193, 78, 192, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(193, 78, 192, 0);
            }
        }
        
        .year-circle::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            background: linear-gradient(135deg, #4158D0, #C850C0, #FFB347);
            border-radius: 50%;
            opacity: 0.3;
            z-index: -1;
            transition: 0.5s;
        }
        
        .journey-card:hover .year-circle {
            transform: scale(1.1) rotateY(180deg);
        }
        
        .journey-card:hover .year-circle i {
            transform: rotateY(180deg);
        }
        
        .journey-card:hover .year-circle::before {
            transform: scale(1.3);
            opacity: 0.5;
        }
        
        .year-circle i {
            font-size: 48px;
            color: white;
            filter: drop-shadow(0 5px 10px rgba(0,0,0,0.2));
            transition: 0.5s;
        }
        
        .journey-year span {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, #4158D0, #C850C0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            position: relative;
        }
        
        .journey-year span::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: linear-gradient(90deg, #4158D0, #C850C0);
            border-radius: 3px;
        }
        
        .journey-card h3 {
            font-size: 24px;
            margin: 20px 0 10px;
            color: #1e293b;
            font-weight: 700;
        }
        
        .journey-card p {
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
            padding: 0 10px;
        }

        /* ========== TEAM SECTION (with working social links) ========== */
        .team-section {
            margin: 80px 0;
        }
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 35px;
            margin-top: 50px;
        }
        
        .team-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 40px;
            overflow: hidden;
            box-shadow: 0 20px 30px rgba(0,0,0,0.1);
            transition: 0.4s;
            border: 1px solid rgba(255,255,255,0.8);
        }
        
        .team-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 30px 40px rgba(193, 78, 192, 0.2);
            border-color: #C850C0;
        }
        
        .team-image {
            height: 320px;
            overflow: hidden;
            position: relative;
        }
        
        .team-image::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to top, rgba(255,255,255,0.8), transparent);
        }
        
        .team-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.8s;
        }
        
        .team-card:hover .team-image img {
            transform: scale(1.15);
        }
        
        .team-info {
            padding: 30px 25px;
            text-align: center;
            position: relative;
            background: white;
        }
        
        .team-info h3 {
            font-size: 26px;
            margin-bottom: 5px;
            color: #1e293b;
            font-weight: 700;
        }
        
        .team-info p {
            background: linear-gradient(135deg, #4158D0, #C850C0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 16px;
        }
        
        .team-social {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        
        .team-social a {
            width: 45px;
            height: 45px;
            background: linear-gradient(145deg, #f1f5f9, #ffffff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4158D0;
            text-decoration: none;
            transition: 0.4s;
            font-size: 20px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        
        .team-social a:hover {
            background: linear-gradient(135deg, #4158D0, #C850C0);
            color: white;
            transform: translateY(-5px) rotate(360deg);
            box-shadow: 0 10px 20px rgba(193, 78, 192, 0.3);
        }

        /* ========== FACILITIES SECTION ========== */
        .facilities-section {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 70px;
            margin: 60px 0;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.5);
        }
        
        .facilities-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 35px;
            margin-top: 50px;
        }
        
        .facility-item {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(145deg, #ffffff, #f8faff);
            border-radius: 40px;
            transition: 0.4s;
        }
        
        .facility-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(193, 78, 192, 0.15);
        }
        
        .facility-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #4158D0, #C850C0);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: white;
            font-size: 36px;
            box-shadow: 0 15px 25px rgba(65, 88, 208, 0.3);
            transition: 0.4s;
        }
        
        .facility-item:hover .facility-icon {
            transform: scale(1.1) rotate(360deg);
        }
        
        .facility-item h4 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #1e293b;
            font-weight: 700;
        }
        
        .facility-item p {
            color: #64748b;
            font-size: 14px;
        }

        /* ========== TESTIMONIALS ========== */
        .testimonials-section {
            margin: 80px 0;
        }
        
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 35px;
            margin-top: 50px;
        }
        
        .testimonial-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 40px;
            box-shadow: 0 20px 30px rgba(0,0,0,0.1);
            position: relative;
            border: 1px solid rgba(255,255,255,0.8);
            transition: 0.4s;
        }
        
        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 40px rgba(193, 78, 192, 0.15);
        }
        
        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 30px;
            font-size: 100px;
            background: linear-gradient(135deg, #4158D0, #C850C0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0.2;
            font-family: serif;
        }
        
        .testimonial-content {
            margin-bottom: 25px;
            color: #475569;
            line-height: 1.9;
            font-style: italic;
            font-size: 16px;
            position: relative;
            z-index: 1;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .testimonial-author img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .author-info h4 {
            font-size: 18px;
            color: #1e293b;
            margin-bottom: 5px;
            font-weight: 700;
        }
        
        .author-info p {
            font-size: 14px;
            color: #C850C0;
            font-weight: 500;
        }

        /* ========== CTA SECTION ========== */
        .cta-section {
            background: linear-gradient(145deg, #4158D0, #C850C0, #FFB347);
            border-radius: 60px;
            padding: 80px;
            margin: 60px 0;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 30px 50px -20px rgba(193, 78, 192, 0.5);
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 140%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%);
            animation: rotate 20s linear infinite;
        }
        
        .cta-section h2 {
            font-size: 42px;
            margin-bottom: 20px;
            position: relative;
            text-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        .cta-section p {
            font-size: 18px;
            margin-bottom: 35px;
            opacity: 0.95;
            position: relative;
        }
        
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            position: relative;
        }
        
        .btn {
            padding: 15px 35px;
            border-radius: 60px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.4s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
        }
        
        .btn-primary {
            background: white;
            color: #4158D0;
        }
        
        .btn-primary:hover {
            background: #f8fafc;
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.2);
        }
        
        .btn-outline-light {
            border: 2px solid white;
            color: white;
            background: transparent;
        }
        
        .btn-outline-light:hover {
            background: white;
            color: #4158D0;
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.2);
        }

        /* ========== FOOTER ========== */
        .footer {
            background: #0b1428;
            color: #94a3b8;
            padding: 80px 0 30px;
            margin-top: 80px;
            border-radius: 80px 80px 0 0;
            position: relative;
            overflow: hidden;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #4158D0, #C850C0, #FFB347);
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .footer-logo img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #ff6b6b;
        }
        
        .footer-logo span {
            color: white;
            font-weight: 700;
            font-size: 24px;
        }
        
        .footer-col h4 {
            color: white;
            margin-bottom: 25px;
            font-size: 18px;
            position: relative;
        }
        
        .footer-col h4::after {
            content: '';
            display: block;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #ff6b6b, #C850C0);
            margin-top: 8px;
            border-radius: 3px;
        }
        
        .footer-col ul {
            list-style: none;
        }
        
        .footer-col ul li {
            margin-bottom: 15px;
        }
        
        .footer-col ul li a {
            color: #94a3b8;
            text-decoration: none;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            font-size: 15px;
        }
        
        .footer-col ul li a i {
            margin-right: 10px;
            font-size: 12px;
            color: #ff9b9b;
            transition: 0.3s;
        }
        
        .footer-col ul li a:hover {
            color: white;
            transform: translateX(8px);
        }
        
        .footer-col ul li a:hover i {
            color: #ff6b6b;
        }
        
        .social-footer {
            display: flex;
            gap: 15px;
            margin-top: 25px;
            flex-wrap: wrap;
        }
        
        .social-footer a {
            width: 45px;
            height: 45px;
            background: #1e293b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: 0.4s;
            font-size: 20px;
            border: 2px solid transparent;
        }
        
        .social-footer a:hover {
            background: linear-gradient(135deg, #ff6b6b, #C850C0);
            transform: translateY(-5px) rotate(360deg);
            border-color: white;
        }
        
        .newsletter-form {
            display: flex;
            margin-top: 20px;
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 60px 0 0 60px;
            outline: none;
            background: #1e293b;
            color: white;
            font-size: 14px;
        }
        
        .newsletter-form input::placeholder {
            color: #64748b;
        }
        
        .newsletter-form button {
            background: linear-gradient(135deg, #ff6b6b, #C850C0);
            border: none;
            border-radius: 0 60px 60px 0;
            padding: 0 25px;
            color: white;
            cursor: pointer;
            transition: 0.3s;
            font-size: 20px;
        }
        
        .newsletter-form button:hover {
            background: linear-gradient(135deg, #C850C0, #ff6b6b);
            transform: scale(1.05);
        }
        
        .footer-bottom {
            border-top: 1px solid #1e293b;
            padding-top: 30px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .footer-bottom p {
            font-size: 14px;
        }
        
        .footer-bottom a {
            color: #94a3b8;
            text-decoration: none;
            margin-left: 25px;
            transition: 0.3s;
            font-size: 14px;
        }
        
        .footer-bottom a:hover {
            color: #ff6b6b;
        }
        
        .footer-bottom i.fa-heart {
            color: #ff6b6b;
            animation: heartbeat 1.5s ease infinite;
        }
        
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* ========== BACK TO TOP BUTTON ========== */
        #backToTop {
            position: fixed;
            bottom: 40px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ff6b6b, #C850C0);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 15px 25px rgba(255,107,107,0.4);
            z-index: 99;
            transition: 0.4s;
            border: 2px solid white;
        }
        
        #backToTop:hover {
            transform: translateY(-10px) scale(1.1);
            box-shadow: 0 20px 30px rgba(193, 78, 192, 0.5);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 968px) {
            .mission-grid {
                grid-template-columns: 1fr;
            }
            
            .journey-grid {
                grid-template-columns: 1fr;
            }
            
            .facilities-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .testimonials-grid {
                grid-template-columns: 1fr;
            }
            
            .cta-buttons {
                flex-direction: column;
            }
            
            .cta-section {
                padding: 50px 30px;
            }
        }
        
        @media (max-width: 576px) {
            .page-header h1 {
                font-size: 36px;
            }
            
            .mission-stats {
                grid-template-columns: 1fr;
            }
            
            .facilities-grid {
                grid-template-columns: 1fr;
            }
            
            .team-grid {
                grid-template-columns: 1fr;
            }
            
            .year-circle {
                width: 80px;
                height: 80px;
            }
            
            .year-circle i {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>

<!-- ========== NAVIGATION ========== -->
<nav class="navbar">
    <div class="container">
        <div class="nav-wrapper">
            <a href="/abc_hospital_virtual_appointment/index.php" class="logo">
                <img src="images/ABC logo.webp" alt="ABC Hospital" onerror="this.src='https://via.placeholder.com/50x50/4f46e5/ffffff?text=ABC';">
                <span class="logo-text">ABC <span class="text-highlight">VIRTUAL</span></span>
            </a>
            
            <ul class="nav-links" id="navMenu">
                <li><a href="/abc_hospital_virtual_appointment/index.php">Home</a></li>
                <li><a href="/abc_hospital_virtual_appointment/doctors.php">Doctors</a></li>
                <li><a href="/abc_hospital_virtual_appointment/services.php">Services</a></li>
                <li><a href="/abc_hospital_virtual_appointment/departments.php">Departments</a></li>
                <li><a href="/abc_hospital_virtual_appointment/appointments.php">Appointments</a></li>
                <li><a href="/abc_hospital_virtual_appointment/about.php">About</a></li>
                <li><a href="/abc_hospital_virtual_appointment/contact.php">Contact</a></li>
                <li><a href="/abc_hospital_virtual_appointment/pages/login.php" class="btn-login">Login</a></li>
                <li><a href="/abc_hospital_virtual_appointment/pages/register.php" class="btn-register">Register</a></li>
            </ul>
            
            <div class="nav-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</nav>

<!-- ========== PAGE HEADER ========== -->
<div class="page-header">
    <div class="container">
        <h1>About ABC Virtual</h1>
        <p>Leading healthcare innovation since 1959, bringing world-class medical services to your fingertips.</p>
    </div>
</div>

<div class="container">
    <!-- ========== MISSION SECTION ========== -->
    <div class="mission-section" data-aos="fade-up">
        <div class="mission-grid">
            <div class="mission-content">
                <span class="section-subtitle">Our Mission</span>
                <h2>Transforming <span class="highlight">Healthcare</span> for a Digital Age</h2>
                <p>Founded in 1959, ABC Hospital has been at the forefront of medical excellence in Sri Lanka for over six decades. Today, we're revolutionizing healthcare delivery through our virtual platform, making quality medical care accessible to everyone, everywhere.</p>
                <p>Our commitment to innovation, compassion, and excellence remains unwavering as we bridge the gap between traditional healthcare and modern technology.</p>
                
                <div class="mission-stats">
                    <div class="stat-item">
                        <span class="stat-number">64+</span>
                        <span class="stat-label">Years of Service</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">150+</span>
                        <span class="stat-label">Expert Doctors</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">50K+</span>
                        <span class="stat-label">Happy Patients</span>
                    </div>
                </div>
            </div>
            <div class="mission-image">
                <img src="images/hospital-building.webp" alt="ABC Hospital" onerror="this.src='https://images.unsplash.com/photo-1587351021759-3e566b6af7cc?w=600&h=400&fit=crop';">
            </div>
        </div>
    </div>

    <!-- ========== VALUES SECTION ========== -->
    <div class="values-section" data-aos="fade-up">
        <span class="section-subtitle">What Drives Us</span>
        <h2 class="section-title">Our Core <span class="highlight">Values</span></h2>
        
        <div class="values-grid">
            <div class="value-card">
                <i class="fas fa-heart"></i>
                <h3>Compassion</h3>
                <p>Every patient deserves care, respect, and understanding. We treat everyone like family.</p>
            </div>
            <div class="value-card">
                <i class="fas fa-microscope"></i>
                <h3>Innovation</h3>
                <p>Constantly evolving with cutting-edge technology to provide the best healthcare solutions.</p>
            </div>
            <div class="value-card">
                <i class="fas fa-shield-alt"></i>
                <h3>Excellence</h3>
                <p>Striving for the highest standards in every aspect of patient care and service.</p>
            </div>
            <div class="value-card">
                <i class="fas fa-hand-holding-heart"></i>
                <h3>Integrity</h3>
                <p>Honest, transparent, and ethical practices in all our medical services.</p>
            </div>
        </div>
    </div>

    <!-- ========== JOURNEY TIMELINE WITH LOGO CIRCLES ========== -->
    <div class="journey-section" data-aos="fade-up">
        <span class="section-subtitle">Our Journey</span>
        <h2 class="section-title">Six Decades of <span class="highlight">Healthcare Excellence</span></h2>
        
        <div class="journey-grid">
            <div class="journey-card">
                <div class="journey-year">
                    <div class="year-circle">
                        <i class="fas fa-clinic-medical"></i>
                    </div>
                    <span>1959</span>
                </div>
                <h3>The Beginning</h3>
                <p>Founded as a small 20-bed clinic in Colombo by Dr. A.B. Cooray</p>
            </div>
            <div class="journey-card">
                <div class="journey-year">
                    <div class="year-circle">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <span>1985</span>
                </div>
                <h3>Multi-Specialty Hospital</h3>
                <p>Expanded to become a full-fledged multi-specialty healthcare facility</p>
            </div>
            <div class="journey-card">
                <div class="journey-year">
                    <div class="year-circle">
                        <i class="fas fa-laptop-medical"></i>
                    </div>
                    <span>2020</span>
                </div>
                <h3>Digital Transformation</h3>
                <p>Launched ABC Virtual to bring healthcare online</p>
            </div>
        </div>
    </div>

    <!-- ========== TEAM SECTION (with working social media links) ========== -->
    <div class="team-section" data-aos="fade-up">
        <span class="section-subtitle">Our Leadership</span>
        <h2 class="section-title">Meet Our <span class="highlight">Medical Team</span></h2>
        
        <div class="team-grid">
            <div class="team-card">
                <div class="team-image">
                    <img src="images/Dr. Kamal Perera.jpg" alt="Dr. Kamal Perera" onerror="this.src='https://images.unsplash.com/photo-1537368910025-700350fe46c7?w=400&h=300&fit=crop';">
                </div>
                <div class="team-info">
                    <h3>Dr. Kamal Perera</h3>
                    <p>Chief Cardiologist</p>
                    <div class="team-social">
                        <a href="https://linkedin.com/in/drkamalperera" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://twitter.com/drkamalperera" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                        <a href="mailto:dr.kamal@abchospital.lk"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
            <div class="team-card">
                <div class="team-image">
                    <img src="images/Ms. Nadeeka Fernando.jpg" alt="Dr. Nadeeka Fernando" onerror="this.src='https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400&h=300&fit=crop';">
                </div>
                <div class="team-info">
                    <h3>Dr. Nadeeka Fernando</h3>
                    <p>Head of Neurology</p>
                    <div class="team-social">
                        <a href="https://linkedin.com/in/drnadeekafernando" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://twitter.com/drnadeeka" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                        <a href="mailto:dr.nadeeka@abchospital.lk"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
            <div class="team-card">
                <div class="team-image">
                    <img src="images/Mrs. Priyani Silva.jpg" alt="Dr. Priyani Silva" onerror="this.src='https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=400&h=300&fit=crop';">
                </div>
                <div class="team-info">
                    <h3>Dr. Priyani Silva</h3>
                    <p>Pediatrics Specialist</p>
                    <div class="team-social">
                        <a href="https://linkedin.com/in/drpriyanisilva" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://twitter.com/drpriyani" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                        <a href="mailto:dr.priyani@abchospital.lk"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== FACILITIES SECTION ========== -->
    <div class="facilities-section" data-aos="fade-up">
        <span class="section-subtitle">Our Facilities</span>
        <h2 class="section-title">World-Class <span class="highlight">Infrastructure</span></h2>
        
        <div class="facilities-grid">
            <div class="facility-item">
                <div class="facility-icon">
                    <i class="fas fa-procedures"></i>
                </div>
                <h4>200+ Beds</h4>
                <p>Modern inpatient facilities with ICU and emergency care</p>
            </div>
            <div class="facility-item">
                <div class="facility-icon">
                    <i class="fas fa-flask"></i>
                </div>
                <h4>Advanced Lab</h4>
                <p>State-of-the-art diagnostic laboratory</p>
            </div>
            <div class="facility-item">
                <div class="facility-icon">
                    <i class="fas fa-x-ray"></i>
                </div>
                <h4>Digital Imaging</h4>
                <p>MRI, CT Scan, and X-ray facilities</p>
            </div>
            <div class="facility-item">
                <div class="facility-icon">
                    <i class="fas fa-ambulance"></i>
                </div>
                <h4>24/7 Emergency</h4>
                <p>Round-the-clock emergency services</p>
            </div>
        </div>
    </div>

    <!-- ========== TESTIMONIALS ========== -->
    <div class="testimonials-section" data-aos="fade-up">
        <span class="section-subtitle">Patient Stories</span>
        <h2 class="section-title">What Our <span class="highlight">Patients Say</span></h2>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <p class="testimonial-content">The virtual consultation service has been a game-changer. I can consult with my doctor from anywhere, saving time and travel. The quality of care remains exceptional.</p>
                <div class="testimonial-author">
                    <img src="images/Mrs. Priyani Silva.jpg" alt="Patient" onerror="this.src='https://images.unsplash.com/photo-1494790108777-467efef9c9d1?w=70&h=70&fit=crop';">
                    <div class="author-info">
                        <h4>Mrs. Priyani Silva</h4>
                        <p>Patient since 2015</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <p class="testimonial-content">As a doctor, the portal helps me manage my appointments efficiently. The digital infrastructure at ABC Virtual is truly world-class.</p>
                <div class="testimonial-author">
                    <img src="images/Dr. Kamal Perera.jpg" alt="Doctor" onerror="this.src='https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=70&h=70&fit=crop';">
                    <div class="author-info">
                        <h4>Dr. Kamal Perera</h4>
                        <p>Consultant Cardiologist</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== CTA SECTION ========== -->
    <div class="cta-section" data-aos="zoom-in">
        <h2>Ready to Experience Modern Healthcare?</h2>
        <p>Join thousands of patients who've embraced digital healthcare with ABC Virtual</p>
        <div class="cta-buttons">
            <a href="/abc_hospital_virtual_appointment/pages/register.php" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Register Now
            </a>
            <a href="/abc_hospital_virtual_appointment/contact.php" class="btn btn-outline-light">
                <i class="fas fa-headset"></i> Contact Us
            </a>
        </div>
    </div>
</div>

<!-- ========== FOOTER ========== -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="footer-logo">
                    <img src="images/ABC logo.webp" alt="ABC Hospital" onerror="this.src='https://via.placeholder.com/50x50/ff6b6b/ffffff?text=ABC';">
                    <span>ABC VIRTUAL</span>
                </div>
                <p>Leading the way in digital healthcare since 1959. Your trusted partner in health and wellness.</p>
                <div class="social-footer">
                    <a href="https://facebook.com/abchospital" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/abchospital" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                    <a href="https://linkedin.com/company/abchospital" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://instagram.com/abchospital" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                    <a href="https://youtube.com/abchospital" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="/abc_hospital_virtual_appointment/index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/doctors.php"><i class="fas fa-chevron-right"></i> Doctors</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/services.php"><i class="fas fa-chevron-right"></i> Services</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/departments.php"><i class="fas fa-chevron-right"></i> Departments</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/appointments.php"><i class="fas fa-chevron-right"></i> Appointments</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/contact.php"><i class="fas fa-chevron-right"></i> Contact</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h4>Our Portals</h4>
                <ul>
                    <li><a href="/abc_hospital_virtual_appointment/pages/login.php?type=patient"><i class="fas fa-chevron-right"></i> Patient Portal</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/pages/login.php?type=doctor"><i class="fas fa-chevron-right"></i> Doctor Portal</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/pages/login.php?type=admin"><i class="fas fa-chevron-right"></i> Admin Portal</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/pages/login.php?type=receptionist"><i class="fas fa-chevron-right"></i> Receptionist Portal</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h4>Newsletter</h4>
                <p>Subscribe for health tips and updates</p>
                <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');">
                    <input type="email" placeholder="Your Email" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2026 ABC Hospital. All rights reserved. | Made with <i class="fas fa-heart"></i> for better healthcare</p>
            <div>
                <a href="/abc_hospital_virtual_appointment/terms-of-use.php">Terms of Use</a>
                <a href="/abc_hospital_virtual_appointment/privacy-policy.php">Privacy Policy</a>
                <a href="/abc_hospital_virtual_appointment/cookie-policy.php">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="backToTop" title="Back to Top"><i class="fas fa-arrow-up"></i></button>

<!-- Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });

    // Mobile navigation toggle
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
    }

    // Back to top button
    const backToTop = document.getElementById('backToTop');
    
    window.addEventListener('scroll', () => {
        if (backToTop) {
            if (window.scrollY > 300) {
                backToTop.style.display = 'flex';
            } else {
                backToTop.style.display = 'none';
            }
        }
    });

    backToTop.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Close mobile menu when clicking a link
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
        });
    });
</script>
</body>
</html>