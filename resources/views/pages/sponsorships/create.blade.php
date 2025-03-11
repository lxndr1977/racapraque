<x-layouts.main title="Apadrinhe um abrigado | Projeto Raça Pra Quê?">
    <x-page-layout>
        <article class="py-6">
            <div class="flex flex-col md:flex-row gap-16 relative">
                 <div class="w-full md:w-2/5">
                    @include('partials/animal/images')
                </div>

                <div class="space-y-12 w-full md:w-3/5">
                    <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Apadrinhe</p>

                    @include('partials/animal/details', ['show_full_description' => false])

                    <div class="p-0 md:p-8 rounded-lg bg-white md:bg-zinc-100">
                        <h2 class="text-2xl font-medium text-primary">Apadrinhe {{$animal->genderedName }}</h2>
                        
                        <livewire:animal.sponsorship-form :animal="$animal" />
                    </div>

                    <div>
                        <h3 class="font-medium mb-6">Despesas</h3>

                        @if($animal->expensesInProgress->isNotEmpty())
                            <div class="border-t border-b border-zinc-100">
                                <dl class="divide-y divide-zinc-100">
                                    @foreach($animal->expensesInProgress as $expense)
                                        <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 items-center">
                                            <dt class="text-sm font-medium text-zinc-900">{{ $expense->typeLabel }}</dt>
                                            <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0 flex justify-between items-center">
                                                {{ $expense->formattedAmount }}
                                                <span class="text-sm">
                                                    {{ $expense->recurrence_days_label }}
                                                </span>
                                                
                                                @if ($expense->status == App\Enums\Animal\ExpenseStatusEnum::Sponsored) 
                                                    <div class="px-3 py-1 text-xs font-medium rounded-md bg-green-50 border-1 border-green-200 text-green-600">
                                                @else   
                                                    <div class="px-3 py-1 text-xs font-medium rounded-md bg-red-50 border-1 border-red-200 text-red-500">
                                                @endif
                                                    {{ $expense->statusLabel }}
                                                </div>
                                            </dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </div>
                        @endif
                    </div>

                    <div>
                        <h3 class="font-medium mb-6">Não pode apadrinhar o valor integral de uma despesa?</h3>
                        <p>Considere fazer um <a href="https://apoia.se/projetoracapraque" class="font-medium text-primary" target="_blank">apoio mensal via Apoia.se</a>.</p>
                    </div>
                </div>
            </div>
        </article>
    </x-page-layout>
</x-layouts.main>


