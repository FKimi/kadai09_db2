<?php
// デバッグ表示
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 関数読み込み
require_once('functions.php');

// DB接続
$pdo = connect_to_db();

// データ取得SQL作成
$sql = 'SELECT * FROM profiles ORDER BY created_at DESC';

// SQL実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール一覧</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <!-- ヘッダー -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">プロフィール一覧</h1>
            <a href="profile_create.php" class="bg-blue-500 text-white px-4 py-2 rounded">
                新規作成
            </a>
        </div>

        <!-- 一覧表示 -->
        <div class="bg-white shadow rounded">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">名前</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ユーザーネーム</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">所属</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">操作</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($result as $record): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?= h($record['name']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @<?= h($record['user_name']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?= h($record['organization']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <a href="profile_edit.php?id=<?= h($record['user_id']) ?>" 
                                   class="text-blue-500 hover:text-blue-700 mr-4">編集</a>
                                <a href="profile_delete.php?id=<?= h($record['user_id']) ?>" 
                                   class="text-red-500 hover:text-red-700"
                                   onclick="return confirm('本当に削除してもよろしいですか？')">削除</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>