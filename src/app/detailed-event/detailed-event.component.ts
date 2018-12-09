import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

// Services needed
import {CommentService} from "../shared/services/comment.service";
import {EventService} from "../shared/services/event.service";
import {TaskService} from "../shared/services/task.service";
import {UserService} from "../shared/services/user.service";

// Interfaces used
import {Event} from "../shared/interfaces/event";
import {Comment} from "../shared/interfaces/comment";
import {User} from "../shared/interfaces/user";
import {Task} from "../shared/interfaces/task";
import {UserComment} from "../shared/interfaces/UserComment";
import {EventTask} from "../shared/interfaces/EventTask";

//Status and router
import {Status} from "../shared/interfaces/status";
import {ActivatedRoute} from "@angular/router";

@Component({
	template: require("./detailed-event.component.html")
})

export class DetailedEventComponent implements OnInit {
	user: User = {userId: null, userFamilyId:null, userAvatar:null, userDisplayName:null, userEmail:null, userPhoneNumber:null};
	comment: Comment = {commentId: null, commentEventId: null, commentTaskId: null, commentUserId: null, commentContent: null, commentDate:null};
	userComments: UserComment[];
	task: Task = {taskId:null, taskEventId:null, taskUserId:null, taskDueDate:null, taskDescription:null, taskIsComplete:null, taskName:null};
	eventTasks: EventTask[];
	event: Event = {eventId:null, eventFamilyId:null, eventUserId:null, eventContent:null, eventEndDate:null, eventName:null, eventStartDate:null};
	eventId: string = this.route.snapshot.params["eventId"];
	commentOnEventForm: FormGroup;
	status: Status = {status: null, message: null, type: null};

	constructor(private commentService: CommentService, private eventService: EventService, private taskService: TaskService, private userService: UserService, private formBuilder: FormBuilder, private route: ActivatedRoute) { }

	ngOnInit() : void {
		this.eventService.getEvent(this.eventId).subscribe(event => this.event = event);
		this.loadComments();
		this.loadTasks();

		this.commentOnEventForm = this.formBuilder.group({
			eventCommentContent : ["", [Validators.maxLength(855), Validators.required]]
		})
	}

	loadComments() : any {
		this.commentService.getCommentByEventId(this.eventId).subscribe(userComments => this.userComments = userComments);
	}

	loadTasks() : any {
		this.taskService.getTaskByEventId(this.eventId).subscribe(eventTasks => this.eventTasks = eventTasks);
	}

	commentOnEvent() : any {
		let comment: Comment = {
			commentId: null,
			commentEventId: this.eventId,
			commentTaskId: null,
			commentUserId: this.user.userId,
			commentContent: this.commentOnEventForm.value.commentContent,
			commentDate: null
		};

		this.commentService.createComment(comment)
			.subscribe(status => {
				this.status = status;

				if(status.status === 200) {
					this.commentOnEventForm.reset();
					this.loadComments();
				} else {
					alert(status.message);
				}
			})
	}
}
