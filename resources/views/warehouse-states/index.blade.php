<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estados de Bodega') }}
        </h2>
    </x-slot>

    <x-list-background>
        <div class="flex flex-wrap justify-between">
            {{-- Crear Estado de Bodegas --}}
            <x-secondary-button class="mb-3 mr-5">
                <a href="{{route('warehouseStates.create')}}">
                    Nuevo Estado
                </a>
            </x-secondary-button>
        </div>
        
        {{-- Lista de Estados de Bodega --}}
        <table class="border-collapse table-fixed w-full text-sm">
            <thead>
                <th>
                    <tr>
                        <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                            Fecha
                        </th>
                    </tr>
                </th>
            </thead>
            <tbody>
                @foreach($warehouseStates as $warehouseStatus)
                    <tr class="even:bg-slate-50">
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                            {{-- Editar y eliminar --}}
                            {{-- <a href="{{route('products.edit', $product->id)}}" class="text-blue-400 underline">
                                Editar
                            </a>&nbsp;&nbsp;&nbsp; --}}
                            <form class="inline" action="{{route('warehouseStates.destroy', $warehouseStatus->id)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="inline text-red-400 underline">
                                    Eliminar
                                </button>
                            </form> <br>
                            <a href="{{route('warehouseStates.show', $warehouseStatus->id)}}">
                                {{$warehouseStatus->date}}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-3 px-4 sm:px-0">
            {{$warehouseStates->links()}}
        </div>
    </x-list-background>
</x-app-layout>