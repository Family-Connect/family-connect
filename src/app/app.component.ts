import {Component} from "@angular/core";
import {SessionService} from "./shared/services/session.services";
import {Status} from "./shared/interfaces/status";

@Component({
	selector: "angular-example-app",
	template: require("./app.component.html")
})

export class AppComponent {
	status: Status = null;

	constructor(private sessionService : SessionService) {
		this.sessionService.setSession().subscribe(status => this.status = status);
	}
}