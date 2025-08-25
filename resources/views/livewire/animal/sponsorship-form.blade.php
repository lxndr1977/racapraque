<form wire:submit.prevent="submit" class=" py-4">
   <div class="space-y-4">
      @if (session()->has('message'))
         <div
            class="{{ session('message.type') === 'success' ? 'bg-green-50 border-green-200 text-green-500' : 'bg-red-50 border-red-200 text-red-500' }} p-2 px-4 rounded-md border-1 font-medium text-center">
            {{ session('message.text') }}
         </div>

         @if (session('message.type') === 'success')
            <div class="text-center">
               <x-heroicon-o-check-circle class="w-15 h-15 text-green-500 mx-auto mb-6" />

               <h4 class="text-2xl font-medium text-primary mb-8">Oba, estamos quase lá!</h4>

               <div class="bg-zinc-50 border-1 border-zinc-200 p-8 rounded-md mb-8">

                  <p class="mb-3 font-medium">
                     Saber que você quer me apadrinhar enquanto espero por uma família que me adote encheu o meu coração
                     de esperança.
                  </p>
                  <p class="leading-relaxed">Já anotei aqui que você quer me apadrinhar. Agora é só clicar no botão
                     abaixo para finalizar o pagamento.</p>
               </div>
            </div>
         @endif

         @if (session('message.link'))
            <x-button type="link" href="{{ session('message.link') }}" target="_blank"
               class="w-full text-lg py-4">Finalizar pagamento</x-button>
         @endif
      @endif

      @if ($animal->expensesActive->isNotEmpty())
         @if (!session()->has('message'))

            {{-- ===== SEÇÃO DE PROGRESSO - INSERIR AQUI ===== --}}
            <div class="bg-zinc-50 border-1 border-zinc-200 p-6 rounded-md mb-8">
               <h3 class="font-medium text-primary mb-6">Esse é o progresso do meu apadrinhamento</h3>

               {{-- Cards com totais --}}
               <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                  <div class="text-center p-4 bg-white border-1 border-zinc-200 rounded-md">
                     <div class="text-2xl font-bold text-zinc-800">{{ $this->getFormattedTotalExpenses() }}</div>
                     <div class="text-sm text-zinc-600 mt-1">Total de Despesas</div>
                  </div>

                  <div class="text-center p-4 bg-white border-1 border-primary/20 rounded-md">
                     <div class="text-2xl font-bold text-primary">{{ $this->getFormattedTotalSponsored() }}</div>
                     <div class="text-sm text-zinc-600 mt-1">Já Apadrinhado</div>
                  </div>

                  <div class="text-center p-4 bg-white border-1 border-zinc-200 rounded-md">
                     <div class="text-2xl font-bold text-zinc-700">{{ $this->getFormattedRemainingAmount() }}</div>
                     <div class="text-sm text-zinc-600 mt-1">Ainda Precisa</div>
                  </div>
               </div>

               {{-- Barra de progresso --}}
               <div class="mb-4">
                  <div class="flex justify-between items-center mb-2">
                     <span class="text-sm font-medium text-zinc-700">Meta de Apadrinhamento</span>
                     <span class="text-sm font-medium text-primary">{{ $progressPercentage }}%</span>
                  </div>

                  <div class="w-full bg-zinc-200 rounded-full h-3 overflow-hidden">
                     <div class="bg-primary h-3 rounded-full transition-all duration-700 ease-out"
                        style="width: {{ $progressPercentage }}%"></div>
                  </div>

                  @if ($this->getIsFullySponsored())
                     <div class="mt-3 flex items-center justify-center text-primary">
                        <x-heroicon-o-check-circle class="w-5 h-5 mr-2" />
                        <span class="text-sm font-medium">Meta atingida! Muito obrigado!</span>
                     </div>
                  @else
                     <div class="mt-3 text-center text-sm text-zinc-600">
                        Faltam {{ $this->getFormattedRemainingAmount() }} para atingir a meta completa
                     </div>
                  @endif
               </div>
            </div>
            {{-- ===== FIM DA SEÇÃO DE PROGRESSO ===== --}}

            <div class="p-0 md:p-8 rounded-xl  border border-1 border-zinc-100 shadow-md">

               <h2 class="text-2xl md:text-3xl mb-6 font-medium text-primary">Apadrinhe</h2>

               <p class="mb-8 leading-relaxed">Com seu apadrinhamento, você ajuda a cuidar de mim até eu encontrar uma família. Você pode apadrinhar o valor integral de uma despesa o contribuir com o valor que puder — toda ajuda conta!</p>

               <div class="space-y-8">
                  <div>
                     <label for="expense_id" class="block text-sm font-medium text-zinc-800 mb-2">Escolha uma despesa
                        para apadrinhar</label>
                     <select
                        id="expense_id"
                        name="expense_id"
                        wire:model="expense_id"
                        class="mt-1 px-4 py-3 block w-full bg-zinc-50 border-1 border-zinc-300 rounded-md">
                        <option value="">Selecione uma despesa</option>
                        @foreach ($expenses as $expense)
                           <option value="{{ $expense->id }}">
                              {{ $expense->typeLabel }} - {{ $expense->formattedAmount }}
                           </option>
                        @endforeach
                     </select>
                     @error('expense_id')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                     @enderror
                  </div>
                  <div>
                     <label for="name" class="block text-sm font-medium text-zinc-800">Nome</label>
                     <input type="text" id="name" wire:model="name"
                        class="mt-1 px-4 py-3 block w-full bg-zinc-50 border-1 border-zinc-300 rounded-md">
                     @error('name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                     @enderror
                  </div>

                  <div>
                     <label for="email" class="block text-sm font-medium text-zinc-800">Email</label>
                     <input type="email" id="email" wire:model="email"
                        class="mt-1 px-4 py-3 block w-full bg-zinc-50 border-1 border-zinc-300 border-1 border-zinc-300 rounded-md">
                     @error('email')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                     @enderror
                  </div>

                  <div x-data="phoneMask()">
                     <label for="whatsapp" class="block text-sm font-medium text-zinc-800">WhatsApp</label>
                     <input
                        type="text"
                        id="whatsapp"
                        x-model="phone"
                        x-on:input="formatPhone()"
                        placeholder="(11) 99999-9999"
                        maxlength="15"
                        class="mt-1 px-4 py-3 block w-full bg-zinc-50 border-1 border-zinc-300 rounded-md">
                     @error('whatsapp')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                     @enderror
                  </div>

                  <script>
                     function phoneMask() {
                        return {
                           phone: @entangle('whatsapp'),

                           formatPhone() {
                              let value = this.phone.replace(/\D/g, '');

                              if (value.length <= 10) {
                                 // Telefone fixo: (11) 9999-9999
                                 value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                              } else {
                                 // Celular: (11) 99999-9999
                                 value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                              }

                              this.phone = value;
                           }
                        }
                     }
                  </script>

                  <div>
                     <div class="mt-4 flex items-center">
                        <input type="checkbox" id="consent" wire:model="consent"
                           class="size-5 border-1 border-zinc-300 rounded-lg checked:accent-primary">
                        <label for="consent" class="ml-2 text-sm text-zinc-800">
                           Estou de acordo com a política de privacidade e termos de uso do site.
                        </label>
                     </div>
                     @error('consent')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                     @enderror
                  </div>

                  <x-button type="submit" class="w-full" size="large">
                     <x-heroicon-o-heart class="w-6 h-5 mr-2" />
                     Apadrinhar
                  </x-button>
               </div>
            </div>
         @endif
      @endif
   </div>
</form>
