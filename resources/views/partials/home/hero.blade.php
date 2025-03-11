<section class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 pt-12 pb-32">
    <div class="grid grid-cols-1 md:grid-cols-2 items-center  gap-10">
        <div>
            <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Toda vida importa</p>
            <h1 class="font-medium text-4xl md:text-5xl xl:text-5xl mb-4 text-primary">Por toda causa animal! Resgatamos, salvamos e transformamos vidas</h1>
            <p class="text-lg mb-8">O “Projeto Raça Pra Quê?” nasceu em 2016 e desde então tem se dedicado incansavelmente a uma missão: resgatar animais em situações de maus-tratos, oferecendo-lhes cuidados veterinários, reabilitação e amor, preparando-os para uma segunda chance por meio da adoção responsável.</p>
            <div class="flex flex-col md:flex-row gap-6 items-center">
                <x-button type="link" href="{{ route('adoption.index') }}" target="_blank" size="medium" class="w-full md:w-auto">
                    Adote um abrigado
                </x-button>
                <a href="{{ route('sponsorship.index') }}" class="font-medium text-primary">Não pode adotar? Apadrinhe!</a>
            </div>
        </div>
        <div>
            <img src="{{ asset('images/home-hero-raca-pra-que.webp') }}" 
                 class="w-full h-auto"
                 width="588"
                 height="419" 
                 alt="Raça Pra Quê">
        </div>
    </div>
</section>