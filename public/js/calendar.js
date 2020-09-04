$(function() {
  d = new Date;
  start = 2017;
  end = d.getFullYear();
  $('#monthYearPicker').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM yy',
    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho',
    'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
    'Jul','Ago','Set','Out','Nov','Dez'],
    currentText: 'Hoje', currentStatus: 'Data atual',
    closeText: 'Selecionar',
    minDate: new Date(start, 0, 1),
    maxDate: new Date(end, 12, 31),
  }).focus(function() {
    var thisCalendar = $(this);
    $('.ui-datepicker-calendar').detach();
    $('.ui-datepicker-close').click(function() {
      var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
      var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
      thisCalendar.datepicker('setDate', new Date(year, month, 1));
      document.getElementById("monthform").submit();
    });
  });
});


