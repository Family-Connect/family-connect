import {Component, OnInit} from "@angular/core";
import {UserService} from "../services/user.service";
import {FamilyService} from "../services/family.service";
import {Family} from "../interfaces/family";
import {User} from "../interfaces/user";

@Component({
	template: require("./sidebar.component.html")
})

export class DetailedEventComponent implements OnInit{
	users: User[];
	family: Family;

	constructor(private userService: UserService, private familyService:FamilyService) {}

	ngOnInit() {
		this.userService.getUserByFamilyId('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe(users => this.users = users);
		this.familyService.getFamily('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe();
		this.loadUsers();
		this.loadFamily();
	}

	loadUsers() : void {
		this.userService.getUserByFamilyId('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe(users => this.users = users)
	}

	loadFamily() : void {
		this.familyService.getFamily('6fa65d66-a7c0-4650-b716-e4d482e48dc9').subscribe();
	}

}