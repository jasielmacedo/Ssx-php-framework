<?php
/**
 * 
 * @version 1.0
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  
 */
 
 define('SSX', 'secure');

 include_once '../core/library/classes/SsxProtect.php';
 include_once '../core/library/classes/Crypt.php';
 include_once '../core/library/classes/SsxString.php';
 
 $generated = false;

 if(isset($_POST['generate']) && $_POST['generate'])
 {
 	$keypair = SsxProtect::getRandomString(32,false);
 	$session_key = SsxProtect::getRandomString(32);
 	
 	
 	$env = isset($_POST['env'])?$_POST['env']:"development";
 	$host = isset($_POST['host'])?$_POST['host']:"";
 	$user = isset($_POST['user'])?$_POST['user']:"";
 	$pass = isset($_POST['pass'])?$_POST['pass']:"";
 	$database = isset($_POST['database'])?$_POST['database']:"";
 	
 	$host = SsxProtect::encrypt($host, $keypair);
 	$user = SsxProtect::encrypt($user, $keypair);
 	$pass = SsxProtect::encrypt($pass, $keypair);
 	$database = SsxProtect::encrypt($database, $keypair);
 	
 	$generated = true;
 	
 	header("Content-Type: text/html; charset=UTF-8");
 }

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Gerador de hash do sistema</title>
	</head>
	<body>
		<div>
			<h2>Gerador de hash do sistema SSX</h2>
			<p>Mantenha este arquivo local, n&atilde;o coloque no servidor onde a aplica&ccedil;&atilde;o ser&aacute; hospedada.</p>
		</div>
		<div>
			<form action="" method="post">
			 <table>
			 	<tr>
			 		<td>Ambiente</td>
			 		<td><input type='text' name='env' value="<?php echo isset($_POST['env'])?$_POST['env']:"development"; ?>" /></td>
			 	</tr>
			 	<tr>
			 		<td>Database Host</td>
			 		<td><input type='text' name='host' value="<?php echo isset($_POST['host'])?$_POST['host']:""; ?>" /></td>
			 	</tr>
			 	<tr>
			 		<td>Database User</td>
			 		<td><input type='text' name='user' value="<?php echo isset($_POST['user'])?$_POST['user']:""; ?>" /></td>
			 	</tr>
			 	<tr>
			 		<td>Database Pass</td>
			 		<td><input type='text' name='pass' value="<?php echo isset($_POST['pass'])?$_POST['pass']:""; ?>" /></td>
			 	</tr>
			 	<tr>
			 		<td>Database Name</td>
			 		<td><input type='text' name='database' value="<?php echo isset($_POST['database'])?$_POST['database']:""; ?>" /></td>
			 	</tr>
			 	<tr>
			 		<td colspan="2">
			 			<input type='submit' value="Gerar hash" name="generate" />
			 		</td>
			 	</tr>
			 </table>
			</form>
		</div>
		<?php if($generated): ?>
		
		<div>
			<p>
				<textarea cols="80" rows="30">
/**
 * Define os dados de banco
 * @var string
 */
$this->ssx_db_access['<?php echo $env; ?>'] = new SsxDbConfig();
$this->ssx_db_access['<?php echo $env; ?>']->ssx_db_type = 'mysql';
$this->ssx_db_access['<?php echo $env; ?>']->ssx_db_user = '<?php echo $user; ?>';
$this->ssx_db_access['<?php echo $env; ?>']->ssx_db_pass = '<?php echo $pass; ?>';
$this->ssx_db_access['<?php echo $env; ?>']->ssx_db_host = '<?php echo $host; ?>';
$this->ssx_db_access['<?php echo $env; ?>']->ssx_db_name = '<?php echo $database; ?>';
$this->ssx_db_access['<?php echo $env; ?>']->ssx_hash_key = '<?php echo $keypair; ?>';
$this->ssx_db_access['<?php echo $env; ?>']->ssx_hash_session_key = '<?php echo $session_key; ?>';
$this->ssx_db_access['<?php echo $env; ?>']->ssx_db_port = 3306;
				</textarea>
			</p>
		</div>		
		<?php endif;?>
	</body>
</html> 