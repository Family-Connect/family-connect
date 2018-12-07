// interfaces are based on what the API wants, not the class
export interface Event {
	eventId: string,
	eventContent: string,
	eventEndDate: Date,
	eventFamilyId: string,
	eventName: string,
	eventStartDate: Date,
	eventUserId: string,
}