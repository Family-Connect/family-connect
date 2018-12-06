import {Injectable} from "@angular/core";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs";
import {SignUp} from "../interfaces/sign-up";
import {HttpClient} from "@angular/common/http";
import {Family} from "../interfaces/family";

@Injectable()
export class SignUpService {
	constructor(protected http: HttpClient) {

	}

	private signUpUrl = "api/sign-up/";

	createFamily(family: Family) : Observable<Status> {
		return(this.http.post<Status>(this.signUpUrl, family));
	}

	createUser(signUp: SignUp) : Observable<Status> {
		return(this.http.post<Status>(this.signUpUrl, signUp));
	}
}