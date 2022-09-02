$(function () {
  'use strict';

  if ($('.datepicker').length) {
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $('.datepicker').datepicker({
      format: "yyyy-mm-dd",
      todayHighlight: true,
      autoclose: true
    });

    if (!$(".datepicker input")[0].hasAttribute('value')) {
      // $('.datepicker').datepicker('setDate', today);
    }
  }
});