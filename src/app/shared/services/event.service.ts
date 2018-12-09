import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";

import {Event} from "../interfaces/event";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs";


@Injectable()
export class EventService {
	constructor(protected http: HttpClient) {
	}

	//define the API endpoint
	private eventUrl = "api/event/";

	// call to the event API and delete the event in question
	deleteEvent(eventId: string): Observable<Status> {
		return (this.http.delete<Status>(this.eventUrl + eventId));
	}

	// call to the event API and edit the event in question
	editEvent(event: Event): Observable<Status> {
		return (this.http.put<Status>(this.eventUrl + event.eventId, event));
	}

	// call to the event API and creat the event in question
	createEvent(event: Event): Observable<Status> {
		return (this.http.post<Status>(this.eventUrl, +event));
	}

	// call to the event API and get a event object based on its Id
	getEvent(eventId: string): Observable<Event> {
		return (this.http.get<Event>(this.eventUrl + eventId));
	}

	// call to the event API and get an array of events based off the familyId
	getEventByFamilyId(eventFamilyId: string): Observable<any[]> {
		return (this.http.get<any[]>(this.eventUrl, {params: new HttpParams().set("eventFamilyId", eventFamilyId)}));
	}

	// call to the event API and get an array of events based off the userId
	getEventByUserId(eventUserId: string): Observable<any[]> {
		return (this.http.get<any[]>(this.eventUrl, {params: new HttpParams().set("eventUserId", eventUserId)}));
	}

	// call to the event API and get an array of events based off the event name
	getEventByEventName(eventName: string): Observable<any[]> {
		return (this.http.get<any[]>(this.eventUrl, {params: new HttpParams().set("eventName", eventName)}));
	}

	// call to the event API and get an array of events based off the eventContent
	getEventByContent(eventContent: string): Observable<Event[]> {
		return (this.http.get<Event[]>(this.eventUrl, {params: new HttpParams().set("eventContent", eventContent)}));
	}

	//call to the event API to get an array of events based off of the end date
	getEventByEndDate() : Observable<Event[]> {
		return(this.http.get<Event[]>(this.eventUrl));
	}

	//call to the event API to get an array of events based off of the start date
	getEventByStartDate() : Observable<Event[]> {
		return(this.http.get<Event[]>(this.eventUrl));
	}

}
