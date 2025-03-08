<form wire:submit.prevent="submit" class="py-4">
    <div class="space-y-4">
        @if (session()->has('message'))
            <div class="{{ session('message.type') === 'success' ? 'bg-green-50 border-green-200 text-green-500' : 'bg-red-50 border-red-200 text-red-500' }} p-2 px-4 rounded-md border-1 font-medium">
                {{ session('message.text') }}
            </div>

            @if(session('message.type') === 'success')
                <div>
                    <h4 class="text-xl font-medium text-primary mb-3">Oba, estamos quase lá!</h4>
                    <p class="mb-3">Obrigado por apoiar o "Raça Pra Quê?". A sua contribuição será muito importante para que a gente possa oferecer todos os cuidados até que o nosso abrigado encontre um lar para chamar de seu! :)</p>
                    <p class="mb-3">Já registramos a sua solicitação de apadrinhamento! Agora basta você clicar no botão abaixo e realizar o pagamento!</p>
                </div>
            @endif

            @if (session('message.link'))
                <x-button type="link" href="{{ session('message.link') }}" target="_blank" class="w-full">Ir para pagamento</x-button>
            @endif
        @endif

        @if($animal->expensesActive->isNotEmpty())
            @if (!session()->has('message'))
                <div class="space-y-8">
                    <div>
                        <p class="block text-sm font-medium text-zinc-700 mb-2">Escolha uma despesa para apadrinhar</p>
                        <fieldset class="grid grid-cols-1 gap-4">
                            <legend class="sr-only">Despesa</legend>
                            @foreach($animal->expensesActive as $expense)
                                @if ($expense->status == \App\Enums\Animal\ExpenseStatusEnum::Active)
                                    <div>
                                        <label
                                        for="expense-{{ $expense->id }}"
                                        class="flex cursor-pointer justify-between gap-4 rounded-lg border border-zinc-300 bg-white p-4 text-sm font-medium hover:border-primary has-[:checked]:border-primary has-[:checked]:ring-1 has-[:checked]:ring-primary"
                                        >
                                        <div>
                                            <p class="text-zinc-700">{{ $expense->typeLabel }}</p>

                                            <p class="mt-1 text-zinc-700"><span class="text-2xl me-1">{{ $expense->formattedAmount }}</span>/ {{ $expense->recurrence_days_label }}</p>
                                        </div>

                                        <input
                                            type="radio"
                                            name="expense_id"
                                            value="{{ $expense->id }}"
                                            id="expense-{{ $expense->id }}"
                                            class="size-5 accent-primary"
                                            wire:model="expense_id"
                                            {{ $loop->first ? 'checked' : ''  }} 
                                        />
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                            @error('expense_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </fieldset>
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-zinc-700">Nome</label>
                        <input type="text" id="name" wire:model="name" class="mt-1 px-4 py-3 block w-full bg-white border-1 border-zinc-300 rounded-md">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-zinc-700">Email</label>
                        <input type="email" id="email" wire:model="email" class="mt-1 px-4 py-3 block w-full bg-white border-1 border-zinc-300 rounded-md">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-zinc-700">WhatsApp</label>
                        <input type="text" id="whatsapp" wire:model="whatsapp" class="mt-1 px-4 py-3 block w-full bg-white border-1 border-zinc-300 rounded-md">
                        @error('whatsapp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <div class="mt-4 flex items-center">
                            <input type="checkbox" id="consent" wire:model="consent" class="size-5 border-1 border-zinc-300 rounded-lg checked:accent-primary">
                            <label for="consent" class="ml-2 text-sm text-zinc-700">
                                Estou de acordo com a política de privacidade e termos de uso do site.
                            </label>
                        </div>
                        @error('consent') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <x-button type="submit" class="w-full" size="large">Apadrinhar</x-button>
                </div>
            @endif
        @endif
    </div>
</form>



