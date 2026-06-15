<?php
session_start();
require_once "db.php";
require_once "layout.php";

$db = get_db();

$stmt = $db->query("
    SELECT *
    FROM library_posts
    ORDER BY id DESC
");

$posts = $stmt->fetchAll();

render_header("PHP Lab 자료실", "library.php");
?>

<div class="modern-page-wrapper">
    <section class="modern-page-card">
        <div class="page-title-row">
            <div>
                <div class="hero-badge">Library</div>
                <h1>자료실</h1>
                <p>서버에 등록된 자료와 첨부파일 다운로드 흐름을 실습합니다.</p>
            </div>
        </div>

        <table class="modern-table">
            <thead>
                <tr>
                    <th>카테고리</th>
                    <th>제목</th>
                    <th>작성자</th>
                    <th>작성일자</th>
                    <th>조회수</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?= htmlspecialchars($post["category"]) ?></td>
                        <td>
                            <a href="/labs/php/library_view.php?id=<?= $post["id"] ?>">
                                <?= htmlspecialchars($post["title"]) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($post["author"]) ?></td>
                        <td><?= htmlspecialchars(substr($post["created_at"], 0, 10)) ?></td>
                        <td><?= htmlspecialchars($post["views"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>

<?php render_footer(); ?>