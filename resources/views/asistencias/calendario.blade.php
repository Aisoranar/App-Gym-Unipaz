@extends('layouts.app')

@section('title', 'Calendario de Asistencias')

@section('content')
<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body px-3 px-sm-5 py-4">

          {{-- Barra de racha --}}
          <div class="streak-box text-center">
            @if($streakLost)
              <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                <span class="fs-4">😢</span>
                <p class="m-0 text-danger fw-semibold">¡Oh no! Perdiste tu racha.<br><small class="text-muted">Tu mejor racha fue de <strong>{{ $currentStreak }}</strong> días.</small></p>
              </div>
            @elseif($currentStreak > 0)
              <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                <span class="fs-4">🔥</span>
                <p class="m-0 text-success fw-semibold">¡Increíble! Llevas <strong>{{ $currentStreak }}</strong> días seguidos entrenando.</p>
              </div>
            @else
              <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                <span class="fs-4">🙌</span>
                <p class="m-0 text-muted fw-semibold">¡Comienza tu primera racha hoy!<br><small>Toca un día para registrar tu asistencia</small></p>
              </div>
            @endif
          </div>

          {{-- Quick Stats Summary --}}
          <div class="quick-stats d-flex justify-content-center gap-3 mb-3 flex-wrap">
            <div class="stat-item">
              <span class="stat-icon">📊</span>
              <span class="stat-label">Mes: <strong id="monthCount">0</strong></span>
            </div>
            <div class="stat-item">
              <span class="stat-icon">💪</span>
              <span class="stat-label">Total: <strong id="totalCount">0</strong></span>
            </div>
          </div>

          {{-- Loading Indicator --}}
          <div id="calendarLoader" class="calendar-loader">
            <div class="loader-spinner"></div>
            <span>Cargando...</span>
          </div>

          <div id="calendar" class="mx-auto"></div>

          {{-- Swipe hint for mobile --}}
          <div class="swipe-hint d-md-none">
            <span>← Desliza para navegar →</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modales -->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" id="registroDialog">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header" style="background: linear-gradient(135deg, #003379 0%, #0056a8 100%); color: #fff;">
        <h5 class="modal-title fw-semibold" id="registroModalLabel"><i class="bi bi-calendar-check me-2"></i>Registrar Asistencia</h5>
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
    --color-primary: #003379;
    --color-primary-light: #0056a8;
    --color-success: #1a472a;
    --color-success-light: #2d5a3d;
    --color-bg: #f0f2f5;
    --color-card: #ffffff;
    --color-text: #333;
  }

  body { background-color: var(--color-bg); }

  /* Streak box mejorado */
  .streak-box {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 16px;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,51,121,0.1);
  }

  /* Card principal */
  .card {
    background: var(--color-card);
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    border: none;
  }

  /* Calendario mejorado */
  #calendar {
    background: var(--color-card);
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    padding: 1.5rem;
    max-width: 100%;
  }

  /* Header del calendario con gradiente */
  .fc-toolbar {
    margin-bottom: 1.5rem !important;
    padding: 0.35rem 0.75rem;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,51,121,0.2);
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: nowrap !important;
    justify-content: space-between !important;
    align-items: center !important;
    min-height: 40px;
    gap: 0.5rem;
  }

  .fc-toolbar h2 {
    font-size: 0.6rem;
    font-weight: 600;
    color: #fff;
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    white-space: nowrap;
    margin: 0;
    text-align: center;
    padding: 0 0.5rem;
  }

  .fc-toolbar-chunk {
    display: flex !important;
    gap: 0.4rem;
    align-items: center;
  }

  .fc-toolbar-chunk:first-child {
    margin-right: 0.3rem;
  }

  .fc-toolbar-chunk:last-child {
    margin-left: 0.3rem;
  }

  /* Botones del calendario */
  .fc-button {
    border-radius: 3px !important;
    box-shadow: 0 1px 2px rgba(0,0,0,0.2) !important;
    margin: 0;
    background: rgba(255,255,255,0.15) !important;
    border: 1px solid rgba(255,255,255,0.25) !important;
    padding: 0.05rem 0.2rem !important;
    color: #fff !important;
    font-size: 0.55rem;
    font-weight: 500;
    transition: all 0.15s ease;
    line-height: 1;
    height: auto;
    min-height: 16px;
  }

  .fc-button .fc-icon {
    font-size: 0.65rem;
  }

  /* Flechas y Hoy - más pequeños */
  .fc-prev-button,
  .fc-next-button {
    padding: 0.02rem 0.1rem !important;
    min-height: 12px !important;
  }

  .fc-prev-button .fc-icon,
  .fc-next-button .fc-icon {
    font-size: 0.5rem !important;
  }

  .fc-today-button {
    padding: 0.02rem 0.15rem !important;
    font-size: 0.45rem !important;
    min-height: 12px !important;
  }

  .fc-button:hover {
    background: rgba(255,255,255,0.35) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.25) !important;
  }

  .fc-button-active {
    background: #fff !important;
    color: var(--color-primary) !important;
    font-weight: 600;
  }

  /* Días de la semana */
  .fc-col-header-cell {
    background: var(--color-bg);
    padding: 0.75rem 0 !important;
    border-bottom: 2px solid var(--color-primary) !important;
  }

  .fc-col-header-cell-cushion {
    font-weight: 700;
    color: var(--color-primary);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  /* Grid de días */
  .fc-daygrid-day {
    transition: all 0.2s ease;
  }

  .fc-daygrid-day:hover {
    background: rgba(0,51,121,0.05);
  }

  .fc-daygrid-day-number {
    font-weight: 600;
    font-size: 1rem;
    padding: 0.5rem;
    color: var(--color-text);
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0.25rem;
  }

  /* Día actual destacado */
  .fc-day-today {
    background: rgba(0,51,121,0.08) !important;
  }

  .fc-day-today .fc-daygrid-day-number {
    background: var(--color-primary);
    color: #fff;
    border-radius: 50%;
    box-shadow: 0 2px 10px rgba(0,51,121,0.3);
  }

  /* Eventos mejorados */
  .fc-daygrid-event {
    border: none;
    border-radius: 50px;
    padding: 0.35rem 0.75rem;
    font-size: 0.8rem;
    font-weight: 500;
    background: linear-gradient(135deg, var(--color-success) 0%, var(--color-success-light) 100%);
    color: #fff;
    box-shadow: 0 2px 6px rgba(26,71,42,0.3);
    margin: 2px 4px;
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .fc-daygrid-event:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(26,71,42,0.4);
  }

  /* Animación de entrada para celdas */
  .fc-daygrid-day {
    animation: fadeIn 0.3s ease-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* Quick Stats */
  .quick-stats {
    margin-bottom: 1rem;
  }

  .stat-item {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 50px;
    padding: 0.6rem 1.2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,51,121,0.1);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
  }

  .stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
  }

  .stat-icon {
    font-size: 1.2rem;
  }

  .stat-label {
    font-size: 0.9rem;
    color: var(--color-text);
  }

  .stat-label strong {
    color: var(--color-primary);
    font-size: 1.1rem;
  }

  /* Loading Spinner */
  .calendar-loader {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    gap: 0.75rem;
  }

  .calendar-loader.active {
    display: flex;
  }

  .loader-spinner {
    width: 40px;
    height: 40px;
    border: 3px solid rgba(0,51,121,0.1);
    border-top-color: var(--color-primary);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
  }

  @keyframes spin {
    to { transform: rotate(360deg); }
  }

  .calendar-loader span {
    color: var(--color-muted);
    font-size: 0.9rem;
  }

  /* Swipe Hint */
  .swipe-hint {
    text-align: center;
    margin-top: 1rem;
    padding: 0.75rem;
    color: var(--color-muted);
    font-size: 0.85rem;
    opacity: 0.7;
    animation: pulse 2s ease-in-out infinite;
  }

  @keyframes pulse {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 0.9; }
  }

  /* Touch feedback para celdas */
  .fc-daygrid-day:active {
    transform: scale(0.98);
    background: rgba(0,51,121,0.1);
  }

  /* Animación de transición del calendario */
  .fc-view-harness {
    transition: opacity 0.3s ease;
  }

  /* Efecto de highlight en días con eventos */
  .fc-daygrid-day.has-events {
    background: rgba(26,71,42,0.03);
  }

  .fc-daygrid-day.has-events .fc-daygrid-day-number {
    color: var(--color-success);
  }

  /* Vista MÓVIL optimizada */
  @media (max-width: 768px) {
    .container-fluid { padding: 0.5rem; }

    .card-body { padding: 1rem !important; }

    #calendar {
      padding: 0.75rem;
      border-radius: 12px;
    }

    .fc-toolbar {
      flex-direction: column !important;
      gap: 0.75rem;
      padding: 1rem;
    }

    .fc-toolbar-chunk {
      justify-content: center;
      width: 100%;
    }

    .fc-toolbar h2 {
      font-size: 1.15rem;
      text-align: center;
    }

    .fc-button {
      padding: 0.4rem 0.8rem !important;
      font-size: 0.8rem;
    }

    .fc-col-header-cell-cushion {
      font-size: 0.7rem;
    }

    .fc-daygrid-day-number {
      font-size: 0.85rem;
      width: 28px;
      height: 28px;
      margin: 0.15rem;
    }

    .fc-daygrid-event {
      font-size: 0.7rem;
      padding: 0.2rem 0.4rem;
    }

    #registroDialog {
      width: 95%;
      margin: 0 auto;
    }

    .streak-box {
      padding: 1rem;
      font-size: 0.9rem;
    }
  }

  /* Vista ESCRITORIO */
  @media (min-width: 992px) {
    #calendar {
      max-width: 900px;
      margin: 0 auto;
      padding: 1.5rem;
    }

    .fc-toolbar {
      flex-direction: row !important;
      flex-wrap: nowrap !important;
      padding: 0.3rem 0.75rem;
      border-radius: 8px;
      gap: 0.75rem;
    }

    .fc-toolbar h2 {
      font-size: 0.65rem;
      white-space: nowrap;
      padding: 0 0.75rem;
    }

    .fc-toolbar-chunk {
      flex-wrap: nowrap !important;
      gap: 0.25rem;
    }

    .fc-toolbar-chunk:first-child {
      margin-right: 0.5rem;
    }

    .fc-toolbar-chunk:last-child {
      margin-left: 0.5rem;
    }

    .fc-button {
      font-size: 0.5rem;
      padding: 0.05rem 0.2rem !important;
      border-radius: 3px !important;
      min-height: 18px;
    }

    .fc-button .fc-icon {
      font-size: 0.6rem;
    }

    #registroDialog { max-width: 500px; }

    .fc-daygrid-day-number {
      width: 38px;
      height: 38px;
      font-size: 1rem;
    }

    .fc-col-header-cell-cushion {
      font-size: 0.85rem;
    }
  }</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var loader = document.getElementById('calendarLoader');
    var totalEvents = 0;

    // Show/hide loader
    function showLoader() {
      loader.classList.add('active');
      calendarEl.style.opacity = '0.5';
    }

    function hideLoader() {
      loader.classList.remove('active');
      calendarEl.style.opacity = '1';
    }

    // Update stats counters
    function updateStats(events) {
      totalEvents = events.length;
      const currentMonth = calendar.getDate().getMonth();
      const currentYear = calendar.getDate().getFullYear();

      const monthEvents = events.filter(e => {
        const date = new Date(e.start);
        return date.getMonth() === currentMonth && date.getFullYear() === currentYear;
      }).length;

      // Animate counters
      animateCounter('monthCount', monthEvents);
      animateCounter('totalCount', totalEvents);
    }

    function animateCounter(elementId, target) {
      const element = document.getElementById(elementId);
      const start = parseInt(element.textContent) || 0;
      const duration = 500;
      const startTime = performance.now();

      function update(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const easeProgress = 1 - Math.pow(1 - progress, 3); // easeOutCubic
        const current = Math.round(start + (target - start) * easeProgress);
        element.textContent = current;

        if (progress < 1) {
          requestAnimationFrame(update);
        }
      }
      requestAnimationFrame(update);
    }

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
      loading: function(isLoading) {
        if (isLoading) {
          showLoader();
        } else {
          hideLoader();
        }
      },
      events: {
        url: '{{ route('asistencias.eventos') }}',
        failure: function() {
          hideLoader();
          alert('No se pudieron cargar las asistencias.');
        }
      },
      eventDidMount: function(info) {
        // Add animation class to events
        info.el.style.animation = 'fadeIn 0.3s ease-out';
        // Highlight days with events
        const dayCell = info.el.closest('.fc-daygrid-day');
        if (dayCell) {
          dayCell.classList.add('has-events');
        }
      },
      eventsSet: function(events) {
        updateStats(events);
        hideLoader();
      },
      dateClick: function(info) {
        // Touch feedback
        const dayCell = info.dayEl;
        dayCell.style.transform = 'scale(0.95)';
        setTimeout(() => {
          dayCell.style.transform = '';
        }, 150);

        document.getElementById('fechaAsistencia').value = info.dateStr;
        new bootstrap.Modal(document.getElementById('registroModal')).show();
      }
    });

    calendar.render();

    // SWIPE GESTURES for mobile navigation
    var touchStartX = 0;
    var touchEndX = 0;
    var touchStartY = 0;
    var minSwipeDistance = 50;

    calendarEl.addEventListener('touchstart', function(e) {
      touchStartX = e.changedTouches[0].screenX;
      touchStartY = e.changedTouches[0].screenY;
    }, { passive: true });

    calendarEl.addEventListener('touchend', function(e) {
      touchEndX = e.changedTouches[0].screenX;
      var touchEndY = e.changedTouches[0].screenY;

      // Calculate swipe distance
      var deltaX = touchEndX - touchStartX;
      var deltaY = touchEndY - touchStartY;

      // Only trigger if horizontal swipe is greater than vertical
      if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > minSwipeDistance) {
        if (deltaX > 0) {
          // Swipe right - go to previous month
          calendar.prev();
        } else {
          // Swipe left - go to next month
          calendar.next();
        }
      }
    }, { passive: true });

    // Fix aria-hidden focus issue
    document.getElementById('registroModal').addEventListener('hidden.bs.modal', function() {
      if (document.activeElement) {
        document.activeElement.blur();
      }
    });

    // Form submission with loading state
    document.getElementById('registroAsistenciaForm').addEventListener('submit', function(e) {
      e.preventDefault();
      var submitBtn = this.querySelector('button[type="submit"]');
      var originalText = submitBtn.textContent;

      var data = {
        fecha: document.getElementById('fechaAsistencia').value,
        ejercicio_id: document.getElementById('ejercicioSelect').value
      };

      if (!data.ejercicio_id) {
        return alert('⚠️ Debes seleccionar un ejercicio.');
      }

      // Loading state
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';

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

        // Reset form
        document.getElementById('ejercicioSelect').value = '';

        // Show success with animation
        document.getElementById('successModalMessage').innerHTML = '<div class="success-animation">' + res.message + ' 🎉</div>';
        new bootstrap.Modal(document.getElementById('successModal')).show();
      })
      .catch(err => {
        alert(err.message || 'Error al registrar.');
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
      });
    });

    // Add success animation styles
    var style = document.createElement('style');
    style.textContent = `
      .success-animation {
        animation: successPop 0.5s ease-out;
      }
      @keyframes successPop {
        0% { transform: scale(0.8); opacity: 0; }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); opacity: 1; }
      }
    `;
    document.head.appendChild(style);

    // Hide swipe hint after first interaction
    var swipeHint = document.querySelector('.swipe-hint');
    var hintHidden = localStorage.getItem('calendarSwipeHintHidden');
    if (hintHidden) {
      swipeHint.style.display = 'none';
    }

    calendarEl.addEventListener('touchstart', function() {
      if (!hintHidden) {
        localStorage.setItem('calendarSwipeHintHidden', 'true');
        swipeHint.style.opacity = '0';
        setTimeout(() => swipeHint.style.display = 'none', 300);
      }
    }, { once: true });
  });
</script>
@endsection