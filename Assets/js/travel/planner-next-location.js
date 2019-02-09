class PlannerNextLocation extends PlannerFieldSet {
  constructor(index, minArrivalDate) {
    super();
    this.__index = index;
    this.__minArrivalDate = minArrivalDate;
  }

  render(countries) {
    const countryOptions = countries.map(
      country => `<option value="${country.id}">${country.name}</option>`
    );

    this.__fieldSet.innerHTML = `
        <legend>Next location:</legend>
        <div class="location-inputs">
          <div class="location-input">
            <label for="next-locations[${this.__index}][country]">Country</label>
            <select id="next-locations[${this.__index}][country]"name="next-locations[${this.__index}][country]">
              ${this.defaultOption()}
              ${countryOptions.join()}
            </select>
          </div>
        </div>`;

    return this.__fieldSet;
  }

  addLocationSelect(locations) {
    const locationSelect = this.createLocationInputWrapper();

    const locationOptions = locations.map(
      location => `<option value="${location.id}">${location.name}</option>`
    );

    locationSelect.innerHTML = `
      <label for="starting-location">Location</label>
      <select id="starting-location" name="starting-location">
        ${this.defaultOption()}
        ${locationOptions.join()}
      </select>`;

    this.addElementToFieldSet(locationSelect);

    this.__locationSelect = locationSelect;
  }

  addDepartureDateInput() {
    const departureDateInput = this.createLocationInputWrapper();

    departureDateInput.innerHTML = `
      <label for="starting-departure-date">Departure Date</label>
      <input min="${this.formatDate(new Date())}" type="date" name="starting-departure-date" id="starting-departure-date" />
    `;

    this.addElementToFieldSet(departureDateInput);

    this.__departureDateInput = departureDateInput;
  }

  addElementToFieldSet(element) {
    const locationInputs = this.__fieldSet.querySelector("div[class=location-inputs]");

    locationInputs.appendChild(element);
  }

  resetSectionOnFieldChange(field) {
    if(field === "country") {
      this.removeField(this.__locationSelect);
      this.removeField(this.__departureDateInput);
    }

    if(field === "location") {
      this.removeField(this.__departureDateInput);
    }
  }
}
