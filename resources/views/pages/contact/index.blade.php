<x-layouts.main>
    <x-page-layout>
        <div class="grid grid-cols-1 md:grid-cols-2 items-center py-18 gap-10">
            <div>
                <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Fale com a gente</p>
                <h1 class="font-medium text-5xl mb-4 text-primary">Tem dúvidas ou precisa de alguma informação?</h1>
                <p class="mb-3">Somos uma equipe pequena, mas dedicada a garantir o bem-estar dos animais resgatados. Se você tem dúvidas ou quer saber mais sobre como ajudar o "Raça Pra Quê?"", entre em contato!</p> 
                <p class="mb-6">Faremos o possível para responder o mais breve possível e orientar você sobre doações, lar temporário e outras formas de apoio. Obrigado por se juntar a essa causa!.</p>
                <div class="flex gap-2 mb-3">
                    <x-icons.whatsapp class="text-primary" />
                    <x-link href="https://wa.me/5551989417221" target="_blank" class="inline-flex self-start font-medium">
                        Envie uma mensagem pelo Whatsapp
                    </x-link>
                </div>
                <div class="flex gap-2">
                    <x-icons.mail class="text-primary" />
                    <x-link href="mailto:projeto@racapraque.com.br" class="inline-flex self-start font-medium">
                        projeto@racapraque.com.br
                    </x-link>
                </div>
            </div>
            <div>
                <img src="{{ asset('images/hero-fale-com-o-raca-pra-que.webp') }}" class="w-full" alt="Raça Pra Quê">
            </div>
        </div>
    </x-page-layout>
</x-layouts.main>