<form wire:submit.prevent="submit" class=" py-4">
   <div class="space-y-4">
      <!-- Modal Header -->

      {{-- @if (session()->has('message')) --}}
         <!-- Modal Backdrop -->
         @include('partials.animal.sponsorship-confirmation-modal')
      {{-- @endif --}}
      @if ($showReminder && $reminderData['type'] === 'success')

         <!-- Lembrete que substitui o formulário -->
         <div class="p-6 md:p-8 mb-6 rounded-xl border border-zinc-200 shadow-md bg-zinc-100">

            <div class="flex items-start gap-4">
               <div class="flex-1">
                  <h3 class="font-medium text-primary text-2xl mb-3">Apadrinhamento em Andamento</h3>
                  <div class="text-zinc-900 mb-4 leading-relaxed">
                     <p class="mb-2">
                        <strong>Obrigado por querer me apadrinhar!</strong> Seu pedido foi registrado com sucesso.
                     </p>
                     <p class="mb-2">
                        • Se você <strong>já efetuou o pagamento</strong>, a confirmação será processada em algumas
                        horas.
                     </p>
                     <p>
                        • Se você <strong>ainda não finalizou o pagamento</strong>, clique no botão abaixo para
                        concluir.
                     </p>
                  </div>

                  @if ($reminderData['link'])
                     <x-button type="link" href="{{ $reminderData['link'] }}" target="_blank"
                        class="inline-flex items-center w-full py-3 text-lg">
                        <x-heroicon-o-credit-card class="w-5 h-5 mr-2" />
                        Finalizar Pagamento
                     </x-button>
                  @endif
               </div>
            </div>
         </div>
      @endif

      @if ($animal->expensesActive->isNotEmpty())
         @if (!session()->has('message') && !$showReminder)

            <div class="bg-zinc-50 border-1 border-zinc-200 p-6 rounded-md mb-8">
               <h3 class="font-medium text-primary mb-6">Esse é o progresso do meu apadrinhamento</h3>

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

            <div class="p-0 md:p-8 rounded-xl  border border-1 border-zinc-100 shadow-md">

               <h2 class="text-2xl md:text-3xl mb-6 font-medium text-primary">Apadrinhe</h2>

               <p class="mb-8 leading-relaxed">Com seu apadrinhamento, você ajuda a cuidar de mim até eu encontrar uma
                  família. Você pode apadrinhar o valor integral de uma despesa ou contribuir com o valor que puder —
                  toda ajuda conta!</p>

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
                                 value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                              } else {
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
