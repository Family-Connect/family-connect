import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";

import {Comment} from "../interfaces/comment";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs";


@Injectable()
export class TaskService {
	constructor(protected http: HttpClient) {
	}

	//define the API endpoint
	private taskUrl = "apis/post/";