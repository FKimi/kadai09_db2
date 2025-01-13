<?php
include('functions.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール登録</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4 max-w-lg">
        <!-- enctype属性を追加 -->
        <form action="profile_create.php" method="POST" enctype="multipart/form-data" 
              class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">プロフィール登録</h1>

            <!-- 名前 -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 mb-2">
                    名前 <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" required
                    class="w-full p-2 border rounded">
            </div>

            <!-- ユーザー名 -->
            <div class="mb-4">
                <label for="user_name" class="block text-gray-700 mb-2">
                    ユーザー名 <span class="text-red-500">*</span>
                </label>
                <input type="text" id="user_name" name="user_name" required
                    class="w-full p-2 border rounded">
            </div>

            <!-- 生年月日 -->
            <div class="mb-4">
                <label for="birth_date" class="block text-gray-700 mb-2">生年月日</label>
                <input type="date" id="birth_date" name="birth_date"
                    class="w-full p-2 border rounded">
            </div>

            <!-- 性別 -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">性別</label>
                <select name="gender" class="w-full p-2 border rounded">
                    <option value="">選択してください</option>
                    <option value="男性">男性</option>
                    <option value="女性">女性</option>
                    <option value="その他">その他</option>
                </select>
            </div>

            <!-- アイコン画像 -->
            <div class="mb-4">
                <label for="icon" class="block text-gray-700 mb-2">アイコン画像</label>
                <input type="file" id="icon" name="icon" accept="image/*"
                    class="w-full p-2 border rounded">
                <div class="mt-1 text-sm text-gray-500">
                    <p>※ 2MBまでのJPG、PNG、GIF形式の画像をアップロード可能</p>
                    <p>※ 推奨サイズ: 400x400ピクセル</p>
                </div>
                <!-- プレビュー表示エリア -->
                <div id="preview" class="mt-2 hidden">
                    <img id="preview-image" class="w-32 h-32 object-cover rounded">
                </div>
            </div>

            <!-- 出身地 -->
            <div class="mb-4">
                <label for="birthplace" class="block text-gray-700 mb-2">出身地</label>
                <input type="text" id="birthplace" name="birthplace"
                    class="w-full p-2 border rounded">
            </div>

            <!-- 居住地 -->
            <div class="mb-4">
                <label for="current_address" class="block text-gray-700 mb-2">居住地</label>
                <input type="text" id="current_address" name="current_address"
                    class="w-full p-2 border rounded">
            </div>

            <!-- 所属 -->
            <div class="mb-4">
                <label for="organization" class="block text-gray-700 mb-2">所属</label>
                <input type="text" id="organization" name="organization"
                    class="w-full p-2 border rounded">
            </div>

            <!-- 肩書き -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 mb-2">肩書き</label>
                <input type="text" id="title" name="title"
                    class="w-full p-2 border rounded">
            </div>

            <!-- 自己紹介 -->
            <div class="mb-4">
                <label for="bio" class="block text-gray-700 mb-2">自己紹介</label>
                <textarea id="bio" name="bio" rows="4"
                    class="w-full p-2 border rounded"
                    maxlength="1024"></textarea>
                <p class="text-sm text-gray-500">最大1024文字</p>
            </div>

            <!-- 興味のあるテーマ -->
            <div class="mb-4">
                <label for="interests" class="block text-gray-700 mb-2">興味のあるテーマ</label>
                <textarea id="interests" name="interests" rows="4"
                    class="w-full p-2 border rounded"
                    maxlength="1024"></textarea>
                <p class="text-sm text-gray-500">最大1024文字</p>
            </div>

            <!-- 送信ボタン -->
            <div class="flex justify-between mt-6">
                <a href="profile_read.php" class="text-gray-600 hover:text-gray-800">
                    キャンセル
                </a>
                <button type="submit" 
                    class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    登録する
                </button>
            </div>
        </form>
    </div>

    <!-- 画像プレビュー用のJavaScript -->
    <script>
    document.getElementById('icon').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // ファイルサイズチェック（2MB）
            if (file.size > 2 * 1024 * 1024) {
                alert('ファイルサイズは2MB以下にしてください');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            const preview = document.getElementById('preview');
            const previewImage = document.getElementById('preview-image');

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.classList.remove('hidden');
            };

            reader.readAsDataURL(file);
        }
    });
    </script>
</body>
</html>