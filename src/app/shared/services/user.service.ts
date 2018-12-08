import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {HttpParams} from "@angular/common/http";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs";
import {User} from "../interfaces/user";


@Injectable()
export class UserService {
	constructor(protected http: HttpClient) {
	}

	//define the API endpoint
	private userUrl = "api/user/";

	//call to the user API and delete the user in question
	deleteUser(userId: string): Observable<Status> {
		return (this.http.delete<Status>(this.userUrl + userId));
	}
	//call to the user API and edit the user in question
	editUser(user: User): Observable<Status> {
		return (this.http.put<Status>(this.userUrl + user.userId, user));
	}
	//call to the user API and create the user in question
	createUser(user: User): Observable<Status> {
		return(this.http.post<Status>(this.userUrl, + user));
	}
	//call to the user API and get a user object based on its Id
	getUser(userId: string): Observable<User> {
		return(this.http.get<User>(this.userUrl + userId));
	}
	// call to the user API and get an array of users based off the familyId
	getUserByFamilyId(userFamilyId: string): Observable<any[]> {
		return (this.http.get<any[]>(this.userUrl, {params: new HttpParams().set("userFamilyId", userFamilyId)}));
	}
	getUserAvatar(userAvatar: string): Observable<User> {
		return(this.http.get<User>(this.userUrl + userAvatar));
	}
	//call to the user API and get a user object based on its Email
	getUserEmail(userEmail: string): Observable<User> {
		return(this.http.get<User>(this.userUrl + userEmail));
	}
	//call to the user API and get a user object based on its Display Name
	getUserDisplayName(userDisplayName: string): Observable<User> {
		return(this.http.get<User>(this.userUrl + userDisplayName));
	}
	//call to the user API and get a user object based on its Phone Number
	getUserPhoneNumber(userPhoneNumber: string): Observable<User> {
		return(this.http.get<User>(this.userUrl + userPhoneNumber));
	}
}