<?php
// DB接続関数
function connect_to_db() {
    // 開発環境（XAMPP）と本番環境（さくらサーバー）の切り替え
    $is_local = false;  // trueなら開発環境、falseなら本番環境
    
    if ($is_local) {
        // ローカル環境（XAMPP）用の設定
        $dbn = 'mysql:dbname=balubo_db;charset=utf8mb4;port=3306;host=localhost';
        $user = 'root';
        $pwd = '';
    } else {
        // さくらサーバー用の設定
        $db_name = 'fuuu_balubo_db';
        $db_host = 'mysql3104.db.sakura.ne.jp';
        $user = 'fuuu_balubo_db';
        $pwd = '134097Fu';
        $dbn = "mysql:dbname={$db_name};charset=utf8;host={$db_host}";
    }
 
    try {
        return new PDO($dbn, $user, $pwd, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e) {
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
    }
}
