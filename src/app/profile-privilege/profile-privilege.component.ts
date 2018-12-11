import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {UserService} from "../shared/services/user.service";
import {User} from "../shared/interfaces/user";
import {Status} from "../shared/interfaces/status";

@Component({
	template: require("./profile-privilege.html")
})

export class ProfilePrivilegeComponent implements OnInit {
	userForm: FormGroup;
	deleted: boolean = false;
	user: User;
	users: User[] = [];
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private userService: UserService, private router: Router, private route: ActivatedRoute) {}

	// @ts-ignore
	ngOnInit() : void {
		this.route.params.forEach((params : Params) => {
			let userId = params["userId"];
			this.userService.getUser(userId)
				.subscribe(user => {
					this.user = user;
					this.userForm.patchValue(user);
				});
		});
	}

	// @ts-ignore
	ngOnInit() : void {
		this.reloadUsers();
		this.userForm = this.formBuilder.group({
			attribution: ["", [Validators.maxLength(64), Validators.required]],
			user: ["", [Validators.maxLength(255), Validators.required]],
			submitter: ["", [Validators.maxLength(64), Validators.required]]
			});
		this.applyFromChanges();
	}

	applyFormChanges() : void {
		this.userForm.valueChanges.subscribe(values => {
			for(let field in values) {
				this.user[field] = values[field];
			}
		});
	}

	deleteUser() : void {
		this.userService.deleteUser(this.user.userId)
			.subscribe(status => {
				this.status = status;
				// @ts-ignore
				if(this.status === 200){
					this.deleted = true;
					// @ts-ignore
					this.user = {userId: null, attribution: null, user: null, submitter: null};
				}
			});
	}

	editUser() : void {
		// @ts-ignore
		this.userService.editUser(this.user)
			.subscribe(status => this.user =status);
	}

	reloadUsers() : void {
		this.userService.getAllUsers()
			.subscribe(users => this.users = users);
	}

	switchUser(user : User) : void {
		this.router.naviagate(["/user/", user.userId]);
	}

	createUser() :  void {
		let user = {userId: null, atrribution: this.userForm.value.attribution, user: this.userForm.value.user, submitter: this.userForm.value.submitter};
		// @ts-ignore
		this.userService.createUser(user)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadUsers();
					this.reloadUsers.reset();
				}
			});
	}
}