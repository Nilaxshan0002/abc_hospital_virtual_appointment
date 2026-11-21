<?php
// Header for Services Page
$base_url = '/abc_hospital_virtual_appointment';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="<?php echo $pageDescription; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo $base_url; ?>/images/ABC logo.webp">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/style.css">
    
    <style>
        /* Navigation - Fixed positioning */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        body {
            padding-top: 80px;
        }
        
        /* Page Header with straight line design */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0;
            text-align: center;
            color: white;
            position: relative;
            border-bottom: 5px solid #ff6b6b;
        }
        
        .page-header h1 {
            font-size: 48px;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .page-header p {
            font-size: 18px;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Services Grid */
        .services-grid {
            padding: 80px 0;
            background: #f9f9ff;
        }
        
        .service-category {
            margin-bottom: 70px;
        }
        
        .service-category h2 {
            font-size: 36px;
            color: #333;
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 15px;
            font-weight: 600;
        }
        
        .service-category h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }
        
        .service-items {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }
        
        .service-item {
            background: white;
            padding: 35px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .service-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
        }
        
        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
        }
        
        .service-icon img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }
        
        .service-item h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
            font-weight: 600;
        }
        
        .service-item p {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.7;
        }
        
        .service-features {
            list-style: none;
            padding: 0;
        }
        
        .service-features li {
            margin-bottom: 12px;
            color: #555;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .service-features li i {
            color: #10b981;
            font-size: 16px;
        }
        
        .service-link {
            display: inline-block;
            margin-top: 20px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .service-link:hover {
            color: #764ba2;
        }
        
        .service-link i {
            transition: transform 0.3s;
        }
        
        .service-link:hover i {
            transform: translateX(8px);
        }
        
        /* Pricing Section */
        .pricing-section {
            padding: 80px 0;
            background: white;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-subtitle {
            color: #667eea;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .section-title {
            font-size: 42px;
            color: #333;
            margin: 15px 0;
            font-weight: 700;
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .section-description {
            color: #666;
            font-size: 18px;
        }
        
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        
        .pricing-card {
            background: #f9f9ff;
            padding: 40px 30px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .pricing-card:hover {
            transform: translateY(-10px) scale(105%);
            box-shadow: 0 30px 60px rgba(102, 126, 234, 0.15);
        }
        
        .pricing-card h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }
        
        .price {
            font-size: 36px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 20px;
        }
        
        .price span {
            font-size: 16px;
            color: #666;
            font-weight: 400;
        }
        
        .btn-book {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-book:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }
        
        /* Footer with all links */
        .footer {
            background: #1a1a2e;
            color: #fff;
            padding: 60px 0 20px;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-col p {
            color: #b3b3b3;
            line-height: 1.8;
            margin: 15px 0;
        }
        
        .footer-col h4 {
            color: #fff;
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .footer-col ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-col ul li {
            margin-bottom: 10px;
        }
        
        .footer-col ul li a {
            color: #b3b3b3;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-col ul li a:hover {
            color: #667eea;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background: #667eea;
            transform: translateY(-3px);
        }
        
        .newsletter-form {
            display: flex;
            margin-top: 20px;
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px 0 0 5px;
            outline: none;
        }
        
        .newsletter-form button {
            padding: 10px 15px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .newsletter-form button:hover {
            background: #764ba2;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .footer-bottom p {
            color: #b3b3b3;
            margin: 0;
        }
        
        .footer-links {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .footer-links a {
            color: #b3b3b3;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: #667eea;
        }
        
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
            transition: all 0.3s;
            z-index: 999;
        }
        
        #backToTop:hover {
            background: #764ba2;
            transform: translateY(-3px);
        }
        
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 36px;
            }
            
            .service-category h2 {
                font-size: 30px;
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="loader"></div>
    </div>