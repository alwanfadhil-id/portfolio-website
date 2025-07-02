<div class="timeline">
    @foreach($experiences as $experience)
    <div class="timeline-item">
        <div class="timeline-marker"></div>
        <div class="timeline-content">
            <h3>{{ $experience->title }}</h3>
            <p class="timeline-date">{{ $experience->period }}</p>
            <p>{{ $experience->description }}</p>
        </div>
    </div>
    @endforeach
</div>