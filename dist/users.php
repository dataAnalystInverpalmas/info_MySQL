<?php
				//traer conexion
require("funciones/conexion.php");
				?>

				<a class="btn btn-primary" href="home.php?menu=tables&table=15&act=add"> <i class="glyphicon glyphicon-plus-sign"></i> Add New Users</a>

				<h1>Users</h1>
				<p>This table includes <?php echo counting("users", "id");?> users.</p>

				<table id="sorted" class="table table-striped table-bordered">
				<thead>
				<tr>
							<th>Id</th>
			<th>Name</th>
			<th>Email</th>
			<th>Password</th>
			<th>Role</th>

				<th class="not">Edit</th>
				<th class="not">Delete</th>
				</tr>
				</thead>

				<?php
				$users = getAll("users");
				if($users) foreach ($users as $userss):
					?>
					<tr>
		<td><?php echo $userss['id']?></td>
		<td><?php echo $userss['name']?></td>
		<td><?php echo $userss['email']?></td>
		<td><?php echo $userss['password']?></td>
		<td><?php echo $userss['role']?></td>


						<td><a href="home.php?menu=tables&table=15&act=edit&id=<?php echo $userss['id']?>">Editar</a></td>
						<td><a href="save.php?act=delete&id=<?php echo $userss['id']?>&cat=users" onclick="return navConfirm(this.href);">Eliminar</i></a></td>
						</tr>
					<?php endforeach; ?>
					</table>
