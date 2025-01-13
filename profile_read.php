<?php
include('functions.php');

// DB接続
$pdo = connect_to_db();

// プロフィールデータ取得
$sql = 'SELECT * FROM profiles WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', 1, PDO::PARAM_INT); // 仮のuser_id=1を設定
$status = $stmt->execute();

// SQL実行時にエラーがある場合はエラーを表示して終了
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
}

// プロフィールデータを取得
$profile = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .profile-section {
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
            margin-right: 10px;
        }
    </style>
</head>
<!-- profile_read.phpの</body>タグの前に追加 -->
<div class="action-buttons" style="margin-top: 20px;">
        <a href="profile_edit.php" style="margin-right: 20px;">編集する</a>
        <a href="profile_delete.php?id=<?= $profile['user_id'] ?>" 
           onclick="return confirm('本当に削除しますか？')" 
           style="color: #ff0000;">削除する</a>
    </div>
</body>
<body>
    <h1>プロフィール</h1>
    
    <div class="profile-section">
        <div><span class="label">名前:</span> <?= htmlspecialchars($profile['name']) ?></div>
        <div><span class="label">ユーザー名:</span> <?= htmlspecialchars($profile['user_name']) ?></div>
        <?php if ($profile['birth_date']): ?>
            <div><span class="label">生年月日:</span> <?= htmlspecialchars($profile['birth_date']) ?></div>
        <?php endif; ?>
        <?php if ($profile['gender']): ?>
            <div><span class="label">性別:</span> <?= htmlspecialchars($profile['gender']) ?></div>
        <?php endif; ?>
    </div>

    <div class="profile-section">
        <?php if ($profile['organization']): ?>
            <div><span class="label">所属組織:</span> <?= htmlspecialchars($profile['organization']) ?></div>
        <?php endif; ?>
        <?php if ($profile['title']): ?>
            <div><span class="label">役職:</span> <?= htmlspecialchars($profile['title']) ?></div>
        <?php endif; ?>
    </div>

    <?php if ($profile['bio']): ?>
        <div class="profile-section">
            <div class="label">自己紹介:</div>
            <div><?= nl2br(htmlspecialchars($profile['bio'])) ?></div>
        </div>
    <?php endif; ?>

    <div>
        <a href="profile_edit.php">プロフィールを編集</a>
    </div>
</body>
</html>