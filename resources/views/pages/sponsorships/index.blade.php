<x-layouts.main>
    <x-page-layout>
        <div class="py-8">
            <h1 class="font-medium text-3xl text-primary">Apadrinhe um abrigado</h1>
        </div>
        <livewire:animal.animal-list :scope="App\Enums\Animal\ScopeEnum::Sponsorables"/>
    </x-page-layout>
</x-layouts.main>