<?php require_once ("head-utils.php");?>

<div>

	<!-- As a heading -->
	<nav class="navbar navbar-light bg-light fixed-top">
		<span class="navbar-brand mb-0 h1">FamilyConnect</span>

	<!-- Page Content -->
	<div id="main container-fluid">
		<!-- Buttons -->
		<div class="buttons">

			<div class="configButtons">
				<button type="button" id="plusButton" class="btn plusButton">
					<i class="fas fa-plus"></i>
				</button>

				<button type="button" id="settingsButton" class="btn settingsButton">
					<i class="fas fa-cog"></i>
				</button>
			</div>
		</div>
	</nav>
</div>

		<!-- Actual content (not sidebar) - edit below -->

		<div class="content container-fluid">
			<h4 class="whoseIn">Who's in the family?</h4>

	<section>
		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Email</th>
					<th scope="col">Username</th>
					<th scope="col">Phone Number</th>
					<th scope="col">Privilege</th>
					<th scope="col">Delete User</th>
					<th scope="col">Edit User</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th scope="row">Frank G</th>
					<td>anEmail@handle.com</td>
					<td>UserName1</td>
					<td>55555555</td>
					<td>1</td>
					<td><button type="button" id="plusButton" class="btn plusButton">
						<span class="fa-stack fa-1x">
							<i class="fas fa-trash-alt"></i>
						</span>
						</button></td>
					<td><button type="button" id="plusButton" class="btn plusButton">
							<i class="fas fa-pencil-alt"></i>
						</button></td>
				</tr>

				<tr>
					<th scope="row">Jake G</th>
					<td>otherEmail@handle.com</td>
					<td>UserName2</td>
					<td>5555557</td>
					<td>0</td>
					<td><button type="button" id="plusButton" class="btn plusButton">
						<span class="fa-stack fa-1x">
							<i class="fas fa-trash-alt"></i>
						</span>
						</button></td>
					<td><button type="button" id="plusButton" class="btn plusButton">
							<i class="fas fa-pencil-alt"></i>
						</button></td>
				</tr>

				<tr>
					<th scope="row">Bob G</th>
					<td>bob@handle.com</td>
					<td>UserName3</td>
					<td>5555556</td>
					<td>1</td>
					<td><button type="button" id="plusButton" class="btn plusButton">
						<span class="fa-stack fa-1x">
							<i class="fas fa-trash-alt"></i>
						</span>
						</button></td>
					<td><button type="button" id="plusButton" class="btn plusButton">
							<i class="fas fa-pencil-alt"></i>
						</button></td>
				</tr>
			</tbody>
		</table>
	</section>
	</div>