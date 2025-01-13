<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>作品登録</title>
</head>
<body>
    <!-- action: データの送信先 / method: 送信方法 / enctype: 画像送信に必要 
    - enctype="multipart/form-data"：画像をアップロードするために必要
    -->
    <form action="portfolio_create.php" method="POST" enctype="multipart/form-data">
        <!-- 作品タイトル: 必須項目 -->
        <div>
            <label for="title">作品タイトル</label>
            <input type="text" name="title" id="title" required>
        </div>
        <!-- 作品説明: 複数行入力可能 -->
        <div>
            <label for="description">作品の説明</label>
            <!-- textareaタグ：複数行のテキスト入力が可能-->
            <textarea name="description" id="description"></textarea>
        </div>
        <!-- 画像アップロード欄 -->
        <div>
            <label for="image">画像</label>
            <!-- 
            input type="file"の特徴：
            - type="file"：ファイルをアップロードするための入力欄
            - accept="image/*"を追加すると画像のみに制限できる
            -->
            <input type="file" name="image" id="image">
        </div>
        <!-- カテゴリー入力欄 -->
        <div>
            <label for="category">カテゴリー</label>
            <input type="text" name="category" id="category">
        </div>
        <!-- 送信ボタン -->
        <button type="submit">登録する</button>
    </form>
</body>
</html>