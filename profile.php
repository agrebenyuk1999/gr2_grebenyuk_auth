<?php
require 'Session.php';
require 'db.php';
$session = new Session;

if ($_SESSION['role_id'] !== 2) {
    header('Location: index.html');
}

$id = $_SESSION['id'];

$sql = "SELECT id, fio, role_id, email FROM users WHERE id=:id";
$rows = $pdo->prepare($sql);
$rows->execute(['id' => $id]);
$user = $rows->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fio = trim($_POST['fio']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);

    $values = ['fio' => $fio, 'email' => $email, 'role_id' => $role, 'id' => $id];
    $sql = "UPDATE users SET fio=:fio, email=:email, role_id=:role_id WHERE id=:id";
    $stm = $pdo->prepare($sql);
    $stm->execute($values);
    header("Refresh:0");
}

?>

<form method="POST">
    <h1>Здравствуйте, <?php echo $user['fio'] ?></h1>
    ФИО:
    <input type="text" name="fio" value="<?php echo $user['fio'] ?>"><br><br>
    E-mail:
    <input type="text" name="email" value="<?php echo $user['email'] ?>"><br><br>
    Роль:
    <select name="role">
        <option value="1">Админ</option>
        <option value="2">Пользователь</option>
    </select>
    <button type="submit">Сохранить</button>
</form>



