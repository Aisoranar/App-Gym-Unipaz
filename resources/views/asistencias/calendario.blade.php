@extends('layouts.app')

@section('title', 'Calendario de Asistencia')

@section('content')
    <h1>Asistencia al Gym</h1>
    <p>Marca tus días de asistencia para acumular tu streak.</p>
    <div id="calendar"></div>

    <!-- Modal para registrar asistencia y seleccionar el ejercicio -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="registroModalLabel">Registrar Asistencia</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <form id="registroAsistenciaForm">
              <input type="hidden" name="fecha" id="fechaAsistencia">
              <div class="mb-3">
                <label for="ejercicioSelect" class="form-label">Selecciona el ejercicio realizado:</label>
                <select class="form-select" id="ejercicioSelect" name="ejercicio_id" required>
                  <option value="">-- Selecciona un ejercicio --</option>
                  @foreach($ejercicios as $ejercicio)
                    <option value="{{ $ejercicio->id }}">{{ $ejercicio->nombre_ejercicio }}</option>
                  @endforeach
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Registrar asistencia</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de éxito -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-success border-success">
          <div class="modal-header">
            <h5 class="modal-title" id="successModalLabel">¡Éxito!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body" id="successModalMessage">
            <!-- El mensaje se insertará dinámicamente -->
          </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
    <!-- FullCalendar CSS y JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <!-- Bootstrap Bundle (incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
            document.getElementById('fechaAsistencia').value = info.dateStr;
            var registroModal = new bootstrap.Modal(document.getElementById('registroModal'));
            registroModal.show();
          }
        });
        calendar.render();

        document.getElementById('registroAsistenciaForm').addEventListener('submit', function(e) {
          e.preventDefault();
          var fecha = document.getElementById('fechaAsistencia').value;
          var ejercicio_id = document.getElementById('ejercicioSelect').value;

          if (!ejercicio_id) {
            alert('Debes seleccionar un ejercicio.');
            return;
          }

          fetch('{{ route('asistencias.store') }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ fecha: fecha, ejercicio_id: ejercicio_id })
          })
          .then(response => {
            if (response.ok) return response.json();
            else if (response.status === 409) throw new Error('Ya registraste asistencia en esa fecha.');
            else return response.json().then(data => { throw new Error(data.message || 'Error al registrar asistencia.'); });
          })
          .then(data => {
            calendar.refetchEvents();
            bootstrap.Modal.getInstance(document.getElementById('registroModal')).hide();

            // Mostrar modal de éxito con el mensaje
            document.getElementById('successModalMessage').innerText = data.message;
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
          })
          .catch(error => {
            alert(error.message);
          });
        });
      });
    </script>
@endsection
