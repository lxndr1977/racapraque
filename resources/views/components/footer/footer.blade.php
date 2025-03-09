<div class="-mt-[15rem] -mb-[1rem]">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none" style="margin-top:10rem;width:100%;height:12rem;display:block"><path fill="#f5f5f5" fill-opacity="1" d="M0,256L80,250.7C160,245,320,235,480,245.3C640,256,800,288,960,288C1120,288,1280,256,1360,240L1440,224L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>
</div>
<footer class="bg-zinc-100">
    <x-container>
        <div class="grid grid-cols-1 gap-8 sm:gap-6 md:grid-cols-4 py-8 lg:py-12">
            <div class="mb-6 md:pt-7">
                <a href="{{ route('home') }}" class="flex items-center mb-12">
                    <img src="{{ asset('images/logo-raca-pra-que.png') }}" class="mr-3 h-18" alt="Logo Raça Pra Quê" />
                </a>

                <div class="flex mt-4 space-x-3 justify-start sm:mt-0">
                    <a href="#" class="bg-primary p-2 rounded-full text-white hover:bg-primary-hover">
                        <x-icons.instagram width="24" height="24"/>                    
                    </a>
                    <a href="#" class="bg-primary p-2 rounded-full text-white hover:bg-primary-hover">
                        <x-icons.facebook width="24" height="24" class="-ms-[1px]"/>                    
                    </a>
                </div>
            </div>
            <div class="md:pt-8">
                <h2 class="mb-6 text-sm font-semibold">Ajude o projeto</h2>
                <ul class="space-y-4 mb-6 ">
                    <li>
                        <x-link href="{{ route('donation') }}" class="text-zinc-700 font-normal">Doe agora</x-link>
                    </li>
                    <li>
                        <x-link href="{{ route('sponsorship.index') }}" class="text-zinc-700 font-normal">Apadrinhe</x-link>
                    </li>
                    <li>
                        <x-link href="{{ route('adoption.index') }}" class="text-zinc-700 font-normal">Adote</x-link>
                    </li>
                    <li>
                        <x-link href="{{ route('support') }}" class="text-zinc-700 font-normal">Outras formas de apoiar</x-link>
                    </li>
                </ul>
            </div>
            <div class="md:pt-8">
                <h2 class="mb-6 text-sm font-semibold">Informações</h2>
                <ul class="mb-6">
                    <li class="mb-4">
                        <x-link href="{{ route('about') }}" class="text-zinc-700 font-normal">Sobre o projeto</x-link>
                    </li>
                    <li class="mb-4">
                        <x-link href="{{ route('contact') }}" class="text-zinc-700 font-normal">Fale com a gente</x-link>
                    </li>
                    <li class="mb-4">
                        <x-link href="{{ route('donation-dropoff') }}" class="text-zinc-700 font-normal">Pontos de Coleta</x-link>
                    </li>
                    <li class="mb-4">
                        <x-link href="{{ route('privacy-policy') }}" class="text-zinc-700 font-normal">Política de Privacidade</x-link>
                    </li>
                    <li>
                        <x-link href="{{ route('terms-of-use') }}" class="text-zinc-700 font-normal">Termos de Uso</x-link>
                    </li>
                </ul>
              
            </div>
            <div>
                <div class="flex flex-col justify-center items-center text-center p-8 rounded-lg bg-primary">
                    <h2 class="mb-6 text-sm uppercase font-semibold text-white">Faça uma doação</h2>
                    <p class="mb-6  text-white">Toda contribuição, não importa o valor, é fundamental para manter o nosso trabalho.</p> 
                    <x-button href="{{ route('donation') }}" class="w-full bg-secondar hover:bg-secondary-hover">Quero doar</x-button>    
                </div>                      
            </div>
        </div>
        <hr class="my-6 border-zinc-200 sm:mx-auto dark:border-zinc-700 lg:my-8" />
        <div class="flex items-center justify-center md:justify-between">
            <div>
                <p class="font-medium  mb-1">Associação Raça Pra Que</p>
                <p class="text-xs mb-1">CNPJ 42.771.889/0001-50, Viamão, Rio Grande do Sul</p>
            </div>
            <div>
                <p class="text-xs mb-1">{{ date('Y') }} &copy; Todos os direitos reservados</p>
            </div>
        </div>
    </x-container> 
</footer>



        