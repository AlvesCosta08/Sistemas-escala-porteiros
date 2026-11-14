<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Obede') - Sistema de Escalas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f8fafc] font-sans antialiased text-gray-800 overflow-hidden">
    <div class="flex h-screen">
        
        <!-- Sidebar Moderna -->
        <aside class="w-64 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white flex flex-col shadow-2xl z-20">
            <div class="h-16 flex items-center justify-center border-b border-white/10">
                <span class="text-2xl font-black tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">OBEDE</span>
            </div>
            
            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/10 hover:translate-x-1 {{ request()->routeIs('admin.ausencias.*') ? 'bg-blue-600 shadow-lg shadow-blue-600/30 font-semibold' : 'text-gray-300' }}">
                        Painel de Ausências
                    </a>
                    <a href="{{ route('admin.escalas.index') }}" class="block px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/10 hover:translate-x-1 {{ request()->routeIs('admin.escalas.index') ? 'bg-blue-600 shadow-lg shadow-blue-600/30 font-semibold' : 'text-gray-300' }}">
                        Calendário Mensal
                    </a>
                    <a href="{{ route('admin.escalas.gerenciar') }}" class="block px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/10 hover:translate-x-1 {{ request()->routeIs('admin.escalas.gerenciar') || request()->routeIs('admin.escalas.alocacoes.*') ? 'bg-blue-600 shadow-lg shadow-blue-600/30 font-semibold' : 'text-gray-300' }}">
                        Gestão de Escalas
                    </a>
                    
                    <div class="pt-6 pb-2">
                        <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Cadastros</p>
                    </div>
                    <a href="{{ route('admin.usuarios.index') }}" class="block px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/10 hover:translate-x-1 {{ request()->routeIs('admin.usuarios.*') ? 'bg-blue-600 shadow-lg shadow-blue-600/30 font-semibold' : 'text-gray-300' }}">
                        Colaboradores
                    </a>
                    <a href="{{ route('admin.postos.index') }}" class="block px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/10 hover:translate-x-1 {{ request()->routeIs('admin.postos.*') ? 'bg-blue-600 shadow-lg shadow-blue-600/30 font-semibold' : 'text-gray-300' }}">
                        Postos de Trabalho
                    </a>
                    <a href="{{ route('admin.turnos.index') }}" class="block px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/10 hover:translate-x-1 {{ request()->routeIs('admin.turnos.*') ? 'bg-blue-600 shadow-lg shadow-blue-600/30 font-semibold' : 'text-gray-300' }}">
                        Turnos
                    </a>
                @else
                    <a href="{{ route('minha-escala') }}" class="block px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/10 hover:translate-x-1 {{ request()->routeIs('minha-escala') ? 'bg-blue-600 shadow-lg shadow-blue-600/30 font-semibold' : 'text-gray-300' }}">
                        Minha Escala
                    </a>
                    <a href="{{ route('perfil.edit') }}" class="block px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/10 hover:translate-x-1 {{ request()->routeIs('perfil.edit') ? 'bg-blue-600 shadow-lg shadow-blue-600/30 font-semibold' : 'text-gray-300' }}">
                        Meu Perfil
                    </a>
                @endif
            </nav>

            <div class="p-4 border-t border-white/10 bg-black/20">
                <p class="text-sm font-bold text-white">{{ auth()->user()->name }}</p>
                <p class="text-xs text-blue-300 mb-3">{{ ucfirst(auth()->user()->cargo) }}</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left text-sm text-red-400 hover:text-red-300 font-semibold transition-colors">
                        Sair do Sistema
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col relative h-screen">
            <!-- Header de Vidro (Glassmorphism) -->
            <header class="glass h-16 flex items-center justify-between px-8 shadow-sm sticky top-0 z-10">
                <h2 class="text-xl font-bold text-gray-800 tracking-tight">@yield('header', 'Painel')</h2>
            </header>

            <div class="flex-1 overflow-y-auto p-8 animate-fade-in relative z-0">
                <!-- Alertas Globais -->
                @if(session('success'))
                    <div class="mb-6 bg-green-100/80 border border-green-400 text-green-700 px-4 py-3 rounded-xl shadow-sm animate-fade-in" role="alert">
                        <span class="block sm:inline font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 bg-red-100/80 border border-red-400 text-red-700 px-4 py-3 rounded-xl shadow-sm animate-fade-in" role="alert">
                        <span class="block sm:inline font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
