function update(event) {
  event.preventDefault();
  //*
  var $date = $("#reserve-date").val();
  var $s_time = $("#reserve-time").val();
  var $id = $("#reserve-user").attr('data-id');
  var $frames = $("#reserve-frame").val();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: '/api/reserve_frame/'+ $id,
    type: 'PATCH',
    cache: false,
    contentType: 'application/json',
    dataType: 'json',
    data: JSON.stringify({
      date: $date,
      s_time: $s_time,
      id: $id,
      frames: $frames,
    })
  }).done(function (data) {
    $('#myFrameModal').modal('hide');
    if (data.status !== 200) {
      alert('変更できませんでした。ネットワーク接続不良の可能性があります。');
    } else {
      $.toast({
        text: "変更できました", // Text that is to be shown in the toast
        heading: 'Note', // Optional heading to be shown on the toast
        showHideTransition: 'fade', // fade, slide or plain
        allowToastClose: true, // Boolean value true or false
        hideAfter: 1000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
        stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
        position: 'mid-center', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values

        bgColor: '#1fd3dc',  // Background color of the toast
        textColor: '#eeeeee',  // Text color of the toast
        textAlign: 'left',  // Text alignment i.e. left, right or center
        beforeShow: function () {}, // will be triggered before the toast is shown
        afterShown: function () {}, // will be triggered after the toat has been shown
        beforeHide: function () {}, // will be triggered before the toast gets hidden
        afterHidden: function () {}  // will be triggered after the toast has been hidden
      });
    }
  }).fail(function (data) {
      alert('変更できませんでした。ネットワーク接続不良の可能性があります。');
  });
  $('#calendar').remove();
  $('<div id="calendar"></div>').appendTo('#calendar-body');
  display_calendar();
  //*/
}
