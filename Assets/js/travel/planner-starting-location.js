class PlannerStartingLocation extends PlannerFieldSet {
  constructor() {
    super("startingLocation");
  }

  resetSectionOnFieldChange(field) {
    if(field === "country") {
      this.__removeField(this.__locationSelect);
      this.__removeField(this.__departureDateInput);
    }

    if(field === "location") {
      this.__removeField(this.__departureDateInput);
    }
  }
}
