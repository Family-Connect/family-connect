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

//Status and router
import {Status} from "../shared/interfaces/status";
import {ActivatedRoute} from "@angular/router";

@Component({
	template: require("./detailed-event.component.html")
})

export class DetailedEventComponent implements OnInit {
	user: User = {userId: null, userFamilyId:null, userAvatar:null, userDisplayName:null, userEmail:null, userPhoneNumber:null};
	comment: Comment = {commentId: null, commentEventId: null, commentTaskId: null, commentUserId: null, commentContent: null, commentDate:null};
	comments: Comment[];
	event: Event = {eventId:null, eventFamilyId:null, eventUserId:null, eventContent:null, eventEndDate:null, eventName:null, eventStartDate:null};
	eventId: string = this.route.snapshot.params["eventId"];
	commentOnEventForm: FormGroup;
	status: Status = {status: null, message: null, type: null};

	constructor(private commentService: CommentService, private eventService: EventService, private taskService: TaskService, private userService: UserService, private formBuilder: FormBuilder, private route: ActivatedRoute) { }

	ngOnInit() : void {
		this.eventService.getEvent(this.eventId).subscribe(event => this.event = event);

		this.commentOnEventForm = this.formBuilder.group({
			commentContent : ["", [Validators.maxLength(855), Validators.required]]
		})
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

				// if(status.status === 200) {
				// 	this.commentOnEventForm.reset();
				// 	this.loadComments();
				// } else {
				// 	alert(status.message);
				// }
			})
	}
}
