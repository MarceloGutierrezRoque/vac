<?php
	/**
	 * 
	 */
	class db
	{
		function conect01(){
			$con1 = mysqli_connect("localhost","root","");
			mysqli_select_db($con1,"vac");
			return($con1);
		}
		function conect02(){
			$con1 = mysqli_connect("HOST","USUARIO","CONTRASEÑA");
			mysqli_select_db($con1,"BASE DE DATOS");
			return($con1);
		}
	}