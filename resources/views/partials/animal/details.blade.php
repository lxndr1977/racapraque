<h1 class="text-5xl font-medium text-primary mb-4">{{ $animal->name }}</h1>

@if(!empty($animal->short_description))
    <p class="text-lg text-zinc-700 mb-6">{{ $animal->short_description }}</p>
@endif 

<div class="border-t border-b border-zinc-100">
    <dl class="divide-y divide-zinc-100">
        <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0">
            <dt class="text-sm font-medium text-zinc-900">Espécie</dt>
            <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->specieLabel }}</dd>
        </div>
        
        <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0">
            <dt class="text-sm font-medium text-zinc-900">Sexo</dt>
            <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->genderLabel }}</dd>
        </div>

        <div class="px-4 py-5 sm:grid sm:grid-cols-3 items-center sm:gap-4 sm:px-0">
            <dt class="text-sm font-medium text-zinc-900">Porte</dt>
            <dd class="mt-1 text-zinc-700 sm:col-span-2 sm:mt-0">{{ $animal->sizeLabel }}</dd>
        </div>

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
        @endif
    </dl>

    @if(!empty($animal->full_description) && $show_full_description)
        <p class="text-zinc-700 mt-4 mb-8">{{ $animal->full_description }}</p>
    @endif
</div>

