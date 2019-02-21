<?php
require 'Session.php';
require 'Request.php';
require 'db.php';

$request = new Request;
$errors = [];

$email = trim($_POST['email']);
$pass = trim($_POST['pass']);

if ($request->isPost()) {
    $request->required('email');

    $request->required('pass');

    $isValid = $request->isValid();
    $errors = $request->getErrors();


    $val = ['email' => $email, 'password' => md5($pass)];
    $sql = "SELECT id, email, fio, role_id, last_enter_date FROM users WHERE email=:email AND password=:password";
    $rows = $pdo->prepare($sql);
    $rows->execute($val);
    $users = $rows->fetch();

    if (!$users) {
        $errors['form'] = 'Такого пользователя не существует либо неверно введен пароль';
        $isValid = false;
    }

    if ($users && empty($errors)){
        $session = new Session;
        foreach ($users as $key => $value) {
            $session->set($key, $value);
        }

        $values = ['last_enter_date' => date('Y-m-d H:i:s'), 'id' => $users['id']];
        $sql = "UPDATE users SET last_enter_date=:last_enter_date WHERE id=:id";
        $stm = $pdo->prepare($sql);
        $stm->execute($values);
    }

    echo json_encode([
        'errors' => $errors,
        'isValid' => $isValid
    ]);
}
?>
