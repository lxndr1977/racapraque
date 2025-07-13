 <div>
   @if($expensesActive->isNotEmpty())
      <div class="border border-1 border-zinc-200 rounded-lg " >
         <div class="flex items-center text-zinc-900 py-4 px-6 rounded-t-lg bg-zinc-50 border-b-1 border-zinc-200">
            <div class="flex items-center justify-center mr-3">
               <x-heroicon-o-document-currency-dollar class="w-6 h-6 text-primary" />
            </div>
            <h3 class="font-medium text-md">Despesas</h3>
         </div>

         <ul class="divide-y divide-zinc-200">
            @foreach($expensesActive as $expense)
               <li class="flex justify-between items-center py-4 px-6">
                  <div>
                     <p class="text-zinc-900">{{ $expense->typeLabel }}</p>
                  </div>
                  <div class="flex flex-col items-end">
                     <p class="font-semibold">{{ $expense->formattedAmount }}</p>
                     <p class="text-sm text-zinc-500">{{ $expense->recurrence_days_label }}</p>
                  </div>
               </li>
            @endforeach
         </ul>
      </div>
   @endif
</div>