/**
 * @file
 * Defines Javascript behaviors for the cact_module_analytics module.
 */
(function (Drupal, $) {
  $(document).ready(function(){

    /**************** Variables ****************/
    // Variables para rastrear el mes y el año actual
    let currentDate = new Date();
    let currentDay = currentDate.getDate();
    let currentMonth = currentDate.getMonth();
    let currentYear = new Date().getFullYear();
    let monthCounter = 1;
    let select_day;

    // Crear el contenedor padre del calendario.
    let $calendarContainer = $('<div class="calendar-container"></div>');

    // Variables globales para almacenar datos de la hora seleccionada
    let selectedDetailTimeSlotId;
    let selectedDate;
    let selectedHour;

    /**************** Functions ****************/
    // Función para obtener el número de días en un mes y año dados
    function daysInMonth(month, year) {
      return new Date(year, month + 1, 0).getDate();
    }

    // Función para renderizar el calendario
    function renderCalendar(data) {
      console.log(data);
      // Vaciar el contenido del contenedor antes de renderizar el nuevo calendario
      $calendarContainer.empty();

      let daysInCurrentMonth = daysInMonth(currentMonth, currentYear);
      let datesData = data.result.dates;
      let availableDays = [];
      datesData.forEach(function (dateInfo, index) {
        let day = parseInt(dateInfo.date.split('-')[2], 10);
        let mes = parseInt(dateInfo.date.split('-')[1], 10);

        // Considerar días del mes actual
        if (mes === currentMonth + 1) {
          availableDays.push({
            day: day,
            mes: mes,
          });
        }
      });

      // Creación de calendario
      // Agregar botones y nombre del mes.
      $calendarContainer.append('<div class="header-table"><button id="prev-month">Mes Anterior</button><div class="header-name-month"></div><button id="next-month">Mes Siguiente</button></div>');

      // Array con todos los meses del año.
      let monthNames = drupalSettings.month_names;

      // Seleccion de elementos
      let $productContainer = $('.product-container-right');

      // Insertar el contenedor después del campo field--name-field-title-copy
      $productContainer.find('.field--name-field-title-copy').after($calendarContainer);

      // Seleccionar el elemento de la clase header-name-month dentro del nuevo contenedor
      let titleCalendar = $('.header-table .header-name-month');

      // Establecer el nombre del mes
      titleCalendar.empty();
      titleCalendar.prepend('<div class="month">' + monthNames[currentMonth] + '</div>');
      titleCalendar.append('<div class="year">' + currentYear + '</div>');

      // Crear el elemento para añadir el calendario
      let $calendar = $('<div class="calendar"></div>');

      // Crear el elemento para añadir las horas del día disponible
      let $hoursAvailable = $('<div class="wrapper-hours-available"></div>')

      // Agregar los días de la semana al calendario
      let daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
      for (let i = 0; i < daysOfWeek.length; i++) {
        $calendar.append('<div class="day-of-week">' + Drupal.t(daysOfWeek[i]) + '</div>');
      }

      // Obtener el día de la semana del primer día del mes
      let firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
      firstDayOfMonth = (firstDayOfMonth === 0) ? 6 : firstDayOfMonth - 1;

      // Agregar celdas vacías antes del primer día del mes
      for (let i = 0; i < firstDayOfMonth; i++) {
        $calendar.append('<div class="empty-cell"></div>');
      }

      // Agregar celdas para los días del mes
      for (let i = 1; i <= daysInCurrentMonth; i++) {
        let $cell = $('<div class="day"><span>' + i + '</span></div>');
        $cell.data('day', i);

        // Verificar si el día tiene eventos y agregar una clase CSS si es así
        if (availableDays.some(event => event.day === i && event.mes === currentMonth + 1)) {
          $cell.addClass('has-events');

          // Evento click en los días dosponibles.
          $cell.on('click', function() {
            // Obtener el año, mes y día seleccionados
            let selectedYear = currentYear;
            let selectedMonth = currentMonth + 1;// Ajustar el mes porque en JavaScript los meses van de 0 a 11
            let selectedDay = $(this).data('day');

            // Añadimos la clase selected marcar el día seleccionado.
            if($(this).siblings('.selected')){
              $(this).siblings('.selected').removeClass('selected');
              $(this).addClass('selected');
            }else{
              $(this).addClass('selected');
            }

            // Comprobamos si el formulario está visible o no y lo ocultamos.
            if($('.field--name-variations').hasClass('visibility')){
              $('.field--name-variations').removeClass('visibility');
            }

            // Llamar al método en JavaScript de Drupal y enviar los datos.
            callDayStocks(selectedYear, selectedMonth, selectedDay);
          });
        }

        // Resaltar el día actual
        if (i === new Date().getDate() && currentMonth === new Date().getMonth() && currentYear === new Date().getFullYear()) {
          // Añadimos al día actual una clase para poder darle estilos.
          $cell.addClass('current-day');

          // Comprobamos si el día actual en el que estamos tiene horas disponibles.
          callDayStocks(currentYear, (currentMonth + 1), i);
        }

        $calendar.append($cell);
      }

      $calendarContainer.append($calendar);
      $calendarContainer.find('.calendar').after($hoursAvailable);
    }

    function callDayStocks(selectedYear, selectedMonth, selectedDay) {
      select_day = selectedYear + '-' + selectedMonth + '-'+ selectedDay;
      let url_json = drupalSettings.url_requested_slots;
      url_json = url_json.replace('change-datefrom', select_day);
      url_json = url_json.replace('change-dateto', select_day);
      console.log("url_json", url_json);

      // Realizar la llamada AJAX utilizando jQuery.ajax
      $.ajax({
        url: url_json, // Reemplaza con la ruta correcta de tu endpoint en Drupal
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          // Procesar la respuesta JSON
          console.log('Respuesta JSON:', response);
          if (
            response &&
            response.success === true &&
            response.result &&
            response.result.dates &&
            Array.isArray(response.result.dates) &&
            response.result.dates.length > 0 &&
            response.result.dates[0].date &&
            response.result.dates[0].timeSlots &&
            Array.isArray(response.result.dates[0].timeSlots) &&
            response.result.dates[0].timeSlots.length > 0
          ) {
            let dates = response.result.dates[0].timeSlots;

            // Reseteo del contenedor de las horas
            $calendarContainer.find('.wrapper-hours-available').empty();
            selectedDetailTimeSlotId = dates[0].detailTimeSlotId;
            selectedDate = select_day;
            // Recorrido para renderizar las horas disponibles de un día
            dates.forEach(function(date) {
              $calendarContainer.find('.wrapper-hours-available').append('<div class="hours-total" detail-time-slot-id="'+date.detailTimeSlotId+'" hour="'+date.hour+'" ><div class="hours">'+date.hour+'</div><div class="qtyAvailable">'+date.qtyAvailable+'</div></div>');
            });

          } else {
            console.error('La estructura no es la esperada:', response);

          }
        },
        error: function(error) {
          console.error('Error en la llamada AJAX:', error);
        }
      });
    }
    function validarArrayNoVacio(arr) {
      if (arr.success){
        return true;
      }
      return false;
    }

    /**************** Calls and Events ****************/
    // Agregamos a las variaciones una clase para ocultarlas por defecto.
    $('.field--name-variations').addClass('type3');



    // Eventos para la navegación entre meses
    $('#prev-month').prop('disabled', true); // Deshabilitar el botón "prev" por defecto

    // Eventos para la navegación entre meses
    $calendarContainer.on('click', '#prev-month', function () {
      if (currentMonth > 0) {
        currentMonth--;
      } else {
        currentMonth = 11; // Cambiar a diciembre
        currentYear--;
      }

      renderCalendar(drupalSettings.data_calendar);

      // Actualizar la variable monthCounter al hacer clic en prev-month
      monthCounter--;

      // Habilitar o deshabilitar el botón "prev" según corresponda
      $('#prev-month').prop('disabled', currentYear < currentDate.getFullYear() || (currentYear === currentDate.getFullYear() && currentMonth === currentDate.getMonth()));

      // Habilitar el botón "next" nuevamente
      $('#next-month').prop('disabled', false);

      $('.field--name-variations').removeClass('visibility');
    });

    $calendarContainer.on('click', '#next-month', function () {
      currentMonth = (currentMonth + 1) % 12;
      if (currentMonth === 0) {
        currentYear++;
      }
      renderCalendar(drupalSettings.data_calendar);
      monthCounter++;

      // Habilitar o deshabilitar el botón "prev" según corresponda
      $('#prev-month').prop('disabled', currentYear < currentDate.getFullYear() || (currentYear === currentDate.getFullYear() && currentMonth === currentDate.getMonth()));

      // Habilitar o deshabilitar el botón "next" según corresponda
      $('#next-month').prop('disabled', monthCounter > 4 || (currentYear === currentDate.getFullYear() && currentMonth === 11));

      $('.field--name-variations').removeClass('visibility');

    });

    // Evento clic a las horas disponibles
    $calendarContainer.on('click', '.hours-total', function (e) {
      if($(this).siblings().hasClass('selected')){
        $(this).siblings().removeClass('selected');
      }

      if($(this).hasClass('selected')){
        $(this).removeClass('selected');
        $('.field--name-variations').removeClass('visibility');
      }else{
        $(this).addClass('selected');
        $('.field--name-variations').addClass('visibility');
      }
      let detail_time_slot_id = $(this).attr("detail-time-slot-id");
      let hour = $(this).attr("hour");
      if(select_day && detail_time_slot_id && hour) {
        $('#field-time-slot-id').attr('value', detail_time_slot_id);
        $('#field-ticket-date').attr('value', select_day + " "+ hour);
        $('#field-session').attr('value', detail_time_slot_id);

      }

      e.preventDefault();
    });

    // Renderizar el calendario al cargar el documento
    let datafirt_load = drupalSettings.data_calendar;
    if (validarArrayNoVacio(datafirt_load)){
      renderCalendar(datafirt_load);
    }
    else {
      console.log('error first loading calendar clear cache');
    }
  });
})(Drupal, jQuery);
;
