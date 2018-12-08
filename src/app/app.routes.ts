import {RouterModule, Routes} from "@angular/router";
import {SplashComponent} from "./splash/splash.component";
import {APP_BASE_HREF} from "@angular/common";
import {DeepDiveInterceptor} from "./shared/interceptors/deep.dive.interceptor";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {SessionService} from "./shared/services/session.service";
import {SignUpService} from "./shared/services/sign-up.service";
import {SignInService} from "./shared/services/sign-in.service";
import {MainComponent} from "./main/main.component";
import {DetailedEventComponent} from "./detailed-event/detailed-event.component";


export const allAppComponents = [SplashComponent, MainComponent, DetailedEventComponent];

export const routes: Routes = [
	{path: "", component: SplashComponent},
	{path: "main", component: MainComponent},
	{path: "detailed-event", component: DetailedEventComponent}
];

const services: any[] = [SessionService, SignUpService, SignInService];

const providers: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true}
];

export const appRoutingProviders: any[] = [providers, services];

export const routing = RouterModule.forRoot(routes);