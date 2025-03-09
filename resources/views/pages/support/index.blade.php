<x-layouts.main>
    <x-page-layout>
        <div class="grid grid-cols-1 md:grid-cols-2 items-center py-18 gap-10">
            <div>
                <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Apoie</p>
                <h1 class="font-medium text-5xl mb-4 text-primary">Como apoiar projeto Raça Pra Quê?</h1>
                <p class="mb-3">Sabemos que nem sempre a ajuda financeira é possível, mas existem muitas outras maneiras de apoiar o "Raça Pra Quê?"" e fazer a diferença na vida dos animais resgatados.</p> 
                <p>Você pode apoiar o Raça Pra Quê? de várias formas: contribuindo com itens para o brechó solidário, doando itens essenciais como ração e medicamentos, oferecendo lar temporário voluntáriopara um animal, ou doando tampinhas plásticas para a compra de ração.</p>
            </div>
            <div>
                <img src="{{ asset('images/hero-apoie-o-raca-pra-que.webp') }}" class="w-full h-auto" alt="Raça Pra Quê">
            </div>
        </div>
       
        <section class="py-18 space-y-14">
            <div class="max-w-3xl  mx-auto text-center">
                <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Como apoiar</p>
                <h2 class="font-medium text-4xl mb-4 text-primary">Saiba como apoiar o projeto</h2>
                <p>Cada gesto de apoio é essencial para que possamos garantir o bem-estar dos animais resgatados até que encontrem uma família que os adote.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 ">
                <div class="space-y-3">
                    <div class="flex mb-8">
                        <div class="bg-primary-50 flex-0 p-3 rounded-full">
                            <x-icons.t-shirt class="stroke-primary" height="32" width="32"/>
                        </div>
                    </div>
                    <h3 class="font-medium text-lg">Doe itens para o brechó</h3>
                    <p>O brechó do “Raça Pra Quê?” é uma outra alternativa para complementar a renda do projeto.</p>
                    <a href="{{ route('thrift-store') }}" class="font-medium text-primary" aria-label="O que pode ser doado para o brechó">Saiba mais</a>
                </div>

                <div class="space-y-3">
                    <div class="flex mb-8">
                        <div class="bg-primary-50 flex-0 p-3 rounded-full">
                            <x-icons.heart class="stroke-primary" height="32" width="32"/>
                        </div>
                    </div>
                    <h3 class="font-medium text-lg">Doe itens para o dia-a-dia</h3>
                    <p>Aceitamos doações de itens essenciais para o dia-a-dia dos abrigados e para a manutenção da sede. 
                    </p>
                    <a href="{{ route('needed-items') }}" class="font-medium text-primary" aria-label="Itens que podem ser doados para o dia-a-dia">Saiba mais</a>
                </div>

                <div class="space-y-3">
                    <div class="flex mb-8">
                        <div class="bg-primary-50 flex-0 p-3 rounded-full">
                            <x-icons.home class="stroke-primary" height="32" width="32"/>
                        </div>
                    </div>
                    <h3 class="font-medium text-lg">Ofereça lar temporário</h3>
                    <p>Seja lar temporário voluntário para um abrigado até conseguirmos uma família que o adote.</p>
                    <a href="{{ route('temporary-shelter') }}" class="font-medium text-primary" aria-label="Ofereça lar temoprário para um abrigado">Saiba mais</a>
                </div>
            </div>
        </section>

        <section class="py-18">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-16">
                <div>
                    <img src="{{ asset('images/home-tampinha-legal.webp') }}" class="w-full h-auto" alt="Raça Pra Quê" loading="lazy">
                </div>
                <div>
                    <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Tampinhas que alimentam</p>
                    <h1 class="font-medium text-4xl mb-4 text-primary">Junte e doe tampinhas plásticas</h1>
                    <p class="mb-3">Tampinhas são valiosas para a gente! Nós as coletamos e as vendemos como uma alternativa para complementar o valor necessário para comprar ração para os abrigados.  
                    </p>
                    <p class="mb-8">Além de beneficiar o meio ambiente através da reciclagem, cada tampinha contribui para alimentar e cuidar dos animais resgatados pelo projeto, mostrando como pequenas ações podem gerar grandes resultados.</p>
                    <x-button type="link" href="{{ route('donation-dropoff') }}" size="medium" class="w-full md:w-auto">Saiba onde entregar</x-button>
                </div>
            </div>
        </section>

    </x-page-layout>
</x-layouts.main>