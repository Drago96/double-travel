<link rel="stylesheet" type="text/css" href="/Assets/styles/travels/planner.css">

<h1 class="title">Travel Planner</h1>

<div id="content-loader" class="loader">Loading...</div>

<form id="location-form" class="location-form" style="display: none" action="/travels/create" method="POST">
  <div class="field-sets"></div>
  <div class="form-buttons">
    <button disabled title="Please fill all information for the current location." id="add-new-location-button"
            class="add-new-location-button">Add new location
    </button>
    <input disabled title="Please select at least one location to visit." id="submit-travel-button"
           class="submit-travel-button" value="Create" type="submit"/>
  </div>
</form>

<script src="/Assets/js/travel/planner.js"></script>
<script src="/Assets/js/travel/planner-form.js"></script>
<script src="/Assets/js/travel/planner-field-set.js"></script>
<script src="/Assets/js/travel/planner-starting-location.js"></script>
<script src="/Assets/js/travel/planner-next-location.js"></script>