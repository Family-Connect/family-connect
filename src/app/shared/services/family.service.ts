import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Status} from "../interfaces/status";

import {Family} from "../interfaces/family";
import {Observable} from "rxjs";
import {User} from "../interfaces/user";

@Injectable()
export class FamilyService {
	constructor(protected http: HttpClient) { }

	// define the API endpoint
	private familyUrl = "api/family/";

	//call to the family API and delete the family in question
	deleteFamily(familyId: string): Observable<Status> {
		return (this.http.delete<Status>(this.familyUrl + familyId));
	}
	//call to the family API and edit the family in question
	editFamily(family: Family): Observable<Status> {
		return (this.http.put<Status>(this.familyUrl + family.familyId, family));
	}
	//call to the family API and create the family in question
	createFamily(family: Family): Observable<Status> {
		return (this.http.post<Status>(this.familyUrl, +family));
	}
	//call to the user API and get a user object based on its Id
	getFamily(familyId: string): Observable<Family> {
		return(this.http.get<Family>(this.familyUrl + familyId));
	}
}