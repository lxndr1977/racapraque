<section class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-12 mb-64">
    <div class="grid grid-cols-1 md:grid-cols-2 items-center py-18 gap-10">
        <div>
            <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Seja um doador</p>
            <h1 class="font-medium text-5xl mb-4 text-primary">A sua ajuda salva vidas! Faça uma doação</h1>
            <p class="mb-3">O nosso trabalho de resgate, reabilitação e cuidado com os animais resgatados de situações de abandono ou maus-tratos depende principalmente das doações feitas por pessoas que abraçam a causa animal.</p>
            <p class="mb-3">Não recebemos apoio financeiro do poder público, o que torna o essa rede de apoiadores fundamental para nossa existência.</p> 
        </div>
        <div>
            <img src="{{ asset('images/home-faca-uma-doacao.webp') }}" class="w-full" alt="Raça Pra Quê">
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div class="col-span-1 row-span-1 space-y-3">
            <img src="{{ asset('images/logo-apoiase-home.png') }}" alt="Logo Apoia.se" class="max-h-10 mb-6" >
            <h2 class="font-medium text-2xl">Doe mensalmente via Apoia.se</h2>
            <p>Dessa forma garantimos previsibilidade nas receitas para cumprir  nossos compromissos de forma consistente e eficaz.</p>
            <p class="mb-5">O seu apoio faz toda a diferença!</p>
            <x-button type="link" href="https://apoia.se/projetoracapraque" target="_blank" class="w-auto">Doar mensalmente</x-button>
        </div>
        <div class="col-span-1 row-span-1 space-y-3">
            <img src="{{ asset('images/logo-pix-home.png') }}" alt="Logo Pix" class="max-h-10 mb-6 h-auto" >
            <h2 class="font-medium text-2xl">Doe via Pix</h2>
            <p>Agende um Pix recorrente ou faça uma doação eventual para a chave CNPJ, em nome de Associação Raça Pra Quê.</p>
            <p class="mb-4">Chave <span class="text-lg font-medium">42771889000150</span></p>
            <div x-data="{ pixKey: '42771889000150', copied: false }" class="flex items-center space-x-3 ">
                <x-button @click="navigator.clipboard.writeText(pixKey); copied = true; setTimeout(() => copied = false, 3000)" 
                     >
                    Copiar Chave PIX
                </x-button>

                <span x-show="copied" x-transition x-cloak class="text-primary font-medium">Chave Copiada</span>
            </div>
        </div>
    </div>
</section>
