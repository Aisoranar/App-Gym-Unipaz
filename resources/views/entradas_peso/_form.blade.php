<div class="mb-3">
    <label for="peso_actual_kg" class="form-label">
        <i class="fas fa-weight-hanging"></i> Peso actual (kg)
    </label>
    <input type="number" step="0.01" name="peso_actual_kg" id="peso_actual_kg"
           class="form-control" value="{{ old('peso_actual_kg', optional($entrada)->peso_actual_kg) }}" required>
</div>

<div class="mb-3">
    <label for="peso_ideal_kg" class="form-label">
        <i class="fas fa-bullseye"></i> Peso ideal (kg)
    </label>
    <input type="number" step="0.01" name="peso_ideal_kg" id="peso_ideal_kg"
           class="form-control" value="{{ old('peso_ideal_kg', optional($entrada)->peso_ideal_kg) }}">
</div>

<div class="mb-3">
    <label for="altura_cm" class="form-label">
        <i class="fas fa-ruler-vertical"></i> Altura (cm)
    </label>
    <input type="number" name="altura_cm" id="altura_cm"
           class="form-control" value="{{ old('altura_cm', optional($entrada)->altura_cm) }}" required>
</div>

<div class="mb-3">
    <label for="fecha" class="form-label">
        <i class="fas fa-calendar-alt"></i> Fecha
    </label>
    <input type="date" name="fecha" id="fecha"
           class="form-control" value="{{ old('fecha', optional($entrada)->fecha?->format('Y-m-d')) }}" required>
</div>