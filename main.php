<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Orbitron:wght@400;600;700&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Keep all your existing CSS exactly as it is */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }
        :root {
            --cyan-primary: #00ffff;
            --cyan-dark: #00b3b3;
            --cyan-light: #80ffff;
            --magenta-primary: #ff00ff;
            --magenta-dark: #b300b3;
            --purple-glow: #9d00ff;
            --dark-bg: #0a0a15;
            --dark-secondary: #121228;
            --transition: all 0.4s ease;
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
            background-image: url('images/img2.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.15;
            z-index: -1;
            animation: slowZoom 30s infinite alternate;
        }
        section {
            padding: 6rem 2rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            scroll-margin-top: 80px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            position: relative;
        }
        /* NAVBAR */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(10, 10, 21, 0.9);
            backdrop-filter: blur(10px);
            z-index: 1000;
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--cyan-primary);
            box-shadow: 0 2px 20px rgba(0, 255, 255, 0.2);
            transition: var(--transition);
        }
        /* Terminal Component Styles */
        .terminal-container {
            width: 600px;
            max-width: 100%;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
            border: 1px solid var(--cyan-primary);
            margin: 3rem auto;
            animation: fadeIn 1s ease;
        }
        .terminal-header {
            background-color: rgba(18, 18, 40, 0.9);
            padding: 8px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--cyan-primary);
        }
        .terminal-title {
            color: var(--cyan-primary);
            font-size: 14px;
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 1px;
        }
        .terminal-buttons {
            display: flex;
            gap: 6px;
        }
        .button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        .close {
            background-color: #ff5f56;
        }
        .minimize {
            background-color: #ffbd2e;
        }
        .maximize {
            background-color: #27c93f;
        }
        .terminal-body {
            background-color: rgba(10, 10, 21, 0.95);
            padding: 20px;
            height: 100px;
            overflow-y: auto;
        }
        .terminal-line {
            display: flex;
            margin-bottom: 10px;
        }
        .terminal-prompt {
            color: var(--cyan-primary);
            margin-right: 8px;
            font-family: 'Rajdhani', sans-serif;
            font-weight: bold;
        }
        .terminal-text {
            color: var(--cyan-primary);
            white-space: pre;
            position: relative;
            font-family: 'Rajdhani', sans-serif;
        }
        .terminal-text::after {
            content: "";
            position: absolute;
            right: -10px;
            top: 0;
            height: 100%;
            width: 8px;
            background-color: var(--cyan-primary);
            animation: blink 1s infinite;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
        .hide-cursor .terminal-text::after {
            display: none;
        }
        /* Media query for terminal responsiveness */
        @media (max-width: 768px) {
            .terminal-container {
                width: 100%;
            }
            .terminal-body {
                height: 80px;
            }
        }
        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        .logo-icon {
            width: 50px;
            height: 50px;
            border: 2px solid var(--cyan-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(0, 255, 255, 0.05);
            animation: pulseLogo 3s infinite;
            position: relative;
            overflow: hidden;
            margin-right: 1rem;
        }
        /* Remove the before pseudo-element with the conic gradient */
        .logo-icon::before {
            display: none;
        }
        /* Replace the "SR" text with the image */
        .logo-icon::after {
            content: "";
            position: absolute;
            inset: 0;
            background: none;
            border-radius: 50%;
        }
        /* Add the actual image */
        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        .logo-text {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            color: var(--cyan-primary);
            text-transform: uppercase;
            letter-spacing: 2px;
            animation: textGlow 2.5s infinite alternate;
        }
        .nav-links {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }
        .nav-links li a {
            color: #e0e0e0;
            text-decoration: none;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 0.5rem 0;
            position: relative;
            transition: var(--transition);
        }
        .nav-links li a::after {
            content: "";
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--cyan-primary);
            transition: width 0.3s ease;
        }
        .nav-links li a:hover {
            color: var(--cyan-primary);
        }
        .nav-links li a:hover::after {
            width: 100%;
        }
        .hamburger {
            display: none;
            cursor: pointer;
            background: none;
            border: none;
            color: var(--cyan-primary);
            font-size: 1.5rem;
        }
        /* HERO SECTION */
        #home {
            min-height: 100vh;
            background: linear-gradient(rgba(10, 10, 21, 0.8), rgba(10, 10, 21, 0.9)), url('/api/placeholder/1920/1080');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero-container {
            position: relative;
            z-index: 5;
            animation: fadeIn 1.5s ease;
        }
        .hero-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
            text-shadow: 0 0 10px var(--cyan-primary), 0 0 20px var(--cyan-primary);
            animation: heroTitleAnim 3s infinite alternate;
        }
        .hero-subtitle {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.8rem;
            margin-bottom: 2rem;
            color: var(--cyan-primary);
            text-shadow: 0 0 5px var(--cyan-dark);
        }
        .btn {
            display: inline-block;
            padding: 1rem 2.5rem;
            background: transparent;
            color: var(--cyan-primary);
            border: 2px solid var(--cyan-primary);
            border-radius: 5px;
            font-family: 'Orbitron', sans-serif;
            font-size: 1.1rem;
            cursor: pointer;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .btn::before {
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
        .btn:hover::before {
            width: 100%;
        }
        .btn:hover {
            color: white;
            text-shadow: 0 0 5px var(--cyan-primary);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }
        .hero-particles {
            position: absolute;
            inset: 0;
            z-index: 1;
            background: url('/api/placeholder/10/10') repeat;
            opacity: 0.05;
        }
        .scroll-indicator {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            color: var(--cyan-primary);
            font-size: 2rem;
            animation: bounce 2s infinite;
            cursor: pointer;
            z-index: 10;
        }
        /* SECTION STYLING */
        .section-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            color: var(--cyan-primary);
            margin-bottom: 1.5rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 3px;
            animation: textGlow 2.5s infinite alternate;
            position: relative;
            display: inline-block;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
            display: block;
        }
        .section-title::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--cyan-primary);
            box-shadow: 0 0 10px var(--cyan-primary);
        }
        .section-subtitle {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.3rem;
            text-align: center;
            margin-bottom: 3rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .cyber-box {
            border: 1px solid var(--cyan-primary);
            border-radius: 10px;
            padding: 2.5rem;
            background: rgba(10, 10, 21, 0.8);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            width: 100%;
        }
        .cyber-box::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent, rgba(0, 255, 255, 0.05), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }
        .cyber-box:hover::before {
            transform: translateX(100%);
        }
        .cyber-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 255, 255, 0.2);
            border-color: var(--cyan-light);
        }
        /* ABOUT SECTION */
        #about .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: justify;
            max-width: 90%;
            margin: 0 auto;
        }
        .about-content h3 {
            font-family: 'Orbitron', sans-serif;
            color: var(--cyan-primary);
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        .about-content p {
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .stat-item {
            text-align: center;
            padding: 1.5rem;
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid var(--cyan-dark);
            transition: var(--transition);
        }
        .stat-item:hover {
            transform: translateY(-5px);
            border-color: var(--cyan-primary);
            box-shadow: 0 5px 15px rgba(0, 255, 255, 0.2);
        }
        .stat-number {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            color: var(--cyan-primary);
            margin-bottom: 0.5rem;
        }
        .stat-text {
            font-family: 'Rajdhani', sans-serif;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        /* PROJECTS SECTION */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }
        .project-card {
            border-radius: 10px;
            overflow: hidden;
            height: 350px;
            position: relative;
            cursor: pointer;
            border: 1px solid var(--cyan-dark);
            transition: var(--transition);
        }
        .project-card:hover {
            transform: translateY(-10px);
            border-color: var(--cyan-primary);
            box-shadow: 0 10px 30px rgba(0, 255, 255, 0.3);
        }
        .project-image {
            width: 100%;
            height: 60%;
            overflow: hidden;
        }
        .project-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .project-card:hover .project-image img {
            transform: scale(1.1);
        }
        .project-content {
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.8);
            height: 40%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .project-title {
            font-family: 'Orbitron', sans-serif;
            color: var(--cyan-primary);
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }
        .project-desc {
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .project-link {
            font-family: 'Rajdhani', sans-serif;
            color: var(--cyan-primary);
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .project-link:hover {
            color: white;
            text-shadow: 0 0 5px var(--cyan-primary);
        }
        /* EVENTS SECTION */
        .events-timeline {
            position: relative;
            max-width: 1000px;
            margin: 0 auto;
        }
        .events-timeline::before {
            content: '';
            position: absolute;
            width: 2px;
            background: var(--cyan-primary);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -1px;
            box-shadow: 0 0 10px var(--cyan-primary);
        }
        .timeline-item {
            padding: 1rem 2rem;
            position: relative;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            width: calc(50% - 40px);
            margin-bottom: 2rem;
            animation: fadeIn 1s ease;
            border: 1px solid var(--cyan-dark);
            transition: var(--transition);
        }
        .timeline-item:hover {
            transform: translateY(-10px);
            border-color: var(--cyan-primary);
            box-shadow: 0 5px 15px rgba(0, 255, 255, 0.2);
        }
        .timeline-item::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: var(--cyan-primary);
            border-radius: 50%;
            top: 20px;
            box-shadow: 0 0 10px var(--cyan-primary);
        }
        .left {
            left: 0;
        }
        .right {
            left: 50%;
        }
        .left::after {
            right: -50px;
        }
        .right::after {
            left: -10px;
        }
        .event-date {
            font-family: 'Orbitron', sans-serif;
            color: var(--cyan-primary);
            margin-bottom: 0.5rem;
            font-size: 1rem;
            display: inline-block;
            padding: 0.3rem 1rem;
            background: rgba(0, 255, 255, 0.1);
            border: 1px solid var(--cyan-dark);
            border-radius: 5px;
        }
        .event-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: white;
        }
        .event-desc {
            margin-bottom: 1rem;
        }
        .event-btn {
            font-family: 'Rajdhani', sans-serif;
            text-decoration: none;
            padding: 0.5rem 1rem;
            background: transparent;
            color: var(--cyan-primary);
            border: 1px solid var(--cyan-primary);
            border-radius: 5px;
            display: inline-block;
            transition: var(--transition);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .event-btn:hover {
            background: rgba(0, 255, 255, 0.1);
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
        }
        /* TEAM SECTION */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }
        .team-member {
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid var(--cyan-dark);
            transition: var(--transition);
            height: 350px;
        }
        .team-member:hover {
            transform: translateY(-10px);
            border-color: var(--cyan-primary);
            box-shadow: 0 10px 30px rgba(0, 255, 255, 0.3);
        }
        .member-image {
            height: 65%;
            overflow: hidden;
        }
        .member-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .team-member:hover .member-image img {
            transform: scale(1.1);
        }
        .member-details {
            padding: 1.2rem;
            text-align: center;
        }
        .member-name {
            font-family: 'Orbitron', sans-serif;
            color: var(--cyan-primary);
            margin-bottom: 0.3rem;
            font-size: 1.2rem;
        }
        .member-role {
            color: #aaa;
            margin-bottom: 0.8rem;
            font-size: 0.9rem;
            font-family: 'Rajdhani', sans-serif;
        }
        .member-social {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
        .member-social a {
            color: var(--cyan-primary);
            font-size: 1.2rem;
            transition: var(--transition);
        }
        .member-social a:hover {
            color: white;
            transform: translateY(-3px);
            text-shadow: 0 0 5px var(--cyan-primary);
        }
        .member-bio {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.9);
            transform: translateY(100%);
            transition: var(--transition);
            border-top: 1px solid var(--cyan-primary);
        }
        .team-member:hover .member-bio {
            transform: translateY(0);
        }
        /* GALLERY SECTION */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            height: 500px;
        }
        .gallery-item {
            height: 100%;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            border: 2px solid var(--cyan-dark);
            transition: var(--transition);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .gallery-item:hover {
            transform: scale(1.03);
            border-color: var(--cyan-primary);
            box-shadow: 0 5px 15px rgba(0, 255, 255, 0.3);
        }
        .gallery-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: var(--transition);
        }
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        .gallery-overlay i {
            font-size: 2.5rem;
            color: var(--cyan-primary);
        }
        .video-controls {
            position: absolute;
            bottom: 15px;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 20px;
            z-index: 10;
            opacity: 0;
            transition: var(--transition);
        }
        .gallery-item:hover .video-controls {
            opacity: 1;
        }
        .video-controls button {
            background: rgba(0, 0, 0, 0.6);
            border: none;
            color: var(--cyan-primary);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .video-controls button:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: scale(1.1);
        }
        /* Modal for Gallery */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            padding: 0;
        }
        .modal-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            position: relative;
        }
        .modal-video {
            max-width: 90%;
            max-height: 80vh;
            border: 2px solid var(--cyan-primary);
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.5);
        }
        .close-modal {
            position: absolute;
            top: 20px;
            right: 30px;
            color: var(--cyan-primary);
            font-size: 2rem;
            cursor: pointer;
            transition: var(--transition);
            z-index: 2010;
        }
        .close-modal:hover {
            transform: rotate(90deg);
            color: white;
        }
        .modal-nav {
            display: flex;
            justify-content: space-between;
            width: 90%;
            padding: 1rem 0;
            position: absolute;
            bottom: 10%;
        }
        .modal-nav button {
            background: rgba(0, 0, 0, 0.6);
            border: none;
            color: var(--cyan-primary);
            font-size: 2rem;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .modal-nav button:hover {
            color: white;
            transform: scale(1.2);
            background: rgba(0, 0, 0, 0.8);
        }
        .modal-controls {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .modal-controls button {
            background: rgba(0, 0, 0, 0.6);
            border: none;
            color: var(--cyan-primary);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
        }
        .modal-controls button:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: scale(1.1);
        }
        /* Responsive */
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: 1fr;
                height: auto;
            }
            .gallery-item {
                height: 400px;
                margin-bottom: 20px;
            }
        }
        /* CONTACT SECTION */
        #contact .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 90%;
            margin: 0 auto;
        }
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .contact-info h3 {
            font-family: 'Orbitron', sans-serif;
            color: var(--cyan-primary);
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }
        .contact-method {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .contact-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(0, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--cyan-dark);
            color: var(--cyan-primary);
            font-size: 1.2rem;
            transition: var(--transition);
        }
        .contact-method:hover .contact-icon {
            background: rgba(0, 255, 255, 0.2);
            border-color: var(--cyan-primary);
            transform: scale(1.1);
        }
        .contact-text {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.1rem;
        }
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        .social-link {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(0, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--cyan-dark);
            color: var(--cyan-primary);
            font-size: 1.5rem;
            text-decoration: none;
            transition: var(--transition);
        }
        .social-link:hover {
            background: rgba(0, 255, 255, 0.2);
            border-color: var(--cyan-primary);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 255, 255, 0.3);
        }
        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            width: 100%;
            max-width: 600px;
            margin-top: 2rem;
        }
        .form-group {
            position: relative;
        }
        .form-input {
            width: 100%;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid var(--cyan-dark);
            border-radius: 5px;
            color: white;
            font-family: 'Montserrat', sans-serif;
            transition: var(--transition);
        }
        .form-input:focus {
            outline: none;
            border-color: var(--cyan-primary);
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
        }
        textarea.form-input {
            min-height: 150px;
            resize: vertical;
        }
        .submit-btn {
            padding: 1rem;
            background: transparent;
            color: var(--cyan-primary);
            border: 2px solid var(--cyan-primary);
            border-radius: 5px;
            font-family: 'Orbitron', sans-serif;
            font-size: 1.1rem;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .submit-btn::before {
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
        .submit-btn:hover::before {
            width: 100%;
        }
        .submit-btn:hover {
            color: white;
            text-shadow: 0 0 5px var(--cyan-primary);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }
        .location-map {
            width: 100%;
            height: 300px;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid var(--cyan-primary);
            margin-top: 2rem;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }
        /* FOOTER continued */
        footer {
            background: rgba(0, 0, 0, 0.8);
            border-top: 1px solid rgba(0, 255, 255, 0.2);
            padding: 3rem 0 1rem;
            position: relative;
            overflow: hidden;
        }
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            padding: 0 2rem;
        }
        .footer-col h4 {
            font-family: 'Orbitron', sans-serif;
            color: var(--cyan-primary);
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        .footer-col h4::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--cyan-primary);
        }
        .footer-col ul {
            list-style: none;
        }
        .footer-col ul li {
            margin-bottom: 0.8rem;
        }
        .footer-col ul li a {
            color: #ddd;
            text-decoration: none;
            transition: var(--transition);
            font-family: 'Rajdhani', sans-serif;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .footer-col ul li a:hover {
            color: var(--cyan-primary);
            transform: translateX(5px);
        }
        .footer-col p {
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }
        .newsletter-form {
            display: flex;
        }
        .newsletter-input {
            padding: 0.8rem;
            border-radius: 5px 0 0 5px;
            border: 1px solid var(--cyan-dark);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            flex-grow: 1;
        }
        .newsletter-btn {
            padding: 0.8rem 1.2rem;
            background: var(--cyan-dark);
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: var(--transition);
        }
        .newsletter-btn:hover {
            background: var(--cyan-primary);
        }
        .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #aaa;
            font-size: 0.9rem;
        }
        .back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.7);
            border: 2px solid var(--cyan-primary);
            color: var(--cyan-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
            opacity: 0;
            visibility: hidden;
            z-index: 100;
        }
        .back-to-top.active {
            opacity: 1;
            visibility: visible;
        }
        .back-to-top:hover {
            background: rgba(0, 255, 255, 0.1);
            transform: translateY(-5px);
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
        }
        #achievements {
            padding: 60px 20px;
            background-color: var(--dark-bg);
            color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
        }
        .achievements-tab {
            max-width: 90%;
            margin: auto;
            text-align: center;
        }
        .tabs {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin: 30px 0;
        }
        .tab-btn {
            background: #111;
            color: #00f0ff;
            border: 2px solid #00f0ff;
            padding: 10px 20px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s ease;
        }
        .tab-btn:hover,
        .tab-btn.active {
            background: #00f0ff;
            color: #111;
            transform: scale(1.05);
        }
        .tab-content {
            margin-top: 30px;
            text-align: left;
            padding: 20px;
            background: rgba(0, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.1);
        }
        .tab-pane {
            display: none;
            animation: fadeIn 0.6s ease;
        }
        .tab-pane.active {
            display: block;
        }
        .tab-pane h4 {
            font-size: 24px;
            color: #00f0ff;
            margin-bottom: 15px;
            animation: slideUp 0.5s ease;
        }
        .tab-pane p {
            font-size: 16px;
            line-height: 1.7;
            color: #ccc;
        }
        .more-achievements-btn {
            display: inline-block;
            margin-top: 2rem;
            padding: 1rem 2rem;
            background: transparent;
            color: var(--cyan-primary);
            border: 2px solid var(--cyan-primary);
            border-radius: 5px;
            font-family: 'Orbitron', sans-serif;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .more-achievements-btn::before {
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
        .more-achievements-btn:hover::before {
            width: 100%;
        }
        .more-achievements-btn:hover {
            color: white;
            text-shadow: 0 0 5px var(--cyan-primary);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }
        .more-projects-btn {
            display: inline-block;
            margin-top: 2rem;
            padding: 1rem 2rem;
            background: transparent;
            color: var(--cyan-primary);
            border: 2px solid var(--cyan-primary);
            border-radius: 5px;
            font-family: 'Orbitron', sans-serif;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .more-projects-btn::before {
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
        .more-projects-btn:hover::before {
            width: 100%;
        }
        .more-projects-btn:hover {
            color: white;
            text-shadow: 0 0 5px var(--cyan-primary);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }
        /* ANIMATIONS */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes slideUp {
            from {transform: translateY(30px); opacity: 0;}
            to {transform: translateY(0); opacity: 1;}
        }
        @keyframes textGlow {
            0% {
                text-shadow: 0 0 5px var(--cyan-primary);
            }
            50% {
                text-shadow: 0 0 15px var(--cyan-primary), 0 0 30px var(--cyan-light);
            }
            100% {
                text-shadow: 0 0 5px var(--cyan-primary);
            }
        }
        @keyframes heroTitleAnim {
            0% {
                text-shadow: 0 0 10px var(--cyan-primary), 0 0 20px var(--cyan-primary);
            }
            50% {
                text-shadow: 0 0 15px var(--cyan-primary), 0 0 30px var(--cyan-light), 0 0 50px var(--cyan-light);
            }
            100% {
                text-shadow: 0 0 10px var(--cyan-primary), 0 0 20px var(--cyan-primary);
            }
        }
        @keyframes pulseLogo {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 255, 255, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(0, 255, 255, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(0, 255, 255, 0);
            }
        }
        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0) translateX(-50%);
            }
            40% {
                transform: translateY(-20px) translateX(-50%);
            }
            60% {
                transform: translateY(-10px) translateX(-50%);
            }
        }
        @keyframes slowZoom {
            from {
                transform: scale(1);
            }
            to {
                transform: scale(1.1);
            }
        }
        /* MEDIA QUERIES */
        @media (max-width: 1024px) {
            section {
                padding: 4rem 2rem;
            }
            .hero-title {
                font-size: 3rem;
            }
            .hero-subtitle {
                font-size: 1.5rem;
            }
            #about .container,
            #contact .container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .navbar-container {
                position: relative;
            }
            .hamburger {
                display: block;
            }
            .nav-links {
                position: absolute;
                top: 100%;
                right: 0;
                flex-direction: column;
                background: rgba(0, 0, 0, 0.9);
                width: 250px;
                padding: 1.5rem;
                border-radius: 0 0 10px 10px;
                transform: translateY(-200%);
                opacity: 0;
                visibility: hidden;
                transition: var(--transition);
                border: 1px solid var(--cyan-primary);
                z-index: 100;
            }
            .nav-links.active {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }
            .nav-links li {
                margin: 0.8rem 0;
            }
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.3rem;
            }
            .section-title {
                font-size: 2rem;
            }
            .events-timeline::before {
                left: 40px;
            }
            .timeline-item {
                width: calc(100% - 80px);
                margin-left: 80px;
            }
            .timeline-item::after {
                left: -50px;
            }
            .left, .right {
                left: 0;
            }
        }
        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }
            .hero-subtitle {
                font-size: 1.1rem;
            }
            .btn {
                padding: 0.8rem 1.5rem;
                font-size: 1rem;
            }
            .section-title {
                font-size: 1.8rem;
            }
            .footer-container {
                grid-template-columns: 1fr;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
        .location-map iframe {
            width: 100%;
            height: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="#home" class="logo">
                <div class="logo-icon"> <img src="images/logo.png" alt="Logo"></div>
                <span class="logo-text">SARS </span>
            </a>
            <button class="hamburger" id="navToggle">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="nav-links" id="navLinks">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="register.php">Events</a></li>
                <li><a href="#team">Team</a></li>
                <li><a href="#gallery">Gallery</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section id="home">
        <div class="hero-particles"></div>
        <div class="container hero-container">
            <h1 class="hero-title" id="title1"></h1>
            <h1 class="hero-title" id="title2"></h1>
            <h2 class="hero-subtitle" id="subtitle"></h2>
            <div class="hero-btns">
                <a href="#projects" class="btn">Explore Projects</a>
            </div>
        </div>
        <a href="#about" class="scroll-indicator">
            <i class="fas fa-chevron-down"></i>
        </a>
    </section>
    
    <!-- About Section -->
    <section id="about">
        <div class="container">
            <div class="about-content cyber-box" id="aboutContent">
                <!-- Dynamic content will be loaded here -->
            </div>
        </div>
    </section>
    
    <section id="achievements">
        <div class="container">
            <div class="achievements-tab cyber-box">
                <h2 class="section-title">Our Achievements</h2>
                <div class="tabs" id="achievementTabs">
                    <!-- Dynamic tabs will be loaded here -->
                </div>
                <div class="tab-content" id="achievementContent">
                    <!-- Dynamic content will be loaded here -->
                </div>
                <div style="text-align: center;">
                    <a href="achievements.php" class="more-achievements-btn">View All Achievements</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Projects Section -->
    <section id="projects">
        <div class="container">
            <h2 class="section-title">Our Projects</h2>
            <p class="section-subtitle">Discover our latest innovations and ongoing research in robotics and automation</p>
            <div class="projects-grid" id="projectsGrid">
                <!-- Dynamic content will be loaded here -->
            </div>
            <div style="text-align: center;">
                <a href="projects.php" class="more-projects-btn">View All Projects</a>
            </div>
        </div>
    </section>
    
    <!-- Events Section -->
    <section id="events">
        <div class="container">
            <h2 class="section-title">Upcoming Events</h2>
            <p class="section-subtitle">Join us at these exciting robotics events and competitions</p>
            <div class="events-timeline" id="eventsTimeline">
                <!-- Dynamic content will be loaded here -->
            </div>
        </div>
    </section>
    
    <!-- Team Section -->
    <section id="team">
        <div class="container">
            <h2 class="section-title">Our Team</h2>
            <p class="section-subtitle">Meet the brilliant minds behind SARS Robotics</p>
            <div class="team-grid" id="teamGrid">
                <!-- Dynamic content will be loaded here -->
            </div>
            <!-- Terminal Component -->
            <div class="terminal-container">
                <div class="terminal-header">
                    <div class="terminal-buttons">
                        <div class="button close"></div>
                        <div class="button minimize"></div>
                        <div class="button maximize"></div>
                    </div>
                    <div class="terminal-title">sars_terminal</div>
                    <div></div>
                </div>
                <div class="terminal-body">
                    <div class="terminal-line">
                        <span class="terminal-prompt">></span>
                        <span class="terminal-text" id="typewriter"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="gallery">
        <div class="container">
            <h2 class="section-title">Gallery</h2>
            <p class="section-subtitle">SARS journey to IIT KGP & IIT BBSR</p>
            <div class="gallery-grid">
                <!-- Video 1 -->
                <div class="gallery-item" data-video="images/vd1.mp4">
                    <video src="images/vd1.mp4" poster="/api/placeholder/400/320" autoplay loop muted playsinline></video>
                    <div class="gallery-overlay">
                        <i class="fas fa-play"></i>
                    </div>
                    <div class="video-controls">
                        <button class="play-btn"><i class="fas fa-pause"></i></button>
                        <button class="mute-btn"><i class="fas fa-volume-mute"></i></button>
                    </div>
                </div>
                <!-- Video 2 -->
                <div class="gallery-item" data-video="images/vd2.mp4">
                    <video src="images/vd2.mp4" poster="/api/placeholder/400/320" autoplay loop muted playsinline></video>
                    <div class="gallery-overlay">
                        <i class="fas fa-play"></i>
                    </div>
                    <div class="video-controls">
                        <button class="play-btn"><i class="fas fa-pause"></i></button>
                        <button class="mute-btn"><i class="fas fa-volume-mute"></i></button>
                    </div>
                </div>
                <!-- Video 3 -->
                <div class="gallery-item" data-video="images/vd3.mp4">
                    <video src="images/vd3.mp4" poster="/api/placeholder/400/320" autoplay loop muted playsinline></video>
                    <div class="gallery-overlay">
                        <i class="fas fa-play"></i>
                    </div>
                    <div class="video-controls">
                        <button class="play-btn"><i class="fas fa-pause"></i></button>
                        <button class="mute-btn"><i class="fas fa-volume-mute"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Modal for Video Gallery -->
    <div class="modal" id="galleryModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <video src="/placeholder.svg" class="modal-video" id="modalVideo" controls></video>
            <div class="modal-controls">
                <button id="playModalBtn"><i class="fas fa-play"></i></button>
                <button id="muteModalBtn"><i class="fas fa-volume-mute"></i></button>
            </div>
            <div class="modal-nav">
                <button id="prevBtn"><i class="fas fa-chevron-left"></i></button>
                <button id="nextBtn"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>
    
    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <div class="contact-info cyber-box">
                <h2 class="section-title">Get In Touch</h2>
                <div class="contact-method">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-text">
                        GIET Gunupur, At – Gobriguda, <br> Po- Kharling, <br> Gunupur, Odisha 765022
                    </div>
                </div>
                <div class="contact-method">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-text">
                        sars@giet.edu
                    </div>
                </div>
                
                <!-- Contact Form -->
                <form class="contact-form" id="contactForm">
                    <div class="form-group">
                        <input type="text" class="form-input" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-input" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" name="subject" placeholder="Subject" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-input" name="message" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Send Message</button>
                </form>
                
                <h3>Follow Us</h3>
                <div class="social-links">
                    <a href="https://www.instagram.com/sars_gietu?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/in/student-association-of-robotics-science-906008323/" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="location-map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3771.3684434530587!2d83.83078417555855!3d19.0475316226725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a3c96658f8652ad%3A0x7dafcb1b8586f019!2sGIET%20University!5e0!3m2!1sen!2sin!4v1745176801369!5m2!1sen!2sin"
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-col">
                <h4>SARS</h4>
                <p>Pioneering the future of robotics technology with innovative solutions and collaborative research.</p>
                <div class="social-links">
                    <a href="https://www.linkedin.com/in/student-association-of-robotics-science-906008323/" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/sars_gietu?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="social-link"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#home"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="#about"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="#projects"><i class="fas fa-chevron-right"></i> Projects</a></li>
                    <li><a href="#events"><i class="fas fa-chevron-right"></i> Events</a></li>
                    <li><a href="#contact"><i class="fas fa-chevron-right"></i> Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="#contact"><i class="fas fa-chevron-right"></i> Robotics Design</a></li>
                    <li><a href="#contact"><i class="fas fa-chevron-right"></i> AI Development</a></li>
                    <li><a href="#contact"><i class="fas fa-chevron-right"></i> Workshops</a></li>
                    <li><a href="#contact"><i class="fas fa-chevron-right"></i> Consulting</a></li>
                    <li><a href="#contact"><i class="fas fa-chevron-right"></i> Educational Programs</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Newsletter</h4>
                <p>Subscribe to our newsletter for updates on events, projects, and robotics news.</p>
                <form class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="Your Email" required>
                    <button type="submit" class="newsletter-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="copyright">
            &copy; 2025 SARS. All Rights Reserved. Designed with <i class="fas fa-heart" style="color: var(--cyan-primary);"></i> by ASHISH CHOUDHURY 22CSE221
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>
    
    <!-- JavaScript -->
    <script>
        // Load dynamic content when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadAboutContent();
            loadAchievements();
            loadProjects();
            loadEvents();
            loadTeam();
            loadTerminalMessages();
            
            // Initialize existing functionality
            initializeNavigation();
            initializeGallery();
            initializeAnimations();
            initializeContactForm();
        });
        
        // Load About Us content
        async function loadAboutContent() {
            try {
                const response = await fetch('api/get_about.php');
                const about = await response.json();
                
                const aboutContent = document.getElementById('aboutContent');
                aboutContent.innerHTML = `
                    <h2 class="section-title">${about.title}</h2>
                    <h3>${about.subtitle}</h3>
                    <p>${about.description.replace(/\n/g, '</p><p>')}</p>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-number">30+</div>
                            <div class="stat-text">Team Members</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">10</div>
                            <div class="stat-text">Projects</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-text">BEST CLUB AWARD 2022 <br> GIET UNIVERSITY</div>
                        </div>
                    </div>
                `;
            } catch (error) {
                console.error('Error loading about content:', error);
            }
        }
        
        // Load Achievements
        async function loadAchievements() {
            try {
                const response = await fetch('api/get_achievements.php?featured=true');
                const achievements = await response.json();
                
                const tabsContainer = document.getElementById('achievementTabs');
                const contentContainer = document.getElementById('achievementContent');
                
                let tabsHTML = '';
                let contentHTML = '';
                
                achievements.forEach((achievement, index) => {
                    const isActive = index === 0 ? 'active' : '';
                    const tabId = `tab${index + 1}`;
                    
                    tabsHTML += `<button class="tab-btn ${isActive}" data-tab="${tabId}">${achievement.tab_name}</button>`;
                    
                    contentHTML += `
                        <div id="${tabId}" class="tab-pane ${isActive}">
                            <h4>${achievement.title}</h4>
                            <p>${achievement.description}</p>
                        </div>
                    `;
                });
                
                tabsContainer.innerHTML = tabsHTML;
                contentContainer.innerHTML = contentHTML;
                
                // Initialize tab functionality
                initializeTabs();
                
            } catch (error) {
                console.error('Error loading achievements:', error);
            }
        }
        
        // Load Projects
        async function loadProjects() {
            try {
                const response = await fetch('api/get_projects.php?featured=true');
                const projects = await response.json();
                
                const projectsGrid = document.getElementById('projectsGrid');
                let projectsHTML = '';
                
                projects.forEach(project => {
                    projectsHTML += `
                        <div class="project-card">
                            <div class="project-image">
                                <img src="${project.image_path}" alt="${project.title}">
                            </div>
                            <div class="project-content">
                                <h3 class="project-title">${project.title}</h3>
                                <p class="project-desc">${project.description}</p>
                            </div>
                        </div>
                    `;
                });
                
                projectsGrid.innerHTML = projectsHTML;
                
            } catch (error) {
                console.error('Error loading projects:', error);
            }
        }
        
        // Load Events
        async function loadEvents() {
            try {
                const response = await fetch('api/get_events.php');
                const events = await response.json();
                
                const eventsTimeline = document.getElementById('eventsTimeline');
                let eventsHTML = '';
                
                events.forEach((event, index) => {
                    const position = index % 2 === 0 ? 'right' : 'left';
                    const statusClass = event.status === 'completed' ? 'done' : '';
                    const statusText = event.status === 'completed' ? 'Completed' : 'Coming Soon';
                    const buttonText = event.status === 'completed' ? 'Done' : 'Register';
                    
                    eventsHTML += `
                        <div class="timeline-item ${position}">
                            <span class="event-status">${statusText}</span>
                            <h3 class="event-title">${event.title}</h3>
                            <p class="event-desc">${event.description}</p>
                            <a href="${event.registration_link || '#'}" class="event-btn ${statusClass}">${buttonText}</a>
                        </div>
                    `;
                });
                
                eventsTimeline.innerHTML = eventsHTML;
                
            } catch (error) {
                console.error('Error loading events:', error);
            }
        }
        
        // Load Team
        async function loadTeam() {
            try {
                const response = await fetch('api/get_team.php');
                const team = await response.json();
                
                const teamGrid = document.getElementById('teamGrid');
                let teamHTML = '';
                
                team.forEach(member => {
                    teamHTML += `
                        <div class="team-member">
                            <div class="member-image">
                                <img src="${member.image_path}" alt="${member.name}">
                            </div>
                            <div class="member-details">
                                <h3 class="member-name">${member.name}</h3>
                                <p class="member-role">${member.role}</p>
                                <div class="member-social">
                                    ${member.linkedin_url ? `<a href="${member.linkedin_url}"><i class="fab fa-linkedin"></i></a>` : '<a href="#"><i class="fab fa-linkedin"></i></a>'}
                                </div>
                            </div>
                            <div class="member-bio">
                                <p>${member.bio ? member.bio.replace(/\n/g, '<br>') : ''}</p>
                            </div>
                        </div>
                    `;
                });
                
                teamGrid.innerHTML = teamHTML;
                
            } catch (error) {
                console.error('Error loading team:', error);
            }
        }
        
        // Load Terminal Messages
        async function loadTerminalMessages() {
            try {
                const response = await fetch('api/get_terminal_messages.php');
                const messages = await response.json();
                
                if (messages.length > 0) {
                    const messageTexts = messages.map(msg => msg.message);
                    startTypewriter(messageTexts);
                }
                
            } catch (error) {
                console.error('Error loading terminal messages:', error);
            }
        }
        
        // Initialize tabs functionality
        function initializeTabs() {
            const tabButtons = document.querySelectorAll(".tab-btn");
            const tabPanes = document.querySelectorAll(".tab-pane");
            
            tabButtons.forEach(button => {
                button.addEventListener("click", () => {
                    const tabId = button.getAttribute("data-tab");
                    tabButtons.forEach(btn => btn.classList.remove("active"));
                    button.classList.add("active");
                    tabPanes.forEach(pane => {
                        pane.classList.remove("active");
                        if (pane.id === tabId) {
                            pane.classList.add("active");
                        }
                    });
                });
            });
        }
        
        // Typewriter effect for terminal
        function startTypewriter(messages) {
            function typeWriter(text, elementId, speed = 100, delay = 2000) {
                const element = document.getElementById(elementId);
                if (!element) return;
                
                let i = 0;
                element.textContent = '';
                
                function type() {
                    if (i < text.length) {
                        element.textContent += text.charAt(i);
                        i++;
                        setTimeout(type, speed);
                    } else {
                        setTimeout(() => {
                            element.parentElement.classList.add('hide-cursor');
                            const nextIndex = (messages.indexOf(text) + 1) % messages.length;
                            setTimeout(() => {
                                element.parentElement.classList.remove('hide-cursor');
                                typeWriter(messages[nextIndex], elementId, speed, delay);
                            }, 500);
                        }, delay);
                    }
                }
                
                type();
            }
            
            if (messages.length > 0) {
                typeWriter(messages[0], "typewriter", 70, 3000);
            }
        }
        
        // Initialize contact form
        function initializeContactForm() {
            const contactForm = document.getElementById('contactForm');
            
            contactForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(contactForm);
                
                try {
                    const response = await fetch('api/submit_contact.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        alert('Message sent successfully!');
                        contactForm.reset();
                    } else {
                        alert('Error sending message. Please try again.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error sending message. Please try again.');
                }
            });
        }
        
        // Initialize navigation
        function initializeNavigation() {
            const navToggle = document.getElementById('navToggle');
            const navLinks = document.getElementById('navLinks');
            
            navToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });
            
            document.querySelectorAll('.nav-links a').forEach(link => {
                link.addEventListener('click', () => {
                    navLinks.classList.remove('active');
                });
            });
            
            // Back to Top Button
            const backToTopBtn = document.getElementById('backToTop');
            
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTopBtn.classList.add('active');
                } else {
                    backToTopBtn.classList.remove('active');
                }
            });
            
            backToTopBtn.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
        
        // Initialize gallery functionality
        function initializeGallery() {
            const modal = document.getElementById('galleryModal');
            const modalVideo = document.getElementById('modalVideo');
            const closeModal = document.querySelector('.close-modal');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const galleryItems = document.querySelectorAll('.gallery-item');
            const playModalBtn = document.getElementById('playModalBtn');
            const muteModalBtn = document.getElementById('muteModalBtn');
            
            let currentIndex = 0;
            let videos = [];
            
            // Setup videos and click events
            galleryItems.forEach((item, index) => {
                const video = item.querySelector('video');
                const playBtn = item.querySelector('.play-btn');
                const muteBtn = item.querySelector('.mute-btn');
                
                videos.push(video);
                
                // Set all videos to autoplay immediately
                video.play().catch(e => {
                    console.log("Autoplay prevented by browser:", e);
                    video.muted = true;
                    video.play().catch(e => console.log("Still can't play:", e));
                });
                
                // Update button icons to match initial state
                playBtn.innerHTML = '<i class="fas fa-pause"></i>';
                muteBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
                
                // Preview play/pause
                playBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (video.paused) {
                        video.play();
                        playBtn.innerHTML = '<i class="fas fa-pause"></i>';
                    } else {
                        video.pause();
                        playBtn.innerHTML = '<i class="fas fa-play"></i>';
                    }
                });
                
                // Preview mute/unmute
                muteBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    video.muted = !video.muted;
                    muteBtn.innerHTML = video.muted ?
                        '<i class="fas fa-volume-mute"></i>' :
                        '<i class="fas fa-volume-up"></i>';
                });
                
                // Open modal
                item.addEventListener('click', () => {
                    currentIndex = index;
                    const videoSrc = item.getAttribute('data-video');
                    modalVideo.src = videoSrc;
                    modalVideo.play();
                    modal.style.display = 'block';
                    playModalBtn.innerHTML = '<i class="fas fa-pause"></i>';
                });
                
                // When video ends, show replay icon and loop it
                video.addEventListener('ended', function() {
                    if (!video.loop) {
                        playBtn.innerHTML = '<i class="fas fa-redo"></i>';
                    }
                });
            });
            
            // Modal play/pause
            playModalBtn.addEventListener('click', () => {
                if (modalVideo.paused) {
                    modalVideo.play();
                    playModalBtn.innerHTML = '<i class="fas fa-pause"></i>';
                } else {
                    modalVideo.pause();
                    playModalBtn.innerHTML = '<i class="fas fa-play"></i>';
                }
            });
            
            // Modal mute/unmute
            muteModalBtn.addEventListener('click', () => {
                modalVideo.muted = !modalVideo.muted;
                muteModalBtn.innerHTML = modalVideo.muted ?
                    '<i class="fas fa-volume-mute"></i>' :
                    '<i class="fas fa-volume-up"></i>';
            });
            
            // Close modal
            closeModal.addEventListener('click', () => {
                modalVideo.pause();
                modal.style.display = 'none';
            });
            
            // Click outside to close
            window.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modalVideo.pause();
                    modal.style.display = 'none';
                }
            });
            
            // Gallery Navigation
            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
                modalVideo.src = galleryItems[currentIndex].getAttribute('data-video');
                modalVideo.play();
                playModalBtn.innerHTML = '<i class="fas fa-pause"></i>';
            });
            
            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % galleryItems.length;
                modalVideo.src = galleryItems[currentIndex].getAttribute('data-video');
                modalVideo.play();
                playModalBtn.innerHTML = '<i class="fas fa-pause"></i>';
            });
            
            // Enable keyboard navigation for gallery
            document.addEventListener('keydown', (e) => {
                if (modal.style.display === 'block') {
                    if (e.key === 'ArrowLeft') {
                        currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
                        modalVideo.src = galleryItems[currentIndex].getAttribute('data-video');
                        modalVideo.play();
                    } else if (e.key === 'ArrowRight') {
                        currentIndex = (currentIndex + 1) % galleryItems.length;
                        modalVideo.src = galleryItems[currentIndex].getAttribute('data-video');
                        modalVideo.play();
                    } else if (e.key === 'Escape') {
                        modalVideo.pause();
                        modal.style.display = 'none';
                    } else if (e.key === ' ') {
                        // Space to play/pause
                        if (modalVideo.paused) {
                            modalVideo.play();
                            playModalBtn.innerHTML = '<i class="fas fa-pause"></i>';
                        } else {
                            modalVideo.pause();
                            playModalBtn.innerHTML = '<i class="fas fa-play"></i>';
                        }
                        e.preventDefault(); // Prevent page scrolling on space
                    }
                }
            });
            
            // Ensure all videos autoplay on page load
            window.addEventListener('load', () => {
                videos.forEach((video, index) => {
                    video.play().catch(e => {
                        console.log(`Video ${index} autoplay prevented:`, e);
                    });
                });
            });
            
            // When modal video ends, show replay icon
            modalVideo.addEventListener('ended', function() {
                playModalBtn.innerHTML = '<i class="fas fa-redo"></i>';
            });
        }
        
        // Initialize animations
        function initializeAnimations() {
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (this.getAttribute('href') === '#') return;
                    
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Newsletter form
            const newsletterForm = document.querySelector('.newsletter-form');
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    
                    const emailInput = newsletterForm.querySelector('.newsletter-input');
                    const submitBtn = newsletterForm.querySelector('.newsletter-btn');
                    
                    if (emailInput.value.trim()) {
                        // Success state
                        submitBtn.innerHTML = '<i class="fas fa-check"></i>';
                        submitBtn.style.backgroundColor = '#00dd99';
                        
                        // Reset form
                        newsletterForm.reset();
                        
                        // Reset button after delay
                        setTimeout(() => {
                            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
                            submitBtn.style.backgroundColor = '';
                        }, 3000);
                    }
                });
            }
            
            // Animated stats counter
            const stats = document.querySelectorAll('.stat-number');
            let statsAnimated = false;
            
            function animateStats() {
                if (statsAnimated) return;
                
                stats.forEach(stat => {
                    const target = parseInt(stat.textContent);
                    let count = 0;
                    const duration = 2000; // ms
                    const increment = Math.ceil(target / (duration / 16)); // 60fps
                    
                    const timer = setInterval(() => {
                        count += increment;
                        if (count >= target) {
                            stat.textContent = target + (stat.textContent.includes('+') ? '+' : '');
                            clearInterval(timer);
                        } else {
                            stat.textContent = count;
                        }
                    }, 16);
                });
                
                statsAnimated = true;
            }
            
            // Trigger stats animation when in view
            const aboutSection = document.getElementById('about');
            if (aboutSection) {
                window.addEventListener('scroll', () => {
                    const rect = aboutSection.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom > 0) {
                        animateStats();
                    }
                });
            }
            
            // Add animation classes when elements come into view
            function animateOnScroll() {
                const elements = document.querySelectorAll('.project-card, .team-member, .gallery-item, .timeline-item');
                
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight;
                    
                    if (elementPosition < screenPosition - 100) {
                        element.classList.add('animate-in');
                    }
                });
            }
            
            window.addEventListener('scroll', animateOnScroll);
            window.addEventListener('load', animateOnScroll);
            
            // Hero title animation
            const title1 = document.getElementById('title1');
            const title2 = document.getElementById('title2');
            const subtitle = document.getElementById('subtitle');
            
            const title1Text = "STUDENT ASSOCIATION OF ROBOTICS AND SCIENCE";
            const title2Text = "innovation through robotics";
            const subtitleText = "Building the future one circuit at a time";
            
            // Function to animate typewriter effect
            function typeWriter(element, text, callback) {
                element.classList.remove('deleting');
                element.classList.add('typing');
                let i = 0;
                const typingSpeed = 50; // Adjust typing speed (milliseconds)
                
                function type() {
                    if (i < text.length) {
                        element.textContent += text.charAt(i);
                        i++;
                        setTimeout(type, typingSpeed);
                    } else {
                        element.classList.remove('typing');
                        element.classList.add('finished');
                        if (callback) setTimeout(callback, 1500); // Pause after typing
                    }
                }
                
                element.textContent = '';
                type();
            }
            
            // Function to animate deleting effect
            function deleteText(element, callback) {
                element.classList.remove('finished');
                element.classList.add('deleting');
                let text = element.textContent;
                let i = text.length;
                const deletingSpeed = 30; // Adjust deleting speed (milliseconds)
                
                function erase() {
                    if (i > 0) {
                        element.textContent = text.substring(0, i-1);
                        i--;
                        setTimeout(erase, deletingSpeed);
                    } else {
                        element.classList.remove('deleting');
                        element.textContent = '';
                        element.style.visibility = 'hidden';
                        if (callback) setTimeout(callback, 500); // Pause after deleting
                    }
                }
                
                erase();
            }
            
            // Function to run the animation sequence in a loop
            function animationLoop() {
                // Make elements visible for animation
                title1.style.visibility = 'visible';
                title2.style.visibility = 'visible';
                subtitle.style.visibility = 'visible';
                
                // Sequence: Type title1 -> Type title2 -> Type subtitle ->
                // Wait -> Delete subtitle -> Delete title2 -> Delete title1 -> Repeat
                typeWriter(title1, title1Text, () => {
                    typeWriter(title2, title2Text, () => {
                        typeWriter(subtitle, subtitleText, () => {
                            setTimeout(() => {
                                deleteText(subtitle, () => {
                                    deleteText(title2, () => {
                                        deleteText(title1, () => {
                                            // Restart the loop
                                            setTimeout(animationLoop, 1000);
                                        });
                                    });
                                });
                            }, 3000); // Pause before starting to delete
                        });
                    });
                });
            }
            
            // Start the animation loop
            setTimeout(animationLoop, 500);
        }
    </script>
</body>
</html>
