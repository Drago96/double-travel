class PlannerForm {
  constructor() {
    this.__form = document.getElementById("location-form");

    this.__currentSection = null;
    this.__currentFieldSet = null;

    this.__currentArrivalDate = null;
    this.__lastDepartureDate = null;
    this.__currentDepartureDate = null;

    this.__nextLocationIndex = 0;
  }

  initialize() {
    fetch("/countries")
      .then(response => response.json())
      .then(countries => {
        this.__countries = countries;
        this.__locations = {};

        this.__displayForm();
        this.__displayStartingLocationFieldSet();
      });

    this.__addAdditionalLocationButtonEventListener();
  }

  __displayStartingLocationFieldSet() {
    const startingLocation = new PlannerStartingLocation();

    this.__displayLocationFieldSet(startingLocation);
  }

  __displayNextLocationFieldSet() {
    const nextLocation = new PlannerNextLocation(this.__nextLocationIndex, this.__currentDepartureDate);

    this.__displayLocationFieldSet(nextLocation);
  }

  __displayLocationFieldSet(location) {
    const locationFieldSet = location.render(this.__countries);
    this.__addFieldSetToForm(locationFieldSet);

    this.__currentSection = location;
    this.__currentFieldSet = locationFieldSet;

    this.__addCountryEventListener();
  }

  __addCountryEventListener() {
    const countrySelect = this.__currentFieldSet.querySelector("select[name*='[country]']");

    countrySelect.addEventListener("change", event => {
      this.__currentSection.resetSectionOnFieldChange("country");
      this.__disableButtons();

      const countryId = event.target.value;

      const locations = this.__locations[countryId];

      if(!locations) {
        fetch(`/locations?country_id=${countryId}`)
          .then(response => response.json())
          .then(locations => {
            this.__locations[countryId] = locations;
            this.__addLocationSelect(locations);
          });
      } else {
        this.__addLocationSelect(locations);
      }
    });
  }

  __addLocationSelect(locations) {
    this.__currentSection.addLocationSelect(locations);
    this.__addLocationEventListener();
  }

  __addLocationEventListener() {
    const locationSelect = this.__currentFieldSet.querySelector("select[name*='[location]']");

    locationSelect.addEventListener("change", event => {
      this.__currentSection.resetSectionOnFieldChange("location");
      this.__disableButtons();

      if(this.__currentSectionIsStartingLocation()) {
        this.__addDepartureDateInput();
      } else {
        this.__addArrivalDateInput();
      }
    });
  }

  __addArrivalDateInput() {
    this.__currentSection.addArrivalDateInput(this.__lastDepartureDate);
    this.__addArrivalDateEventListener();
  }

  __addArrivalDateEventListener() {
    const arrivalDateInput = this.__currentFieldSet.querySelector("input[name*='[arrivalDate]']");

    arrivalDateInput.addEventListener("change", event => {
      this.__currentSection.resetSectionOnFieldChange("arrivalDate");
      this.__disableButtons();

      this.__currentArrivalDate = event.target.value;

      this.__addDepartureDateInput();
    });
  }

  __addDepartureDateInput() {
    this.__currentSection.addDepartureDateInput(this.__currentArrivalDate);
    this.__addDepartureDateEventListener();
  }

  __addDepartureDateEventListener() {
    const departureDateInput = this.__currentFieldSet.querySelector("input[name*='[departureDate]']");

    departureDateInput.addEventListener("change", event => {
      this.__currentDepartureDate = event.target.value;

      this.__enableAdditionalLocationButton();

      if(!this.__currentSectionIsStartingLocation()) {
        this.__enableSubmitButton();
      }
    });
  }

  __currentSectionIsStartingLocation() {
    return this.__currentSection.constructor.name === "PlannerStartingLocation";
  }

  __addAdditionalLocationButtonEventListener() {
    const additionalLocationButton = document.getElementById("add-new-location-button");
    additionalLocationButton.addEventListener("click", (event) => {
      event.preventDefault();

      this.__disableFieldSet(this.__currentFieldSet);
      this.__displayNextLocationFieldSet();

      this.__lastDepartureDate = this.__currentDepartureDate;
      this.__nextLocationIndex ++;
      this.__disableButtons();
    });
  }

  __enableAdditionalLocationButton() {
    const additionalLocationButton = document.getElementById("add-new-location-button");
    additionalLocationButton.title = "";
    additionalLocationButton.disabled = false;
  }

  __enableSubmitButton() {
    const submitButton = document.getElementById("submit-travel-button");
    submitButton.title = "";
    submitButton.disabled = false;
  }

  __disableButtons() {
    this.__disableAdditonalLocationButton();
    this.__disableSubmitButton();
  }

  __disableAdditonalLocationButton() {
    const additionalLocationButton = document.getElementById("add-new-location-button");
    additionalLocationButton.title ="Please fill all information for the current location.";
    additionalLocationButton.disabled = true;
  }

  __disableSubmitButton() {
    const submitButton = document.getElementById("submit-travel-button");
    submitButton.title = "Please select at least one location to visit.";
    submitButton.disabled = true;
  }

  __disableFieldSet(fieldSet) {
    const inputs = fieldSet.querySelectorAll("select, input");

    inputs.forEach(input => {
      input.classList.add("disabled");
    });
  }

  __addFieldSetToForm(fieldSet) {
    const fieldSetsElement = this.__form.querySelector(".field-sets");

    fieldSetsElement.appendChild(fieldSet);
  }

  __displayForm() {
    const loader = document.getElementById("content-loader");
    loader.remove();

    this.__form.style.display = "block";
  }
}
