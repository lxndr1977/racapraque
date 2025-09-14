<h1 class="text-4xl md:text-5xl font-medium text-primary mb-4">{{ $animal->name }}</h1>

@if(!empty($animal->short_description))
    <p class="text-base md:text-lg text-zinc-900 mb-6">{{ $animal->short_description }}</p>
@endif 

<div class="grid grid-cols-3 gap-4">
   <div class="px-4 py-5 flex flex-col items-center sm:gap-4 sm:px-0 bg-zinc-50 border-1 border-zinc-200 rounded-lg">
      <p class="text-sm font-medium text-zinc-900">Espécie</p>
      <p class="mt-1 text-primary text-lg font-medium sm:col-span-2 sm:mt-0">{{ $animal->specieLabel }}</p>
   </div>
   
   <div class="px-4 py-5 flex flex-col items-center sm:gap-4 sm:px-0 bg-zinc-50 border-1 border-zinc-200 rounded-lg">
      <p class="text-sm font-medium text-zinc-900">Sexo</p>
      <p class="mt-1 text-primary text-lg font-medium sm:col-span-2 sm:mt-0">{{ $animal->genderLabel }}</p>
   </div>

   <div class="px-4 py-5 flex flex-col items-center sm:gap-4 sm:px-0 bg-zinc-50 border-1 border-zinc-200 rounded-lg">
      <p class="text-sm font-medium text-zinc-900">Porte</p>
      <p class="mt-1 text-primary text-lg font-medium sm:col-span-2 sm:mt-0">{{ $animal->sizeLabel }}</p>
   </div>
</div>

<div class="border-1 border-zinc-200 rounded-lg">
      <div class="flex items-center text-zinc-900 py-4 px-6 rounded-t-lg bg-zinc-50 border-b-1 border-zinc-200">
         <div class="flex items-center justify-center mr-3">
            <x-heroicon-o-information-circle class="w-6 h-6 text-primary" />
         </div>
         <h3 class="font-medium text-md">Algumas informações sobre mim</h3>
      </div>   

      <dl class="divide-y divide-zinc-200 px-6">

        @if(!empty($animal->birth_date))
            <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium text-zinc-900">Idade estimada</dt>
                <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->age }}</dd>
            </div>
        @endif

        @if(!empty($animal->intake_date))
            <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium text-zinc-900">No abrigo desde</dt>
                <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->intakeYear }}</dd>
            </div>
        @endif

         @if($show_full_description)
            <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium text-zinc-900">Sociável com gatos</dt>
                <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->sociableWithCatsLabel }}</dd>
            </div>

            <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium text-zinc-900">Sociável com cães</dt>
                <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->sociableWithDogsLabel }}</dd>
            </div>

            <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium text-zinc-900">Sociável com crianças</dt>
                <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->sociableWithChildrenLabel }}</dd>
            </div>

            @if(!empty($animal->temperaments))
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium text-zinc-900">Temperamento</dt>
                    <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->temperamentLabels }}</dd>
                </div>
            @endif
         @endif

         @if(!empty($animal->health_conditions))
               <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0">
                  <dt class="text-sm font-medium text-zinc-900">Condições de saúde</dt>
                  <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->healthConditionsLabels }}</dd>
               </div>
         @endif

         @if(!empty($animal->special_needs))
               <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0 ">
                  <dt class="text-sm font-medium text-zinc-900">Necessidades especiais</dt>
                  <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->special_needs }}</dd>
               </div>
         @endif

         <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0">
               <dt class="text-sm font-medium text-zinc-900">Castrado</dt>
               <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->neuteredStatus }}</dd>
         </div>

         @if($show_location_info)
            <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0">
                  <dt class="text-sm font-medium text-zinc-900">Local de abrigo</dt>
                  <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->location->name }}</dd>
            </div>

            @if($animal->location_identification)
               <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0">
                     <dt class="text-sm font-medium text-zinc-900">Identificação do local</dt>
                     <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->location_identification }}</dd>
               </div>
            @endif
         @endif
    </dl>

    @if(!empty($animal->full_description) && $show_full_description)
        <p class="text-zinc-700 mt-4 mb-8 px-6">{{ $animal->full_description }}</p>
    @endif

</div>

