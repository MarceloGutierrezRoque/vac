<?php
	/**
	 * 
	 */
	class cursos
	{
		private $table ='cursos';
		private $action='detalle.php?p=';
		private $action1='cursos/detalle.php?p=';

		function listar($c1){
			$inf=null;$n=1;$cant=5;
			$inf.='<thead>';
				$inf.='<tr>';
					$inf.='<th scope="col">#</th>';
					$inf.='<th scope="col">Nombre</th>';
					$inf.='<th scope="col">Descripción</th>';
					$inf.='<th scope="col">Creado</th>';
					$inf.='<th scope="col">Gestión</th>';
				$inf.='</tr>';
			$inf.='</thead>';
			$inf.='<tbody>';
				$sql = "SELECT * FROM ".$this->table." WHERE status=1;";
				$res = mysqli_query($c1,$sql) OR $_SESSION['Mysqli_Error'] = (mysqli_error($c1));
				if ($res) {
					if ($res->num_rows > 0) {
						while ($row = mysqli_fetch_array($res)) {
							$inf.='<tr>';
								$inf.='<th scope="row">'.$n.'</th>';
								$inf.='<td>'.$row['nombre'].'</td>';
								$inf.='<td>'.$row['descrip'].'</td>';
								$inf.='<td>'.$row['created_at'].'</td>';
								$inf.='<td>';
									$inf.='<a href="'.URL.$this->action1.base64_encode($row['id']).'" class="btn btn-outline-warning">';
										$inf.='<i class="fa fa-edit"></i>';
									$inf.='</a>';
								$inf.='</td>';
							$inf.='</tr>';

							$n++;
						}
						mysqli_free_result($res);//liberar memoria del resultado
					}else{
						$inf.='<tr><td colspan="'.$cant.'"><div class="alert alert-warning">No se encontró ningún registro</div></td></tr>';
					}
				}else{
					$inf.='<tr><td colspan="'.$cant.'"><div class="alert alert-danger">Error: '.$_SESSION['Mysqli_Error'].'</div></td></tr>';
				}
			$inf.='</tbody>';

			mysqli_close($c1);
			return $inf;
		}
		function callID($c1,$pid){
			$inf=null;
			$sql = "SELECT * FROM ".$this->table." WHERE id=".$pid." ;";
			$res = mysqli_query($c1,$sql) OR $_SESSION['Mysqli_Error'] = (mysqli_error($c1));
			if ($res) {
				if ($res->num_rows > 0) {
					while ($row = mysqli_fetch_array($res)) {
						$_SESSION['nombre'] = $row['nombre'];
						$_SESSION['descrip'] = $row['descrip'];
					}
					$inf=true;
					mysqli_free_result($res);//liberar memoria del resultado
				}else{
					$inf=false;
				}
			}else{
				$inf=false;
			}

			mysqli_close($c1);
			return $inf;
		}
		function add($c1,$nombre,$descrip,$created_at){
			$inf=null;$er=1;
			$sql="INSERT INTO ".$this->table." (nombre, descrip, created_at) VALUES ('".$nombre."', '".$descrip."', '".$created_at."');";
			$res = mysqli_query($c1,$sql) OR $_SESSION['Mysqli_Error'] = (mysqli_error($c1));
			if ($res) {
				$inf='add';
			}else{
				$inf='noadd';
			}

			mysqli_close($c1);
			return $inf;
		}
		function edit($c1,$pid,$nombre,$descrip,$updated_at){
			$inf=null;$er=1;
			$sql="UPDATE ".$this->table." SET nombre='".$nombre."', descrip='".$descrip."', updated_at='".$updated_at."' WHERE id=".$pid." ;";
			$res = mysqli_query($c1,$sql) OR $_SESSION['Mysqli_Error'] = (mysqli_error($c1));
			if ($res) {
				$inf='edit';
			}else{
				$inf='noedit';
			}

			mysqli_close($c1);
			return $inf;
		}
	}
?>