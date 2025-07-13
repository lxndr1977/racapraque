@php
    $expensesActive = $animal->expensesActive->where('status', \App\Enums\Animal\ExpenseStatusEnum::Active)
      ->sortBy(fn($expense) => $expense->type->getLabel());
@endphp

<x-layouts.main title="Apadrinhe um abrigado | Projeto Raça Pra Quê?">
    <x-page-layout>
        <article class="py-6">
            <div class="flex flex-col md:flex-row gap-16 relative">
                 <div class="w-full md:w-2/5">
                    @include('partials/animal/images')
                </div>

                <div class="space-y-12 w-full md:w-3/5">
                    <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Apadrinhe</p>

                     @include('partials/animal/details', [
                        'show_full_description' => false,
                        'show_location_info' => false,
                     ])

                    @include('partials/animal/expenses')

                     <div class="bg-primary/5 border-1 border-primary/20 p-6 rounded-md text-center">
                           <x-heroicon-o-information-circle class="w-8 h-8 text-primary mx-auto mb-6" />
                           <p class="font-medium text-primary text-lg mb-3">Esses são os valores que o projeto gasta pra cuidar de mim com carinho e me oferecer uma vida digna.</p>    
                           <p class="text-zinc-900 leading-relaxed">Se quiser me ajudar com tudo, vou adorar! Mas fica de boa — você pode escolher quanto pode contribuir. Qualquer valor já ajuda muito!</p>                 
                     </div>

                    <div class="p-0 md:p-8 rounded-xl  border border-1 border-zinc-100 shadow-md">
                        <livewire:animal.sponsorship-form :animal="$animal" :expenses="$expensesActive" />
                    </div>

                    {{-- <div>
                        <h3 class="font-medium mb-6">Não pode apadrinhar o valor integral de uma despesa?</h3>
                        <p>Considere fazer um <a href="https://apoia.se/projetoracapraque" class="font-medium text-primary" target="_blank">apoio mensal via Apoia.se</a>.</p>
                    </div> --}}
                </div>
            </div>
        </article>
    </x-page-layout>
</x-layouts.main>


