import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";

import {Comment} from "../interfaces/comment";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs";


@Injectable()
export class EventService {
	constructor(protected http: HttpClient) {
	}

	//define the API endpoint
	private eventUrl = "apis/post/";

	// call to the event API and delete the event in question
	deleteEvent(eventId: string): Observable<Status> {
		return (this.http.delete<Status>(this.eventUrl + eventId));
	}

	// call to the event API and edit the event in question
	editEvent(event: Comment): Observable<Status> {
		return (this.http.put<Status>(this.eventUrl + event.commentId, event));
	}

	// call to the event API and creat the event in question
	createEvent(event: Comment): Observable<Status> {
		return (this.http.post<Status>(this.eventUrl, +event));
	}

	// call to the event API and get a event object based on its Id
	getEvent(eventId: string): Observable<Event> {
		return (this.http.get<Event>(this.eventUrl + eventId));
	}

