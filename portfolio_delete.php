<?php
include('functions.php');

// $_GET：URLパラメータを取得
$id = $_GET['id'];

// データベースに接続
$pdo = connect_to_db();

// 削除する作品の情報を取得（画像を削除するため）
$sql = 'SELECT image_path FROM portfolio WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $stmt->execute();
    $work = $stmt->fetch();

    // 画像ファイルが存在する場合は削除
    if (!empty($work['image_path']) && file_exists($work['image_path'])) {
        unlink($work['image_path']);  // unlink：ファイルを削除
    }

    // データベースから作品を削除
    $sql = 'DELETE FROM portfolio WHERE id = :id'; // DELETE文：指定したIDのデータを削除
    $stmt = $pdo->prepare($sql); // prepare：SQLを実行する準備を行う
    $stmt->bindValue(':id', $id, PDO::PARAM_INT); // bindValue：プレースホルダに変数をバインド
    $stmt->execute(); // execute：SQLを実行

    // 一覧ページへリダイレクト
    header('Location: portfolio_read.php');
    exit();
// エラー処理 
} catch (PDOException $e) {
    echo '削除エラー: ' . $e->getMessage();
    exit();
}
?>