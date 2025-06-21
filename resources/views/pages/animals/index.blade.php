<x-layouts.main title="Relaçao de todos os abrigados | Projeto Raça Pra Quê?">
    <x-page-layout>
        <div class="py-8">
            <h1 class="font-medium text-3xl text-primary">Lista de abrigados</h1>
        </div>
        <livewire:animal.animal-list 
            :scope="App\Enums\Animal\ScopeEnum::Actives"
            :listStyle="App\Enums\Animal\ListStyleEnum::Horizontal->value"/>
    </x-page-layout>
</x-layouts.main>