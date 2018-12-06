// interfaces are based on what the API wants, not the class
export interface Event {
	eventId: string,
	eventContent: string,
	eventDate: Date,
	eventName: string,
	eventUserId: string,
}