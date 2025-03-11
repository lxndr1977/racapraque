<header x-data="{ open: false }" class="bg-white">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-4">
        <nav class="flex justify-between items-center">
            <!-- Logo -->
             <div class="flex gap-3">
                <button @click="open = true" class="md:hidden text-xl focus:outline-none">
                    ☰
                </button>
                <a href="{{ route('home') }}" class="text-lg font-medium">
                    <img src="{{ asset('images/logo-raca-pra-que.webp') }}" class="mr-3 h-16 w-auto md:h-18" width="123" height="72" alt="Logo Raça Pra Quê" />
                </a>
            </div>

            <!-- Desktop Menu -->
            <ul class="hidden md:flex space-x-6">
                <li>
                    <a href="{{ route('donation') }}" class="group relative font-medium {{ request()->routeIs('donation') ? 'font-medium text-primary' : 'hover:text-primary-dark' }}">
                        Doe
                        <span class="absolute -bottom-1 left-0 w-0 transition-all h-0.5 bg-primary group-hover:w-full"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('adoption.index') }}" class="group relative font-medium {{ request()->routeIs('adoption.index') || request()->routeIs('adoption.create') ? 'font-medium text-primary' : 'hover:text-primary-dark' }}">
                        Adote
                        <span class="absolute -bottom-1 left-0 w-0 transition-all h-0.5 bg-primary group-hover:w-full"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sponsorship.index') }}" class="group relative font-medium {{ request()->routeIs('sponsorship.index') || request()->routeIs('sponsorship.create')  ? 'font-medium text-primary' : '' }}">
                        Apadrinhe
                        <span class="absolute -bottom-1 left-0 w-0 transition-all h-0.5 bg-primary group-hover:w-full"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('support') }}" class="group relative font-medium {{ request()->routeIs('support') ? 'font-medium text-primary' : 'hover:text-primary-dark' }}">
                        Apoie
                        <span class="absolute -bottom-1 left-0 w-0 transition-all h-0.5 bg-primary group-hover:w-full"></span> 
                    </a>
                </li>
                <li>
                    <a href="{{ route('donation-dropoff') }}" class="group relative font-medium {{ request()->routeIs('donation-dropoff') ? 'font-medium text-primary' : 'hover:text-primary-dark' }}">
                        Pontos de Coleta
                        <span class="absolute -bottom-1 left-0 w-0 transition-all h-0.5 bg-primary group-hover:w-full"></span>      
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="group relative font-medium {{ request()->routeIs('about') ? 'font-medium text-primary' : 'hover:text-primary-dark' }}">
                        Sobre
                        <span class="absolute -bottom-1 left-0 w-0 transition-all h-0.5 bg-primary group-hover:w-full"></span> 
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="group relative font-medium {{ request()->routeIs('contact') ? 'font-medium text-primary' : 'hover:text-primary-dark' }}">
                        Contato
                        <span class="absolute -bottom-1 left-0 w-0 transition-all h-0.5 bg-primary group-hover:w-full"></span>
                    </a>
                </li>
            </ul>

            <a href="{{ route('donation') }}" class=" md:block bg-primary text-white font-medium px-4 py-2 rounded-lg hover:bg-primary-hover">
                Doe agora
            </a>
        </nav>
    </div>

    <!-- Mobile Menu (Fullscreen) -->
    <div x-show="open" x-transition 
        class="fixed inset-0 space-y-6 bg-white bg-opacity-90 flex flex-col justify-center bg-zinc-100 p-6 md:px-10 z-9"
        style="display: none;">

        <button @click="open = false" class="absolute top-4 right-6 text-3xl text-gray-700">&times;</button>

        <ul class="space-y-6 text-lg font-semibold">
            <li><a href="{{ route('donation') }}" class="font-medium hover:text-primary">Doe</a></li>
            <li><a href="{{ route('adoption.index') }}" class="font-medium hover:text-primary">Adote</a></li>
            <li><a href="{{ route('sponsorship.index') }}" class="font-medium hover:text-primary">Apadrinhe</a></li>
            <li><a href="{{ route('support') }}" class="font-medium hover:text-primary">Apoie</a></li>
            <li><a href="{{ route('donation-dropoff') }}" class="font-medium hover:text-primary">Pontos de Coleta</a></li>
            <li><a href="{{ route('about') }}" class="font-medium hover:text-primary">Sobre</a></li>
            <li><a href="{{ route('contact') }}" class="font-medium hover:text-primary">Contato</a></li>
        </ul>
        <!-- Call to Action Button -->
        <a href="{{ route('donation') }}" class="bg-primary text-white font-medium px-4 py-2 self-start inline-block rounded-lg hover:bg-primary-hover">
            Doe agora
        </a>
    </div>
</header>

