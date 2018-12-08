import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CommentService} from "../shared/services/comment.service";
import {EventService} from "../shared/services/event.service";
import {TaskService} from "../shared/services/task.service";
import {UserService} from "../shared/services/user.service";
import {Status} from "../shared/interfaces/status";
import {User} from "../shared/interfaces/user";

@Component({
	template: require("./detailed-event.component.html")
})

export class DetailedEventComponent implements OnInit{
	users: User[];
	status: Status = {status:null, message:null, type:null};

	constructor(private commentService: CommentService, private eventService: EventService, private taskService: TaskService, private userService: UserService, private formBuilder: FormBuilder) {}

		ngOnInit() {
			this.userService.getUserByFamilyId('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe(users => this.users = users);
			this.loadUsers()
		}

		loadUsers() : void {
			this.userService.getUserByFamilyId('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe(users => this.users = users)
		}

}