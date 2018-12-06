import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";

import {Comment} from "../interfaces/comment";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs";


@Injectable()
export class UserService {
	constructor(protected http: HttpClient) {
	}

	//define the API endpoint
	private userUrl = "api/post/";

}