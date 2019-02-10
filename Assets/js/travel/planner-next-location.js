class PlannerNextLocation extends PlannerFieldSet {
  constructor(index) {
    super(`nextLocations[${index}]`);
  }

  addArrivalDateInput(minDate) {
    const arrivalDateInput = this.__createLocationInputWrapper();

    arrivalDateInput.innerHTML = `
      <label for="${this.__name}[arrival-date]">Arrival Date</label>
      <input min="${minDate}" type="date" name="${this.__name}[arrivalDate]" id="${this.__name}[arrival-date]" />
    `;

    this.addElementToFieldSet(arrivalDateInput);

    this.__arrivalDateInput = arrivalDateInput;
  }

  addReviewLinkForLocation() {
    const reviewLink = document.createElement("span");
    reviewLink.textContent = "View reviews";
    reviewLink.classList.add("review-link");

    this.__fieldSet.appendChild(reviewLink);

    this.__reviewLink = reviewLink;
  }

  resetSectionOnFieldChange(field) {
    if(field === "country") {
      this.__removeField(this.__locationSelect);
      this.__removeField(this.__arrivalDateInput);
      this.__removeField(this.__departureDateInput);
      this.__removeField(this.__reviewLink);
    }

    if(field === "location") {
      this.__removeField(this.__arrivalDateInput);
      this.__removeField(this.__departureDateInput);
      this.__removeField(this.__reviewLink);
    }

    if(field === "arrivalDate") {
      this.__removeField(this.__departureDateInput);
    }
  }
}
