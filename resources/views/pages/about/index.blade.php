<x-layouts.main>
    <x-page-layout>
        <div class="grid grid-cols-1 md:grid-cols-2 items-center py-18 gap-10">
            <div>
                <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Quem somos</p>
                <h1 class="font-medium text-5xl mb-4 text-primary">Sobre o Projeto Raça Pra Quê?</h1>
                <p>O “Projeto Raça Pra Quê?” nasceu em 2016, em Viamão, Rio Grande do Sul, e desde então tem se dedicado incansavelmente a uma missão: resgatar animais em situações de maus-tratos, oferecendo-lhes cuidados veterinários, reabilitação e amor, preparando-os para uma segunda chance por meio da adoção responsável.</p>
            </div>
            <div>
                <img src="{{ asset('images/hero-sobre-o-raca-pra-que.webp') }}" alt="Raça Pra Quê">
            </div>
        </div>    

        <section class="py-18 space-y-14">
            <div class="max-w-4xl  mx-auto text-center">
                <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Nosso impacto</p>
                <h2 class="font-medium text-4xl mb-4 text-primary">Vidas são muito mais que números</h2>
                <p class="mb-12">Sabemos que precisamos medir o impacto social do nosso trabalho através de números, mas é igualmente importante sempre lembrar que cada vida resgatada é uma vitória.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex flex-col gap-2 items-center p-8 rounded-lg bg-primary-50">
                        <p class="text-4xl font-bold text-primary">+ de 1000</p>
                        <p>animais resgatados</p>
                    </div>
                    <div class="flex flex-col gap-2 items-center p-8 rounded-lg bg-primary-50">
                        <p class="text-4xl font-bold text-primary">+ de 800</p>
                        <p>animais adotados</p>
                    </div>
                    <div class="flex flex-col gap-2 items-center p-8 rounded-lg bg-primary-50">
                        <p class="text-4xl font-bold text-primary">+ de 2000</p>
                        <p>vidas salvas</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 items-center py-18 gap-10">
            <div>
                <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Nossa existência</p>
                <h2 class="font-medium text-4xl mb-4 text-primary">Como mantemos as nossas atividades</h2>
                <p class="mb-3">O nosso trabalho de resgate, reabilitação e cuidado com os animais resgatados de situações de abandono ou maus-tratos depende principalmente das doações feitas por pessoas que abraçam a causa animal.</p>
                <p class="mb-3">Além das <a href="{{ route('donation') }}" class="font-medium text-primary">doações</a>, complementamos nossa renda com a <a href="https://reserva.ink/racapraque" target="_blank" class="font-medium text-primary">venda de produtos</a> com a marca do projeto, parcerias estratégicas, brechós solidários e diversas outras ações de captação de recursos.</p>
            </div>
            <div>
                <img src="{{ asset('images/hero-sobre-o-raca-pra-que-2.webp') }}" alt="Raça Pra Quê">
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 items-center mx-auto py-18 gap-10">
                <div>
                    <img src="{{ asset('images/daiana-testa-raca-pra-que.webp') }}" alt="Daiana Testa" class="w-full h-auto">
                </div>
                <div>
                    <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Fundadora do Projeto</p>
                    <h2 class="font-medium text-4xl mb-4 text-primary">Daiana Testa</h2>
                    <p class="mb-3">Oi, eu sou Daiana, fundadora do "Projeto de Raça Pra Quê?"". </p>
                    <p class="mb-3">Desde 2016, dedico meu trabalho ao resgate, tratamento e adoção de cães e gatos. Antes disso, já sentia uma profunda empatia pelos animais abandonados, que enfrentam o sofrimento nas ruas.</p>
                    <p class="mb-3">É um prazer saber que você se importa com a causa animal e chegou até aqui.</p>
                    <p class="mb-3">Ao se juntar à nossa rede de apoio, você nos ajudará a continuar essa missão vital. Sua <a href="{{ route('donation') }}" class="font-medium text-primary">contribuição</a> fará toda a diferença para a vida dos animais que resgatamos.</p>
                </div>
        </section>
    </x-page-layout>
</x-layouts.main>