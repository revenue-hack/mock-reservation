function create (event) {
  var $type = 'POST';
  var $uri = '/api/reserve';
  var $user_flag = ($("#reserve-user").attr('data-user') === "true");
  var $text = "予約完了しました!";
  if ($user_flag) {
    $type = 'DELETE';
    $uri += '/' + $("#reserve-user").attr('data-id');
    $text = "予約キャンセルしました";
  }
  event.preventDefault();
  //*
  var $date = $("#reserve-date").val();
  var $s_time = $("#reserve-time").val();
  var $period = $("#reserve-minute option:selected").val();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: $uri,
    type: $type,
    cache: false,
    contentType: 'application/json',
    dataType: 'json',
    data: JSON.stringify({
      date: $date,
      s_time: $s_time,
      period: $period
    })
  }).done(function (data) {
    $('#myModal').modal('hide');
    if (data.status !== 200) {
      alert('予約またはキャンセルがうまくできませんでした。ネットワークの接続不良またはすでに予約されてしまっています');
    } else {
      $.toast({
        text: $text, // Text that is to be shown in the toast
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
      alert('予約またはキャンセルがうまくできませんでした。電波の問題か、権限がないことが原因です');
  });
  $('#calendar').remove();
  $('<div id="calendar"></div>').appendTo('#calendar-body');
  display_calendar();
  //*/
}
