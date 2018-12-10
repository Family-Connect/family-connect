import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

import {EventService} from "../shared/services/event.service";
import {TaskService} from "../shared/services/task.service";
import {UserService} from "../shared/services/user.service";

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
	event: Event = {eventId:null, eventFamilyId:null, eventUserId:null, eventContent:null, eventEndDate:null, eventName:null, eventStartDate:null};
	events: Event[]
	userId: string = this.route.snapshot.params["userId"];
	status: Status = {status:null, message:null, type:null};




	constructor(private eventService: EventService, private taskService: TaskService, private userService: UserService, private formBuilder: FormBuilder, private route: ActivatedRoute) { }

	ngOnInit(): void {
		this.userService.getUser(this.userId).subscribe(user => this.user = user);
		this.loadEvents();
		this.loadTasks();
	}

	loadEvents() : any {
		this.eventService.getEventByUserId(this.userId).subscribe(events => this.events = events)
	}


}

