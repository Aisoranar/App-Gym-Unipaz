@extends('layouts.app')

@section('title', 'Calendario de Asistencia')

@section('content')
<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body px-3 px-sm-5 py-4">

          {{-- Barra de racha --}}
          <div class="text-center mb-4">
            @if($streakLost)
              <p class="fs-5 text-danger">😢 ¡Oh no! Perdiste tu racha. Tu mejor racha fue de <strong>{{ $currentStreak }}</strong> días.</p>
            @elseif($currentStreak > 0)
              <p class="fs-5 text-success">🔥 ¡Increíble! Llevas <strong>{{ $currentStreak }}</strong> días seguidos entrenando.</p>
            @else
              <p class="fs-5 text-muted">🙌 ¡Comienza tu primera racha hoy registrando tu asistencia!</p>
            @endif
          </div>

          <div id="calendar" class="mx-auto"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modales -->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" id="registroDialog">
    <div class="modal-content rounded-4">
      <div class="modal-header" style="background: var(--color-gradient-primary); color: #fff;">
        <h5 class="modal-title" id="registroModalLabel"><i class="bi bi-calendar-check me-2"></i>Registrar Asistencia</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body px-3 px-sm-5 py-4">
        <form id="registroAsistenciaForm">
          @csrf
          <input type="hidden" name="fecha" id="fechaAsistencia">
          <div class="mb-3">
            <label for="ejercicioSelect" class="form-label fw-semibold">Ejercicio realizado:</label>
            <select class="form-select" id="ejercicioSelect" name="ejercicio_id" required>
              <option value="" disabled selected>Selecciona un ejercicio</option>
              @foreach($ejercicios as $ejercicio)
                <option value="{{ $ejercicio->id }}">{{ $ejercicio->nombre_ejercicio }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn w-100 rounded-pill" style="background: var(--color-primary); color: #fff;">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content border-0 rounded-4">
      <div class="modal-header" style="background: var(--color-success); color: #fff;">
        <h5 class="modal-title" id="successModalLabel"><i class="bi bi-check-circle me-2"></i>¡Éxito!</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center py-3" id="successModalMessage"></div>
    </div>
  </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<style>
  :root {
    --color-primary: #0d253f;
    --color-success: #1a472a;
    --color-bg: #f8f9fa;
    --color-gradient-primary: linear-gradient(135deg, #0d253f 0%, #354b60 100%);
  }
  body { background-color: var(--color-bg); }

  /* Calendario */
  #calendar {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    padding: 1rem;
    max-width: 100%;
  }
  .fc-toolbar {
    margin-bottom: .75rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: .5rem;
  }
  .fc-toolbar h2 { font-size: 1.25rem; font-weight: 600; }
  .fc-button {
    border-radius: 2rem;
    box-shadow: none;
    margin: 0;
    background: var(--color-primary);
    border: none;
    padding: .4rem .8rem;
    color: #fff;
    font-size: .85rem;
  }
  .fc-button:hover, .fc-button:focus { background: var(--color-gradient-primary); }
  .fc-button-active { background: var(--color-success) !important; }
  .fc-col-header-cell-cushion,
  .fc-daygrid-day-number { font-weight: 600; }
  .fc-daygrid-event {
    border: none;
    border-radius: .75rem;
    padding: .3rem .5rem;
    font-size: .85rem;
    background-color: var(--color-success);
    color: #fff;
  }
  /* Vista móvil */
  @media (max-width: 576px) {
    #calendar { padding: .5rem; }
    .fc-toolbar h2 { font-size: 1rem; }
    .fc-button { padding: .3rem .6rem; font-size: .75rem; }
    #registroDialog { width: 90%; }
    .modal-body { padding: 1rem; }
  }
  /* Vista escritorio */
  @media (min-width: 992px) {
    #calendar { max-width: 900px; margin: 0 auto; padding: 2rem; }
    .fc-daygrid-day-top { padding: .75rem; }
    .fc-button { font-size: .9rem; padding: .5rem 1rem; }
    #registroDialog { max-width: 600px; }
  }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'es',
      headerToolbar: {
        left: 'prev today next',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listWeek'
      },
      buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week: 'Semana',
        listWeek: 'Agenda'
      },
      navLinks: true,
      dayMaxEvents: true,
      height: 'auto',
      events: {
        url: '{{ route('asistencias.eventos') }}',
        failure: function() { alert('No se pudieron cargar las asistencias.'); }
      },
      dateClick: function(info) {
        document.getElementById('fechaAsistencia').value = info.dateStr;
        new bootstrap.Modal(document.getElementById('registroModal')).show();
      }
    });
    calendar.render();

    document.getElementById('registroAsistenciaForm').addEventListener('submit', function(e) {
      e.preventDefault();
      var data = {
        fecha: document.getElementById('fechaAsistencia').value,
        ejercicio_id: document.getElementById('ejercicioSelect').value
      };
      if (!data.ejercicio_id) { return alert('⚠️ Debes seleccionar un ejercicio.'); }
      fetch('{{ route('asistencias.store') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
      })
      .then(res => res.ok ? res.json() : res.json().then(err => Promise.reject(err)))
      .then(res => {
        calendar.refetchEvents();
        bootstrap.Modal.getInstance(document.getElementById('registroModal')).hide();
        document.getElementById('successModalMessage').innerText = res.message + ' 🎉';
        new bootstrap.Modal(document.getElementById('successModal')).show();
      })
      .catch(err => alert(err.message || 'Error al registrar.'));
    });
  });
</script>
@endsection