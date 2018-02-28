<section class="activities">
    <h2 class="section-title">{{ $section_title }}</h2>
    @foreach ($activities as $activity)
        <div class="activity">
            <div class="info">
                <h3 class="title">{{ $activity['title'] }}</h3>
                <p class="hr">-</p>
                <p class="desc">{{ $activity['type'] }} · {{ $activity['region'] }}</p>
            </div>
            <img class="cover" src="{{ $activity['cover'] }}">
            <p class="price"><span>TWD.</span>{{ $activity['price'] }}7</p>
        </div>
    @endforeach
</section>
