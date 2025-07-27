<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-image: url('images/img1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            font-family: 'Arial', sans-serif;
        }
        .launch-container {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .logo {
            max-width: 400px;
            opacity: 0;
            transform: scale(0.5);
            transition: all 4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            filter: brightness(1.2) contrast(1.4);
            position: absolute;
        }
        .logo.show {
            opacity: 1;
            transform: scale(1);
        }
        .loading-screen {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 20, 0.921);
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }
        .advanced-loader {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: conic-gradient(#00ffff 0deg, transparent 270deg);
            animation: rotate 6s linear infinite;
            position: relative;
        }
        .advanced-loader::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            height: 80%;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
        }
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loading-text {
            color: #00ffff;
            letter-spacing: 4px;
            margin-top: 20px;
            text-transform: uppercase;
        }
        .logo:hover {
            filter: brightness(1.5) contrast(1.6);
            transition: filter 6s ease;
        }
    </style>
</head>
<body>
    <div class="launch-container">
        <img src="images/logo1.png" alt="SARS Logo 1" class="logo" id="logo1">
        <img src="images/logo.png" alt="SARS Logo 2" class="logo" id="logo2">
                
        <div class="loading-screen">
            <div class="advanced-loader"></div>
            <h2 class="loading-text">Initializing</h2>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const logo1 = document.getElementById('logo1');
            const logo2 = document.getElementById('logo2');
            const loadingScreen = document.querySelector('.loading-screen');
            
            logo2.style.display = 'none';
            
            setTimeout(() => {
                logo1.classList.add('show');
            }, 500);
            
            setTimeout(() => {
                logo1.classList.remove('show');
                setTimeout(() => {
                    logo1.style.display = 'none';
                    logo2.style.display = 'block';
                    setTimeout(() => {
                        logo2.classList.add('show');
                    }, 200);
                }, 600);
            }, 4000);
            
            setTimeout(() => {
                logo2.classList.remove('show');
                setTimeout(() => {
                    logo2.style.display = 'none';
                    loadingScreen.style.display = 'flex';
                }, 600);
            }, 6500);
            
            setTimeout(() => {
                window.location.href = 'main.php';
            }, 8500);
        });
    </script>
</body>
</html>
