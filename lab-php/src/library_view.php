<?php
session_start();
require_once "db.php";
require_once "layout.php";

$id = intval($_GET["id"] ?? 0);

$db = get_db();

$stmt = $db->prepare("SELECT * FROM library_posts WHERE id = :id");
$stmt->execute(["id" => $id]);
$post = $stmt->fetch();

if (!$post) {
    echo "자료를 찾을 수 없습니다.";
    exit;
}

$db->prepare("UPDATE library_posts SET views = views + 1 WHERE id = :id")
   ->execute(["id" => $id]);

render_header("PHP Lab 자료 상세", "library_view.php");
?>

<div class="modern-page-wrapper">
    <section class="modern-page-card narrow-card">
        <div class="hero-badge"><?= htmlspecialchars($post["category"]) ?></div>

        <h1><?= htmlspecialchars($post["title"]) ?></h1>

        <p class="page-subtitle">
            작성자 <?= htmlspecialchars($post["author"]) ?> |
            <?= htmlspecialchars(substr($post["created_at"], 0, 10)) ?> |
            조회수 <?= htmlspecialchars($post["views"] + 1) ?>
        </p>

        <div class="modern-viewer">
            <?= htmlspecialchars($post["content"]) ?>
        </div>

        <div class="modern-attach-box">
            <strong>첨부파일</strong>
            <a href="/labs/php/download.php?fileName=<?= urlencode($post["file_name"]) ?>">
                <?= htmlspecialchars($post["file_name"]) ?>
            </a>
        </div>
    </section>
</div>

<?php render_footer(); ?>