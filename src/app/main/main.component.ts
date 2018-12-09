import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {TaskService} from "../shared/services/task.service";
import {UserService} from "../shared/services/user.service";
import {Status} from "../shared/interfaces/status";
import {User} from "../shared/interfaces/user";
import {Task} from "../shared/interfaces/task";
import {ActivatedRoute} from "@angular/router";
import {TaskData} from "@angular/core/src/testability/testability";
import {EventService} from "../shared/services/event.service";

@Component({
	template: require("./main.component.html")
})

export class MainComponent implements OnInit {
	user: User = {userId:null, userFamilyId:null, userAvatar:null, userDisplayName:null, userEmail:null, userPhoneNumber:null};
	event: Event = {eventId:null, eventUserId:null, eventContent:null, eventEndDate:null, eventName:null, eventStartDate:null};
	eventId: string = this.route.snapshot.params["eventId"];
	task: Task = {taskId:null, taskEventId:null, taskUserId:null, taskDescription:null, taskDueDate:null, taskName:null};
	taskId: string = this.route.snapshot.params["taskId"];

	constructor(private userService: UserService, private eventService: EventService, private taskService: TaskService){ }

	ngOnInit(): void {
		this.taskService.getTask(this.taskId).subscribe(task => this.task = task);
		this.loadTasks();

		this.eventService.getEvent(this.eventId).subscribe(event => this.event = event);
	}

		loadTasks() : any {
			this.taskService.getTaskByTaskId(this.taskId).subscribe(tasks => this.tasks = tasks);
		}

		loadEvents() : any {
			this.eventService.getEventByEventId(this.eventId).subscribe(events => this.events = events);
		}
}