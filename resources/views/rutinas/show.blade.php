@extends('layouts.app')
@section('title', 'Detalle de Rutina')
@section('content')

<!-- Header -->
<div class="show-header">
  <h1>
    <i class="fas fa-running"></i>
    {{ $rutina->nombre }}
  </h1>
  @if($rutina->activa)
    <span class="badge bg-success mt-2">Rutina Activa</span>
  @endif
</div>

<!-- Descripción -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-align-left"></i> Descripción
  </div>
  <p class="mb-0">{{ $rutina->descripcion ?? 'Sin descripción' }}</p>
</div>

<!-- Planificación -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-calendar-week"></i> Planificación
  </div>
  <div class="row">
    <div class="col-md-3 show-field">
      <div class="show-label">Fecha de inicio</div>
      <div class="show-value">{{ $rutina->fecha_inicio ? \Carbon\Carbon::parse($rutina->fecha_inicio)->format('d/m/Y') : 'No definida' }}</div>
    </div>
    <div class="col-md-3 show-field">
      <div class="show-label">Fecha de fin</div>
      <div class="show-value">{{ $rutina->fecha_fin ? \Carbon\Carbon::parse($rutina->fecha_fin)->format('d/m/Y') : 'No definida' }}</div>
    </div>
    <div class="col-md-3 show-field">
      <div class="show-label">Hora de inicio</div>
      <div class="show-value">{{ $rutina->hora_inicio ? \Carbon\Carbon::parse($rutina->hora_inicio)->format('H:i') : 'No definida' }}</div>
    </div>
    <div class="col-md-3 show-field">
      <div class="show-label">Hora de fin</div>
      <div class="show-value">{{ $rutina->hora_fin ? \Carbon\Carbon::parse($rutina->hora_fin)->format('H:i') : 'No definida' }}</div>
    </div>
    <div class="col-12 show-field">
      <div class="show-label">Días seleccionados</div>
      <div class="show-value">
        @if($rutina->dias)
          @php
            $diasArray = is_array($rutina->dias) ? $rutina->dias : json_decode($rutina->dias, true);
            if (!is_array($diasArray)) $diasArray = [$rutina->dias];
          @endphp
          @foreach($diasArray as $dia)
            <span class="badge bg-primary me-1 mb-1"><i class="fas fa-check-circle me-1"></i>{{ $dia }}</span>
          @endforeach
        @else
          <span class="text-muted">No especificado</span>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Objetivos -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-bullseye"></i> Objetivos y Detalles
  </div>
  <div class="row">
    <div class="col-md-4 show-field">
      <div class="show-label">Estado</div>
      <div class="show-value">{{ ucfirst($rutina->estado) }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Objetivo</div>
      <div class="show-value">{{ $rutina->objetivo ?? 'No definido' }}</div>
    </div>
    <div class="col-md-4 show-field">
      <div class="show-label">Intensidad</div>
      <div class="show-value">{{ $rutina->intensidad ?? 'No definida' }}</div>
    </div>
    @if($rutina->notas)
    <div class="col-12 show-field">
      <div class="show-label">Notas</div>
      <div class="show-value">{{ $rutina->notas }}</div>
    </div>
    @endif
  </div>
</div>

<!-- Calendario visual -->
<div class="show-section">
  <div class="show-section-title">
    <i class="fas fa-calendar-alt"></i> Calendario Mensual
  </div>
  <div id="dynamic-calendar" class="text-center"></div>
</div>

<!-- Acciones -->
<div class="show-actions">
  <a href="{{ route('rutinas.index') }}" class="btn-back">
    <i class="fas fa-arrow-left"></i> Volver
  </a>
  <a href="{{ route('rutinas.edit', $rutina) }}" class="btn-edit">
    <i class="fas fa-edit"></i> Editar
  </a>
</div>

<style>
  .calendar-table {
    width: 100%;
    max-width: 400px;
    border-collapse: collapse;
    margin: 0 auto;
    text-align: center;
  }
  .calendar-table th, .calendar-table td {
    border: 1px solid #dee2e6;
    padding: 8px;
    font-size: 0.9rem;
  }
  .calendar-table th {
    background: var(--primary-color);
    color: #fff;
  }
  .calendar-table td.empty {
    background: #f8f9fa;
  }
  .calendar-table td.selected {
    background-color: var(--primary-color);
    color: #fff;
    font-weight: bold;
  }
  @media (max-width: 576px) {
    .calendar-table { font-size: 0.75rem; }
    .calendar-table th, .calendar-table td { padding: 4px; }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var startDateStr = "{{ $rutina->fecha_inicio ?? '' }}";
  var selectedDays = @json($rutina->dias);
  var dateObj = startDateStr ? new Date(startDateStr) : new Date();
  var year = dateObj.getFullYear();
  var month = dateObj.getMonth();

  function generateCalendar(year, month, selectedDays) {
    var dayNamesFull = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
    var dayNamesHeader = dayNamesFull.map(d => d.substring(0, 2));
    var firstDay = new Date(year, month, 1);
    var lastDay = new Date(year, month + 1, 0);
    var numDays = lastDay.getDate();
    var startWeekday = firstDay.getDay();

    var html = '<table class="calendar-table">';
    html += '<thead><tr>' + dayNamesHeader.map(h => '<th>' + h + '</th>').join('') + '</tr></thead>';
    html += '<tbody>';
    var currentDay = 1;
    for (var i = 0; i < 6; i++) {
      html += '<tr>';
      for (var j = 0; j < 7; j++) {
        if (i === 0 && j < startWeekday) {
          html += '<td class="empty"></td>';
        } else if (currentDay > numDays) {
          html += '<td class="empty"></td>';
        } else {
          var tempDate = new Date(year, month, currentDay);
          var dayName = dayNamesFull[tempDate.getDay()];
          var cellClass = selectedDays && selectedDays.includes(dayName) ? 'selected' : '';
          html += '<td class="' + cellClass + '">' + currentDay + '</td>';
          currentDay++;
        }
      }
      html += '</tr>';
      if (currentDay > numDays) break;
    }
    html += '</tbody></table>';
    return html;
  }
  
  document.getElementById('dynamic-calendar').innerHTML = generateCalendar(year, month, selectedDays);
});
</script>

@endsection
