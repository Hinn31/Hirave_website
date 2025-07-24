<link rel="stylesheet" href="{{ asset('css/category.css') }}">
<div class="category-card">
  <a href="{{ $link ?? '#' }}">
    <img src="{{ $image }}" alt="{{ $name }}" class="category-image" />
    <h5 class="category-name">{{ $name }}</h5>
  </a>
</div>

