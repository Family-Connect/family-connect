import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {UserService} from "../shared/services/user.service";
import {Status} from "../shared/interfaces/status";
import {User} from "../shared/interfaces/user";

@Component({
	template: require("./profile-privilege.component.html")
})

export class ProfilePrivilegeComponent implements OnInit {
	users: User [];
	status: Status = {status: null, message: null, type:null};

	constructor(private userService: UserService, private formBuilder: FormBuilder) {}

	ngOnInit() {
		this.userService.getUserByFamilyId('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe(users => this.users = users);
		this.loadUsers()
	}

	loadUsers() : void {
		this.userService.getUserByFamilyId('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe(users => this.users = users)
	}

}
