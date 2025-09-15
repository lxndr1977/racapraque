<div class="fixed inset-0 bg-black/60 backdrop-blur flex items-center justify-center z-50 p-4"
   x-data="{ show: true }"
   style="display: flex !important;"  {{-- Forçar display --}}
   wire:click="closeModal()">

   <!-- Modal Content -->
   <div
      class="bg-white rounded-lg w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-2xl xl:max-w-4xl max-h-screen overflow-y-auto"
      @click.stop
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-95">

      <!-- Modal Header -->
      <div class="flex justify-between items-center p-4 border-b border-zinc-200">
         <h3 class="text-lg font-medium text-zinc-800">
            {{ session('message.type') === 'success' ? 'Sucesso!' : 'Atenção!' }}
         </h3>
         <button type="button" wire:click="closeModal()"
            class="text-zinc-400 hover:text-zinc-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
               </path>
            </svg>
         </button>
      </div>

      <!-- Modal Body -->
      <div class="p-6">
         <div
            class="{{ session('message.type') === 'success' ? 'bg-green-50 border-green-200 text-green-500' : 'bg-red-50 border-red-200 text-red-500' }} p-3 px-4 rounded-md border mb-4 font-medium text-center">
            {{ session('message.text') }}
         </div>

         @if (session('message.type') === 'success')
            <div class="text-center">
               @if ($animal->getMedia('animals')->isNotEmpty())
                  <img src=" {{ $animal->getFirstMediaUrl('animals') }}" alt="{{ $animal->name }}"
                     class="rounded-full w-28 h-28 mx-auto mb-4" loading="lazy">
               @else
                  <img src="{{ asset('images/animal-placeholder.jpg') }}" alt="Foto do abrigado" loading="lazy"
                     class="rounded-full w-28 h-28 mx-auto mb-4">
               @endif

               <h4 class="text-2xl font-medium text-primary mb-8">Oba, estamos quase lá!</h4>

               <div class="bg-zinc-50 border border-zinc-200 p-6 rounded-md mb-6">
                  <p class="mb-3 font-medium">
                     Saber que você quer me apadrinhar enquanto espero por uma família que me adote encheu o
                     meu coração
                     de esperança.
                  </p>
                  <p class="leading-relaxed">Já anotei aqui que você quer me apadrinhar. Agora é só clicar no
                     botão
                     abaixo para finalizar o pagamento.</p>
               </div>
            </div>
         @endif

         @if (session('message.link'))
            <x-button type="link" href="{{ session('message.link') }}" target="_blank"
               class="w-full text-lg py-4">Finalizar pagamento</x-button>
         @endif
      </div>
   </div>
</div>
