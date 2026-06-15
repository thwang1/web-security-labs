<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: /labs/php/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json; charset=UTF-8");

    $input = json_decode(file_get_contents("php://input"), true);
    $otp = $input["otp"] ?? "";

    if ($otp !== ($_SESSION["pending_otp"] ?? "")) {
        http_response_code(401);
        echo json_encode(["status" => "failed"]);
        exit;
    }

    $_SESSION["mfa_verified"] = true;
    unset($_SESSION["pending_otp"]);

    echo json_encode(["status" => "success"]);
    exit;
}

$phone = $_SESSION["user"]["phone"];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>PHP Lab 2차 인증</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">

<div class="bg-circle bg-circle-1"></div>
<div class="bg-circle bg-circle-2"></div>
<div class="bg-circle bg-circle-3"></div>

<div class="auth-wrapper">
    <div class="auth-card">

        <div class="logo-icon">🔐</div>

        <div class="auth-title">2차 인증</div>
        <div class="auth-desc">
            등록된 휴대폰 번호<br>
            <strong><?= htmlspecialchars($phone) ?></strong><br>
            로 전송된 OTP 코드를 입력하세요.
        </div>

        <div id="errorBox" class="error" style="display:none;"></div>

        <form id="mfaForm">
            <label>6자리 OTP</label>

            <div class="input-group">
                <span class="input-icon">🔢</span>
                <input
                    type="text"
                    id="otp"
                    maxlength="6"
                    placeholder="OTP 6자리를 입력하세요"
                    required
                >
            </div>

            <button type="submit" class="login-btn">인증 완료</button>
        </form>

        <div class="bottom-divider">보안 인증 단계</div>

        <button type="button" class="secondary-btn" onclick="location.href='/labs/php/login.php'">
            로그인으로 돌아가기
        </button>

    </div>
</div>

<div class="login-footer">
    © 2026 PHP Lab. All rights reserved.
</div>

<script>
const form = document.getElementById('mfaForm');
const otpInput = document.getElementById('otp');
const errorBox = document.getElementById('errorBox');

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    errorBox.style.display = 'none';
    errorBox.textContent = '';

    try {
        const response = await fetch('/labs/php/mfa.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ otp: otpInput.value })
        });

        const result = await response.json();

        if (result.status === 'success') {
            window.location.href = '/labs/php/main.php';
            return;
        }

        errorBox.textContent = 'OTP 코드가 올바르지 않습니다.';
        errorBox.style.display = 'block';
    } catch (e) {
        errorBox.textContent = '요청 처리 중 오류가 발생했습니다.';
        errorBox.style.display = 'block';
    }
});
</script>

<button class="source-toggle-btn" onclick="openSourcePanel('mfa.php')">
    소스코드 보기
</button>

<div id="sourceOverlay" class="source-overlay" onclick="closeSourcePanel()"></div>

<aside id="sourcePanel" class="source-panel">
    <div class="source-panel-header">
        <strong id="sourceTitle">mfa.php</strong>
        <button onclick="closeSourcePanel()">닫기</button>
    </div>

    <pre><code id="sourceCode">Loading...</code></pre>
</aside>

<script>
async function openSourcePanel(file) {
    const panel = document.getElementById('sourcePanel');
    const overlay = document.getElementById('sourceOverlay');
    const codeBox = document.getElementById('sourceCode');

    panel.classList.add('open');
    overlay.classList.add('open');

    codeBox.textContent = 'Loading...';

    const res = await fetch('/labs/php/source_view.php?file=' + encodeURIComponent(file));
    const text = await res.text();

    codeBox.textContent = text;
}

function closeSourcePanel() {
    document.getElementById('sourcePanel').classList.remove('open');
    document.getElementById('sourceOverlay').classList.remove('open');
}
</script>

</body>
</html>