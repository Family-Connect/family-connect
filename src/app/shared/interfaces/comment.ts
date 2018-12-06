// interfaces are based on what the API wants, not the class
export interface Comment {
	commentId: string,
	commentEventId: string,
	commentTaskId: string,
	commentUserId: string,
	commentContent: string,
	commentDate: Date,
}