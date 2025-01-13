<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール設定 - balubo</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <header>
        <a href="/" class="logo">balubo</a>
    </header>

    <main>
        <div class="signup-container">
            <section class="welcome-section">
                <h1>プロフィールを設定しましょう</h1>
                <p>基本情報を入力してください</p>
            </section>

            <section class="signup-section">
                <div class="signup-box">
                    <form action="save_profile.php" method="POST" class="form-group">
                        <!-- 名前 -->
                        <div class="name-group">
                            <div class="form-group">
                                <label for="last_name">姓</label>
                                <input type="text" id="last_name" name="last_name" required>
                            </div>
                            <div class="form-group">
                                <label for="first_name">名</label>
                                <input type="text" id="first_name" name="first_name" required>
                            </div>
                        </div>

                        <!-- 生年月日 -->
                        <div class="form-group">
                            <label for="birth_date">生年月日</label>
                            <input type="date" id="birth_date" name="birth_date" required>
                        </div>

                        <!-- 性別 -->
                         <div class="form-group">
                            <label for="gender">性別</label>
                            <select id="gender" name="gender" required>
                                 <option value="" selected disabled>選択してください</option>
                                  <option value="male">男性</option>
                                   <option value="female">女性</option>
                                    <option value="custom">カスタム</option>
                                     <option value="no_answer">答えたくない</option>
                                     </select>
                                      <div id="custom-gender" class="custom-gender" style="display: none;">
                                        <input type="text" name="custom_gender" placeholder="性別を入力してください">
                                     </div>
                                    </div>

                        <!-- ユーザー名 -->
                        <div class="form-group">
                            <label for="username">ユーザー名</label>
                            <input type="text" id="username" name="username" required
                                   placeholder="半角英数字で入力してください">
                        </div>

                        <button type="submit" class="submit-btn">
                             登録完了
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <script>
        // カスタム性別の入力フィールド表示制御
        document.getElementById('gender').addEventListener('change', function() {
            const customField = document.getElementById('custom-gender');
            customField.style.display = this.value === 'custom' ? 'block' : 'none';
        });
    </script>
</body>
</html>