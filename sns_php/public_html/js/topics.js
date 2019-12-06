$(function() {
  'use strict';


  $("#datepicker1" ).datepicker({
      prevText:"前月", nextText:"翌月",
      changeMonth: true, monthNamesShort: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
      showOn: 'both',
      buttonImage: "/img/calendar.ico",
      buttonText: "Select date",
      buttonImageOnly: true,
  });

  $("#datepicker2" ).datepicker({
      prevText:"前月", nextText:"翌月",
      changeMonth: true, monthNamesShort: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
      showOn: 'both',
      buttonImage: "/img/calendar.ico",
      buttonText: "Select date",
      buttonImageOnly: true,
  });

  $("#datepicker3" ).datepicker({
      prevText:"前月", nextText:"翌月",
      changeMonth: true, monthNamesShort: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
      showOn: 'both',
      buttonImage: "/img/calendar.ico",
      buttonText: "Select date",
      buttonImageOnly: true,
  });

  $('button>img').css({'width':'30px', 'height':'30px'});




});
