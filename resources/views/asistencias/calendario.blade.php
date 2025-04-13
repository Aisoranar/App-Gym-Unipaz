@extends('layouts.app')
@section('title', 'Calendario de Asistencia')
@section('content')
    <h1>Asistencia al Gym</h1>
    <p>Marca tus días de asistencia para acumular tu streak.</p>
    <div id="calendar"></div>
@endsection

@section('scripts')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locale: 'es',
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
          },
          events: '{{ route('asistencias.eventos') }}',
          dateClick: function(info) {
            if (confirm('¿Registrar asistencia para el ' + info.dateStr + '?')) {
              fetch('{{ route('asistencias.store') }}', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ fecha: info.dateStr })
              })
              .then(response => {
                if (response.ok) return response.json();
                else if(response.status === 409) throw new Error('Ya registraste asistencia en esa fecha.');
                else throw new Error('Error al registrar asistencia.');
              })
              .then(data => {
                alert(data.message);
                calendar.refetchEvents();
              })
              .catch(error => alert(error.message));
            }
          }
        });
        calendar.render();
      });
    </script>
@endsection
