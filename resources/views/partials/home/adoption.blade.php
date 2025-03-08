<div class="-mt-[22rem] -mb-[1rem]">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none" style="margin-top:10rem;width:100%;height:12rem;display:block"><path fill="#f5f5f5" fill-opacity="1" d="M0,256L80,250.7C160,245,320,235,480,245.3C640,256,800,288,960,288C1120,288,1280,256,1360,240L1440,224L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>
</div>

<section class="py-18 bg-zinc-100">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <p class="text-tertiary font-bold uppercase tracking-wide mb-2 text-center">Conheça o seu melhor amigo</p>
            <h2 class="text-2xl lg:text-4xl font-medium text-center text-primary mb-2">Adote um abrigado</h2>
            <p class="text-center text-lg mb-12">Dẽ uma chance a quem tanto espera por um lar para chamar de seu</p>
        </div>
        @if ($adoptables)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($adoptables as $animal)
                    <x-animal-card 
                        action="adoption"
                        image="{{ $animal->getFirstMediaUrl('animals', 'responsive') ?: asset('images/animal-placeholder.jpg') }}"
                        slug="{{ $animal->slug }}"
                        name="{{ $animal->name }}"
                        gender="{{ $animal->genderLabel }}"/>
                @endforeach
            </div>
        @else
            <p class="text-center">Ops! Nenhum animal encontrado.</p>
        @endif
        <div class="pt-12 text-center">
            <a href="{{ route('adoption.index') }}" class="font-medium text-primary hover:text-primary-hover">Conheça outros adotáveis</a>
        </div>
    </div>
</section>

<div class="rotate-180 rotate-y-180 -mb-[12rem]">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none" style="margin-top:0;width:100%;height:12rem;display:block">><path fill="#f5f5f5" fill-opacity="1" d="M0,288L80,288C160,288,320,288,480,293.3C640,299,800,309,960,304C1120,299,1280,277,1360,266.7L1440,256L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>
</div>