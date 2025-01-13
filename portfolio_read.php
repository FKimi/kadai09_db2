<?php
// functions.phpを読み込む
include('functions.php');

// データベースに接続
$pdo = connect_to_db();

// 全てのデータを取得／ORDER BY created_at DESC：新しい作品から順に表示
$sql = 'SELECT * FROM portfolio ORDER BY created_at DESC';
$stmt = $pdo->prepare($sql);

// SQL実行
try {
    $stmt->execute();
    $works = $stmt->fetchAll();  // 全てのデータを配列に入れる
} catch (PDOException $e) {
    echo '表示エラー: ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>作品一覧</title>
    <style>
        .work-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .work-item {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }
        .work-item img {
            max-width: 100%;
            height: auto;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            margin: 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-edit {
            background: #4CAF50;
            color: white;
        }
        .btn-delete {
            background: #f44336;
            color: white;
        }
    </style>
</head>

<body>
    <h1>作品一覧</h1>
    <a href="portfolio_input.php" class="btn">新しい作品を登録</a>
    <!-- 作品を表示するグリッド -->
    <div class="work-grid">
        <?php foreach ($works as $work): ?> 
            <div class="work-item">
                <h2><?= htmlspecialchars($work['title']) ?></h2>
                <!-- 画像：パスがあれば表示 -->
                <?php if ($work['image_path']): ?>
                    <img src="<?= htmlspecialchars($work['image_path']) ?>" alt="<?= htmlspecialchars($work['title']) ?>">
                <?php endif; ?>
                <!-- 説明文：改行を反映して表示／nl2br()：テキストの改行を反映 -->
                <p><?= nl2br(htmlspecialchars($work['description'])) ?></p>
                <!-- カテゴリー：あれば表示 -->
                <?php if ($work['category']): ?>
                    <p>カテゴリー: <?= htmlspecialchars($work['category']) ?></p>
                <?php endif; ?>
                <!-- 編集・削除ボタン -->
                <div class="actions">
                    <a href="portfolio_edit.php?id=<?= $work['id'] ?>" class="btn btn-edit">編集</a>
                    <!-- onclick="return confirm()"：削除前の確認表示 -->
                    <a href="portfolio_delete.php?id=<?= $work['id'] ?>" class="btn btn-delete" onclick="return confirm('本当に削除しますか？')">削除</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>