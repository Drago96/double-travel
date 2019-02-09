class PlannerNextLocation extends PlannerFieldSet {
  constructor(index) {
    super(`nextLocations[${index}]`);
  }

  addArrivalDateInput(minDate) {
    const arrivalDateInput = this.__createLocationInputWrapper();

    arrivalDateInput.innerHTML = `
      <label for="${this.__name}[arrival-date]">Arrival Date</label>
      <input min="${minDate || this.__formatDate(new Date())}" type="date" name="${this.__name}[arrivalDate]" id="${this.__name}[arrival-date]" />
    `;

    this.addElementToFieldSet(arrivalDateInput);

    this.__arrivalDateInput = arrivalDateInput;
  }

  resetSectionOnFieldChange(field) {
    if(field === "country") {
      this.__removeField(this.__locationSelect);
      this.__removeField(this.__arrivalDateInput);
      this.__removeField(this.__departureDateInput);
    }

    if(field === "location") {
      this.__removeField(this.__arrivalDateInput);
      this.__removeField(this.__departureDateInput);
    }

    if(field === "arrivalDate") {
      this.__removeField(this.__departureDateInput);
    }
  }
}
