<?php
include('functions.php');
// POSTでデータが送られてきた時だけ実行／$_POST：編集フォームから送られたデータを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 送られてきたデータを取得
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $current_image = $_POST['current_image'];  // 現在の画像パス

    // 画像の処理：新しい画像がアップロードされた場合／$_FILES：アップロードされたファイルを受け取る
    $image_path = $current_image;  // デフォルトは現在の画像のまま／$current_image：既存の画像パスを保持（新しい画像がない場合用）
    if (!empty($_FILES['image']['name'])) {  // 画像がアップロードされた場合
        $upload_dir = 'uploads/';  // アップロード先のディレクトリ
        $image_name = date('YmdHis') . '_' . $_FILES['image']['name'];  // 日時＋ファイル名で画像名を作成
        $image_path = $upload_dir . $image_name;  // 画像の保存先を作成
        // 新しい画像を保存
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    // データベースに接続／connect_to_db：データベースに接続
    $pdo = connect_to_db();

    // SQL作成／UPDATE文：指定したIDの作品情報を更新
    $sql = 'UPDATE portfolio SET title = :title, description = :description, image_path = :image_path, category = :category WHERE id = :id';

    // SQL準備／prepare：SQLを実行する準備を行う
    $stmt = $pdo->prepare($sql);

    // バインド変数設定／bindValue：プレースホルダに変数をバインド
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':image_path', $image_path, PDO::PARAM_STR);
    $stmt->bindValue(':category', $category, PDO::PARAM_STR);

    // SQL実行／try-catch構文：エラーが発生した場合の処理を記述
    try {
        $stmt->execute();
        // 一覧ページへリダイレクト／header関数：指定したURLに遷移
        header('Location: portfolio_read.php');
        exit();
    } catch (PDOException $e) {
        echo '更新エラー: ' . $e->getMessage();
        exit();
    }
}
?>