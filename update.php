<?php
// update.php - 更新処理
session_start();

// CSRFチェック
if (
    !isset($_SESSION['csrf_token']) ||
    !isset($_POST['csrf_token']) ||
    $_SESSION['csrf_token'] !== $_POST['csrf_token']
) {
    exit('不正なリクエストです。');
}

// DB接続（既存の接続処理を流用）
try {
    $db_name = 'fuuu_profile_table';
    $db_host = 'mysql3104.db.sakura.ne.jp';
    $db_id   = 'fuuu_profile_table';
    $db_pw   = '134097Fu';
    $dsn = "mysql:dbname={$db_name};charset=utf8mb4;host={$db_host}";
    $pdo = new PDO($dsn, $db_id, $db_pw);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit('データベース接続エラー：' . $e->getMessage());
}

// データの受け取り
$id = $_POST['id'] ?? exit('IDが指定されていません。');
$email = $_POST['email'] ?? exit('メールアドレスが指定されていません。');
$pw = $_POST['pw']; // パスワードは変更オプション

// SQL作成（パスワード変更の有無で分岐）
if (!empty($pw)) {
    $sql = 'UPDATE profile_table SET email = :email, pw = :pw, updated_at = NOW() WHERE id = :id';
} else {
    $sql = 'UPDATE profile_table SET email = :email, updated_at = NOW() WHERE id = :id';
}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
if (!empty($pw)) {
    // 本番環境ではパスワードのハッシュ化が必要
    $stmt->bindValue(':pw', $pw, PDO::PARAM_STR);
}

try {
    $status = $stmt->execute();
    header('Location: read.php');
} catch (PDOException $e) {
    exit('エラー：' . $e->getMessage());
}