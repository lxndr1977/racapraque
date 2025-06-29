<x-layouts.main title="Adote um abrigado | Projeto Raça Pra Quê?">
    <x-page-layout>
        <article class="py-6">
            <div class="flex flex-col md:flex-row gap-16 relative">
                <div class="w-full md:w-2/5">
                    @include('partials/animal/images')
                </div>

                <div class="w-full md:w-3/5">
                    <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Adote</p>

                    @include('partials/animal/details', [
                        'show_full_description' => true,
                        'show_location_info' => false,
                     ])

                    <div class="p-0 md:p-8 rounded-lg bg-white md:bg-zinc-100">
                        <livewire:animal.adoption-form animal_id="{{ $animal->id }}" animal_name="{{$animal->genderedName }}" />
                    </div>
                </div>
            </div>
        </article>
    </x-page-layout>
</x-layouts.main>
