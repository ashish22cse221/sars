<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WORKSHOP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Orbitron:wght@400;600&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        :root {
            --cyan-primary: #00ffff;
            --cyan-dark: #00b3b3;
            --cyan-light: #80ffff;
            --dark-bg: #0a0a15;
            --dark-secondary: #121228;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--dark-bg);
            color: #e0e0e0;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('images/img1.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.15;
            z-index: -1;
            animation: slowZoom 30s infinite alternate;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            border: 1px solid var(--cyan-primary);
            border-radius: 15px;
            margin-top: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.2);
            animation: fadeIn 1s ease-in;
            background: rgba(10, 10, 21, 0.85);
            backdrop-filter: blur(10px);
        }
        header {
            display: flex;
            align-items: center;
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(0, 255, 255, 0.3);
        }
        .logo-container {
            width: 90px;
            height: 90px;
            border: 2px solid var(--cyan-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 1.5rem;
            background: rgba(0, 255, 255, 0.05);
            animation: pulseLogo 3s infinite;
            position: relative;
            overflow: hidden;
        }
        .logo-container::before {
            background-image: url('images/logo.png');
            position: absolute;
            width: 150%;
            height: 150%;
            background: conic-gradient(
                transparent,
                transparent,
                transparent,
                var(--cyan-primary)
            );
            animation: rotate 3s linear infinite;
        }
        .logo-container::after {
            content: "";
            background-image: url('images/logo.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            position: absolute;
            inset: 5px;
            border-radius: 50%;
        }
        .company-name {
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem;
            color: var(--cyan-primary);
            text-transform: uppercase;
            letter-spacing: 3px;
            animation: slideInRight 0.8s ease, textGlow 2.5s infinite alternate;
            position: relative;
        }
        .company-name::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--cyan-primary);
            animation: lineExpand 1.5s forwards 1s;
        }
        main {
            display: flex;
            flex-direction: column;
        }
        .event-section {
            display: flex;
            flex-direction: row;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(0, 255, 255, 0.3);
            margin-bottom: 2.5rem;
            animation: fadeIn 1.2s ease, floatUp 1.5s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.4s ease;
        }
        .event-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 255, 255, 0.15);
            border-color: var(--cyan-primary);
        }
        .event-image {
            background-image: url('images/.jpg');
            background-size: cover;
            background-position: center;
        }
        .event-image::before {
            content: "";
        }
        .event-image::before {
            content: "";
            position: absolute;
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.2rem;
            color: var(--cyan-primary);
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 20px;
            border-radius: 30px;
            border: 1px solid var(--cyan-primary);
            animation: pulse 2s infinite;
        }
        .event-image::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 30%, rgba(0, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(0, 255, 255, 0.05) 0%, transparent 50%);
            animation: shimmer 8s infinite alternate;
        }
        .event-details {
            flex: 1;
            padding: 2.5rem;
            position: relative;
        }
        .details-title {
            font-family: 'Orbitron', sans-serif;
            color: var(--cyan-primary);
            margin-bottom: 1.5rem;
            border-bottom: 1px solid rgba(0, 255, 255, 0.3);
            padding-bottom: 0.5rem;
            animation: glow 3s infinite alternate;
            display: inline-block;
            font-size: 1.8rem;
        }
        .info-box {
            min-height: 180px;
            border: 1px solid rgba(0, 255, 255, 0.3);
            padding: 1.8rem;
            margin-bottom: 2rem;
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.4);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        .info-box::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent, rgba(0, 255, 255, 0.05), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }
        .info-box:hover::before {
            transform: translateX(100%);
        }
        .info-box:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 10px 25px rgba(0, 255, 255, 0.15);
            border-color: var(--cyan-primary);
        }
        .register-btn {
            display: block;
            width: 100%;
            padding: 1.2rem;
            background: transparent;
            color: var(--cyan-primary);
            border: 2px solid var(--cyan-primary);
            border-radius: 8px;
            font-family: 'Orbitron', sans-serif;
            font-size: 1.1rem;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .register-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background: rgba(0, 255, 255, 0.1);
            transition: width 0.4s ease;
            z-index: -1;
        }
        .register-btn:hover::before {
            width: 100%;
        }
        .register-btn::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 10px;
            height: 10px;
            background: var(--cyan-primary);
            opacity: 0;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(1);
            transition: 0.5s;
        }
        .register-btn:active::after {
            opacity: 0.3;
            transform: translate(-50%, -50%) scale(20);
        }
        .register-btn:hover {
            color: white;
            text-shadow: 0 0 5px var(--cyan-primary);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }
        footer {
            background: rgba(0, 0, 0, 0.8);
            border-top: 1px solid rgba(0, 255, 255, 0.2);
            padding: 2rem 0;
            text-align: center;
            margin-top: 2rem;
            position: relative;
            overflow: hidden;
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .copyright {
            margin-top: 1.5rem;
            color: #aaa;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideInRight {
            from { transform: translateX(-50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes floatUp {
            from { transform: translateY(50px); }
            to { transform: translateY(0); }
        }
        @keyframes pulseLogo {
            0% { box-shadow: 0 0 0 0 rgba(0, 255, 255, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(0, 255, 255, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 255, 255, 0); }
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        @keyframes glow {
            from { text-shadow: 0 0 5px var(--cyan-primary), 0 0 10px var(--cyan-primary); }
            to { text-shadow: 0 0 10px var(--cyan-primary), 0 0 20px var(--cyan-primary), 0 0 30px var(--cyan-primary); }
        }
        @keyframes textGlow {
            from { text-shadow: 0 0 2px var(--cyan-primary); }
            to { text-shadow: 0 0 10px var(--cyan-primary), 0 0 20px var(--cyan-light); }
        }
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes lineExpand {
            from { width: 0; }
            to { width: 100px; }
        }
        @keyframes shimmer {
            from { opacity: 0.3; }
            to { opacity: 0.8; }
        }
        @keyframes float {
            from { transform: translateY(0); }
            to { transform: translateY(-10px); }
        }
        @keyframes slowZoom {
            from { transform: scale(1); }
            to { transform: scale(1.1); }
        }
        /* Responsive Styles */
        @media screen and (max-width: 768px) {
            .event-section {
                flex-direction: column;
            }
            .event-image {
                min-height: 200px;
                border-right: none;
                border-bottom: 1px solid rgba(0, 255, 255, 0.2);
            }
            .container {
                padding: 1.5rem;
                margin-top: 1rem;
                margin-bottom: 1rem;
            }
            header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            .logo-container {
                margin-right: 0;
                margin-bottom: 0.5rem;
            }
            .company-name {
                font-size: 1.5rem;
            }
            .company-name::after {
                left: 50%;
                transform: translateX(-50%);
            }
            .footer-links {
                gap: 1rem;
                flex-direction: column;
                align-items: center;
            }
        }
        @media screen and (max-width: 480px) {
            .event-details {
                padding: 1.2rem;
            }
            .info-box {
                padding: 1rem;
                min-height: 150px;
            }
            .register-btn {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo-container"></div>
            <h1 class="company-name">SARS</h1>
        </header>
        <main id="eventContainer">
            <!-- Dynamic events will be loaded here -->
        </main>
    </div>
    <footer>
        <div class="footer-content">
            <p class="copyright">© 2025 SARS. All Rights Reserved.</p>
            <p class="copyright">Vivek Choudhury:- 7815048041</p>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadEvents();
            
            // Add click animation to buttons
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('register-btn')) {
                    e.target.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        e.target.style.transform = 'scale(1)';
                    }, 150);
                }
            });
            
            // Animate elements on scroll
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.info-box, .event-section, .details-title');
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.2;
                    
                    if(elementPosition < screenPosition) {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }
                });
            };
            
            // Set initial state for scroll animations
            const elementsToAnimate = document.querySelectorAll('.info-box, .event-section, .details-title');
            elementsToAnimate.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            });
            
            // Call once on load
            setTimeout(animateOnScroll, 500);
            
            // Add scroll listener
            window.addEventListener('scroll', animateOnScroll);
        });
        
        // Load events from database
        async function loadEvents() {
            try {
                const response = await fetch('api/get_events.php');
                const events = await response.json();
                
                const eventContainer = document.getElementById('eventContainer');
                let eventsHTML = '';
                
                events.forEach(event => {
                    const buttonText = event.status === 'completed' ? 'Completed' : 'Register Now';
                    const buttonAction = event.status === 'completed' ? 
                        'onclick="alert(\'This event has been completed\')"' : 
                        `onclick="window.open('${event.registration_link || '#'}', '_blank')"`;
                    
                    eventsHTML += `
                        <div class="event-section">
                            <img src="${event.poster_path}" alt="Event Image" style="width: 50%; height: 100%; object-fit: cover;">
                            <div class="event-details">
                                <h2 class="details-title">Details</h2>
                                <div class="info-box">
                                    <h1>${event.title}</h1>
                                    <p><strong>Organized by:</strong> SARS Club</p>
                                    <p><strong>Date:</strong> ${new Date(event.event_date).toLocaleDateString()}</p>
                                    <p><strong>Venue:</strong> ${event.venue || 'TBA'}</p>
                                    <p><strong>Expected Participants:</strong> ${event.expected_participants || 'TBA'} students</p>
                                    
                                    <h2>Event Description</h2>
                                    <p>${event.description}</p>
                                </div>
                                <button class="register-btn" ${buttonAction}>${buttonText}</button>
                            </div>
                        </div>
                    `;
                });
                
                eventContainer.innerHTML = eventsHTML;
                
            } catch (error) {
                console.error('Error loading events:', error);
                document.getElementById('eventContainer').innerHTML = '<p>Error loading events. Please try again later.</p>';
            }
        }
    </script>
</body>
</html>
