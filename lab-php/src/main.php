<?php
session_start();
require_once "layout.php";

render_header("PHP Lab 메인", "main.php");
?>

<div class="modern-page-wrapper">
    <section class="main-hero-card">
        <div class="hero-badge">Web Security Training</div>

        <h1>PHP Lab 메인 페이지</h1>

        <p>
            웹 모의해킹 실습을 위한 PHP 기반 훈련장입니다.<br>
            게시판, 자료실, 데이터 조회 기능을 통해 인증, 파일 처리, 입력값 처리 흐름을 실습할 수 있습니다.
        </p>

        <div class="main-menu-grid">
            <a href="/labs/php/board.php" class="main-menu-card">
                <div class="menu-icon">📝</div>
                <h2>게시판</h2>
                <p>게시글 작성, 조회, 첨부파일 기능을 실습합니다.</p>
            </a>

            <a href="/labs/php/library.php" class="main-menu-card">
                <div class="menu-icon">📁</div>
                <h2>자료실</h2>
                <p>서버 파일 다운로드 흐름을 실습합니다.</p>
            </a>

            <a href="/labs/php/data_search.php" class="main-menu-card">
                <div class="menu-icon">🔎</div>
                <h2>데이터 조회</h2>
                <p>제품 번호, 제품명, 가격, 공급 업체, 분류 데이터를 검색합니다.</p>
            </a>
        </div>
    </section>
</div>

<?php render_footer(); ?>