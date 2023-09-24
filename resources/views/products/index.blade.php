<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tus Productos') }}
        </h2>
    </x-slot>

    <x-list-background>
        <div class="flex flex-wrap justify-between">
            {{-- Crear Nuevo Producto --}}
            <x-secondary-button class="mb-3 mr-5">
                <a href="{{route('products.create')}}">
                    Nuevo Producto
                </a>
            </x-secondary-button> 

            {{-- Funcionalidad de Busqueda --}}
            <form action="{{route('products.index')}}" class="flex items-center mb-3">
                <x-primary-button type="submit">
                    Buscar
                </x-primary-button> 

                <x-text-input
                    class="block ml-1 w-full" type="text" name="search" 
                    :value="$search"
                />

                <a 
                    href="{{route('products.index')}}"
                    class="
                        text-white bg-red-400 shrink-0 w-5 h-5 p-4 rounded-full ml-1
                        flex justify-center items-center
                    "
                >X</a>
            </form>
        </div>
        
        {{-- Lista de Productos --}}
        <table class="border-collapse table-fixed w-full text-sm">
            <thead>
                <th>
                    <tr>
                        <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 text-slate-400 dark:text-slate-200 text-left">
                            Tipo
                        </th>
                        <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 text-slate-400 dark:text-slate-200 text-left">
                            Nombre
                        </th>
                        <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 text-slate-400 dark:text-slate-200 text-left">
                            Presentacion
                        </th>
                    </tr>
                </th>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="even:bg-slate-50">
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                            {{ucfirst($product->type->name)}}
                        </td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                            <a href="{{route('products.edit', $product->id)}}" class="text-blue-400 underline">
                                Editar
                            </a>&nbsp;&nbsp;&nbsp;
                            <form class="inline" action="{{route('products.destroy', $product->id)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="inline text-red-400 underline">
                                    Eliminar
                                </button>
                            </form> <br>
                            {{ucfirst($product->name)}}
                        </td>
                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                            {{$product->presentation->content . "ml"}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3 px-4 sm:px-0">
            {{$products->links()}}
        <div>
    </x-list-background>
</x-app-layout>