SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    name VARCHAR(50) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    otp VARCHAR(6) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (user_id, password, name, phone, otp) VALUES
('alice', 'alice1234', 'Alice', '010-1111-2222', '654321'),
('bob', 'bob1234', 'Bob', '010-3333-4444', '123456');

CREATE TABLE board_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    views INT NOT NULL DEFAULT 0,
    attachment_original_name VARCHAR(255),
    attachment_saved_name VARCHAR(255),
    attachment_url VARCHAR(255),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE library_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    views INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO library_posts (category, title, author, content, file_name) VALUES
('가이드', 'PHP 서비스 이용 가이드', 'admin', 'PHP Lab 서비스 이용 가이드입니다.', 'sample-guide.txt'),
('정책', 'PHP 보안 정책 문서', 'admin', 'PHP Lab 보안 정책 자료입니다.', 'policy.txt'),
('공지', 'PHP 릴리즈 노트', 'admin', 'PHP Lab 릴리즈 노트입니다.', 'release-note.txt');

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_no VARCHAR(50) NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_price INT NOT NULL,
    supplier VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO products (product_no, product_name, product_price, supplier, category) VALUES
('P-1001', '보안 점검 리포트 템플릿', 120000, 'SecureWorks Korea', '문서'),
('P-1002', '웹 취약점 진단 체크리스트', 80000, 'AppSec Lab', '문서'),
('P-1003', '모의해킹 교육 키트', 350000, 'HackTrain', '교육'),
('P-1004', '로그 분석 샘플 데이터셋', 150000, 'DataSec', '데이터'),
('P-1005', '취약점 관리 대시보드', 900000, 'BlueTeam Systems', '소프트웨어');