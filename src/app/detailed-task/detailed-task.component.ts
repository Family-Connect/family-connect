import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

// Service needed
import {CommentService} from "../shared/services/comment.service";
import {TaskService} from "../shared/services/task.service";
import {UserService} from "../shared/services/user.service";

// Interfaces needed
import {Status} from "../shared/interfaces/status";
import {User} from "../shared/interfaces/user";
import {Task} from "../shared/interfaces/task";
import {Comment} from "../shared/interfaces/comment";
import {UserComment} from "../shared/interfaces/UserComment";

// Status and routher
import {ActivatedRoute} from "@angular/router";

@Component({
	template: require("./detailed-task.component.html")
})

export class DetailedTaskComponent implements OnInit {
	user: User = {userId: null, userFamilyId:null, userAvatar:null, userDisplayName:null, userEmail:null, userPhoneNumber:null, userPrivilege:null};
	comment: Comment = {commentId: null, commentEventId: null, commentTaskId: null, commentUserId: null, commentContent: null, commentDate:null};
	userComments: UserComment[];
	task: Task = {taskId:null, taskEventId:null, taskUserId:null, taskDescription:null, taskDueDate:null, taskIsComplete:null, taskName:null};
	taskId: string = this.route.snapshot.params["taskId"];
	commentOnTaskForm: FormGroup;
	status: Status = {status:null, message:null, type:null};

	constructor(private commentService: CommentService, private taskService: TaskService, private userService: UserService, private formBuilder: FormBuilder, private route: ActivatedRoute) { }

	ngOnInit(): void {
		this.taskService.getTask(this.taskId).subscribe(task => this.task = task);
		this.loadComments();

		this.commentOnTaskForm = this.formBuilder.group({
			taskCommentContent : ["", [Validators.maxLength(855), Validators.required]]
		})
	}

	loadComments() : any {
		this.commentService.getCommentByTaskId(this.taskId).subscribe(userComments => this.userComments = userComments);
	}

	commentOnTask() : any {
		let comment: Comment = {
			commentId: null,
			commentEventId: null,
			commentTaskId: this.task.taskId,
			commentUserId: this.user.userId,
			commentContent: this.commentOnTaskForm.value.commentContent,
			commentDate: null
		};

		this.commentService.createComment(comment)
			.subscribe(status => {
				this.status = status;

				if(status.status === 200) {
					this.commentOnTaskForm.reset();
					this.loadComments();
				} else {
					alert(status.message);
				}
			})
	}

}

