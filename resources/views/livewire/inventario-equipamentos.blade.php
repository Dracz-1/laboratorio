@php use Illuminate\Support\Facades\Auth; @endphp

<div>
    <h2 class="text-2xl font-bold mb-4">Inventário de Equipamentos</h2>

    <!-- Filtros e Pesquisa -->
    <div class="mb-4 flex flex-wrap gap-2 items-center">
        <!-- Campo de Pesquisa -->
        <input type="text" wire:model.defer="search" placeholder="Procurar equipamento..."
            class="border rounded h-10 px-3" />
    
        <!-- Dropdown Localizações -->
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
        class="border rounded h-10 px-4 flex items-center justify-between min-w-[180px]">
        Localizações
        <svg :class="{ 'rotate-180': open }" class="h-4 w-4 ml-2 transition-transform"
            xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div x-show="open" @click.outside="open = false"
        x-transition:enter="transition-all duration-300 ease-out"
        x-transition:enter-start="opacity-0 max-h-0"
        x-transition:enter-end="opacity-100 max-h-60"
        x-transition:leave="transition-all duration-200 ease-in"
        x-transition:leave-start="opacity-100 max-h-60"
        x-transition:leave-end="opacity-0 max-h-0"
        class="absolute border mt-1 rounded shadow-md w-full z-10 overflow-hidden">
        @foreach($locations as $location)
            <label class="flex items-center px-4 py-2 text-white bg-gray-700 hover:bg-gray-500">
                <input type="checkbox" wire:model.defer="selectedLocation"
                    value="{{ $location->id }}" class="mr-2">
                {{ $location->nome }}
            </label>
        @endforeach
    </div>
</div>

<!-- Dropdown Responsáveis -->
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
        class="border rounded h-10 px-4 flex items-center justify-between min-w-[180px]">
        Responsáveis
        <svg :class="{ 'rotate-180': open }" class="h-4 w-4 ml-2 transition-transform"
            xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div x-show="open" @click.outside="open = false"
        x-transition:enter="transition-all duration-300 ease-out"
        x-transition:enter-start="opacity-0 max-h-0"
        x-transition:enter-end="opacity-100 max-h-60"
        x-transition:leave="transition-all duration-200 ease-in"
        x-transition:leave-start="opacity-100 max-h-60"
        x-transition:leave-end="opacity-0 max-h-0"
        class="absolute border mt-1 rounded shadow-md w-full z-10 overflow-hidden">
        @foreach($responsaveis as $responsavel)
            <label class="flex items-center px-6 py-2 text-white bg-gray-700 hover:bg-gray-500">
                <input type="checkbox" wire:model.defer="selectedResponsavel"
                    value="{{ $responsavel->id }}" class="mr-2">
                {{ $responsavel->nome }}
            </label>
        @endforeach
    </div>
</div>

        <!-- Botão Procurar -->
        <button wire:click="buscarEquipamentos"
            class="rounded h-10 px-4 transition text-white bg-blue-500 duration-200 hover:bg-blue-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Procurar
        </button>
    
        <!-- Botão Limpar -->
        <button wire:click="limparProcura"
            class="bg-gray-500 text-white rounded h-10 px-4 transition duration-200 hover:bg-gray-500 active:scale-95 focus:outline-none focus:ring-2 focus:ring-gray-500">
            Limpar Procura
        </button>
    </div>
    

    <!-- Tabela de Equipamentos -->
    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-orange-600 text-white">
                <th class="border p-2">Equipamento</th>
                <th class="border p-2">Características</th>
                <th class="border p-2">Condição de Empréstimo</th>
                <th class="border p-2">Localização</th>
                <th class="border p-2">Responsável</th>
                <th class="border p-2">Imagem</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipamentos as $equipamento)
                <tr class="border transition duration-200 hover:bg-[rgba(125,125,125,0.90)] dark:hover:bg-[rgba(51,51,51,0.90)]  bg-opacity-75">
                    <td class="border p-2">
                    <a href="javascript:void(0)" 
   class="inline-block transition duration-200 ease-in-out hover:text-indigo-600 active:scale-90" 
   wire:click="selecionarEquipamento({{ $equipamento->id }})">
   {{ $equipamento->equipamento }}
</a>
             </td>
                    <td class="border p-2">{{ $equipamento->caracteristicas }}</td>
                    <td class="border p-2">{{ $equipamento->condicao_de_emprestimo }}</td>
                    <td class="border p-2">{{ $equipamento->sala->nome ?? 'N/A' }}</td>
                    <td class="border p-2">{{ $equipamento->responsaveis->nome ?? 'N/A' }}</td>
                    <td class="border p-2">
                        @if($equipamento->fotografia_base64)
                            <img src="data:image/png;base64,{{ $equipamento->fotografia_base64 }}" alt="Imagem do equipamento" class="h-auto max-h-40 w-auto object-contain">
                        @else
                            <span class="text-gray-500">Sem imagem</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="mt-4">
        {{ $equipamentos->links() }}
    </div>

    @if($equipamentoSelecionado)
