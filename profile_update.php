<?php
include('functions.php');

// POSTデータ確認
if (
    !isset($_POST['user_id']) || $_POST['user_id'] == '' ||
    !isset($_POST['name']) || $_POST['name'] == '' ||
    !isset($_POST['user_name']) || $_POST['user_name'] == ''
) {
    exit('ParamError');
}

$user_id = $_POST['user_id'];
$name = $_POST['name'];
$user_name = $_POST['user_name'];
$birth_date = $_POST['birth_date'];
$gender = $_POST['gender'];
$organization = $_POST['organization'];
$title = $_POST['title'];
$bio = $_POST['bio'];

// DB接続
$pdo = connect_to_db();

// SQL作成&実行
$sql = 'UPDATE profiles SET name=:name, user_name=:user_name, birth_date=:birth_date, 
        gender=:gender, organization=:organization, title=:title, bio=:bio, 
        updated_at=now() WHERE user_id=:user_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
$stmt->bindValue(':birth_date', $birth_date, PDO::PARAM_STR);
$stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
$stmt->bindValue(':organization', $organization, PDO::PARAM_STR);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':bio', $bio, PDO::PARAM_STR);
$status = $stmt->execute();

// 処理後のリダイレクト
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    header('Location:profile_read.php');
    exit();
}