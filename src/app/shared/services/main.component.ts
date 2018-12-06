import {Component} from "@angular/core";
import {AuthService} from "../shared/services/auth.service";
import {ProfileService} from "../shared/services/profile.service";
import {ActivatedRoute} from "@angular/router";


@Component ({
	template: require("./main.template.html"),
	selector: "main"
})

export class MainComponent {
	isAuthenticated: boolean;

	constructor(
		protected authService: AuthService,
		protected route: ActivatedRoute
	) {
	};

	ngOnInit() {
		//set session storage for sign in purposes
		this.route.url.subscribe(route => window.sessionStorage.setItem("url", JSON.stringify(route)));
		this.isAuthenticated = this.authService.isAuthenticated();
	};

}