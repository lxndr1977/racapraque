<x-layouts.main>
    <x-page-layout>
        <div class="grid grid-cols-1 md:grid-cols-2 items-center py-18 gap-10">
            <div>
                <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Doe agora</p>
                <h1 class="font-medium text-4xl md:text-5xl mb-4 text-primary">Como apoiar financeiramente</h1>
                <p class="mb-3">Você pode nos apoiar de várias maneiras: tornando-se um apoiador mensal pelo Apoia.se, agendando doações recorrentes, fazendo doações únicas via Pix ou apadrinhando um animal.</p> 
                <p class="mb-3">Toda contribuição, não importa o valor, é fundamental para manter o nosso trabalho de resgate e cuidado com os animais resgatados e abrigados pelo projeto.</p>
            </div>
            <div>
                <img src="{{ asset('images/hero-doe-para-o-raca-pra-que.webp') }}" class="w-full" alt="Raça Pra Quê">
            </div>
        </div>

        <div class="max-w-3xl pb-18 mx-auto text-center">
            <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Seja a esperança de um animal resgatado</p>
            <h2 class="font-medium text-4xl mb-4 text-primary">Por que a sua ajuda é muito importante?</h2>
            <p class="text-xl mb-3">Não recebemos apoio financeiro do poder público, o que torna o essa rede de apoiadores fundamental para nossa existência.</p>
            <p>O nosso trabalho de resgate, reabilitação e cuidado com os animais resgatados de situações de abandono ou maus-tratos depende principalmente das doações feitas por pessoas que abraçam a causa animal.</p>
        </div>

        <div class="px-8 py-18 mb-10 rounded-lg bg-zinc-100">
            <div class="flex flex-col justity-center items-center mx-auto max-w-screen-sm space-y-6 text-center">
                <img src="{{ asset('images/logo-apoia-se-raca-pra-que.png') }}" alt="Logo Apoia.se" class="max-w-3xs h-auto py-2" >
                <h2 class="font-medium text-3xl text-primary">Doe mensalmente para o projeto</h2>
                <p>Essa forma de apoio proporciona previsibilidade nas receitas, permitindo-nos cumprir compromissos e expandir nossos esforços de resgate e cuidado com os animais de forma consistente e eficaz.</p>
                <x-button type="link" href="https://apoia.se/projetoracapraque" target="_blank" size="medium" class="w-auto">Doar mensalmente</x-button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="col-span-1 row-span-1 p-8 space-y-3">
                <img src="{{ asset('images/logo-pix.jpg') }}" alt="Logo Pix" class="max-h-20 h-auto mb-6" >
                <h2 class="font-medium text-2xl text-primary">Doe via Pix</h2>
                <p>Agende um Pix recorrente ou faça uma doação eventual para a chave CNPJ, em nome de Associação Raça Pra Quê.</p>
                <p>Chave <span class="text-lg font-medium">42771889000150</span></p>
                <div x-data="{ pixKey: '42771889000150', copied: false }" class="flex items-center space-x-3">
                    <x-button @click="navigator.clipboard.writeText(pixKey); copied = true; setTimeout(() => copied = false, 3000)" 
                        >
                        Copiar Chave PIX
                    </x-button>

                    <span x-show="copied" x-transition x-cloak class="text-primary font-medium">Chave Copiada</span>
                </div>
            </div>

            <div class="col-span-1 row-span-1 space-y-3 p-8 bg-zinc1200">
                <img src="{{ asset('images/como-apoiar-apadrinhamento.jpg') }}" alt="Logo Pix" class="max-h-20 mb-6" >
                <h2 class="font-medium text-2xl text-primary">Apadrinhe um abrigado</h2>
                <p>Ajude a pagar as despesas com ração, medicamentos ou lar temporário de um abrigado.</p>
                <p>O seu apoio faz toda a diferença!</p>
                <x-button type="link" href="{{ route('sponsorship.index') }}"  class="w-auto">Apadrinhar</x-button>

            </div>
        </div>
    </x-page-layout>
</x-layouts.main>