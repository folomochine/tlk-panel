<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        /* --- Basic Setup --- */
body, html {
    height: 100%;
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background-color: #00041a;
    color: #fff;
    overflow: hidden; /* Prevents scrollbars from appearing */
}

/* --- Starry Background Animation --- */
.smmpanelbdlab-stars {
    background: #000 url(https://www.transparenttextures.com/patterns/stardust.png) repeat top center;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    display: block;
    z-index: 0;
}

.smmpanelbdlab-twinkling {
    background: transparent url(https://www.transparenttextures.com/patterns/gplay.png) repeat top center;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    display: block;
    z-index: 1;
    animation: smmpanelbdlab-move-twink-back 200s linear infinite;
}

@keyframes smmpanelbdlab-move-twink-back {
    from { background-position: 0 0; }
    to { background-position: -10000px 5000px; }
}


/* --- Main Content Container --- */
.smmpanelbdlab-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    text-align: center;
    position: relative;
    z-index: 2;
    padding: 20px;
}

.smmpanelbdlab-content-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap; /* For responsiveness on smaller screens */
}

/* --- Astronaut Image & Animation --- */
.smmpanelbdlab-astronaut-img {
    width: 200px;
    margin-right: 40px;
    animation: smmpanelbdlab-float 6s ease-in-out infinite;
}

@keyframes smmpanelbdlab-float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-30px); }
    100% { transform: translateY(0px); }
}


/* --- Text Content Styling --- */
.smmpanelbdlab-text-content {
    max-width: 500px;
}

.smmpanelbdlab-title {
    font-family: 'Orbitron', sans-serif;
    font-size: 8rem;
    font-weight: 700;
    margin: 0;
    position: relative;
    color: #fff;
    text-shadow: 0 0 10px #00bfff, 0 0 20px #00bfff, 0 0 40px #00bfff;
    animation: smmpanelbdlab-glitch 1s linear infinite;
}

/* --- Glitch Effect on 404 Title --- */
@keyframes smmpanelbdlab-glitch {
    2%, 64% { transform: translate(2px, 0) skew(0deg); }
    4%, 60% { transform: translate(-2px, 0) skew(0deg); }
    62% { transform: translate(0, 0) skew(5deg); }
}

.smmpanelbdlab-title:before,
.smmpanelbdlab-title:after {
    content: attr(data-text);
    position: absolute;
    left: 0;
    width: 100%;
    height: 100%;
    top: 0;
    background: #00041a;
    overflow: hidden;
}

.smmpanelbdlab-title:before {
    left: 2px;
    text-shadow: -2px 0 #ff00c1;
    animation: smmpanelbdlab-glitch-top 1s linear infinite reverse;
}

@keyframes smmpanelbdlab-glitch-top {
    2%, 64% { transform: translate(2px, -2px); }
    4%, 60% { transform: translate(-2px, 2px); }
    62% { transform: translate(13px, -1px) skew(-13deg); }
}

.smmpanelbdlab-title:after {
    left: -2px;
    text-shadow: -2px 0 #00fff9, 2px 2px #ff00c1;
    animation: smmpanelbdlab-glitch-bottom 1.5s linear infinite reverse;
}

@keyframes smmpanelbdlab-glitch-bottom {
    2%, 64% { transform: translate(-2px, 0); }
    4%, 60% { transform: translate(2px, 0); }
    62% { transform: translate(-22px, 5px) skew(21deg); }
}


/* --- Subtitle and Description --- */
.smmpanelbdlab-subtitle {
    font-family: 'Orbitron', sans-serif;
    font-size: 2rem;
    margin: 0;
    color: #cceeff;
}

.smmpanelbdlab-description {
    font-size: 1rem;
    color: #aaa;
    margin-top: 10px;
    margin-bottom: 30px;
}


/* --- Homepage Button Styling --- */
.smmpanelbdlab-home-button {
    display: inline-block;
    padding: 12px 25px;
    border: 2px solid #00bfff;
    border-radius: 50px;
    color: #00bfff;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 0 10px #00bfff;
}

.smmpanelbdlab-home-button:hover {
    background-color: #00bfff;
    color: #00041a;
    box-shadow: 0 0 20px #00bfff, 0 0 30px #00bfff;
}


/* --- Responsive Design --- */
@media (max-width: 768px) {
    .smmpanelbdlab-content-wrapper {
        flex-direction: column;
    }
    .smmpanelbdlab-astronaut-img {
        width: 150px;
        margin-right: 0;
        margin-bottom: 20px;
    }
    .smmpanelbdlab-title {
        font-size: 6rem;
    }
    .smmpanelbdlab-subtitle {
        font-size: 1.5rem;
    }
}
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto:wght@300;400&display=swap" rel="stylesheet">
</head>
<body>
    <div class="smmpanelbdlab-stars"></div>
    <div class="smmpanelbdlab-twinkling"></div>

    <div class="smmpanelbdlab-container">
        <div class="smmpanelbdlab-content-wrapper">
          <!----  <img src="https://i.ibb.co/T1gBFPd/astronaut.png" alt="Lost Astronaut" class="smmpanelbdlab-astronaut-img">  --->
            <div class="smmpanelbdlab-text-content">
                <h1 class="smmpanelbdlab-title" data-text="404">404</h1>
                <p class="smmpanelbdlab-subtitle">Oops! You're Lost in Space.</p>
                <p class="smmpanelbdlab-description">The page you are looking for might have been removed or is temporarily unavailable.</p>
                <a href="/" class="smmpanelbdlab-home-button">GO TO HOMEPAGE</a>
            </div>
        </div>
    </div>
</body>
</html>