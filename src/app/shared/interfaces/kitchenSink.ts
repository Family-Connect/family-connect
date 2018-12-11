import {Task} from "./task";
import {Comment} from "./comment"

export interface KitchenSink {
	task: Task,
	userDisplayName: string,
	comments: Comment[]

}