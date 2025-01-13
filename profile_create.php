<?php
// デバッグ表示
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 関数ファイルの読み込み
include('functions.php');

// データ受け取り
$name = $_POST['name'];
$user_name = $_POST['user_name'];
$birth_date = $_POST['birth_date'];
$gender = $_POST['gender'];
$birthplace = $_POST['birthplace'];
$current_address = $_POST['current_address'];
$organization = $_POST['organization'];
$title = $_POST['title'];
$bio = $_POST['bio'];
$interests = $_POST['interests'];

// 画像アップロード処理
$icon_path = null; // 初期値
if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
    $uploaded_file = $_FILES['icon'];
    $file_size = $uploaded_file['size'];
    $max_size = 2 * 1024 * 1024; // 2MB

    // ファイルサイズチェック
    if ($file_size > $max_size) {
        exit('ファイルサイズは2MB以下にしてください');
    }

    // ファイルの種類をチェック
    $allowed_types = [
        'image/jpeg',
        'image/png',
        'image/gif'
    ];
    $file_type = $uploaded_file['type'];
    
    if (!in_array($file_type, $allowed_types)) {
        exit('JPG、PNG、GIF形式の画像を選択してください');
    }

    // アップロード先ディレクトリ
    $upload_dir = 'uploads/';
    
    // ディレクトリがなければ作成
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // ユニークなファイル名を生成
    $extension = pathinfo($uploaded_file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $filepath = $upload_dir . $filename;

    // ファイルを移動
    if (move_uploaded_file($uploaded_file['tmp_name'], $filepath)) {
        $icon_path = $filepath;
    } else {
        exit('ファイルのアップロードに失敗しました');
    }
}

// DB接続
$pdo = connect_to_db();

// SQL作成&実行
$sql = 'INSERT INTO profiles (
    name, user_name, birth_date, gender, birthplace,
    current_address, organization, title, icon, bio,
    interests, created_at, updated_at
) VALUES (
    :name, :user_name, :birth_date, :gender, :birthplace,
    :current_address, :organization, :title, :icon, :bio,
    :interests, now(), now()
)';

$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
$stmt->bindValue(':birth_date', $birth_date, PDO::PARAM_STR);
$stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
$stmt->bindValue(':birthplace', $birthplace, PDO::PARAM_STR);
$stmt->bindValue(':current_address', $current_address, PDO::PARAM_STR);
$stmt->bindValue(':organization', $organization, PDO::PARAM_STR);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':icon', $icon_path, PDO::PARAM_STR);
$stmt->bindValue(':bio', $bio, PDO::PARAM_STR);
$stmt->bindValue(':interests', $interests, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// 処理が完了したら一覧ページへ移動
header("Location:profile_read.php");
exit();