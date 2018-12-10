import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {TaskService} from "../shared/services/task.service";
import {UserService} from "../shared/services/user.service";
import {Status} from "../shared/interfaces/status";
import {User} from "../shared/interfaces/user";
import {Task} from "../shared/interfaces/task";
import {Event} from "../shared/interfaces/event";
import {ActivatedRoute} from "@angular/router";
import {EventService} from "../shared/services/event.service";
import {JwtHelperService} from "@auth0/angular-jwt";

@Component({
	template: require("./main.component.html")
})

export class MainComponent implements OnInit {
	user: User = {userId:null, userFamilyId:null, userAvatar:null, userDisplayName:null, userEmail:null, userPhoneNumber:null};
	event: Event = {eventId:null, eventFamilyId:null, eventUserId:null, eventContent:null, eventEndDate:null, eventName:null, eventStartDate:null};
	eventId: string = this.route.snapshot.params["eventId"];
	task: Task = {taskId:null, taskEventId:null, taskUserId:null, taskDescription:null, taskDueDate:null, taskIsComplete:null, taskName:null};
	taskId: string = this.route.snapshot.params["taskId"];
	events: Event[];

	jwt = this.jwtHelperService.decodeToken(window.localStorage.getItem("jwt-token"));

	constructor(private userService: UserService, private eventService: EventService, private taskService: TaskService, private route : ActivatedRoute,private jwtHelperService: JwtHelperService){ }

	ngOnInit(): void {
		this.taskService.getTaskByFamilyId(this.jwt.auth.taskId).subscribe(task => this.task = task);
		this.loadTasks();


		this.eventService.getEventByFamilyId(this.jwt.auth.familyId).subscribe(event => this.events = event);
	}

		loadTasks() : any {
			this.taskService.getTask(this.taskId).subscribe(tasks => this.task = tasks);
		}

		loadEvents() : any {
			this.eventService.getEventByFamilyId(this.eventId).subscribe(events => this.events = events);
		}

		justMe() : any {
			this.eventService.getEventByUserId(this.jwt.auth.userId).subscribe(events => this.events = events);
		}
}