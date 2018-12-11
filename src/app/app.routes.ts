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
import {CommentService} from "./shared/services/comment.service";
import {EventService} from "./shared/services/event.service";
import {SignOutService} from "./shared/services/sign-out.service";
import {TaskService} from "./shared/services/task.service";
import {UserService} from "./shared/services/user.service";
import {DetailedTaskComponent} from "./detailed-task/detailed-task.component";
import {UserProfileComponent} from "./user-profile/user-profile.component";
import {FamilyService} from "./shared/services/family.service";
import {ProfilePrivilegeComponent} from "./profile-privilege/profile-privilege.component";
import {SidebarComponent} from "./shared/components/sidebar.component";


export const allAppComponents = [SplashComponent, MainComponent, DetailedEventComponent, DetailedTaskComponent, UserProfileComponent, ProfilePrivilegeComponent, SidebarComponent];

export const routes: Routes = [
	{path: "main", component: MainComponent},
	{path: "detailed-event/:eventId", component: DetailedEventComponent},
	{path: "detailed-task/:taskId", component: DetailedTaskComponent},
	{path: "user-profile/:userId", component: UserProfileComponent},
	{path: "profile-privilege", component: ProfilePrivilegeComponent},
	{path: "", component: SplashComponent}

];

const services: any[] = [SessionService, SignUpService, SignInService, CommentService, EventService, SignOutService, TaskService, UserService, FamilyService];

const providers: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true}
];

export const appRoutingProviders: any[] = [providers, services];

export const routing = RouterModule.forRoot(routes);