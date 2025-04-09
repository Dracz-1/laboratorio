<div class="max-w-xl mx-auto p-4 border-gray-500 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Criar Novo Equipamento</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="guardar" class="space-y-4" enctype="multipart/form-data">
        <input type="text" wire:model="equipamento" placeholder="Nome do Equipamento" class="w-full border p-2 rounded">
        <textarea wire:model="caracteristicas" placeholder="Características" class="w-full border p-2 rounded"></textarea>
        
        <input type="text" wire:model="condicao_de_emprestimo" placeholder="Condição de Empréstimo" class="w-full border p-2 rounded">
        <input type="number" id="quantity-input" wire:model="quantidade" class="w-full border p-2 rounded" data-input-counter aria-describedby="helper-text-explanation" class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Quantidade" required />
        <select wire:model="calibrado" class="border p-1 w-full rounded">
            <option value="" class="text-white bg-gray-700 hover:bg-gray-500">Calibrado</option>
            <option value="Sim" class="flex items-center px-6 py-2 text-white bg-gray-700 hover:bg-gray-500">Sim</option>
            <option value="Não" class ="flex items-center px-6 py-2 text-white bg-gray-700 hover:bg-gray-500">Não</option>
            <option value="N/a" class="flex items-center px-6 py-2 text-white bg-gray-700 hover:bg-gray-500">Não Aplicável</option>
        </select>
        <input type="url" wire:model="manual_url" placeholder="Link do Manual (URL)" class="w-full border p-2 rounded">
        

        <select wire:model="localizacao" class="w-full border p-2 rounded">
            <option value=""class="text-white bg-gray-700 hover:bg-gray-500">Selecione a Localização</option>
            @foreach($salas as $sala)
                <option value="{{ $sala->id }}" class="text-white bg-gray-700 hover:bg-gray-500">{{ $sala->nome }}</option>
            @endforeach
        </select>

        <select wire:model="responsavel" class="w-full border p-2 rounded">
            <option value="" class="text-white bg-gray-700 hover:bg-gray-500">Selecione o Responsável</option>
            @foreach($responsaveis as $r)
                <option value="{{ $r->id }}" class="text-white bg-gray-700 hover:bg-gray-500">{{ $r->nome }}</option>
            @endforeach
        </select>
<!-- Upload de fotografia -->
<div class="w-full">
    <label for="fotografia" class="block text-sm font-medium text-gray-700 dark:text-neutral-200">Fotografia do Equipamento</label>
    <input type="file" wire:model="fotografia" class="w-full border p-2 rounded mt-2">
    @error('fotografia') 
        <span class="text-red-500 text-xs">{{ $message }}</span>
    @enderror
</div>        <button type="submit" class="px-4 py-2 rounded transition text-white bg-blue-500 duration-200 hover:bg-blue-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Guardar Equipamento
        </button>
    </form>
</div>
