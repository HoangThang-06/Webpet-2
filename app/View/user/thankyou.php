<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>PetRescueHub - Cảm ơn bạn!</title>
<link rel="icon" type="image/png" href="../../../public/icon/pawprint.png"> 
<style>
    body {
        margin: 0;
        padding: 0;
        background: #E8F8EF;
        font-family: 'Poppins', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        overflow: hidden;
    }

    .bubble {
        position: absolute;
        bottom: -150px;
        background: rgba(46, 204, 113, 0.3);
        border-radius: 50%;
        animation: floatUp 7s infinite ease-in;
    }

    @keyframes floatUp {
        0% { transform: translateY(0) scale(1); opacity: 1;}
        100% { transform: translateY(-900px) scale(1.4); opacity: 0;}
    }

    .thank-box {
        background: white;
        width: 450px;
        padding: 40px;
        border-radius: 25px;
        text-align: center;
        box-shadow: 0 10px 35px rgba(0,0,0,0.15);
        position: relative;
        z-index: 10;
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Tick SVG to hơn */
    .checkmark {
        width: 150px;
        height: 150px;
        margin: 0 auto 20px;
        display: block;
        overflow: visible;
        animation: rotateCircle 1.5s ease-in-out;
    }

    @keyframes rotateCircle {
        0%   { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Vẽ vòng tròn */
    .check-circle {
        stroke: #2ecc71;
        stroke-width: 4;
        fill: none;
        stroke-dasharray: 200;
        stroke-dashoffset: 200;
        animation: drawCircle 1.5s forwards ease-out;
    }

    @keyframes drawCircle {
        to { stroke-dashoffset: 0; }
    }

    /* Vẽ dấu tick */
    .check-line {
        stroke: #2ecc71;
        stroke-width: 4;
        fill: none;
        stroke-dasharray: 60;
        stroke-dashoffset: 60;
        animation: drawCheck 0.8s 1.2s forwards ease-out;
    }

    @keyframes drawCheck {
        to { stroke-dashoffset: 0; }
    }

    h2 {
        color: #2ecc71;
        font-size: 28px;
        margin-bottom: 10px;
    }

    p {
        color: #555;
        font-size: 16px;
        line-height: 1.4;
    }

    .button {
        margin-top: 20px;
        display: inline-block;
        padding: 12px 25px;
        background: #2ecc71;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: bold;
        transition: 0.3s;
    }

    .button:hover {
        background: #27ae60;
        transform: scale(1.05);
    }
</style>
</head>

<body>

<script>
    for (let i = 0; i < 25; i++) {
        let bubble = document.createElement("div");
        bubble.className = "bubble";
        bubble.style.left = Math.random() * 100 + "vw";
        let size = 20 + Math.random() * 40;
        bubble.style.width = bubble.style.height = size + "px";
        bubble.style.animationDuration = (5 + Math.random() * 5) + "s";
        document.body.appendChild(bubble);
    }
</script>

<div class="thank-box">

    <!-- SVG to, không bị cắt hình -->
    <svg class="checkmark" viewBox="0 0 60 60">
        <circle class="check-circle" cx="30" cy="30" r="26"></circle>
        <path class="check-line" d="M18 30l9 9 17-18"></path>
    </svg>

    <h2>PetRescueHub xin cảm ơn!</h2>
    <p>
        Sự ủng hộ của bạn sẽ giúp các bé thú cưng<br>
        có cơ hội được chăm sóc và cứu trợ tốt hơn.<br><br>
        Chúng tôi sẽ kiểm tra biên lai và xác nhận sớm nhất.
    </p>

    <a href="index.php" class="button">Quay về trang chủ</a>
</div>
</body>
</html>
