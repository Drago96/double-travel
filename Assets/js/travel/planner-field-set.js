class PlannerFieldSet {
  constructor() {
    const fieldSet = document.createElement("fieldset");
    fieldSet.className = "location-planner";

    this.__fieldSet = fieldSet;
  }

  addElementToFieldSet(element) {
    const locationInputs = this.__fieldSet.querySelector("div[class=location-inputs]");

    locationInputs.appendChild(element);
  }

  createLocationInputWrapper() {
    const locationInputWrapper = document.createElement("div");
    locationInputWrapper.className = "location-input";

    return locationInputWrapper;
  }

  removeField(field) {
    if(field) {
      field.remove();
    }

    field = null;
  }

  defaultOption() {
    return "<option disabled selected value></option>";
  }

  formatDate(date) {
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