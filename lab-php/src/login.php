<?php
session_start();
require_once "db.php";

$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_POST["userId"] ?? "";
    $password = $_POST["password"] ?? "";

    $db = get_db();

    $sql = "
        SELECT user_id, password, name, phone, otp
        FROM users
        WHERE user_id = '{$userId}' and password = '{$password}'
        LIMIT 1
    ";

    $user = $db->query($sql)->fetch();

    if ($user) {
        session_regenerate_id(true);

        $_SESSION["user"] = [
            "id" => $user["user_id"],
            "name" => $user["name"],
            "phone" => $user["phone"]
        ];

        $_SESSION["mfa_verified"] = false;
        $_SESSION["pending_otp"] = $user["otp"];

        header("Location: /labs/php/mfa.php");
        exit;
    }

    $error = "아이디 또는 비밀번호가 올바르지 않습니다.";
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Lab 로그인</title>

    <link rel="stylesheet" href="/labs/php/style.css">

    <!-- 아이콘 -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="login-page">

<div class="bg-circle bg-circle-1"></div>
<div class="bg-circle bg-circle-2"></div>
<div class="bg-circle bg-circle-3"></div>

<div class="login-wrapper">

    <div class="login-card">

        <div class="logo-icon">
            <i class="fa-solid fa-shield-halved"></i>
        </div>

        <div class="login-logo">
            PHP Lab
        </div>

        <div class="login-desc">
            웹 모의해킹 실습 로그인 페이지
        </div>

        <?php if ($error): ?>
            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post">

            <label>아이디</label>

            <div class="input-group">
                <i class="fa-regular fa-user"></i>

                <input
                    type="text"
                    name="userId"
                    placeholder="아이디를 입력하세요"
                    required
                >
            </div>

            <label>비밀번호</label>

            <div class="input-group">
                <i class="fa-solid fa-lock"></i>

                <input
                    type="password"
                    name="password"
                    placeholder="비밀번호를 입력하세요"
                    required
                >
            </div>

            <div class="forgot-row">
                <a href="#">비밀번호를 잊으셨나요?</a>
            </div>

            <button type="submit" class="login-btn">
                로그인
            </button>

        </form>

        <div class="bottom-divider">
            계정이 없으신가요?
        </div>

        <button class="secondary-btn">
            문의하기
        </button>

    </div>

</div>

<div class="login-footer">
    © 2026 PHP Lab. All rights reserved.
</div>

<button class="source-toggle-btn" onclick="openSourcePanel('login.php')">
    소스코드 보기
</button>

<div id="sourceOverlay" class="source-overlay" onclick="closeSourcePanel()"></div>

<aside id="sourcePanel" class="source-panel">
    <div class="source-panel-header">
        <strong id="sourceTitle">login.php</strong>
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