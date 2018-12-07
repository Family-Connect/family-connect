import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";

import {Comment} from "../interfaces/comment";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs";
import {Task} from "../interfaces/task";


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
	editTask(task: Task): Observable<status> {
		return (this.http.put<Status>(this.taskUrl + task.taskId, task));
	}

	//call to the task API and create the task in question
	createTask(task: Task): Observable<Status> {
		return (this.http.post<Status>(this.taskUrl, +task));
	}

	//call to the task API and get a task object based on its Id
	getTask(taskId: string): Observable<Task> {
		return (this.http.get<Task>(this.taskUrl + taskId));
	}



}