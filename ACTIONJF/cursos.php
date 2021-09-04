<?php
	$rut='../';
	$db='db';
	$cl1='cursos';
	$dir1='cursos/';
	$dir2='cursos/detalle.php?p=';

	function index($rut){
		global $db, $cl1;
		require_once($rut.DIRMOR.$db.'.php');
		require_once($rut.DIRMOR.$cl1.'.php');
		$_db = new $db();
		$_cl1 = new $cl1();

		$inf = $_cl1->listar($_db->conect01());

		return $inf;
	}
	function exportar($rut,$tip){
		global $db, $cl1;
		require_once($rut.DIRMOR.$db.'.php');
		require_once($rut.DIRMOR.$cl1.'.php');
		$_db = new $db();
		$_cl1 = new $cl1();

		$inf = $_cl1->exportar($_db->conect01(),$tip);

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
		$descrip = $_POST['descrip'];
		
		if (is_uploaded_file($_FILES["imagen"]["tmp_name"])) {
			$nombfile=$_FILES["imagen"]["name"];
			$taman=$_FILES["imagen"]["size"];
			$type=$_FILES["imagen"]["type"];
			$destino= __DIRIMG__."cursos/";
			$imagen=date("YmdHis").$nombfile;
			move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino.$imagen);
		}else{
			$imagen='user.png';
		}

		$created_at = date('Y-m-d H:i:s');

		$_SESSION['stat'] = $_cl1->add($_db->conect01(),$nombre,$descrip,$imagen,$created_at);

		header("Location: ".SIST.$dir1);
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
		$nombre = $_POST['nombre'];
		$descrip = $_POST['descrip'];

		if (is_uploaded_file($_FILES["imagen"]["tmp_name"])) {
			$nombfile=$_FILES["imagen"]["name"];
			$taman=$_FILES["imagen"]["size"];
			$type=$_FILES["imagen"]["type"];
			$destino= __DIRIMG__."cursos/";
			$imagen=date("YmdHis").$nombfile;
			move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino.$imagen);
		}else{
			$imagen=$_POST['imagen_ant'];
		}

		$updated_at = date('Y-m-d H:i:s');

		$_SESSION['stat'] = $_cl1->edit($_db->conect01(),$pid,$nombre,$descrip,$imagen,$updated_at);

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