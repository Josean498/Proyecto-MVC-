<?php

    require_once "models/equiposModel.php";
	$nuevo = new equiposModel();
	$equipo = $nuevo->get();
	$cabecera = $nuevo->cabeceraTabla();

?>
<!doctype html>
<html lang="es"> 

<?php require_once("template/partials/head.php") ?>

<body>
    <?php require_once("template/partials/menu.php") ?>
    
    <!-- Page Content -->
    <div class="container">
	<br><br><br><br>

		<?php require_once("template/partials/mensaje.php") ?>
		

		<!-- Estilo card de bootstrap -->
		<div class="card">
			<div class="card-header" style = "background-color: black; color: white; text-align: center">
				MVC - Sección Equipos
			</div>
			<div class="card-body">
			<?php require_once("template/partials/cabecera.php") ?>
			<?php if (!empty($_SESSION['id'])): ?>
				<?php require_once("template/equipos/menubar.php") ?>
				<?php endif ?>
				<br>
		<section>
			<article>
				<table class ="table">
					<thead>
						<tr>
							<?php foreach ($cabecera as $key => $valor): ?>
							<th><?=$valor?></th>
							<?php endforeach;?>
							<?php if (!empty($_SESSION['id'])): ?>
							<th>
								Acciones
							</th>
							<?php endif ?>
						</tr>
					</thead>	
					<tbody>
							<?php foreach ($equipo as $registro => $value):?>
								<tr>
									<td><?=$value->id?></td>
									<td><?=$value->nombre?></td>
									<td><?=$value->numPiloto?></td>
									<td><img src="imagenes/<?=$value->imagen?>" width="40px" height="40px"></td>
									<td><?=$value->nacionalidad?></td>
									<?php if (!empty($_SESSION['id'])): ?>
									<td>
										<a href="<?= URL ?>equipos/show/<?=$value->id?>" title="Visualizar"><i class="material-icons">visibility</i></a>
										<a href="<?= URL ?>equipos/edit/<?=$value->id?>" title="Editar"><i class="material-icons">edit</i></a>
										<a href="<?= URL ?>equipos/delete/<?=$value->id?>"><i class="material-icons">clear</i></a>									</td>
										<?php endif ?>
								</tr>
							<?php endforeach;?>
					</tbody>			
				</table>
				<h4>El número de equipos es: <?= Count($equipo)?></h4>
			</article>
		</section>
		</div>
		</div>
    </div>
    <!-- /.container -->
    <?php require_once("template/partials/footer.php") ?>
	<?php require_once("template/partials/javascript.php") ?>
	
</body>
</html>