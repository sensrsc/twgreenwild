<section class="activities">
    @if ($section_title)
        <h2 class="section-title">{{ $section_title }}</h2>
    @endif
    @foreach ($activities as $activity)
        <a href="/activity/{{ $activity['id'] }}">
            <div class="activity">
                <div class="info">
                    <h3 class="title">{{ $activity['title'] }}</h3>
                    <p class="hr">-</p>
                    <p class="desc">{{ $activity['type'] }} · {{ $activity['region'] }}</p>
                </div>
                <img class="cover" src="{{ $activity['cover'] }}">
                <p class="price"><span>TWD.</span>{{ $activity['price'] }}</p>
            </div>
        </a>
    @endforeach
</section>
