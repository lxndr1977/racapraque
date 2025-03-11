<x-layouts.main title="Pontos de coleta de doações | Projeto Raça Pra Quê?">
    <x-page-layout>
        <div class="grid grid-cols-1 md:grid-cols-2 items-center py-18 gap-10">
            <div>
                <p class="text-tertiary font-bold uppercase tracking-wide mb-2">Pontos de coleta</p>
                <h1 class="font-medium text-4xl md:text-5xl mb-4 text-primary">Saiba onde entregar as duas doações</h1>
                <p class="mb-3">Para facilitar as doações, temos pontos de coleta em empresas parceiras, onde você pode deixar suas contribuições. Além disso, disponibilizamos pontos exclusivos para o recebimento de tampinhas plásticas. Confira os endereços dos pontos de coleta.</p> 
            </div>
            <div>
                <img src="{{ asset('images/pattern.png') }}" alt="Raça Pra Quê" loading="lazy">
            </div>
        </div>
        
        @if(!empty($locations))
            <div  class="">
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-6 ">
                    @foreach($locations as $location)
                        <li class="border-1 border-zinc-100 shadow-md rounded-lg p-6">
                            <div class="text-xl font-medium text-primary">{{ $location->name }}</div>
                            <div>
                                {{ $location->address }},
                                {{ $location->number }}
                                @if($location->complement)
                                , {{ $location->complement }}
                                @endif
                                , {{ $location->neighborhood }}
                            </div>
                            
                            <div>{{ $location->city }}, {{ $location->state }}, {{ $location->zip_code }}</div>
                            
                            <div class="inline-flex gap-3">
                            @if($location->phone)
                                <div>{{ $location->phone }}</div>
                            @endif

                            @if($location->whatsapp)
                                <div>{{ $location->whatsapp }}</div>
                            @endif
                            </div>
                        </li>   
                    @endforeach
                </ul>
                <div class="py-8">
                    {{ $locations->links() }}
                </div>
            </div>
        @endif
    </x-page-layout>
</x-layouts.main>