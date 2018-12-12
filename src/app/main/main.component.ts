import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {UserService} from "../shared/services/user.service";
import {Status} from "../shared/interfaces/status";
import {User} from "../shared/interfaces/user";
import {Event} from "../shared/interfaces/event";
import {ActivatedRoute, Router} from "@angular/router";
import {EventService} from "../shared/services/event.service";
import {JwtHelperService} from "@auth0/angular-jwt";
import {Config} from "@fortawesome/fontawesome";
import {template} from "@angular/core/src/render3";


@Component({
	selector: 'main',
	template: require("./main.component.html"),
})

export class MainComponent implements OnInit {
	user: User = {
		userId: null,
		userFamilyId: null,
		userAvatar: null,
		userDisplayName: null,
		userEmail: null,
		userPhoneNumber: null,
		userPrivilege: null
	};
	event: Event = {
		eventId: null,
		eventFamilyId: null,
		eventUserId: null,
		eventContent: null,
		eventEndDate: null,
		eventName: null,
		eventStartDate: null
	};
	eventId: string = this.route.snapshot.params["eventId"];
	// task: Task = {taskId:null, taskEventId:null, taskUserId:null, taskDescription:null, taskDueDate:null, taskIsComplete:null, taskName:null};
	// taskId: string = this.route.snapshot.params["taskId"];
	events: Event[];

	jwt = this.jwtHelperService.decodeToken(window.localStorage.getItem("jwt-token"));


	constructor(private userService: UserService, private eventService: EventService, private route: ActivatedRoute, private jwtHelperService: JwtHelperService) {
	}

	ngOnInit(): void {
		//	this.taskService.getTaskByFamilyId(this.jwt.auth.taskId).subscribe(task => this.task = task);
		// 	this.loadTasks();


		this.eventService.getEventByFamilyId(this.jwt.auth.familyId).subscribe(event => this.events = event);
	}

	 loadTasks() : any {
	// 	this.taskService.getTask(this.taskId).subscribe(tasks => this.task = tasks);
	 }

	loadEvents(): any {
		this.eventService.getEventByFamilyId(this.eventId).subscribe(events => this.events = events);
	}

	stateFlag = false;
	stateFlag1 = false;

	justMe(): any {
		this.eventService.getEventByUserId(this.jwt.auth.userId).subscribe(events => this.events = events);
		return {
			'inactive': this.stateFlag
		}
	}

	toggleState() {
		this.stateFlag = !this.stateFlag;
		this.stateFlag1 = !this.stateFlag1;
	}


}

@Component({
	template: require("./main.component.html")
})

export class PostsComponent implements OnInit{
	events: Event[];
	postForm : FormGroup;
	status : Status = {status:null, message:null, type: null};

	constructor(private eventService: EventService, private formBuilder : FormBuilder) {}

	ngOnInit() {
		this.eventService.getAllEvents().subscribe(events => this.events = events);

		this.postForm = this.formBuilder.group({
			eventName : ["", [Validators.maxLength(30), Validators.required]],
			eventContent : ["", [Validators.maxLength(255), Validators.required]]
		});
		this.loadEvents();
	}

	loadEvents() : void {
		this.eventService.getAllEvents().subscribe(events => this.events = events);
	}
	createEvent() : void {
		let event :Event = {eventId: null, eventFamilyId: null, eventUserId:null, eventContent: this.postForm.value.eventContent, eventEndDate: null, eventName: this.postForm.value.eventName, eventStartDate: null};

		this.eventService.createEvent(event).subscribe(status => {
			this.status = status;
			if(status.status === 200) {
				this.loadEvents();
				this.postForm.reset()
			}
		})
	}
}