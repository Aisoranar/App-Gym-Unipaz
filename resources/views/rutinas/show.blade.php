@extends('layouts.app')
@section('title', 'Detalle de Rutina')
@section('content')
<div class="container py-4">
  <h1 class="mb-4">{{ $rutina->nombre }}</h1>

  <div class="card mb-4">
    <div class="card-header">
      <strong>Descripción</strong>
    </div>
    <div class="card-body">
      <p>{{ $rutina->descripcion ?? 'No especificada' }}</p>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-header">
      <strong>Planificación</strong>
    </div>
    <div class="card-body">
      <p>
        <strong>Fecha de inicio:</strong>
        {{ $rutina->fecha_inicio ? \Carbon\Carbon::parse($rutina->fecha_inicio)->format('d/m/Y') : 'No definida' }}
      </p>
      <p>
        <strong>Fecha de fin:</strong>
        {{ $rutina->fecha_fin ? \Carbon\Carbon::parse($rutina->fecha_fin)->format('d/m/Y') : 'No definida' }}
      </p>
      <p>
        <strong>Hora de inicio:</strong>
        {{ $rutina->hora_inicio ? \Carbon\Carbon::parse($rutina->hora_inicio)->format('H:i') : 'No definida' }}
      </p>
      <p>
        <strong>Hora de fin:</strong>
        {{ $rutina->hora_fin ? \Carbon\Carbon::parse($rutina->hora_fin)->format('H:i') : 'No definida' }}
      </p>
      <p>
        <strong>Días seleccionados:</strong> 
        @if($rutina->dias)
          {{ is_array($rutina->dias) ? implode(', ', $rutina->dias) : $rutina->dias }}
        @else
          No especificado
        @endif
      </p>
      <!-- Calendario dinámico -->
      <div id="dynamic-calendar"></div>
      <!-- Fin calendario dinámico -->
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-header">
      <strong>Objetivos y Detalles</strong>
    </div>
    <div class="card-body">
      <p><strong>Estado:</strong> {{ ucfirst($rutina->estado) }}</p>
      <p><strong>Objetivo:</strong> {{ $rutina->objetivo ?? 'No definido' }}</p>
      <p><strong>Intensidad:</strong> {{ $rutina->intensidad ?? 'No definida' }}</p>
      <p><strong>Notas:</strong> {{ $rutina->notas ?? 'No hay notas' }}</p>
    </div>
  </div>

  <!-- Botones de acción -->
  <a href="{{ route('rutinas.edit', $rutina) }}" class="btn btn-warning mb-2">
    <i class="fa-solid fa-pen-to-square"></i> Editar Rutina
  </a>
  <a href="{{ route('rutinas.index') }}" class="btn btn-secondary">
    <i class="fa-solid fa-arrow-left"></i> Volver a Mis Rutinas
  </a>
</div>

<!-- Estilos para el calendario dinámico -->
<style>
  .calendar-table {
    width: 100%;
    max-width: 400px;
    border-collapse: collapse;
    margin: 20px auto;
    text-align: center;
  }
  .calendar-table th,
  .calendar-table td {
    border: 1px solid #ccc;
    padding: 8px;
  }
  .calendar-table th {
    background: var(--primary, #001f3f);
    color: #fff;
  }
  .calendar-table td.empty {
    background: #f0f0f0;
  }
  .calendar-table td.selected {
    background-color: #FF6347; /* Color tomate para días seleccionados */
    color: #fff;
    font-weight: bold;
  }
  /* Estilos responsivos para móviles */
  @media only screen and (max-width: 576px) {
    .calendar-table {
      max-width: 100%;
      font-size: 0.8rem;
      margin: 10px auto;
    }
    .calendar-table th,
    .calendar-table td {
      padding: 4px;
    }
  }
</style>

<!-- Script para generar el calendario dinámico -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Obtener la fecha de inicio y días seleccionados desde Blade.
  var startDateStr = "{{ $rutina->fecha_inicio ?? '' }}";
  var selectedDays = @json($rutina->dias);

  // Usar la fecha de inicio para determinar el mes; si no existe, usar el mes actual.
  var dateObj = startDateStr ? new Date(startDateStr) : new Date();
  var year = dateObj.getFullYear();
  var month = dateObj.getMonth(); // Mes 0-indexado (0 = Enero)

  // Función para generar el calendario.
  function generateCalendar(year, month, selectedDays) {
    var dayNamesFull = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
    var dayNamesHeader = dayNamesFull.map(function(day) {
      return day.substring(0, 2);
    });

    var firstDay = new Date(year, month, 1);
    var lastDay = new Date(year, month + 1, 0);
    var numDays = lastDay.getDate();
    var startWeekday = firstDay.getDay();

    var html = '<table class="calendar-table">';
    html += '<thead><tr>';
    dayNamesHeader.forEach(function(header) {
      html += '<th>' + header + '</th>';
    });
    html += '</tr></thead>';
    
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
  
  var calendarContainer = document.getElementById('dynamic-calendar');
  calendarContainer.innerHTML = generateCalendar(year, month, selectedDays);
});
</script>
@endsection
