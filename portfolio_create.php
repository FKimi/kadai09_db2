<?php
include('functions.php'); 

// アップロード先のディレクトリ
$upload_dir = 'uploads/';

// ディレクトリが存在しない場合は作成
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// フォームからデータが送られてきた時の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // データ受け取り
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    // 画像の処理
    $image_path = '';
    if (!empty($_FILES['image']['name'])) {
        // アップロードされた画像の名前を設定（日時+元のファイル名）／date('YmdHis')：画像名が重複しないように日時を付ける
        $image_name = date('YmdHis') . '_' . $_FILES['image']['name'];
        $image_path = $upload_dir . $image_name;
        
        // 画像のアップロード
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            // アップロード成功
        } else {
            echo 'アップロードエラー：' . $_FILES['image']['error'];
        }
    }

    // データベースに接続
    $pdo = connect_to_db();

    // SQL作成&実行
    $sql = 'INSERT INTO portfolio (title, description, image_path, category) VALUES (:title, :description, :image_path, :category)';
    $stmt = $pdo->prepare($sql);
    
    // バインド変数設定
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':image_path', $image_path, PDO::PARAM_STR);
    $stmt->bindValue(':category', $category, PDO::PARAM_STR);

    // SQL実行
    try {
        $stmt->execute();
        echo '登録が完了しました！';
        // 一覧ページへのリンクを追加
        echo '<br><a href="portfolio_read.php">一覧ページへ</a>';
    } catch(PDOException $e) {
        echo '登録エラー: ' . $e->getMessage();
    }
}
?>