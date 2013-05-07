<?php
session_start();
if (isset($_REQUEST['login']))
  $_SESSION['login'] = $_REQUEST['login'];
if (isset($_SESSION['login'])
  $location_id = $_SESSION['login'];
else
  $location_id = 0;
$location = "nowhere";
$result = false;
$flash = '';
try {
  $dbh = new PDO('mysql:host=reeperbahntrack;dbname=reeperbahntrack', 'reeperbahntrack', 'NextMedia13', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
  $sql = 'select * from `location` where `id` = :id';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':id', $location_id);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
} catch (PDOException $e) {
  $dbh = null;
?><html>
<head></head>
<body>
<form action="track.php" method="post">
Database error:<br />
<input type="text" name="dummy" value="retry" autofocus="true" /><input type="submit" value="OK" />
</form>
</body>
</html>
<?php
  die();
}
if ($result === false) {
?><html>
<head></head>
<body>
<form action="track.php" method="post">
Terminal not found. Please log in first:<br />
<input type="text" name="login" value="" autofocus="true" /><input type="submit" value="OK" />
</form>
</body>
</html>
<?php
  die();
}
$location = $result['name'];

if (isset($_POST['code'])) {
  $sql = 'insert into `tracks` (`code`, `location_id`, `time`) values (:code, :location, :time)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':code', $_POST['code'], PDO::PARAM_STR);
    $stmt->bindValue(':location', $location_id, PDO::PARAM_STR);
    $stmt->bindValue(':time', time(), PDO::PARAM_STR);
    if ($stmt->execute()) {
      $id = $dbh->lastInsertId();
      $flash = 'success';
    } else {
      $flash = 'error';
    }
  }
}
?><html>
<head></head>
<body>
<form action="track.php" method="post">
You are here: <strong><?php echo $location; ?></strong><br />
<input type="text" name="code" value="" autofocus="true" /><input type="submit" value="OK" />
</form>
<?php echo $flash; ?>
</body>
</html>
