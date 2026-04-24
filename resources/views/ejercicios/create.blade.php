@extends('layouts.app')
@section('title', 'Crear Nuevo Ejercicio')
@section('content')

<style>
  .exercise-form-container {
    max-width: 1200px;
    margin: 0 auto;
  }
  
  .media-upload-zone {
    border: 3px dashed #003379;
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  
  .media-upload-zone:hover {
    border-color: #0056a8;
    background: linear-gradient(135deg, #e6f0ff 0%, #d4e4ff 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,51,121,0.15);
  }
  
  .media-upload-zone.has-file {
    border-color: #28a745;
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
  }
  
  .upload-icon {
    font-size: 3rem;
    color: #003379;
    margin-bottom: 1rem;
  }
  
  .upload-text {
    font-size: 1.1rem;
    color: #495057;
    font-weight: 500;
  }
  
  .upload-hint {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 0.5rem;
  }
  
  .preview-container {
    margin-top: 1rem;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }
  
  .preview-container img,
  .preview-container video {
    width: 100%;
    max-height: 300px;
    object-fit: cover;
  }
  
  .form-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
    margin-bottom: 1.5rem;
  }
  
  .form-card-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
  }
  
  .form-card-header i {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #003379, #0056a8);
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
  }
  
  .form-card-header h5 {
    margin: 0;
    font-weight: 700;
    color: #003379;
  }
  
  .input-group-custom {
    position: relative;
    margin-bottom: 1rem;
  }
  
  .input-group-custom .input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #003379;
    z-index: 10;
  }
  
  .input-group-custom input,
  .input-group-custom select,
  .input-group-custom textarea {
    padding-left: 3rem;
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
  }
  
  .input-group-custom input:focus,
  .input-group-custom select:focus,
  .input-group-custom textarea:focus {
    border-color: #003379;
    box-shadow: 0 0 0 3px rgba(0,51,121,0.1);
  }
  
  .btn-create-exercise {
    background: linear-gradient(135deg, #003379, #0056a8);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.1rem;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,51,121,0.3);
  }
  
  .btn-create-exercise:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,51,121,0.4);
    color: white;
  }
  
  .difficulty-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.9rem;
  }
  
  .difficulty-baja { background: #d4edda; color: #155724; }
  .difficulty-media { background: #fff3cd; color: #856404; }
  .difficulty-alta { background: #f8d7da; color: #721c24; }
</style>

<div class="exercise-form-container py-4">
  <!-- Header -->
  <div class="page-header mb-4">
    <div>
      <h1><i class="fas fa-dumbbell"></i> Crear Nuevo Ejercicio</h1>
      <p class="mb-0 mt-2 opacity-75">Diseña un ejercicio completo con imágenes y video explicativo</p>
    </div>
  </div>

  <form method="POST" action="{{ route('ejercicios.store') }}" enctype="multipart/form-data">
    @csrf
    
    {{-- Mostrar errores de validación --}}
    @if($errors->any())
      <div class="alert alert-danger mb-4">
        <strong><i class="fas fa-exclamation-circle"></i> Errores en el formulario:</strong>
        <ul class="mb-0 mt-2">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    
    <div class="row">
      <!-- Columna izquierda: Media -->
      <div class="col-lg-5 mb-4">
        <!-- Upload de Imagen -->
        <div class="form-card">
          <div class="form-card-header">
            <i class="fas fa-image"></i>
            <h5>Imagen del Ejercicio</h5>
          </div>
          
          <div class="media-upload-zone" id="fotoZone">
            <input type="file" name="foto" id="foto" class="d-none" accept="image/*">
            <div class="upload-content" id="fotoUploadContent">
              <i class="fas fa-cloud-upload-alt upload-icon"></i>
              <div class="upload-text">Arrastra o haz clic para subir imagen</div>
              <div class="upload-hint">JPG, PNG, GIF (sin límite de tamaño)</div>
            </div>
            <div class="preview-container d-none" id="fotoPreview"></div>
          </div>
        </div>
        
        <!-- Upload de Video -->
        <div class="form-card">
          <div class="form-card-header">
            <i class="fas fa-video"></i>
            <h5>Video Explicativo</h5>
          </div>
          
          <div class="media-upload-zone" id="videoZone">
            <input type="file" name="video" id="video" class="d-none" accept="video/mp4,video/avi,video/quicktime,video/x-msvideo">
            <div class="upload-content" id="videoUploadContent">
              <i class="fas fa-play-circle upload-icon"></i>
              <div class="upload-text">Arrastra o haz clic para subir video</div>
              <div class="upload-hint">MP4, AVI, MOV (sin límite de tamaño)</div>
            </div>
            <div class="preview-container d-none" id="videoPreview"></div>
          </div>
        </div>
      </div>
      
      <!-- Columna derecha: Detalles -->
      <div class="col-lg-7">
        <div class="form-card">
          <div class="form-card-header">
            <i class="fas fa-info-circle"></i>
            <h5>Información del Ejercicio</h5>
          </div>
          
          <div class="row g-3">
            <!-- Nombre -->
            <div class="col-12">
              <label class="form-label fw-semibold">Nombre del Ejercicio</label>
              <div class="input-group-custom">
                <i class="fas fa-running input-icon"></i>
                <input type="text" name="nombre_ejercicio" class="form-control form-control-lg" placeholder="Ej: Press de Banca, Sentadillas, Peso Muerto..." required>
              </div>
            </div>
            
            <!-- Grupo Muscular -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Grupo Muscular</label>
              <div class="input-group-custom">
                <i class="fas fa-layer-group input-icon"></i>
                <select name="grupo_muscular" class="form-select">
                  <option value="">Selecciona...</option>
                  <option value="Pecho">Pecho</option>
                  <option value="Espalda">Espalda</option>
                  <option value="Hombros">Hombros</option>
                  <option value="Bíceps">Bíceps</option>
                  <option value="Tríceps">Tríceps</option>
                  <option value="Piernas">Piernas</option>
                  <option value="Glúteos">Glúteos</option>
                  <option value="Abdomen">Abdomen</option>
                  <option value="Cardio">Cardio</option>
                  <option value="Full Body">Full Body</option>
                </select>
              </div>
            </div>
            
            <!-- Nivel de Dificultad -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Nivel de Dificultad</label>
              <div class="input-group-custom">
                <i class="fas fa-signal input-icon"></i>
                <select name="nivel_dificultad" class="form-select" required>
                  <option value="Baja" class="difficulty-baja">🟢 Principiante</option>
                  <option value="Media" class="difficulty-media" selected>🟡 Intermedio</option>
                  <option value="Alta" class="difficulty-alta">🔴 Avanzado</option>
                </select>
              </div>
            </div>
            
            <!-- Descripción -->
            <div class="col-12">
              <label class="form-label fw-semibold">Descripción del Ejercicio</label>
              <div class="input-group-custom">
                <i class="fas fa-align-left input-icon" style="top: 1.5rem;"></i>
                <textarea name="descripcion" class="form-control" rows="4" placeholder="Explica el ejercicio, músculos trabajados, beneficios..."></textarea>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Configuración de Series/Repeticiones -->
        <div class="form-card">
          <div class="form-card-header">
            <i class="fas fa-sliders-h"></i>
            <h5>Configuración de Series</h5>
          </div>
          
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label fw-semibold">Series</label>
              <div class="input-group-custom">
                <i class="fas fa-redo input-icon"></i>
                <input type="number" name="series" class="form-control" placeholder="3" min="1">
              </div>
            </div>
            
            <div class="col-md-3">
              <label class="form-label fw-semibold">Repeticiones</label>
              <div class="input-group-custom">
                <i class="fas fa-hashtag input-icon"></i>
                <input type="number" name="repeticiones" class="form-control" placeholder="12" min="1">
              </div>
            </div>
            
            <div class="col-md-3">
              <label class="form-label fw-semibold">Duración (min)</label>
              <div class="input-group-custom">
                <i class="fas fa-clock input-icon"></i>
                <input type="number" name="duracion" class="form-control" placeholder="5" min="1">
              </div>
            </div>
            
            <div class="col-md-3">
              <label class="form-label fw-semibold">Calorías</label>
              <div class="input-group-custom">
                <i class="fas fa-fire input-icon"></i>
                <input type="number" name="calorias_aprox" class="form-control" placeholder="50" min="1">
              </div>
            </div>
          </div>
        </div>
        
        <!-- Fecha -->
        <div class="form-card">
          <div class="form-card-header">
            <i class="fas fa-calendar-alt"></i>
            <h5>Fecha de Publicación</h5>
          </div>
          <div class="input-group-custom">
            <i class="fas fa-calendar input-icon"></i>
            <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
          </div>
        </div>
        
        <!-- Botones -->
        <div class="d-flex gap-3 justify-content-end">
          <a href="{{ route('ejercicios.index') }}" class="btn btn-outline-secondary btn-lg">
            <i class="fas fa-times"></i> Cancelar
          </a>
          <button type="submit" class="btn-create-exercise">
            <i class="fas fa-plus-circle"></i> Crear Ejercicio
          </button>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
// Configurar zona de imagen
setupUploadZone('fotoZone', 'foto', 'fotoUploadContent', 'fotoPreview', previewImage);

// Configurar zona de video
setupUploadZone('videoZone', 'video', 'videoUploadContent', 'videoPreview', previewVideo);

function setupUploadZone(zoneId, inputId, contentId, previewId, previewFunc) {
  const zone = document.getElementById(zoneId);
  const input = document.getElementById(inputId);
  const content = document.getElementById(contentId);
  const preview = document.getElementById(previewId);

  // Click para abrir selector
  zone.addEventListener('click', function(e) {
    // No abrir si se hace click en el preview
    if (e.target.closest('.preview-container')) return;
    input.click();
  });

  // Drag enter
  zone.addEventListener('dragenter', function(e) {
    e.preventDefault();
    e.stopPropagation();
    this.classList.add('dragover');
  });

  // Drag over
  zone.addEventListener('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
    this.classList.add('dragover');
  });

  // Drag leave
  zone.addEventListener('dragleave', function(e) {
    e.preventDefault();
    e.stopPropagation();
    this.classList.remove('dragover');
  });

  // Drop
  zone.addEventListener('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();
    this.classList.remove('dragover');

    const files = e.dataTransfer.files;
    if (files.length) {
      input.files = files;
      previewFunc(input);
    }
  });

  // Change event
  input.addEventListener('change', function() {
    previewFunc(this);
  });
}

function previewImage(input) {
  const preview = document.getElementById('fotoPreview');
  const content = document.getElementById('fotoUploadContent');

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
      preview.classList.remove('d-none');
      content.classList.add('d-none');
      preview.closest('.media-upload-zone').classList.add('has-file');
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function previewVideo(input) {
  const preview = document.getElementById('videoPreview');
  const content = document.getElementById('videoUploadContent');

  if (input.files && input.files[0]) {
    const url = URL.createObjectURL(input.files[0]);
    preview.innerHTML = '<video controls><source src="' + url + '" type="video/mp4"></video>';
    preview.classList.remove('d-none');
    content.classList.add('d-none');
    preview.closest('.media-upload-zone').classList.add('has-file');
  }
}

// CSS para dragover
const style = document.createElement('style');
style.textContent = `
  .media-upload-zone.dragover {
    border-color: #28a745 !important;
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
    transform: scale(1.02);
  }
`;
document.head.appendChild(style);
</script>

@endsection
