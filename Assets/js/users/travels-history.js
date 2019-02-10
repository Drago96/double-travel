class TravelsHistory {
  constructor() {
    this.__travelsListElement = document.querySelector(".travels");
    this.__tabButtonElements = document.querySelectorAll(".tabs-links button");
    this.__spinnerElement = document.getElementById("content-loader");

    this.__travels = [];
  }

  initialize() {
    this.__addTabsEventListeners();

    this.__fetchTravels("past")
      .then(travels => this.__displayTravels(travels))
      .then(() => this.__hideSpinner());
  }

  __addTabsEventListeners() {
    this.__tabButtonElements.forEach(button => {
      const buttonValue = button.dataset.value;

      button.addEventListener("click", () => {
        this.__tabButtonElements.forEach(button => {
          button.classList.remove("active");
        });

        button.classList.add("active");

        if (this.__travels[buttonValue]) {
          this.__displayTravels(this.__travels[buttonValue]);
        } else {
          this.__showSpinner();

          this.__fetchTravels(buttonValue)
            .then(travels => this.__displayTravels(travels))
            .then(() => this.__hideSpinner());
        }
      });
    });
  }

  __displayTravels(travels) {
    this.__travelsListElement.innerHTML = "";

    if(travels.length === 0) {
      this.__travelsListElement.innerHTML = "<h3 class='no-travels'>There are no travels to display. &#9785;</h3>";

      return;
    }

    const travelElements = travels.map((travel) => this.__generateTravelElement(travel));
    travelElements.forEach(element => {
      this.__travelsListElement.appendChild(element);
    });
  }

  __generateTravelElement(travel) {
    const travelElement = document.createElement("li");
    travelElement.classList.add("travel");

    const targetLocation = travel.locations[travel.locations.length - 1];

    travelElement.innerHTML = `
        <span>
          ${travel.startingLocation.name}, ${travel.startingCountry.name} (${travel.startingDepartureDate}) &#9992; 
          ${targetLocation.location.name}, ${targetLocation.country.name} (${targetLocation.departureDate})
          <span data-visibility="hidden" class="travel-details">View details</span>
          <ul style="display: none;" class="sub-travels">
            ${this.__generateSubTravels(travel).join("")}
          </ul>
        </span>`;

    this.__addDetailsLinkEventListener(travelElement);

    return travelElement;
  }

  __generateSubTravels(travel) {
    const subTravels = [];

    const travels = [
      {
        location: travel.startingLocation,
        country: travel.startingCountry,
        departureDate: travel.startingDepartureDate
      },
      ...travel.locations
    ];

    for (let travelIndex = 0; travelIndex < travels.length - 1; travelIndex++) {
      subTravels.push(this.__generateSubTravel(travels[travelIndex], travels[travelIndex + 1], travelIndex === travels.length - 2));
    }

    return subTravels;
  }

  __generateSubTravel(from, to, isFinal) {
    return `<li class="sub-travel">
              ${from.location.name}, ${from.country.name} (${from.departureDate}) &#9992;
              ${to.location.name}, ${to.country.name} (${to.arrivalDate})
            </li>
            ${isFinal ? `<li class="sub-travel">
                            Final Departure: ${to.location.name}, ${to.country.name} (${to.departureDate})
                         </li>` : ""}`;
  }

  __addDetailsLinkEventListener(travelElement) {
    const travelDetailsLink = travelElement.querySelector(".travel-details");
    const subTravelsList = travelElement.querySelector(".sub-travels");

    travelDetailsLink.addEventListener("click", () => {
      const detailsVisibility = travelDetailsLink.dataset.visibility;

      if (detailsVisibility === "hidden") {
        subTravelsList.style.display = "block";

        travelDetailsLink.textContent = "Hide details";
        travelDetailsLink.dataset.visibility = "visible";
      } else {
        subTravelsList.style.display = "none";

        travelDetailsLink.textContent = "View details";
        travelDetailsLink.dataset.visibility = "hidden";
      }
    });
  }

  __fetchTravels(period) {
    return fetch(`/travels/${period}`)
      .then(response => response.json())
      .then(travels => {
        this.__travels[period] = travels;

        return travels;
      });
  }

  __hideSpinner() {
    this.__spinnerElement.style.display = "none";
  }

  __showSpinner() {
    this.__spinnerElement.style.display = "block";
  }
}
