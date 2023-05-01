<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Disk Usage - Apache ECharts Demo</title>
  <link rel="stylesheet" href="{{ asset('../vendor/parking-spaces/parking-spaces.css') }}">
  <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">

  <!-- Button trigger modal Vehicle Enter -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Vehicle Enter</button>

    <!-- Button trigger modal Vehicle Exit -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Vehicle Exit
  </button>

  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2 ">
    Add Another Parking Level
  </button>

  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop3 ">
   Config Parking Level capacity
  </button>

  </div>
  <div id="chart-container"></div>
  <script src="https://fastly.jsdelivr.net/npm/jquery"></script>
  <script src="https://fastly.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>
  <script src="{{ asset('../vendor/parking-spaces/parking-spaces.js') }}"></script>

<!-- Modal Vehicle enter -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Vehicle enter</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="enterForm" action='enter' method='post'>
          @csrf
          <div class="mb-3">
            <label for="license_plate" class="col-form-label">License plate:</label>
            <input name="license_plate" type="text" class="form-control" id="license_plate">
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Type:</label>
            <select name="type" class="form-select" id="floatingSelect" aria-label="Floating label select example">
              <option selected value="1">Car</option>
              <option value="2">Motorbike</option>
            </select>
          </div>
          @if ($errors->any() && ($errors->has('license_plate') || $errors->has('type')))
              <div class="alert alert-danger">
                  <ul>  
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
              <script>$( document ).ready(function() {
                  $("#exampleModal").modal('show');
              });</script>
          @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button id="vehicleEnter" type="submit" class="btn btn-primary">Accept</button>
      </div>
      </form>
    </div>
  </div>
</div>
  </div>




<!-- Modal Vehicle exit -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Choose Exiting Vehicle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="exitForm" action='exit' method='post'>
      @csrf
          <div class="mb-3">
            <label for="exit_license_plate" class="col-form-label">License plate:</label>
            <select name="exit_license_plate" class="form-select" id="exit_license_plate">
              @foreach ($vehicles as $vehicle)
                <option value="{{$vehicle->license_plate}}">{{$vehicle->license_plate}}</option>
              @endforeach
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Create Parking Level -->
<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Parking Level</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="addLevelForm" action='add-parking-level' method='post'>
      @csrf
      <div class="mb-3">
            <label for="level-name" class="col-form-label">Parking Level Name:</label>
            <input name="level_name" type="text" class="form-control" id="level-name">
          </div>
          <div class="mb-3">
            <label for="level-capacity" class="col-form-label">Capacity:</label>
            <input name="capacity" type="text" class="form-control" id="level-capacity">
          </div>
          @if ($errors->any() && ($errors->has('level_name') || $errors->has('capacity')))
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
              <script>$( document ).ready(function() {
                  $("#staticBackdrop2").modal('show');
              });</script>
          @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Parking Level -->
<div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Parking Level</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> 
      <div class="modal-body">
      <form id="editLevelForm" action='edit-parking-level' method='post'>
      @csrf
        <div class="mb-3">
            <label for="parking-level" class="col-form-label">Parking Level:</label>
            <select name="edit_parking_level" class="form-select" id="edit-parking-level">
              @foreach ($parkingLevels as $parkingLevel)
                <option value="{{$parkingLevel->id}}" data="{{$parkingLevel->capacity}}">{{$parkingLevel->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="level-capacity" class="col-form-label">Capacity:</label>
            <input name="edit_capacity" type="text" class="form-control" id="edit-level-capacity">
          </div>
          @if ($errors->any() && ($errors->has('edit_parking_level') || $errors->has('edit_capacity')))
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
              <script>$( document ).ready(function() {
                  $("#staticBackdrop3").modal('show');
              });</script>
          @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

</div>
</body>
<script>
  $( document ).ready(function() {
    let valueSelected = $("#edit-parking-level option:selected");
    $('#edit-level-capacity').val(valueSelected.attr("data"));
  $('#edit-parking-level').on('change', function (e) {
    let valueSelected = $("option:selected", this);   
    $('#edit-level-capacity').val(valueSelected.attr("data"));
  })
});
</script>

</html> 