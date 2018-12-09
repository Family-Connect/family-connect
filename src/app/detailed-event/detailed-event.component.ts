import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CommentService} from "../shared/services/comment.service";
import {EventService} from "../shared/services/event.service";
import {TaskService} from "../shared/services/task.service";
import {UserService} from "../shared/services/user.service";
import {Status} from "../shared/interfaces/status";
import {Event} from "../shared/interfaces/event";
import {Comment} from "../shared/interfaces/comment";
import {ActivatedRoute} from "@angular/router";

@Component({
	template: require("./detailed-event.component.html")
})

export class DetailedEventComponent implements OnInit {
	status: Status = {status: null, message: null, type: null};
	comments: Comment[];
	event: Event = {eventId:null, eventFamilyId:null, eventUserId:null, eventContent:null, eventEndDate:null, eventName:null, eventStartDate:null};
	eventId: string = this.route.snapshot.params["eventId"];

	constructor(private commentService: CommentService, private eventService: EventService, private taskService: TaskService, private userService: UserService, private formBuilder: FormBuilder, private route: ActivatedRoute) { }

	ngOnInit() : void {
		this.eventService.getEvent(this.eventId).subscribe(event => this.event = event);
	}

}