<div class="fixed inset-0 bg-[rgba(0,0,0,0.75)] flex justify-center items-center z-50 px-4">
    <div class="p-6 rounded-lg w-full max-w-4xl max-h-screen overflow-y-auto bg-white dark:bg-gray-800">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Texto -->
            <div class="flex-1 space-y-3">
                <h3 class="text-xl font-bold">
                    @if($modoEdicao)
                        <input type="text" wire:model.defer="dadosEdicao.equipamento" class="border p-1 w-full rounded" />
                    @else
                        {{ $equipamentoSelecionado->equipamento }}
                    @endif
                </h3>

                <p><strong>Características:</strong><br>
                    @if($modoEdicao)
                        <textarea wire:model.defer="dadosEdicao.caracteristicas" class="border p-1 w-full rounded"></textarea>
                    @else
                        {{ $equipamentoSelecionado->caracteristicas }}
                    @endif
                </p>

                <p><strong>Condição de Empréstimo:</strong><br>
                    @if($modoEdicao)
                        <input type="text" wire:model.defer="dadosEdicao.condicao_de_emprestimo" class="border p-1 w-full rounded" />
                    @else
                        {{ $equipamentoSelecionado->condicao_de_emprestimo }}
                    @endif
                </p>

                <p><strong>Quantidade:</strong><br>
                    @if($modoEdicao)
                        <input type="number" wire:model.defer="dadosEdicao.quantidade" class="border p-1 w-full rounded" />
                    @else
                        {{ $equipamentoSelecionado->quantidade }}
                    @endif
                </p>

                <p><strong>Calibrado:</strong><br>
                    @if($modoEdicao)
                        <select wire:model.defer="dadosEdicao.calibrado" class="border p-1 w-full rounded">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    @else
                        {{ $equipamentoSelecionado->calibrado ? 'Sim' : 'Não' }}
                    @endif
                </p>

                <p><strong>Manual:</strong><br>
                    @if($modoEdicao)
                        <input type="text" wire:model.defer="dadosEdicao.manual_url" class="border p-1 w-full rounded" />
                    @elseif($equipamentoSelecionado->manual_url)
                        <a href="{{ $equipamentoSelecionado->manual_url }}" target="_blank" class="text-blue-700 underline">link</a>
                    @else
                        Não disponível
                    @endif
                </p>

                @if($modoEdicao)
                <div class="mt-4">
                    <label for="novaImagem" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Nova Imagem:</label>
                    
                    <div class="hs-file-upload relative overflow-hidden inline-block">
                        <input id="novaImagem"
                               type="file"
                               wire:model="novaImagem"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        <button type="button"
                                class="bg-white border border-gray-300 rounded px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700">
                            Escolher Ficheiro
                        </button>
                    </div>
            
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1" wire:loading wire:target="novaImagem">
                        A carregar imagem...
                    </div>
            
                    @error('novaImagem') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            @endif

            </div>
            <!-- Imagem -->
            <div class="w-full md:w-1/2 flex justify-center items-center h-full">
                @if($equipamentoSelecionado->fotografia_base64)
                <img src="data:image/png;base64,{{ $equipamentoSelecionado->fotografia_base64 }}" 
                alt="Imagem do equipamento"
                class="max-h-96 object-contain border rounded shadow mx-auto" />
                @else
                    <span class="text-gray-500">Sem imagem</span>
                @endif
            </div>
        </div>

        <!-- Botões -->
        <div class="mt-6 flex justify-end gap-2">
            @if(Auth::id() != 3)
            @if($modoEdicao)
                <button wire:click="cancelarEdicao" class="bg-gray-500 text-white px-4 py-2 transition duration-200  rounded hover:bg-gray-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancelar</button>
                <button wire:click="guardarEdicao" class="bg-green-500 text-white px-4 py-2 transition duration-200  rounded hover:bg-green-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-green-500">Guardar</button>
            @else
                <button wire:click="editarEquipamento" class="bg-blue-500 text-white px-4 py-2 transition duration-200  rounded hover:bg-blue-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500">Editar</button>
            @endif
            @endif
            <button wire:click="fecharModal" class="bg-red-500 text-white px-4 py-2 rounded transition duration-200 hover:bg-red-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-500">Fechar</button>
        </div>
    </div>
</div>
@endif

</div>
