@php
   $expensesActive = $animal->expensesActive
       ->where('status', \App\Enums\Animal\ExpenseStatusEnum::Active)
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

               <livewire:animal.sponsorship-form :animal="$animal" :expenses="$expensesActive" />
            </div>
         </div>
      </article>
   </x-page-layout>
</x-layouts.main>
