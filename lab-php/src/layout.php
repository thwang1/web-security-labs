<?php
function render_header($title = "PHP Lab", $sourceFile = null) {
    if (!isset($_SESSION["user"])) {
        header("Location: /labs/php/login.php");
        exit;
    }

    $userName = $_SESSION["user"]["name"];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/labs/php/style.css">
</head>
<body>
<header class="modern-nav">
    <div class="nav-brand">
        PHP Lab
    </div>

    <nav class="nav-menu">
        <a href="/labs/php/main.php">메인</a>
        <a href="/labs/php/board.php">게시판</a>
        <a href="/labs/php/library.php">자료실</a>
        <a href="/labs/php/data_search.php">데이터 조회</a>
    </nav>

    <div class="nav-user">
        <span><?= htmlspecialchars($userName) ?>님</span>
        <a href="/labs/php/logout.php" class="nav-logout">로그아웃</a>
    </div>
</header>

<?php if ($sourceFile): ?>
<button class="source-toggle-btn" onclick="openSourcePanel('<?= htmlspecialchars($sourceFile) ?>')">
    소스코드 보기
</button>

<div id="sourceOverlay" class="source-overlay" onclick="closeSourcePanel()"></div>

<aside id="sourcePanel" class="source-panel">
    <div class="source-panel-header">
        <strong id="sourceTitle">소스코드</strong>
        <button onclick="closeSourcePanel()">닫기</button>
    </div>

    <pre><code id="sourceCode">Loading...</code></pre>
</aside>
<?php endif; ?>

<main class="modern-content">
<?php
}

function render_footer() {
?>
</main>

<script>
async function openSourcePanel(file) {
    const panel = document.getElementById('sourcePanel');
    const overlay = document.getElementById('sourceOverlay');
    const codeBox = document.getElementById('sourceCode');
    const title = document.getElementById('sourceTitle');

    panel.classList.add('open');
    overlay.classList.add('open');

    title.textContent = file;
    codeBox.textContent = 'Loading...';

    try {
        const res = await fetch('/labs/php/source_view.php?file=' + encodeURIComponent(file));
        const text = await res.text();
        codeBox.textContent = text;
    } catch (e) {
        codeBox.textContent = '소스코드를 불러오지 못했습니다.';
    }
}

function closeSourcePanel() {
    document.getElementById('sourcePanel').classList.remove('open');
    document.getElementById('sourceOverlay').classList.remove('open');
}
</script>

</body>
</html>
<?php
}
?>