<?php
	$rut='../';
	$db='db';
	$cl1='contacto';
	$dir1='contacto/';
	$dir2='contacto/detalle.php?p=';

	function index($rut){
		global $db, $cl1;
		require_once($rut.DIRMOR.$db.'.php');
		require_once($rut.DIRMOR.$cl1.'.php');
		$_db = new $db();
		$_cl1 = new $cl1();

		$inf = $_cl1->listar($_db->conect01());

		return $inf;
	}
	function exportar($rut){
		global $db, $cl1;
		require_once($rut.DIRMOR.$db.'.php');
		require_once($rut.DIRMOR.$cl1.'.php');
		$_db = new $db();
		$_cl1 = new $cl1();

		$inf = $_cl1->exportar($_db->conect01());

		return $inf;
	}
	function detalle($rut,$pid){
		global $db, $cl1;
		require_once($rut.DIRMOR.$db.'.php');
		require_once($rut.DIRMOR.$cl1.'.php');
		$_db = new $db();
		$_cl1 = new $cl1();

		$inf = $_cl1->callID($_db->conect01(),$pid);

		return $inf;
	}
	if (isset($_POST['guardar'])) {
		session_start();
		require_once($rut.'constant.php');

		require_once($rut.DIRMOR.$db.'.php');
		require_once($rut.DIRMOR.$cl1.'.php');
		$_db = new $db();
		$_cl1 = new $cl1();

		$nombre = $_POST['nombre'];
		$correo = $_POST['correo'];
		$telefono = $_POST['telefono'];
		$mensaje = $_POST['mensaje'];
		$created_at = date('Y-m-d H:i:s');

		$_SESSION['stat'] = $_cl1->add($_db->conect01(),$nombre,$correo,$telefono,$mensaje,$created_at);

		header("Location: ".URL.$dir1);
		exit();
	}
	if (isset($_POST['editar'])) {
		session_start();
		require_once($rut.'constant.php');

		require_once($rut.DIRMOR.$db.'.php');
		require_once($rut.DIRMOR.$cl1.'.php');
		$_db = new $db();
		$_cl1 = new $cl1();

		$pid = base64_decode($_POST['pid']);
		$respuesta = $_POST['respu_ant'].'<h3>Respuesta '.date('Y-m-d H:i:s').':</h3><br>'.$_POST['respuesta'];
		$updated_at = date('Y-m-d H:i:s');

		$_SESSION['stat'] = $_cl1->edit($_db->conect01(),$pid,$respuesta,$updated_at);

		header("Location: ".SIST.$dir2.base64_encode($pid));
		exit();
	}
	if (isset($_REQUEST['met'])) {
		session_start();
		require_once($rut.'constant.php');

		require_once($rut.DIRMOR.$db.'.php');
		require_once($rut.DIRMOR.$cl1.'.php');
		$_db = new $db();
		$_cl1 = new $cl1();

		$pid = base64_decode($_REQUEST['p']);
		$updated_at = date('Y-m-d H:i:s');

		switch ($_REQUEST['met']) {
			case 'acti':
				$_SESSION['stat'] = $_cl1->acti($_db->conect01(),$pid,$updated_at);
			break;
			case 'desact':
				$_SESSION['stat'] = $_cl1->desact($_db->conect01(),$pid,$updated_at);
			break;
		}

		header("Location: ".SIST.$dir1);
		exit();
	}
	if (isset($_POST['eliminar'])) {
		session_start();
		require_once($rut.'constant.php');

		require_once($rut.DIRMOR.$db.'.php');
		require_once($rut.DIRMOR.$cl1.'.php');
		$_db = new $db();
		$_cl1 = new $cl1();

		$pid = base64_decode($_POST['pid']);
		$drop_at = date('Y-m-d H:i:s');

		$_SESSION['stat'] = $_cl1->drop($_db->conect01(),$pid,$drop_at);

		header("Location: ".SIST.$dir1);
		exit();
	}