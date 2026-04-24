@extends('layouts.app')
@section('title', 'Ejercicios')
@section('content')

<style>
  .exercise-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: none;
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  
  .exercise-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,51,121,0.15);
  }
  
  .exercise-image {
    position: relative;
    height: 200px;
    overflow: hidden;
  }
  
  .exercise-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top;
    transition: transform 0.3s ease;
  }
  
  .exercise-card:hover .exercise-image img {
    transform: scale(1.05);
  }
  
  .exercise-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .badge-pecho { background: #ff6b6b; color: white; }
  .badge-espalda { background: #4ecdc4; color: white; }
  .badge-hombros { background: #45b7d1; color: white; }
  .badge-piernas { background: #96ceb4; color: white; }
  .badge-biceps { background: #feca57; color: #333; }
  .badge-triceps { background: #ff9ff3; color: white; }
  .badge-abdomen { background: #54a0ff; color: white; }
  .badge-cardio { background: #5f27cd; color: white; }
  .badge-default { background: #003379; color: white; }
  
  .exercise-difficulty {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 700;
  }
  
  .difficulty-baja { background: #d4edda; color: #155724; }
  .difficulty-media { background: #fff3cd; color: #856404; }
  .difficulty-alta { background: #f8d7da; color: #721c24; }
  
  .exercise-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
  }
  
  .exercise-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #003379;
    margin-bottom: 0.5rem;
    line-height: 1.3;
  }
  
  .exercise-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
  }
  
  .exercise-meta-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.85rem;
    color: #6c757d;
  }
  
  .exercise-meta-item i {
    color: #003379;
  }
  
  .exercise-description {
    color: #6c757d;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  
  .exercise-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
  }
  
  .exercise-stats {
    display: flex;
    gap: 1rem;
  }
  
  .exercise-stat {
    text-align: center;
  }
  
  .exercise-stat-value {
    font-size: 1.1rem;
    font-weight: 700;
    color: #003379;
  }
  
  .exercise-stat-label {
    font-size: 0.7rem;
    color: #6c757d;
    text-transform: uppercase;
  }
  
  .btn-view-exercise {
    background: linear-gradient(135deg, #003379, #0056a8);
    color: white;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
  }
  
  .btn-view-exercise:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(0,51,121,0.3);
    color: white;
  }
  
  .filter-bar {
    background: white;
    border-radius: 16px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  }
  
  .filter-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #003379;
    margin-bottom: 0.75rem;
    font-size: 0.9rem;
  }
  
  .filter-scroll {
    display: flex;
    gap: 0.5rem;
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
    padding-bottom: 0.5rem;
    -webkit-overflow-scrolling: touch;
    position: relative;
    cursor: grab;
    user-select: none;
  }
  
  .filter-scroll:active {
    cursor: grabbing;
  }
  
  .filter-scroll::-webkit-scrollbar {
    display: none;
  }
  
  /* Swipe indicator for mobile - always visible */
  .swipe-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.5rem;
    margin-bottom: 0.5rem;
    color: #6c757d;
    font-size: 0.85rem;
    cursor: grab;
    user-select: none;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 20px;
    border: 1px dashed #003379;
  }
  
  .swipe-indicator:active {
    cursor: grabbing;
  }
  
  .swipe-indicator i {
    font-size: 1.2rem;
    color: #003379;
  }
  
  .swipe-indicator .fa-hand-pointer {
    animation: swipeHand 2s ease-in-out infinite;
  }
  
  @keyframes swipeHand {
    0%, 100% { transform: translateX(0); }
    50% { transform: translateX(8px); }
  }
  
  /* Gradient fade on edges */
  .filter-scroll-container {
    position: relative;
  }
  
  .filter-scroll-container::after {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0.5rem;
    width: 40px;
    background: linear-gradient(to right, transparent, white);
    pointer-events: none;
    border-radius: 0 16px 16px 0;
  }
  
  @media (min-width: 768px) {
    .swipe-indicator,
    .filter-scroll-container::after {
      display: none;
    }
  }
  
  .filter-btn {
    padding: 0.6rem 1.2rem;
    border-radius: 25px;
    border: 2px solid #e9ecef;
    background: white;
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    flex-shrink: 0;
  }
  
  .filter-btn:hover,
  .filter-btn.active {
    border-color: #003379;
    background: linear-gradient(135deg, #003379, #0056a8);
    color: white;
    box-shadow: 0 4px 12px rgba(0,51,121,0.25);
    transform: translateY(-1px);
  }
  
  @media (min-width: 768px) {
    .filter-bar {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 1rem 1.5rem;
    }
    
    .filter-label {
      margin-bottom: 0;
    }
    
    .filter-scroll {
      flex-wrap: wrap;
      overflow-x: visible;
      padding-bottom: 0;
    }
  }
  
  .no-exercise-image {
    height: 200px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    font-size: 3rem;
  }

  /* Hero Banner */
  .hero-banner {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    animation: fadeUp 0.6s ease-out;
    animation-delay: 0.1s;
    animation-fill-mode: both;
  }

  .hero-banner img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    object-position: center;
    display: block;
    transition: transform 0.5s ease;
  }

  @media (min-width: 768px) {
    .hero-banner img {
      height: 220px;
    }
  }

  @media (min-width: 992px) {
    .hero-banner img {
      height: 260px;
    }
  }

  .hero-banner:hover img {
    transform: scale(1.03);
  }

  .hero-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,51,121,0.9), transparent 70%);
    padding: 2rem 1.5rem 1.5rem;
    color: white;
  }

  .hero-title {
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  @media (min-width: 768px) {
    .hero-title {
      font-size: 1.8rem;
    }
  }

  .hero-subtitle {
    font-size: 0.9rem;
    opacity: 0.95;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
  }

  @media (min-width: 768px) {
    .hero-subtitle {
      font-size: 1.1rem;
    }
  }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<!-- Header -->
<div class="page-header">
  <div>
    <h1><i class="fas fa-dumbbell"></i> Biblioteca de Ejercicios</h1>
    <p class="mb-0 mt-2 opacity-75">Explora ejercicios con videos e imágenes explicativas</p>
  </div>
  <div class="page-actions">
    @if(Auth::user()->role === 'entrenador' || Auth::user()->role === 'superadmin')
      <a href="{{ route('ejercicios.create') }}" class="btn-primary-gym">
        <i class="fas fa-plus"></i>
        <span class="d-none d-sm-inline">Nuevo Ejercicio</span>
      </a>
    @endif
  </div>
</div>

<!-- Hero Banner -->
<div class="hero-banner mb-4">
  <img src="{{ asset('images/images/im3.jpeg') }}" alt="Ejercicios - GymApp">
  <div class="hero-overlay">
    <div class="hero-title"><i class="fas fa-fire"></i> Potencia tu Entrenamiento</div>
    <div class="hero-subtitle">Descubre ejercicios profesionales para cada grupo muscular</div>
  </div>
</div>

<!-- Filtros -->
<div class="filter-bar">
  <div class="filter-label">
    <i class="fas fa-filter"></i>
    <span>Filtrar por grupo:</span>
  </div>
  
  <!-- Indicador de swipe para móvil -->
  <div class="swipe-indicator d-md-none">
    <i class="fas fa-hand-pointer"></i>
    <span>Desliza para ver más</span>
    <i class="fas fa-chevron-right"></i>
  </div>
  
  <div class="filter-scroll-container">
    <div class="filter-scroll">
      <button class="filter-btn active" onclick="filterExercises('all', this)">Todos</button>
      @foreach(['Pecho', 'Espalda', 'Hombros', 'Piernas', 'Bíceps', 'Tríceps', 'Abdomen', 'Cardio'] as $grupo)
        <button class="filter-btn" onclick="filterExercises('{{ strtolower($grupo) }}', this)">{{ $grupo }}</button>
      @endforeach
    </div>
  </div>
</div>

<!-- Búsqueda -->
<div class="gym-search mb-4">
  <i class="fas fa-search"></i>
  <input type="text" id="searchEjercicios" placeholder="Buscar ejercicio por nombre...">
</div>

<!-- Grid de ejercicios -->
<div class="row g-4" id="exercisesGrid">
  @forelse($ejercicios as $ejercicio)
    <div class="col-md-6 col-lg-4 exercise-item" data-grupo="{{ strtolower($ejercicio->grupo_muscular ?? 'otros') }}">
      <div class="exercise-card">
        <!-- Imagen -->
        <div class="exercise-image">
          @if($ejercicio->foto)
            <img src="{{ asset('storage/' . $ejercicio->foto) }}" alt="{{ $ejercicio->nombre_ejercicio }}">
          @else
            <div class="no-exercise-image">
              <i class="fas fa-dumbbell"></i>
            </div>
          @endif
          
          <!-- Badge de grupo muscular -->
          @if($ejercicio->grupo_muscular)
            <span class="exercise-badge badge-{{ strtolower(str_replace(['í', 'é', 'ú', 'ó', 'á', 'ñ'], ['i', 'e', 'u', 'o', 'a', 'n'], $ejercicio->grupo_muscular)) }}">
              {{ $ejercicio->grupo_muscular }}
            </span>
          @endif
          
          <!-- Badge de dificultad -->
          <span class="exercise-difficulty difficulty-{{ strtolower($ejercicio->nivel_dificultad) }}">
            {{ substr($ejercicio->nivel_dificultad, 0, 1) }}
          </span>
        </div>
        
        <!-- Contenido -->
        <div class="exercise-content">
          <h3 class="exercise-title">{{ $ejercicio->nombre_ejercicio }}</h3>
          
          <div class="exercise-meta">
            <div class="exercise-meta-item">
              <i class="fas fa-calendar"></i>
              <span>{{ $ejercicio->fecha }}</span>
            </div>
            @if($ejercicio->video)
              <div class="exercise-meta-item">
                <i class="fas fa-video"></i>
                <span>Video</span>
              </div>
            @endif
          </div>
          
          @if($ejercicio->descripcion)
            <p class="exercise-description">{{ $ejercicio->descripcion }}</p>
          @endif
          
          <div class="exercise-footer">
            <div class="exercise-stats">
              @if($ejercicio->series)
                <div class="exercise-stat">
                  <div class="exercise-stat-value">{{ $ejercicio->series }}</div>
                  <div class="exercise-stat-label">Series</div>
                </div>
              @endif
              @if($ejercicio->repeticiones)
                <div class="exercise-stat">
                  <div class="exercise-stat-value">{{ $ejercicio->repeticiones }}</div>
                  <div class="exercise-stat-label">Reps</div>
                </div>
              @endif
              @if($ejercicio->duracion)
                <div class="exercise-stat">
                  <div class="exercise-stat-value">{{ $ejercicio->duracion }}</div>
                  <div class="exercise-stat-label">Min</div>
                </div>
              @endif
            </div>
            
            <a href="{{ route('ejercicios.show', $ejercicio) }}" class="btn-view-exercise">
              Ver <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>
        
        <!-- Acciones admin (solo visibles para entrenadores/superadmin) -->
        @if(Auth::user()->role === 'entrenador' || Auth::user()->role === 'superadmin')
          <div class="px-4 pb-3 d-flex gap-2">
            <a href="{{ route('ejercicios.edit', $ejercicio) }}" class="btn btn-sm btn-outline-warning flex-fill">
              <i class="fas fa-edit"></i> Editar
            </a>
            <form action="{{ route('ejercicios.destroy', $ejercicio) }}" method="POST" class="flex-fill" onsubmit="return confirm('¿Eliminar este ejercicio?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                <i class="fas fa-trash"></i> Eliminar
              </button>
            </form>
          </div>
        @endif
      </div>
    </div>
  @empty
    <div class="col-12 text-center py-5">
      <div class="mb-4">
        <i class="fas fa-dumbbell fa-4x text-muted"></i>
      </div>
      <h4 class="text-muted mb-3">No hay ejercicios disponibles</h4>
      @if(Auth::user()->role === 'entrenador' || Auth::user()->role === 'superadmin')
        <p class="text-muted mb-4">Comienza creando ejercicios con videos e imágenes explicativas</p>
        <a href="{{ route('ejercicios.create') }}" class="btn-primary-gym btn-lg">
          <i class="fas fa-plus me-2"></i>Crear Primer Ejercicio
        </a>
      @else
        <p class="text-muted">Pronto añadiremos nuevos ejercicios a la biblioteca</p>
      @endif
    </div>
  @endforelse
</div>

<script>
  // Búsqueda
  document.getElementById('searchEjercicios')?.addEventListener('input', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.exercise-item').forEach(item => {
      const text = item.textContent.toLowerCase();
      item.style.display = text.includes(term) ? '' : 'none';
    });
  });
  
  // Filtros
  function filterExercises(grupo, btn) {
    // Actualizar botones activos
    document.querySelectorAll('.filter-btn').forEach(b => {
      b.classList.remove('active');
    });
    btn.classList.add('active');
    
    // Filtrar ejercicios
    document.querySelectorAll('.exercise-item').forEach(item => {
      if (grupo === 'all' || item.dataset.grupo === grupo) {
        item.style.display = '';
      } else {
        item.style.display = 'none';
      }
    });
  }
  
  // Drag/Swipe para filtros en móvil y desktop
  const filterScroll = document.querySelector('.filter-scroll');
  const swipeIndicator = document.querySelector('.swipe-indicator');
  let isDown = false;
  let startX;
  let scrollLeft;

  // Función para manejar el inicio del drag
  function handleDragStart(e) {
    isDown = true;
    filterScroll.style.cursor = 'grabbing';
    if (swipeIndicator) swipeIndicator.style.cursor = 'grabbing';
    startX = e.pageX || e.touches[0].pageX;
    scrollLeft = filterScroll.scrollLeft;
  }

  // Función para manejar el movimiento del drag
  function handleDragMove(e) {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX || (e.touches ? e.touches[0].pageX : 0);
    const walk = (x - startX) * 2;
    filterScroll.scrollLeft = scrollLeft - walk;
  }

  // Función para manejar el fin del drag
  function handleDragEnd() {
    isDown = false;
    filterScroll.style.cursor = 'grab';
    if (swipeIndicator) swipeIndicator.style.cursor = 'grab';
    snapToNearestButton();
  }

  // Eventos para filter-scroll
  filterScroll.addEventListener('mousedown', handleDragStart);
  filterScroll.addEventListener('mousemove', handleDragMove);
  filterScroll.addEventListener('mouseup', handleDragEnd);
  filterScroll.addEventListener('mouseleave', handleDragEnd);

  // Eventos para swipe-indicator (que también dispara el scroll)
  if (swipeIndicator) {
    swipeIndicator.addEventListener('mousedown', handleDragStart);
    swipeIndicator.addEventListener('mousemove', handleDragMove);
    swipeIndicator.addEventListener('mouseup', handleDragEnd);
    swipeIndicator.addEventListener('mouseleave', handleDragEnd);
    
    // Touch events para swipe-indicator
    swipeIndicator.addEventListener('touchstart', (e) => {
      handleDragStart(e);
    }, {passive: true});
    
    swipeIndicator.addEventListener('touchmove', (e) => {
      handleDragMove(e);
    }, {passive: true});
    
    swipeIndicator.addEventListener('touchend', handleDragEnd);
  }

  // Touch events para filter-scroll
  filterScroll.addEventListener('touchstart', (e) => {
    handleDragStart(e);
  }, {passive: true});

  filterScroll.addEventListener('touchmove', (e) => {
    handleDragMove(e);
  }, {passive: true});

  filterScroll.addEventListener('touchend', handleDragEnd);

  // Snap al botón más cercano
  function snapToNearestButton() {
    const buttons = filterScroll.querySelectorAll('.filter-btn');
    const scrollPos = filterScroll.scrollLeft;
    let nearestBtn = null;
    let minDistance = Infinity;

    buttons.forEach(btn => {
      const btnLeft = btn.offsetLeft;
      const distance = Math.abs(btnLeft - scrollPos);
      if (distance < minDistance) {
        minDistance = distance;
        nearestBtn = btn;
      }
    });

    if (nearestBtn) {
      filterScroll.scrollTo({
        left: nearestBtn.offsetLeft - 20,
        behavior: 'smooth'
      });
    }
  }
</script>

@endsection
