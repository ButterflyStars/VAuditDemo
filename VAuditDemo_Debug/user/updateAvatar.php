<?php
include_once('../sys/config.php');
$uploaddir = '../uploads';

if (isset($_POST['submit']) && isset($_FILES['upfile'])) {

	if(is_pic($_FILES['upfile']['name'])){

		$avatar = $uploaddir . '/u_'. time(). '_' . $_FILES['upfile']['name'];

		if (move_uploaded_file($_FILES['upfile']['tmp_name'], $avatar)) {
			//更新用户信息
			$query = "UPDATE users SET user_avatar = '$avatar' WHERE user_id = '{$_SESSION['user_id']}'";
			mysql_query($query, $conn) or die('update error!');
			mysql_close($conn);
			//刷新缓存
			$_SESSION['avatar'] = $avatar;
			header('Location: edit.php');
		}
		else {
			echo 'upload error<br />';
			echo '<a href="edit.php">返回</a>';
		}
	}else{
		echo '只能上傳 jpg png gif！<br />';
		echo '<a href="edit.php">返回</a>';
	}
}
else {
	not_find($_SERVER['PHP_SELF']);
}
?>
