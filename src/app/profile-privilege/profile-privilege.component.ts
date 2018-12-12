import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {FormBuilder, FormGroup, Validators, FormControl} from "@angular/forms";
import {Router} from "@angular/router";
import {UserService} from "../shared/services/user.service";
import {User} from "../shared/interfaces/user";
import {Status} from "../shared/interfaces/status"
import {JwtHelperService} from "@auth0/angular-jwt";

declare const $: any;

@Component({
	template: require("./profile-privilege.component.html")
})

export class ProfilePrivilegeComponent implements OnInit {
	userForm: FormGroup;
	deleted: boolean = false;
	user: User = {userId: null, userFamilyId:null, userAvatar:null, userDisplayName:null, userEmail:null, userPhoneNumber:null, userPrivilege:null};
	users: User[];
	status: Status = null;
	userAvatar: any;
	showForm: boolean = false;

	constructor(private formBuilder: FormBuilder, private userService: UserService, private router: Router, private route: ActivatedRoute, private jwtHelperService : JwtHelperService) {
	}

	// @ts-ignore
	ngOnInit(): void {
		//this.reloadUsers();

		this.userService.getUserByFamilyId('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe(users => this.users = users);

		this.userForm = this.formBuilder.group({
			userDisplayName: ["", [Validators.maxLength(64), Validators.required]],
			userPrivilege: [""],
			userPhoneNumber: ["", [Validators.maxLength(32), Validators.required]],
			userEmail: ["", [Validators.maxLength(255),Validators.required]]
		});

		// 	this.applyFormChanges();
	}


	deleteUser(): void {
		this.userService.deleteUser(this.user.userId)
			.subscribe(status => {
				this.status = status;
				// @ts-ignore
				if(this.status === 200) {
					this.deleted = true;
					// @ts-ignore
					this.user = {userId: null, attribution: null, user: null, submitter: null};
				}
			});
	}

	editUser(user : User): void {

		let editUser: User = {
			userId: user.userId,
			userFamilyId: this.jwtHelperService.decodeToken(localStorage.getItem("jwt-token")),
			userPhoneNumber: this.userForm.value.userPhoneNumber,
			userEmail: this.userForm.value.userEmail,
			userDisplayName: this.userForm.value.userDisplayName,
			userAvatar: "http:http.cat/404",
			userPrivilege: this.userForm.value.userPrivilege


		};
		this.userService.editUser(this.user)
			.subscribe(status => this.status = status);
	}


}