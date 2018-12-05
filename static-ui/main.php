<?php require_once ("head-utils.php");?>

<div class="wrapper">

	<!-- Sidebar -->
	<nav id="sidebar" class="sidebar col-md-2 bg-light">
		<div class="sidebar-header">
			<h2>Family Name</h2>
		</div>

		<ul class="users">
			<li>
				<a href="#">User1</a>
			</li>
		</ul>
	</nav>

	<!-- Page Content -->
	<div id="main container-fluid">
		<!-- Buttons -->
		<div class="buttons">

			<button type="button" id="sidebarCollapse" class="btn toggleButton">
				<i class="fas fa-ellipsis-h"></i>
			</button>

			<div class="configButtons">
				<button type="button" id="plusButton" class="btn plusButton">
					<i class="fas fa-plus"></i>
				</button>

				<button type="button" id="settingsButton" class="btn settingsButton">
					<i class="fas fa-cog"></i>
				</button>
			</div>


		<!-- Actual content (not sidebar) - edit below -->
			<!--Radio buttons-->
		<div class="content container">
		<div class="btn-group btn-group-toggle" data-toggle="buttons">
			<label class="btn btn-secondary active">
			<input type="radio" name="task" id="task" autocomplete="off" checked> Task
			</label>
			<label class="btn btn-secondary">
			<input type="radio" name="event" id="event" autocomplete="off"> Event
			</label>
		</div>

			<!--Check box, just me-->
			<div class="container mt-3">
				<div class="row no-gutters">
				<div class="custom-control custom-checkbox col-sm-6 col-md-8">
				<input type="checkbox" class="custom-control-input" id="justMe">
				<label class="custom-control-label" for="justMe">Just Me</label>
			</div>

		<!--Search Box-->
				<div class="input-group input-group-sm col-6 col-md-4">
					<div class="input-group-prepend">
						<span class="input-group-text" id="inputGroup-sizing-sm">Search</span>
					</div>
					<input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
				</div>
			</div>
			</div>


				<!--Event Drop Down-->
			<div class="container mt-5">
				<div id="accordion" role="tablist">
					<div class="card">
						<div class="card-header" role="tab" id="headingOne">
							<h5 class="mb-0">
								<a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="">
									Event 1
								</a>
							</h5>
						</div>

						<div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" style="">
							<div class="card-body">
								Information for Event 1. Lorem ipsum dolor sit amet, magna nec amet tristique, arcu
								sollicitudin libero id, adipiscing ea velit felis pede quisque, in pellentesque et sit.
								Lobortis nulla iaculis adipiscing velit. Nam eu vulputate sem. Lorem ipsum dolor sit amet, magna nec amet tristique, arcu
								sollicitudin libero id, adipiscing ea velit felis pede quisque, in pellentesque et sit. Lobortis nulla iaculis adipiscing velit. Nam eu vulputate sem.
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header" role="tab" id="headingTwo">
							<h5 class="mb-0">
								<a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									Event 2
								</a>
							</h5>
						</div>
						<div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
							<div class="card-body">
								Information for Event 2. Lorem ipsum dolor sit amet, magna nec amet tristique, arcu
								sollicitudin libero id, adipiscing ea velit felis pede quisque, in pellentesque et sit.
								Lobortis nulla iaculis adipiscing velit. Nam eu vulputate sem. Lorem ipsum dolor sit amet, magna nec amet tristique, arcu sollicitudin libero id, adipiscing ea velit felis pede quisque, in pellentesque et sit. Lobortis nulla iaculis adipiscing velit. Nam eu vulputate sem.
							</div>
						</div>
					</div>
				</div>


		</div>
		</div>
	</div>
