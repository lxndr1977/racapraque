<x-layouts.main title="Adote um abrigado | Projeto Raça Pra Quê?">
    <x-page-layout>
        <article class="py-6">
            <div class="flex flex-col md:flex-row gap-16 relative">
                <div class="w-full md:w-2/5">
                    @include('partials/animal/images')
                </div>

                <div class="w-full md:w-3/5">
                    <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Informações do abrigado</p>

                    @include('partials/animal/details', [
                     'show_full_description' => true,
                     'show_location_info' => true
                     ])
                </div>
            </div>
        </article>
    </x-page-layout>
</x-layouts.main>
