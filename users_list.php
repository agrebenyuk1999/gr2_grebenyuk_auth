<?php
require 'Session.php';
require 'db.php';
$session = new Session;

if ($_SESSION['role_id'] !== 1) {
    header('Location: index.html');
}

$sql = "SELECT id, fio FROM users";
$rows = $pdo->query($sql);

?>

<?php while ($users = $rows->fetch()) { ?>
    <ul>
        <li><?php echo $users['fio'] ?></li>
        <a href="edit.php?id=<?php echo $users['id']; ?>">Редактировать</a>
    </ul>
<?php } ?>
