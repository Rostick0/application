<?

if (empty($_SERVER['DOCUMENT_ROOT'])) $_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

require_once './include/connect.php';

$after_tomorrow = date('Y-m-d', strtotime(' +2 day'));
$today = date('Y-m-d', strtotime(' -1 day'));

$db_connect->query("UPDATE `project` SET `status_date`='2' WHERE `delivery_date`='$after_tomorrow'");
$db_connect->query("UPDATE `project` SET `status_date`='3' WHERE `delivery_date`='$today'");
