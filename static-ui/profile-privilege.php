<?php require_once ("head-utils.php");?>

<!-- As a heading -->
<div class="navbar navbar-light bg-light fixed-top">
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
	</div>
</div>

<!-- Actual content (not sidebar) - edit below -->

<div class="content container-fluid">
	<h4 class="whoseIn">Who's in the family?</h4>


	<div>
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
				<tr *ngFor="let user of users; let i = index">
					<th scope="row">{{ i + 1 }}</th>
					<td>{{ user.name }}</td>
					<td>{{ user.userEmail }}</td>
					<td>{{ user.userDisplayName}}</td>
					<td>{{ user.userPhoneNumber}}</td>
					<td>{{ user.userPrivilege }}</td>
					<td><button type="button" id="deleteButton" class="btn plusButton" (click)="onDelete(i)">
						<span class="fa-stack fa-1x">
							<i class="fas fa-trash-alt"></i>
						</span>
						</button></td>
					<td><button type="button" id="editButton" class="btn plusButton" (click)="onEdit(i)">
							<i class="fas fa-pencil-alt"></i>
						</button></td>
				</tr>
			</tbody>
		</table>
		<div class="text-right">
			<button type="submit" class="btn btn-primary" (click)="onNew()">New</button>
		</div>
	</div>
	<br>
	<div class="userentry" *ngIf="showNew">
		<form (ngSubmit)="onSave()">
			<div class="form-group row">
				<label id="name-input" class="col-2 col-form-label">Name</label>
				<div class="col-10">
					<input class="form-control" type="text" [(ngModel)]="regModel.name" name="Name">
				</div>
			</div>
			<div class="form-group row">
				<label id="email-input" class="col-2 col-form-label">Email</label>
				<div class="col-10">
					<input class="form-control" type="text" [(ngModel)]="regModel.userEmail" name="lastName">
				</div>
			</div>
			<div class="form-group row">
				<label id="displayname-input" class="col-2 col-form-label">Display Name</label>
				<div class="col-3 input-group">
					<input type="text" class="form-control" name="displayName" [(ngModel)]="regModel.userDisplayName" title="">
				</div>
			</div>
			<div class="form-group row">
				<label id="phoneNumber-input" class="col-2 col-form-label">Phone Number</label>
				<div class="col-10">
					<label>
						<input class="form-control" type="number" [(ngModel)]="regModel.userPhoneNumber" name="email">
					</label>
				</div>
			</div>
			<div class="form-group row">
				<label id="privilege-input" class="col-2 col-form-label">Privilege</label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
					<label class="form-check-label" for="inlineRadio1">0</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
					<label class="form-check-label" for="inlineRadio2">1</label>
				</div>
			</div>
			<button type="submit" class="btn btn-success">{{submitType}}</button>
			<button type="submit" class="btn btn-primary" (click)="onCancel()">Cancel</button>
		</form>
	</div>
</div>