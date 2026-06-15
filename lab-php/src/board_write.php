<?php
session_start();
require_once "db.php";

$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $category = $_POST["category"] ?? "";
    $title = $_POST["title"] ?? "";
    $content = $_POST["content"] ?? "";

    if ($category === "" || $title === "" || $content === "") {
        $error = "카테고리, 제목, 내용을 모두 입력해주세요.";
    } else {
        $attachmentOriginalName = null;
        $attachmentSavedName = null;
        $attachmentUrl = null;

        if (isset($_FILES["attachment"]) && $_FILES["attachment"]["error"] === UPLOAD_ERR_OK) {
            $originalName = $_FILES["attachment"]["name"];
            $tmpName = $_FILES["attachment"]["tmp_name"];

            $savedName = time() . "_" . basename($originalName);
            $targetPath = __DIR__ . "/uploads/" . $savedName;

            move_uploaded_file($tmpName, $targetPath);

            $attachmentOriginalName = $originalName;
            $attachmentSavedName = $savedName;
            $attachmentUrl = "/labs/php/uploads/" . $savedName;
        }

        if (!isset($_SESSION["user"])) {
            header("Location: /labs/php/login.php");
            exit;
        }

        $author = $_SESSION["user"]["name"];

        $db = get_db();

        $stmt = $db->prepare("
            INSERT INTO board_posts
            (
                category,
                title,
                content,
                author,
                attachment_original_name,
                attachment_saved_name,
                attachment_url
            )
            VALUES
            (
                :category,
                :title,
                :content,
                :author,
                :attachment_original_name,
                :attachment_saved_name,
                :attachment_url
            )
        ");

        $stmt->execute([
            "category" => $category,
            "title" => $title,
            "content" => $content,
            "author" => $author,
            "attachment_original_name" => $attachmentOriginalName,
            "attachment_saved_name" => $attachmentSavedName,
            "attachment_url" => $attachmentUrl
        ]);

        header("Location: /labs/php/board.php");
        exit;
    }
}

require_once "layout.php";
render_header("PHP Lab 글쓰기", "board_write.php");
?>

<div class="modern-page-wrapper">
    <section class="modern-page-card narrow-card">
        <div class="hero-badge">Write</div>
        <h1>게시글 작성</h1>
        <p class="page-subtitle">카테고리, 제목, 내용을 입력하고 첨부파일을 등록할 수 있습니다.</p>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="modern-form">
            <label>카테고리</label>
            <input type="text" name="category" required>

            <label>제목</label>
            <input type="text" name="title" required>

            <label>내용</label>
            <textarea name="content" rows="10" required></textarea>

            <label>첨부파일</label>
            <input type="file" name="attachment">

            <button type="submit" class="modern-primary-btn full-btn">등록</button>
        </form>
    </section>
</div>

<?php render_footer(); ?>