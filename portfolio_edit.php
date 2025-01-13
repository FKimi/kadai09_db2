<?php
// include('functions.php');
include('functions.php');  // この行のコメントアウトを解除

// idの受け取り／$_GET['id']：URLからIDを取得（例：edit.php?id=1）
$id = $_GET['id'];

// データベースに接続
$pdo = connect_to_db();

// idを指定して作品データを取得
$sql = 'SELECT * FROM portfolio WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

// SQLを実行してデータを取得
try {
    $stmt->execute();
    $work = $stmt->fetch();  // 1つの作品データを取得

    // データが見つからない場合の処理
    if (!$work) {
        echo '作品が見つかりません';
        exit();
    }
} catch (PDOException $e) {
    echo 'エラー: ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>作品編集</title>
</head>
<body>
    <h1>作品編集</h1>
    <!-- 更新用のフォーム -->
    <form action="portfolio_update.php" method="POST" enctype="multipart/form-data">
        <!-- 作品IDを隠して送信／input type="hidden"：画面には表示しないがデータを送信 -->
        <input type="hidden" name="id" value="<?= $work['id'] ?>">
        <!-- タイトル編集欄：現在の値を表示 -->
        <div>
            <label for="title">作品タイトル</label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($work['title']) ?>" required>
        </div>
        <!-- 説明文編集欄：現在の値を表示 -->
        <div>
            <label for="description">作品の説明</label>
            <textarea name="description" id="description"><?= htmlspecialchars($work['description']) ?></textarea>
        </div>
        <!-- カテゴリー編集欄：現在の値を表示 -->
        <div>
            <label for="category">カテゴリー</label>
            <input type="text" name="category" id="category" value="<?= htmlspecialchars($work['category']) ?>">
        </div>
        <!-- 画像関連の編集欄 -->
        <div>
            <?php if ($work['image_path']): ?>
                <p>現在の画像：</p>
                <img src="<?= htmlspecialchars($work['image_path']) ?>" width="200">
                <input type="hidden" name="current_image" value="<?= htmlspecialchars($work['image_path']) ?>">
            <?php endif; ?>
            <!-- 新しい画像のアップロード欄 -->            
            <label for="image">新しい画像（選択すると更新されます）</label>
            <input type="file" name="image" id="image">
        </div>
        <!-- 送信ボタンと戻るリンク -->
        <div>
            <button type="submit">更新する</button>
            <a href="portfolio_read.php">戻る</a>
        </div>
    </form>
</body>
</html>