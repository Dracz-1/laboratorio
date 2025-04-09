<div class="p-4 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-4 text-center">Gestão de Salas</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-2 mb-4">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'save' }}">
        <div class="flex gap-2 mb-4">
            <input type="text" wire:model="nome" placeholder="Nome da Sala" class="border p-2 rounded w-full">
            <button type="submit" class="px-4 py-2 rounded transition text-white bg-blue-500 duration-200 hover:bg-blue-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500">
                {{ $isEditing ? 'Atualizar' : 'Adicionar' }}
            </button>
        </div>

        @if ($isEditing)
        <button type="button" wire:click="cancelEdit" class="px-4 py-2 rounded mt-2 transition text-white bg-gray-500 duration-200 hover:bg-gray-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-gray-500">
            Cancelar
        </button>
        @endif
    </form>

    <table class="w-full border-collapse border mt-4 text-center">
        <thead>
            <tr class="bg-orange-600 text-white">
                <th class="border p-2">Nome</th>
                <th class="border p-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salas as $sala)
                <tr class="transition duration-200 hover:bg-[rgba(125,125,125,0.90)] dark:hover:bg-[rgba(51,51,51,0.90)]  bg-opacity-75">
                    <td class="border p-2">{{ $sala->nome }}</td>
                    <td class="border p-2">
                        <button wire:click="edit({{ $sala->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded transition duration-200 hover:bg-yellow-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-yellow-500">Editar</button>
                        <button wire:click="delete({{ $sala->id }})" class="bg-red-500 text-white px-2 py-1 rounded transition duration-200 hover:bg-red-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="return confirm('Tem certeza que deseja excluir?')">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>