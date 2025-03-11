<div class="flex flex-col overflow-hidden sticky top-10">

    @if (($animal->getMedia('animals')->isNotEmpty()))
    <div class="swiper mySwiper2 mb-4">
        <div class="swiper-wrapper">
            @foreach ($animal->getMedia('animals') as $media)
                <div class="swiper-slide">
                    <img src="{{ asset('images/animal-placeholder-300px.webp') }}" 
                         data-src="{{ $media->getUrl('responsive') }}" 
                         alt="{{ $media->name }}" 
                         width="640"
                         height="640"
                         class="lazyload rounded-lg aspect-square w-full h-auto">
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