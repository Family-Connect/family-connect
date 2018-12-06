import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";

import {Comment} from "../interfaces/comment";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs";


@Injectable()
export class PostService {
	constructor(protected http: HttpClient) {
	}

	private postUrl = "apis/post/";

	getAllComments() : Observable<Comment[]> {
		return(this.http.get<Comment[]>(this.postUrl));
	}

	getCommentByCommentId(postId : number) : Observable<Comment> {
		return(this.http.get<Comment>(this.postUrl +postId));
	}

	createComment(post : Comment) : Observable<Status> {
		return(this.http.post<Status>(this.postUrl, +post)
		);
	}
}
