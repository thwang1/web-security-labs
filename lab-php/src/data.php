<?php
$BASE_PATH = "/labs/php";
$users = [
    [
        "id" => "alice",
        "password" => "alice1234",
        "name" => "Alice",
        "phone" => "010-1111-2222",
        "otp" => "654321"
    ],
    [
        "id" => "bob",
        "password" => "bob1234",
        "name" => "Bob",
        "phone" => "010-3333-4444",
        "otp" => "123456"
    ]
];

$libraryPosts = [
    [
        "id" => 1,
        "category" => "가이드",
        "title" => "PHP 서비스 이용 가이드",
        "author" => "admin",
        "createdAt" => "2026-04-15",
        "views" => 0,
        "content" => "PHP Lab 서비스 이용 가이드입니다.",
        "fileName" => "sample-guide.txt"
    ],
    [
        "id" => 2,
        "category" => "정책",
        "title" => "PHP 보안 정책 문서",
        "author" => "admin",
        "createdAt" => "2026-04-15",
        "views" => 0,
        "content" => "PHP Lab 보안 정책 자료입니다.",
        "fileName" => "policy.txt"
    ],
    [
        "id" => 3,
        "category" => "공지",
        "title" => "PHP 릴리즈 노트",
        "author" => "admin",
        "createdAt" => "2026-04-15",
        "views" => 0,
        "content" => "PHP Lab 릴리즈 노트입니다.",
        "fileName" => "release-note.txt"
    ]
];