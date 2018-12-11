import {Component, OnInit} from "@angular/core";
import {UserService} from "../services/user.service";
import {FamilyService} from "../services/family.service";
import {Family} from "../interfaces/family";
import {User} from "../interfaces/user";

@Component({
	template: require("./sidebar.component.html"),
	selector: "sidebar"
})

export class SidebarComponent implements OnInit{
	users: User[];
	family: Family = {familyId:null, familyName:null};

	constructor(private userService: UserService, private familyService:FamilyService) {}

	ngOnInit() {
		this.userService.getUserByFamilyId('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe(users => this.users = users);
		//this.userService.getUserByFamilyId(this.jwt.auth.familyId).subscribe(users => this.users = users);
		this.familyService.getFamily('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe(family =>this.family = family);
		//this.familyService.getFamily(this.jwt.auth.familyId).subscribe(family =>this.family = family);
		this.loadUsers();
		//this.loadFamily();
	}

	loadUsers() : void {
		this.userService.getUserByFamilyId('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe(users => this.users = users)
	}

	loadFamily() : void {
		this.familyService.getFamily('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe();
	}

}