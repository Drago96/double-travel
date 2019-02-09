class PlannerStartingLocation extends PlannerFieldSet {
  render(countries) {
    const countryOptions = countries.map(
      country => `<option value="${country.id}">${country.name}</option>`
    );

    this.__fieldSet.innerHTML = `
        <legend>Starting location:</legend>
        <div class="location-inputs">
          <div class="location-input">
            <label for="starting-location[country]">Country</label>
            <select id="starting-location[country]" name="starting-location[country]">
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
      <label for="starting-location[location]">Location</label>
      <select id="starting-location[location]" name="starting-location[location]">
        ${this.defaultOption()}
        ${locationOptions.join()}
      </select>`;

    this.addElementToFieldSet(locationSelect);

    this.__locationSelect = locationSelect;
  }

  addDepartureDateInput() {
    const departureDateInput = this.createLocationInputWrapper();

    departureDateInput.innerHTML = `
      <label for="starting-location[departure-date]">Departure Date</label>
      <input min="${this.formatDate(new Date())}" type="date" name="starting-location[departure-date]" id="starting-location[departure-date]" />
    `;

    this.addElementToFieldSet(departureDateInput);

    this.__departureDateInput = departureDateInput;
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
