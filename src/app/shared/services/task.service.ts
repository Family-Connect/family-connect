import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";

import {Task} from "../interfaces/task";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs";


@Injectable()
export class TaskService {
	constructor(protected http: HttpClient) {
	}

	//define the API endpoint
	private taskUrl = "api/post/";

	// call to the task API and delete the task in question
	deleteTask(taskId: string): Observable<Status> {
		return (this.http.delete<Status>(this.taskUrl + taskId));
	}

	//call to the task API and edit the task in question
	editTask(task: Task): Observable<Status> {
		return (this.http.put<Status>(this.taskUrl + task.taskId, task));
	}

	//call to the task API and create the task in question
	createTask(task: Task): Observable<Status> {
		return (this.http.post<Status>(this.taskUrl, + task));
	}

	//call to the task API and get a task object based on its Id
	getTask(taskId: string): Observable<Task> {
		return (this.http.get<Task>(this.taskUrl + taskId));
	}

// call to the task API and get an array of tasks based off the eventId
	getTaskByEventId(taskEventId: string): Observable<any[]> {
		return (this.http.get<any[]>(this.taskUrl, {params: new HttpParams().set("taskEventId", taskEventId)}));
	}

	// call to the task API and get an array of tasks based off the userId
	getTaskByUserId(taskUserId: string) : Observable<any[]> {
		return (this.http.get<any[]>(this.taskUrl, {params: new HttpParams().set("taskUserId", taskUserId)}));
	}

	//call to the task API and get an array of tasks based off the taskDescription
	getTaskByTaskDescription(taskDescription: string): Observable<Task[]> {
		return (this.http.get<Task[]>(this.taskUrl, {params: new HttpParams().set("taskDescription", taskDescription)}));
	}

	//call to the task API and get an array of tasks based off the taskDueDate
	getTaskByTaskDueDate(taskDueDate: string): Observable<Task[]> {
		return (this.http.get<Task[]>(this.taskUrl, {params: new HttpParams().set("taskDueDate", taskDueDate)}));
	}

	//call to the task API and get an array of tasks based off the taskEndInterval
	getTaskByTaskEndInterval(taskEndInterval: string): Observable<Task[]> {
		return (this.http.get<Task[]>(this.taskUrl, {params: new HttpParams().set("taskEndInterval", taskEndInterval)}));
	}

	//call to the task API and get an array of tasks based off of taskIsComplete
	getTaskByTaskIsComplete(taskIsComplete: string): Observable<Task[]> {
		return (this.http.get<Task[]>(this.taskUrl, {params: new HttpParams().set("taskIsComplete", taskIsComplete)}));
	}

	//call to the task API and get an array of tasks based off the taskName
	getTaskByTaskName(taskName: string): Observable<Task[]> {
		return (this.http.get<Task[]>(this.taskUrl, {params: new HttpParams().set("taskName", taskName)}));
	}

//call to the task API and get an array of tasks based off the taskStartInterval
	getTaskByTaskStartInterval(taskStartInterval: string): Observable<Task[]> {
		return (this.http.get<Task[]>(this.taskUrl, {params: new HttpParams().set("taskStartInterval", taskStartInterval)}));
	}

}