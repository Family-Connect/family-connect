import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";

import {Comment} from "../interfaces/comment";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs";


@Injectable()
export class PostService {
	constructor(protected http: HttpClient) {
	}

	//define the API endpoint
	private commentUrl = "apis/post/";

	// call to the comment API and delete the comment in question
	deleteComment(commentId: string): Observable<Status> {
		return (this.http.delete<Status>(this.commentUrl + commentId));
	}

	// call to the comment API and edit the comment in question
	editComment(comment: Comment): Observable<Status> {
		return (this.http.put<Status>(this.commentUrl + comment.commentId, comment));
	}

	// call to the comment API and creat the comment in question
	createComment(comment: Comment): Observable<Status> {
		return (this.http.post<Status>(this.commentUrl, +comment));
	}

	// call to the comment API and get a comment object based on its Id
	getComment(commentId: string): Observable<Comment> {
		return (this.http.get<Comment>(this.commentUrl + commentId));
	}

	// call to the comment API and get an array of comments based off the eventId
	getCommentbyEventId(commentEventId: string): Observable<any[]> {
		return (this.http.get<any[]>(this.commentUrl, {params: new HttpParams().set("commentEventId", commentEventId)}));
	}

	// call to the comment API and get an array of comments based off the taskId
	getCommentbyTaskId(commentTaskId: string): Observable<any[]> {
		return (this.http.get<any[]>(this.commentUrl, {params: new HttpParams().set("commentTaskId", commentTaskId)}));
	}

	// call to the comment API and get an array of commentss based off the userId
	getCommentbyUserId(commentUserId: string): Observable<any[]> {
		return (this.http.get<any[]>(this.commentUrl, {params: new HttpParams().set("commentUserId", commentUserId)}));
	}

	// call to the comment API and get an array of comments based off the profileId
	getCommentbyProfileId(commentProfileId: string): Observable<Comment[]> {
		return (this.http.get<Comment[]>(this.commentUrl, {params: new HttpParams().set("commentProfileId", commentProfileId)}));
	}

	// call to the comment API and get an array of comments based off the commentContent
	getCommentByContent(commentContent: string): Observable<Comment[]> {
		return (this.http.get<Comment[]>(this.commentUrl, {params: new HttpParams().set("commentContent", commentContent)}));
	}

}



