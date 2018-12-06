// interfaces are based on what the API wants, not the class
export interface Task {
	taskId: string,
	taskDescription: string,
	taskDueDate: Date,
	taskEventId: string,
	taskIsComplete: string,
	taskName: string,
	taskUserId: string,
}