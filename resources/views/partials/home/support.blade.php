<section class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-12">
    <div class="max-w-2xl mx-auto">
        <p class="text-tertiary font-bold uppercase tracking-wide mb-2 text-center">Toda ajuda é bem-vinda</p>
        <h2 class="text-2xl lg:text-4xl font-medium text-center text-primary mb-2">Outras formas de apoiar</h2>
        <p class="text-center text-lg mb-12">Não pode apoiar financeiramente? Veja outras formas de apoiar o projeto</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <div class="space-y-3">
            <div class="flex mb-8">
                <div class="bg-primary-50 flex-0 p-3 rounded-full">
                    <x-icons.t-shirt class="stroke-primary" height="32" width="32"/>
                </div>
            </div>
            <h3 class="font-medium text-lg">Doe itens para o brechó</h3>
            <p>O brechó do “Raça Pra Quê?” é uma outra alternativa para complementar a renda do projeto.</p>
            <a href="{{ route('thrift-store') }}" class="font-medium text-primary">Saiba mais</a>
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
            <a href="{{ route('needed-items') }}" class="font-medium text-primary">Saiba mais</a>
        </div>

        <div class="space-y-3">
            <div class="flex mb-8">
                <div class="bg-primary-50 flex-0 p-3 rounded-full">
                    <x-icons.home class="stroke-primary" height="32" width="32"/>
                </div>
            </div>
            <h3 class="font-medium text-lg">Ofereça lar temporário</h3>
            <p>Seja lar temporário voluntário para um abrigado até conseguirmos uma família que o adote.</p>
            <a href="{{ route('temporary-shelter') }}" class="font-medium text-primary">Saiba mais</a>
        </div>
    </div>
</section>