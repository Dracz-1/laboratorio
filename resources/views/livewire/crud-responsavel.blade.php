<div class="p-6 max-w-4xl mx-auto rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Lista de Responsáveis</h1>
    <button wire:click="create" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition duration-200 ease-in-out mb-6">Adicionar Responsável</button>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-4 mb-6 rounded-md shadow-sm">
            {{ session('message') }}
        </div>
    @endif

<!-- Modal para adicionar/editar responsável -->
@if ($isOpen)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $responsavel_id ? 'Editar' : 'Adicionar' }} Responsável</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-4">
                                <label for="nome" class="block text-sm font-semibold mb-2">Nome</label>
                                <input type="text" id="nome" wire:model="nome" class="border border-gray-300 p-3 rounded-lg w-full shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                @error('nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-semibold mb-2">Email</label>
                                <input type="email" id="email" wire:model="email" class="border border-gray-300 p-3 rounded-lg w-full shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="departamento" class="block text-sm font-semibold mb-2">Departamento</label>
                                <input type="text" id="departamento" wire:model="departamento" class="border border-gray-300 p-3 rounded-lg w-full shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="bg-gray-500 text-white px-6 py-2 rounded-md transition duration-200 hover:bg-gray-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-gray-500" wire:click="closeModal">
                            Cancelar
                        </button>
                        <button type="button" class="bg-green-500 text-white px-6 py-2 rounded-md transition duration-200 hover:bg-green-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-green-500" wire:click="{{ $responsavel_id ? 'update' : 'store' }}">
                            {{ $responsavel_id ? 'Atualizar' : 'Salvar' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse shadow-sm rounded-lg">
            <thead>
                <tr class="bg-orange-600 text-white">
                    <th class="border p-4 text-left">Nome</th>
                    <th class="border p-4 text-left">Email</th>
                    <th class="border p-4 text-left">Departamento</th>
                    <th class="border p-4 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($responsaveis as $responsavel)
                    <tr class="border-b transition duration-200 hover:bg-[rgba(125,125,125,0.90)] dark:hover:bg-[rgba(51,51,51,0.90)]  bg-opacity-75">
                        <td class="border p-4">{{ $responsavel->nome }}</td>
                        <td class="border p-4">{{ $responsavel->email }}</td>
                        <td class="border p-4">{{ $responsavel->departamento }}</td>
                        <td class="border p-4 text-center">
                            <button wire:click="edit({{ $responsavel->id }})" class="bg-yellow-500 text-white px-4 py-2 rounded-md transition duration-200 hover:bg-yellow-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                Editar
                            </button>
                            <button wire:click="delete({{ $responsavel->id }})" class="bg-red-500 text-white px-4 py-2 rounded-md transition duration-200 hover:bg-red-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="return confirm('Tem certeza que deseja excluir?')">
                                Excluir
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
