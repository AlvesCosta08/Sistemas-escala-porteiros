<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Obede') - Sistema de Escalas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">
    <div class="flex h-screen bg-gray-100">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col shadow-xl">
            <div class="h-16 flex items-center justify-center border-b border-gray-800">
                <span class="text-2xl font-bold tracking-wider text-blue-400">OBEDE</span>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.ausencias.*') ? 'bg-gray-800 text-blue-400 border-l-4 border-blue-400' : '' }}">
                    Painel de Ausências
                </a>
                <a href="{{ route('admin.escalas.index') }}" class="block px-4 py-2.5 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.escalas.index') ? 'bg-gray-800 text-blue-400 border-l-4 border-blue-400' : '' }}">
                    Calendário Mensal
                </a>
                <a href="{{ route('admin.escalas.gerenciar') }}" class="block px-4 py-2.5 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.escalas.gerenciar') || request()->routeIs('admin.escalas.alocacoes.*') ? 'bg-gray-800 text-blue-400 border-l-4 border-blue-400' : '' }}">
                    Gestão de Escalas
                </a>
                
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cadastros</p>
                </div>
                <a href="{{ route('admin.usuarios.index') }}" class="block px-4 py-2.5 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.usuarios.*') ? 'bg-gray-800 text-blue-400 border-l-4 border-blue-400' : '' }}">
                    Colaboradores
                </a>
                <a href="{{ route('admin.postos.index') }}" class="block px-4 py-2.5 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.postos.*') ? 'bg-gray-800 text-blue-400 border-l-4 border-blue-400' : '' }}">
                    Postos de Trabalho
                </a>
                <a href="{{ route('admin.turnos.index') }}" class="block px-4 py-2.5 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.turnos.*') ? 'bg-gray-800 text-blue-400 border-l-4 border-blue-400' : '' }}">
                    Turnos
                </a>
            </nav>

            <div class="p-4 border-t border-gray-800">
                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-400 mb-3">{{ ucfirst(auth()->user()->cargo) }}</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left text-sm text-red-400 hover:text-red-300 font-semibold">
                        Sair do Sistema
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shadow-sm">
                <h2 class="text-xl font-semibold text-gray-800">@yield('header', 'Painel')</h2>
            </header>

            <div class="flex-1 overflow-y-auto p-8">
                <!-- Alertas Globais -->
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
