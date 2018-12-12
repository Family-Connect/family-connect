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
import {KitchenSink} from "../shared/interfaces/kitchenSink";
import {NgbModal, ModalDismissReasons} from "@ng-bootstrap/ng-bootstrap";


//Status and router
import {Status} from "../shared/interfaces/status";
import {ActivatedRoute} from "@angular/router";
import {forEach} from "@angular/router/src/utils/collection";
import {el} from "@angular/platform-browser/testing/src/browser_util";

@Component({
	template: require("./detailed-event.component.html")
})

export class DetailedEventComponent implements OnInit {
	user: User = {userId: null, userFamilyId:null, userAvatar:null, userDisplayName:null, userEmail:null, userPhoneNumber:null, userPrivilege:null};
	comment: Comment = {commentId: null, commentEventId: null, commentTaskId: null, commentUserId: null, commentContent: null, commentDate:null};
	userComments: UserComment[];
	task: Task = {taskId:null, taskEventId:null, taskUserId:null, taskDueDate:null, taskDescription:null, taskIsComplete:null, taskName:null};
	eventTasks: EventTask[];
	event: Event = {eventId:null, eventFamilyId:null, eventUserId:null, eventContent:null, eventEndDate:null, eventName:null, eventStartDate:null};
	kitchenSinks: KitchenSink[];
	eventId: string = this.route.snapshot.params["eventId"];
	commentOnEventForm: FormGroup;
	commentOnEventTaskForm: FormGroup;
	editEventForm: FormGroup;
	addTaskForm: FormGroup;
	closeResult: string;
	status: Status = {status: null, message: null, type: null};

	objectKeys = Object.keys;

	constructor(private commentService: CommentService, private eventService: EventService, private taskService: TaskService, private userService: UserService, private formBuilder: FormBuilder, private route: ActivatedRoute, private modalService: NgbModal) { }

	ngOnInit() : void {
		this.eventService.getEvent(this.eventId).subscribe(event => this.event = event);
		this.loadComments();
		this.loadTasks();
		this.loadTaskComments();

		this.commentOnEventForm = this.formBuilder.group({
			eventCommentContent : ["", [Validators.maxLength(855), Validators.required]]
		});

		this.commentOnEventTaskForm = this.formBuilder.group({
			eventTaskCommentContent : ["", [Validators.maxLength(855), Validators.required]]
		})
	}

	open(modalContent) {
		this.modalService.open(modalContent, {ariaLabelledBy: 'modal-basic-title'}).result.then((result) => {
			this.closeResult = `Closed with: ${result}`;
		}, (reason) => {
			this.closeResult = `Dismissed ${this.getDismissReason(reason)}`;
		});
	}

	private getDismissReason(reason: any): string {
		if (reason === ModalDismissReasons.ESC) {
			return 'by pressing ESC';
		} else if (reason === ModalDismissReasons.BACKDROP_CLICK) {
			return 'by clicking on a backdrop';
		} else {
			return  `with: ${reason}`;
		}
	}

	loadComments() : any {
		this.commentService.getCommentByEventId(this.eventId).subscribe(userComments => this.userComments = userComments);
	}

	loadTasks() : any {
		this.taskService.getTaskByEventId(this.eventId).subscribe(eventTasks => this.eventTasks = eventTasks);
	}

	loadTaskComments() : any {
		this.taskService.getTaskByEventId(this.eventId).subscribe(kitchenSinks => this.kitchenSinks = kitchenSinks);
	}

	editEvent() : any {
		let event: Event = {
			eventId: null,
			eventFamilyId: null,
			eventUserId: this.user.userId,
			eventContent: this.editEventForm.value.eventContentEdit,
			eventEndDate: this.editEventForm.value.eventEndEdit,
			eventStartDate: this.editEventForm.value.eventStartEdit,
			eventName: this.editEventForm.value.eventNameEdit
		};

		this.eventService.editEvent(event)
			.subscribe(status => {
				this.status = status;

				if(status.status === 200) {
					this.editEventForm.reset();
				} else {
					alert(status.message);
				}
			})

	}

	addTaskToEvent() : any {
		let task: Task = {
			taskId: null,
			taskEventId: this.eventId,
			taskUserId: this.user.userId,
			taskDescription: this.addTaskForm.value.taskDescriptionInsert,
			taskDueDate: this.addTaskForm.value.taskDueDateInsert,
			taskIsComplete: null,
			taskName: this.addTaskForm.value.taskNameInsert
		};

		this.taskService.createTask(task)
			.subscribe(status => {
				this.status = status;

				if(status.status === 200) {
					this.addTaskForm.reset();
				} else {
					alert(status.message);
				}
			})
	}

	commentOnEvent() : any {
		let comment: Comment = {
			commentId: null,
			commentEventId: this.eventId,
			commentTaskId: null,
			commentUserId: this.user.userId,
			commentContent: this.commentOnEventForm.value.eventCommentContent,
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

	commentOnEventTask() : any {
		let comment: Comment = {
			commentId: null,
			commentEventId: null,
			commentTaskId: this.task.taskId,
			commentUserId: this.user.userId,
			commentContent: this.commentOnEventForm.value.eventCommentContent,
			commentDate: null
		};

		this.commentService.createComment(comment)
			.subscribe(status => {
				this.status = status;

				if(status.status === 200) {
					this.commentOnEventTaskForm.reset();
					this.loadComments();
				} else {
					alert(status.message);
				}
			})
	}
}
