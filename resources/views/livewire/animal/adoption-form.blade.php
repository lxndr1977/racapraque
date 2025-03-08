<form wire:submit.prevent="submit" >
    <div class="space-y-8">
         @if (session()->has('message'))
            @if(session('message.type') === 'success')
                <div>
                    <h4 class="text-xl font-medium text-primary mb-3">Oba, recebemos o seu pedido de adoção!</h4>
                    <p class="mb-3">Em breve a nossa equipe entrará em contato com você para dar continuidade à sua solicitação de adoção.</p>
                </div>
            @else 
                <div class="{{ session('message.type') === 'success' ? 'bg-green-50 border-green-200 text-green-500' : 'bg-red-50 border-red-200 text-red-500' }} p-2 px-4 rounded-md border-1 font-medium">
                    {{ session('message.text') }}
                </div>
            @endif
        @endif

        @if (!session()->has('message'))
            <div>
                <h2 class="text-2xl font-medium text-primary mb-4">Adote {{ $animal_name }}</h2>
                <p class="mb-2">Que alegria saber do seu interesse em adotar! Queremos conhecer você um pouco melhor para garantir que essa seja a combinação perfeita.</p>
                <p class="mb-6">Basta responder ao questionário, e em breve entraremos em contato!</p>
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

            <div class="mt-4 flex items-center">
                <input type="checkbox" id="consent" wire:model="consent" class="size-5 border-1 border-zinc-300 rounded-lg checked:accent-primary">
                <label for="consent" class="ml-2 text-sm text-zinc-700">
                    Estou de acordo com a política de privacidade e termos de uso do site.
                </label>
            </div>
            @error('cocnsent') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <x-button type="submit" class="w-full" size="large">Quero adotar</x-button>
        @endif
    </div>
</form>
