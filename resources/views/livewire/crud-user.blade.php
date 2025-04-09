<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Gestão de Utilizadores</h2>

    <form wire:submit.prevent="{{ $user_id ? 'atualizar' : 'guardar' }}" class="space-y-3 mb-6">
        <input type="text" wire:model="name" placeholder="Nome" class="border p-2 w-full rounded" />
        <input type="email" wire:model="email" placeholder="Email" class="border p-2 w-full rounded" />
        @if($user_id)
        <div x-data="{ show: false }">
            <input :type="show ? 'text' : 'password'" 
                   wire:model="password" 
                   placeholder="Nova palavra-passe (opcional)" 
                   class="border p-2 w-full rounded" />
            <button type="button" @click="show = !show" class="text-sm mt-1 text-blue-600">
                <span x-text="show ? 'Ocultar' : 'Mostrar'"></span>
            </button>
        </div>
    @else
        <div x-data="{ show: false }">
            <input :type="show ? 'text' : 'password'" 
                   wire:model="password" 
                   placeholder="Palavra-passe" 
                   class="border p-2 w-full rounded" />
            <button type="button" @click="show = !show" class="text-sm mt-1 text-blue-600">
                <span x-text="show ? 'Ocultar' : 'Mostrar'"></span>
            </button>
        </div>
    @endif
    
    

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded transition duration-200 hover:bg-blue-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500">
                {{ $user_id ? 'Atualizar' : 'Criar' }}
            </button>
            @if($user_id)
                <button type="button" wire:click="resetCampos" class="bg-gray-500 text-white px-4 py-2 rounded transition duration-200 hover:bg-gray-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancelar</button>
            @endif
        </div>
    </form>

    <table class="w-full text-left border">
        <thead class="bg-orange-600 text-white">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">Nome</th>
                <th class="p-2">Email</th>
                <th class="p-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="border-t">
                    <td class="p-2">{{ $user->id }}</td>
                    <td class="p-2">{{ $user->name }}</td>
                    <td class="p-2">{{ $user->email }}</td>
                    <td class="p-2 flex gap-2">
                        <button wire:click="editar({{ $user->id }})" class="bg-yellow-500 text-white px-4 py-2 rounded transition duration-200 hover:bg-yellow-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-yellow-500">Editar</button>
                        <button wire:click="eliminar({{ $user->id }})" class="bg-red-500 text-white px-4 py-2 rounded transition duration-200 hover:bg-red-600 active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="return confirm('Eliminar utilizador?')">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
