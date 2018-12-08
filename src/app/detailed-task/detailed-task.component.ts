import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CommentService} from "../shared/services/comment.service";
import {TaskService} from "../shared/services/task.service";
import {UserService} from "../shared/services/user.service";
import {Status} from "../shared/interfaces/status";
import {User} from "../shared/interfaces/user";

@Component({
	template: require("./detailed-task.component.html")
})

export class DetailedTaskComponent implements OnInit {
	status: Status = {status:null, message:null, type:null};

	constructor(private commentService: CommentService, private taskService: TaskService, private userService: UserService, private formBuilder: FormBuilder) { }

	ngOnInit(): void {
	}

}

