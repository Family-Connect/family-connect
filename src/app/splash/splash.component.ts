import {Component, OnInit} from "@angular/core";
import {SignUp} from "../shared/interfaces/sign-up";
import {Status} from "../shared/interfaces/status";
import {SignIn} from "../shared/interfaces/sign-in";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {SignUpService} from "../shared/services/sign-up.service";
import {SignInService} from "../shared/services/sign-in.service";

@Component({
	template: require("./splash.component.html")
})

export class SplashComponent implements OnInit {
	signUp: SignUp;
	signUpForm: FormGroup;
	signInForm: FormGroup;
	status: Status = {status:null, message:null, type:null};

	constructor(private signUpService: SignUpService, private signInService : SignInService, private formBuilder : FormBuilder) {}

	ngOnInit() {
		this.signUpForm = this.formBuilder.group({
			userEmail:["", [Validators.maxLength(128), Validators.required]],
			userDisplayName:["", [Validators.maxLength(32), Validators.required]],
			userPhoneNumber:["", [Validators.maxLength(32), Validators.required]],
			userPassword:["", [Validators.maxLength(97), Validators.required]],
			userPasswordConfirm:["", [Validators.maxLength(97), Validators.required]],
			userFamilyId:["", [Validators.maxLength(16), Validators.required]],
		});

		this.signInForm = this.formBuilder.group({
			userEmail: ["", [Validators.maxLength(128), Validators.required]],
			userPassword: ["", [Validators.maxLength(97), Validators.required]]
		})
	}

	createUser() : void {
		let user : SignUp = {userEmail: this.signUpForm.value.userEmail, userDisplayName: this.signUpForm.value.userDisplayName, userPhoneNumber:this.signUpForm.value.userPhoneNumber, userPassword:this.signUpForm.value.userPassword, userPasswordConfirm:this.signUpForm.value.userPasswordConfirm, userFamilyId:this.signUpForm.value.userFamilyId};

		this.signUpService.createUser(user)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert(status.message);
				}
			});
	}

	signIn() : void {
		let user: SignIn = {userEmail: this.signInForm.value.userEmail, userPassword: this.signInForm.value.userPassword};

		this.signInService.postSignIn(user)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert(status.message);
				}
			});
	}

}