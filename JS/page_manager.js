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
  }
  