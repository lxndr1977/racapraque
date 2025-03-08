<div class="flex flex-col overflow-hidden sticky top-10">

    @if (($animal->getMedia('animals')->isNotEmpty()))
    <div class="swiper mySwiper2 mb-4">
        <div class="swiper-wrapper">
            @foreach ($animal->getMedia('animals') as $media)
                <div class="swiper-slide">
                    <img src="{{ $media->getUrl('responsive') }}" alt="{{ $media->name }}" class="rounded-lg">
                </div>
            @endforeach
        </div>
    </div>

    <div class="swiper swiper-animal-thumbnails">
        <div class="swiper-wrapper">
            @foreach ($animal->getMedia('animals') as $media)
                <div class="swiper-slide">
                    <img src="{{ $media->getUrl('responsive') }}" alt="{{ $media->name }}" class="rounded-lg w-full">
                </div>
            @endforeach
        </div>
    </div>
    @else
        <img src="{{ asset('images/animal-placeholder.jpg') }}" alt="Foto do abrigado" class="rounded-lg w-full">
    @endif
</div> 