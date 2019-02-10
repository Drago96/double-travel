class PlannerFieldSet {
  constructor(name) {
    const fieldSet = document.createElement("fieldset");
    fieldSet.className = "location-planner";

    this.__fieldSet = fieldSet;
    this.__name = name;
  }

  render(countries) {
    const countryOptions = countries.map(
      country => `<option value="${country.id}">${country.name}</option>`
    );

    this.__fieldSet.innerHTML = `
        <legend>${this.__name === 'startingLocation' ? "Starting" : "Next"} location:</legend>
        <div class="location-inputs">
          <div class="location-input">
            <label for="${this.__name}[country]">Country</label>
            <select id="${this.__name}[country]"name="${this.__name}[country]">
              ${this.__defaultOption()}
              ${countryOptions.join()}
            </select>
          </div>
        </div>`;

    return this.__fieldSet;
  }

  addLocationSelect(locations) {
    const locationSelect = this.__createLocationInputWrapper();

    const locationOptions = locations.map(
      location => `<option value="${location.id}">${location.name}</option>`
    );

    locationSelect.innerHTML = `
      <label for="${this.__name}[location]">Location</label>
      <select id="${this.__name}[location]" name="${this.__name}[location]">
        ${this.__defaultOption()}
        ${locationOptions.join()}
      </select>`;

    this.addElementToFieldSet(locationSelect);

    this.__locationSelect = locationSelect;
  }

  addDepartureDateInput(minDate) {
    const departureDateInput = this.__createLocationInputWrapper();

    departureDateInput.innerHTML = `
      <label for="${this.__name}[departure-date]">Departure Date</label>
      <input min="${minDate || this.__formatDate(new Date())}" type="date" name="${this.__name}[departureDate]" id="${this.__name}[departure-date]" />
    `;

    this.addElementToFieldSet(departureDateInput);

    this.__departureDateInput = departureDateInput;
  }

  addElementToFieldSet(element) {
    const locationInputs = this.__fieldSet.querySelector("div[class=location-inputs]");

    locationInputs.appendChild(element);
  }

  __createLocationInputWrapper() {
    const locationInputWrapper = document.createElement("div");
    locationInputWrapper.classList.add("location-input");

    return locationInputWrapper;
  }

  __removeField(field) {
    if(field) {
      field.remove();
    }

    field = null;
  }

  __defaultOption() {
    return "<option disabled selected value></option>";
  }

  __formatDate(date) {
    let day = date.getDate();
    let month = date.getMonth() + 1;
    const year = date.getFullYear();

    if(day<10){
      day='0' + day
    }

    if(month<10){
      month='0' + month
    }

    return `${year}-${month}-${day}`;
  }
}