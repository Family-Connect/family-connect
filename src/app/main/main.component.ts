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
import {BsDatepickerModule} from 'ngx-bootstrap/datepicker';

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
		userPhoneNumber: null
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


		//this.eventService.getEventByFamilyId(this.jwt.auth.familyId).subscribe(event => this.events = event);
	}

	// loadTasks() : any {
	// 	this.taskService.getTask(this.taskId).subscribe(tasks => this.task = tasks);
	// }

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
	selector: 'datepicker',
	templateUrl: "./main.component.html"
})

export class Datepicker {
	bsValue = new Date();
	bsRangeValue: Date[];
	maxDate = new Date();

	constructor() {
		this.maxDate.setDate(this.maxDate.getDate() + 7);
		this.bsRangeValue = [this.bsValue, this.maxDate];
	}
}

@Component({
	selector: 'ngbd-accordion-basic',
	templateUrl: "./main.component.html"
})

export class NgbdAccordionBasic {
}

@Component({
	templateUrl: "./main.component.html"
})

export class HomeComponent implements OnInit {

	today: number = Date.now();

	eventId: string;
	user: User;
	event: Event;
	status: Status = null;

	events: Event[] = [];
	users: User[] = [];

	constructor(private eventService: EventService, private userService: UserService, private jwtHelperService: JwtHelperService, private route: ActivatedRoute, private router: Router) {
	}

	ngOnInit(): void {
		this.getUser();
		this.listEvents()
	}

	getUser() {
		let userToken = this.jwtHelperService.decodeToken(localStorage.getItem("jwt-token"));
		let userId = userToken.auth.userId;
		this.userService.getUser(userId)
			.subscribe(user => this.user = user);
	}

	listEvents(): void {
		this.eventService.getAllEvents()
			.subscribe(events => {
				this.events = events;
				this.getUser();
			});
	}
}