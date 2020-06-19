//Changes Menu Buttons based on if a user is logged in and the type of user
function changeMenuButtonsClient(hidden = false){
    $('#make_reservation').prop('hidden', hidden);
    $('#view_reservations').prop('hidden', hidden);
    $('#logout').prop('hidden', hidden);
  }

  function changeMenuButtonsAdmin(hidden = false){
    $('#make_reservation').prop('hidden', hidden);
    $('#create_admin').prop('hidden', hidden);
    $('#reservations_settings').prop('hidden', hidden);
    $('#view_reservations').prop('hidden', hidden);
    $('#logout').prop('hidden', hidden);
    $('#menu').prop('hidden', true);
  }

function makeMenuChanges(){
  if (localStorage.getItem("login") && localStorage.getItem("customer_type") == 0){
    changeMenuButtonsClient();
  } else if (localStorage.getItem("login") && localStorage.getItem("customer_type") == 1){
    changeMenuButtonsAdmin();
    $('#view_reservations').html("View all Reservations");
  }
}
  