<?php
include('functions.php');

// DB接続
$pdo = connect_to_db();

// プロフィールデータ取得
$sql = 'SELECT * FROM profiles WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', 1, PDO::PARAM_INT); // 仮のuser_id=1を設定
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
}

$profile = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール編集</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        textarea {
            height: 100px;
        }
    </style>
</head>
<body>
    <h1>プロフィール編集</h1>
    
    <form action="profile_update.php" method="POST">
        <div class="form-group">
            <label for="name">名前 *</label>
            <input type="text" id="name" name="name" required 
                value="<?= htmlspecialchars($profile['name']) ?>">
        </div>

        <div class="form-group">
            <label for="user_name">ユーザー名 *</label>
            <input type="text" id="user_name" name="user_name" required 
                value="<?= htmlspecialchars($profile['user_name']) ?>">
        </div>

        <div class="form-group">
            <label for="birth_date">生年月日</label>
            <input type="date" id="birth_date" name="birth_date" 
                value="<?= htmlspecialchars($profile['birth_date']) ?>">
        </div>

        <div class="form-group">
            <label for="gender">性別</label>
            <input type="text" id="gender" name="gender" 
                value="<?= htmlspecialchars($profile['gender']) ?>">
        </div>

        <div class="form-group">
            <label for="organization">所属組織</label>
            <input type="text" id="organization" name="organization" 
                value="<?= htmlspecialchars($profile['organization']) ?>">
        </div>

        <div class="form-group">
            <label for="title">役職</label>
            <input type="text" id="title" name="title" 
                value="<?= htmlspecialchars($profile['title']) ?>">
        </div>

        <div class="form-group">
            <label for="bio">自己紹介（最大1024文字）</label>
            <textarea id="bio" name="bio" maxlength="1024"><?= htmlspecialchars($profile['bio']) ?></textarea>
        </div>

        <input type="hidden" name="user_id" value="<?= $profile['user_id'] ?>">
        
        <div class="form-group">
            <button type="submit">更新する</button>
            <a href="profile_read.php">戻る</a>
        </div>
    </form>
</body>
</html>