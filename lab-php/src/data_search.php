<?php
session_start();
require_once "db.php";
require_once "layout.php";

$keyword = $_GET["keyword"] ?? "";
$products = [];

$db = get_db();

if ($keyword !== "") {
    // SQL Injection 취약 버전
    $sql = "
        SELECT *
        FROM products
        WHERE product_no LIKE '%{$keyword}%'
           OR product_name LIKE '%{$keyword}%'
           OR supplier LIKE '%{$keyword}%'
           OR category LIKE '%{$keyword}%'
        ORDER BY id DESC
    ";

    $stmt = $db->query($sql);
    $products = $stmt->fetchAll();
} else {
    $stmt = $db->query("
        SELECT *
        FROM products
        ORDER BY id DESC
    ");

    $products = $stmt->fetchAll();
}

render_header("PHP Lab 데이터 조회", "data_search.php");
?>

<div class="modern-page-wrapper">
    <section class="modern-page-card">
        <div class="page-title-row">
            <div>
                <div class="hero-badge">Data Search</div>
                <h1>데이터 조회</h1>
                <p>키워드로 제품 데이터를 검색합니다.</p>
            </div>
        </div>

        <form method="get" class="search-form">
            <label>검색 키워드</label>
            <div class="search-row">
                <input
                    type="text"
                    name="keyword"
                    placeholder="제품 번호, 제품 이름, 공급 업체, 제품 분류 검색"
                    value="<?= htmlspecialchars($keyword) ?>"
                >
                <button type="submit" class="modern-primary-btn">검색</button>
            </div>
        </form>

        <table class="modern-table">
            <thead>
                <tr>
                    <th>제품 번호</th>
                    <th>제품 이름</th>
                    <th>제품 가격</th>
                    <th>공급 업체</th>
                    <th>제품 분류</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($products) === 0): ?>
                    <tr>
                        <td colspan="5" class="empty">조회된 데이터가 없습니다.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product["product_no"]) ?></td>
                        <td><?= htmlspecialchars($product["product_name"]) ?></td>
                        <td><?= number_format($product["product_price"]) ?>원</td>
                        <td><?= htmlspecialchars($product["supplier"]) ?></td>
                        <td><?= htmlspecialchars($product["category"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>

<?php render_footer(); ?>