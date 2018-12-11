import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

import {EventService} from "../shared/services/event.service";
import {TaskService} from "../shared/services/task.service";
import {UserService} from "../shared/services/user.service";
import {JwtHelperService} from "@auth0/angular-jwt";

import {User} from "../shared/interfaces/user";
import {Task} from "../shared/interfaces/task";
import {Event} from "../shared/interfaces/event";

import {Status} from "../shared/interfaces/status";
import {ActivatedRoute} from "@angular/router";


@Component({
	template: require("./user-profile.component.html")
})

export class UserProfileComponent implements OnInit {
	user: User = {userId: null, userFamilyId:null, userAvatar:null, userDisplayName:null, userEmail:null, userPhoneNumber:null};
	task: Task = {taskId:null, taskEventId:null, taskUserId:null, taskDueDate:null, taskDescription:null, taskIsComplete:null, taskName:null};
	tasks: Task[];
	event: Event = {eventId:null, eventFamilyId:null, eventUserId:null, eventContent:null, eventEndDate:null, eventName:null, eventStartDate:null};
	events: Event[];
	userId: string = this.route.snapshot.params["userId"];
	editUserForm : FormGroup;
	status: Status = {status:null, message:null, type:null};
	jwt = this.jwtHelperService.decodeToken(window.localStorage.getItem("jwt-token"));

	public userShow: boolean = false;
	public showEditForm: boolean = false;
	public buttonName: any = "Edit User";

	constructor(private eventService: EventService, private taskService: TaskService, private userService: UserService, private formBuilder: FormBuilder, private route: ActivatedRoute, private jwtHelperService: JwtHelperService) { }

	ngOnInit(): void {
		this.userService.getUser(this.userId).subscribe(user => this.user = user);
		this.loadEvents();
		this.loadTasks();
		this.checkUser();

		this.editUserForm = this.formBuilder.group({
			editDisplayName : ["", [Validators.maxLength(32), Validators.required]],
			editEmail : ["", [Validators.maxLength(128), Validators.required]],
			editPhoneNumber : ["", [Validators.maxLength(32), Validators.required]]
		})
	}

	loadEvents() : any {
		this.eventService.getEventByUserId(this.userId).subscribe(events => this.events = events)
	}

	loadTasks() : any {
		this.taskService.getTaskByUserId(this.userId).subscribe(tasks => this.tasks = tasks)
	}

	editUserFormSubmit() : any {
		let user : User = {
			userId: null,
			userAvatar: null,
			userEmail: this.editUserForm.value.editEmail,
			userDisplayName: this.editUserForm.value.editDisplayName,
			userFamilyId: null,
			userPhoneNumber: this.editUserForm.value.editPhoneNumber
		};

		this.userService.editUser(user)
	}

	toggleEditForm() {
		this.showEditForm = !this.showEditForm;

		if(!this.showEditForm)
			this.buttonName ="Edit User";
		else
			this.buttonName = "Hide Edit Form"
	}

	checkUser() {
		if(this.jwt.auth.userId === "userId" )
			this.userShow = !this.userShow;
	}


}

