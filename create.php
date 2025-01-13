<?php
// var_dump($_POST)
// JSON形式のデータ受け取りを追加（Google認証用）
$input = json_decode(file_get_contents('php://input'), true);
// 1.POSTデータ確認。以下の条件に合致する場合は以降の処理を中止してエラー画面を表示する。!は反対の意味になる。

if ($input) {
  // Google認証からのデータを処理
  $email = $input['email'];
  $pw = null; // パスワードは不要（Google認証のため）
} else {
  // 既存のフォームからのデータ処理（変更なし）
  if (!isset($_POST['email']) || $_POST['email'] === '' ||
      !isset($_POST['pw']) || $_POST['pw'] === '') {
      exit('データがありません');
  }
// 2.データの受け取り
  $email = $_POST['email'];
  $pw = $_POST['pw'];
}

// 3.データベースへの接続準備.各種項目設定。データベース、ユーザー名、PWの確認
$dbn ='mysql:dbname=balubo_db;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// 4.データベースへの接続
try {
  $db_name = 'fuuu_profile_table';  // データベース名
  $db_host = 'mysql3104.db.sakura.ne.jp';  
  $db_id   = 'fuuu_profile_table';      // データベース名と同じ
  $db_pw   = '134097Fu';      // 設定したデータベースパスワード
  
  // 接続文字列を1つにまとめる
  $dsn = "mysql:dbname={$db_name};charset=utf8mb4;host={$db_host}";

    // PDOインスタンスを作成
    $pdo = new PDO($dsn, $db_id, $db_pw);
    
    // エラーモードを設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    exit('データベース接続エラー：' . $e->getMessage());
}


// 5.SQLの準備
// 修正後のコード
$sql = 'INSERT INTO profile_table (id,email,pw,created_at, updated_at) VALUES (NULL, :email, :pw, NOW(), NOW())';
   // $sql = 'INSERT INTO profile_table (id, name, email,pw, dateofbirth,username,occupation,created_at, updated_at) VALUES(NULL, :name, :email, :pw,: dateofbirth,:username,:occupation, now(), now())';
$stmt = $pdo->prepare($sql);

// 6.バインド変数を設定
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':pw', $pw, PDO::PARAM_STR);
// $stmt->bindValue(':name', $name, PDO::PARAM_STR);
// $stmt->bindValue(':dateofbirth', $dateofbirth, PDO::PARAM_STR);
// $stmt->bindValue(':username', $username, PDO::PARAM_STR);
// $stmt->bindValue(':occupation', $occupation, PDO::PARAM_STR);

// 7.SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// 8.SQL実行の処理
if ($input) {
  // Google認証の場合はJSON形式でレスポンス
  echo json_encode(['success' => true]);
} else {
  // 通常フォームの場合はread.phpにリダイレクト
  header('Location: read.php');
}
exit();

