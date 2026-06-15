<?php
session_start();
require_once "db.php";
require_once "layout.php";

$db = get_db();

$stmt = $db->query("
    SELECT *
    FROM board_posts
    ORDER BY id DESC
");

$posts = $stmt->fetchAll();

render_header("PHP Lab 게시판", "board.php");
?>

<div class="modern-page-wrapper">
    <section class="modern-page-card">
        <div class="page-title-row">
            <div>
                <div class="hero-badge">Board</div>
                <h1>게시판</h1>
                <p>게시글 작성, 조회, 첨부파일 기능을 실습합니다.</p>
            </div>

            <a href="/labs/php/board_write.php" class="modern-primary-btn">글쓰기</a>
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
                <?php if (count($posts) === 0): ?>
                    <tr>
                        <td colspan="5" class="empty">등록된 게시글이 없습니다.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?= htmlspecialchars($post["category"]) ?></td>
                        <td>
                            <a href="/labs/php/board_view.php?id=<?= $post["id"] ?>">
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