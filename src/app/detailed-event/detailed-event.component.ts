import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CommentService} from "../shared/services/comment.service";
import {EventService} from "../shared/services/event.service";
import {TaskService} from "../shared/services/task.service";
import {UserService} from "../shared/services/user.service";
import {FamilyService} from "../shared/services/family.service";
import {Status} from "../shared/interfaces/status";
import {User} from "../shared/interfaces/user";
import {Family} from "../shared/interfaces/family";

@Component({
	template: require("./detailed-event.component.html")
})

export class DetailedEventComponent implements OnInit{
	users: User[];
	comments : Comment[];
	family: Family = {familyId: null, familyName: null};
	event: Event = {eventId:null, eventContent: null, eventEndDate: null, eventFamilyId:null, eventName: null, eventStartDate: null, eventUserId: null};
	status: Status = {status:null, message:null, type:null};

	constructor(private commentService: CommentService, private eventService: EventService, private taskService: TaskService, private userService: UserService, private familyService: FamilyService, private formBuilder: FormBuilder) {}

	ngOnInit() {
		this.userService.getUserByFamilyId('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe(users => this.users = users);
		this.familyService.getFamily('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe();
		this.eventService.getEvent().subscribe();

		this.loadEvent();
		this.loadUsers();
		this.loadFamily();
	}

		loadUsers() : void {
			this.userService.getUserByFamilyId('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe(users => this.users = users)
		}

		loadFamily() : void {
			this.familyService.getFamily('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe();
		}

		loadEvent() : void {
			this.eventService.getEvent().subscribe()
		}



}