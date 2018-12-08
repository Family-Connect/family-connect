import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {EventService} from "../shared/services/event.service";
import {TaskService} from "../shared/services/task.service";
import {UserService} from "../shared/services/user.service";
import {Status} from "../shared/interfaces/status";
import {User} from "../shared/interfaces/user";

@Component({
	template: require("./profile-edit.component.html")
})

export class ProfileEditComponent implements OnInit {
	status: Status = {status:null, message:null, type:null};

	constructor(private eventService: EventService, private taskService: TaskService, private userService: UserService, private formBuilder: FormBuilder) { }

	ngOnInit(): void {
	}

}

