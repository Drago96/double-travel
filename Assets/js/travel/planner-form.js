class PlannerForm {
  constructor() {
    this.__form = document.getElementById("location-form");

    this.__currentSection = new PlannerStartingLocation();
    this.__currentFieldSet = null;

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
    const startingLocationFieldSet = this.__startingLocationSection.render(this.__countries);
    this.__addFieldSetToForm(startingLocationFieldSet);
    this.__currentFieldSet = startingLocationFieldSet;

    this.__addStartingCountryEventListener();
  }

  __addStartingCountryEventListener() {
    const startingCountrySelect = document.getElementById("starting-location[country]");

    startingCountrySelect.addEventListener("change", event => {
      this.__currentSection.resetSectionOnFieldChange("country");
      this.__disableAdditonalLocationButton();

      const countryId = event.target.value;

      const locations = this.__locations[countryId];

      if(!locations) {
        fetch(`/locations?country_id=${countryId}`)
          .then(response => response.json())
          .then(locations => {
            this.__locations[countryId] = locations;
            this.__addLocationSelectToStartingSection(locations);
          });
      } else {
        this.__addLocationSelectToStartingSection(locations);
      }
    });
  }

  __addLocationSelectToStartingSection(locations) {
    this.__currentSection.addLocationSelect(locations);
    this.__addStartingLocationEventListener();
  }

  __addStartingLocationEventListener() {
    const startingLocationSelect = document.getElementById("starting-location[location]");

    startingLocationSelect.addEventListener("change", event => {
      this.__currentSection.resetSectionOnFieldChange("location");
      this.__disableAdditonalLocationButton();

      this.__addDepartureDateToStartingInput();
    });
  }

  __addDepartureDateToStartingInput() {
    this.__currentSection.addDepartureDateInput();
    this.__addStartingDepartureDateEventListener();
  }

  __addStartingDepartureDateEventListener() {
    const startingDepartureDateInput = document.getElementById("starting-location[departure-date]");

    startingDepartureDateInput.addEventListener("change", event => {
      this.__currentDepartureDate = event.target.value;
      this.__enableAdditionalLocationButton();
    });
  }

  __displayNextLocationFieldSet() {
    const nextLocation = new PlannerNextLocation(this.__nextLocationIndex, this.__currentDepartureDate);

    const nextLocationFieldSet = nextLocation.render(this.__countries);
    this.__addFieldSetToForm(nextLocationFieldSet);
    this.__currentFieldSet = nextLocationFieldSet;

    this.__addNextLocationCountryEventListener();
  }

  __addNextLocationCountryEventListener() {

  }

  __addAdditionalLocationButtonEventListener() {
    const additionalLocationButton = document.getElementById("add-new-location-button");
    additionalLocationButton.addEventListener("click", (event) => {
      event.preventDefault();

      this.__disableFieldSet(this.__currentFieldSet);
      this.__displayNextLocationFieldSet();

      this.__nextLocationIndex ++;
      this.__disableAdditonalLocationButton();
    });
  }

  __enableAdditionalLocationButton() {
    const additionalLocationButton = document.getElementById("add-new-location-button");
    additionalLocationButton.title = "";
    additionalLocationButton.disabled = false;
  }

  __disableAdditonalLocationButton() {
    const additionalLocationButton = document.getElementById("add-new-location-button");
    additionalLocationButton.title ="Please fill all information for the current location.";
    additionalLocationButton.disabled = true;
  }

  __disableFieldSet(fieldSet) {
    const inputs = fieldSet.querySelectorAll("select, input");

    inputs.forEach(input => {
      input.disabled = true;
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
