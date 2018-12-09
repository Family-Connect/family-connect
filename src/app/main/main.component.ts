import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

import {Status} from "../shared/interfaces/status";
import {User} from "../shared/interfaces/user";

@Component({
	template: require("./main.component.html")
})

export class MainComponent implements OnInit {
	user: User = {userId:null, userFamilyId:null, userAvatar:null, userDisplayName:null, userEmail:null, userPhoneNumber:null};
	event:

}