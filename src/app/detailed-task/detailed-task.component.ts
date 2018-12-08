import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CommentService} from "../shared/services/comment.service";
import {TaskService} from "../shared/services/task.service";
import {UserService} from "../shared/services/user.service";
import {Status} from "../shared/interfaces/status";
import {User} from "../shared/interfaces/user";
import {Task} from "../shared/interfaces/task";
import {ActivatedRoute} from "@angular/router";

@Component({
	template: require("./detailed-task.component.html")
})

export class DetailedTaskComponent implements OnInit {
	status: Status = {status:null, message:null, type:null};
	task: Task = {taskId:null, taskEventId:null, taskUserId:null, taskDescription:null, taskDueDate:null, taskIsComplete:null, taskName:null};
	taskId: string = this.route.snapshot.params["taskId"];

	constructor(private commentService: CommentService, private taskService: TaskService, private userService: UserService, private formBuilder: FormBuilder, private route: ActivatedRoute) { }

	ngOnInit(): void {
		this.taskService.getTask(this.taskId).subscribe(task => this.task = task);
		//this.loadTask();
	}

}

