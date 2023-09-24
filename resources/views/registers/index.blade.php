<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __( 'Registro: ' . $date ) }}
        </h2>
    </x-slot>

    <x-list-background>
        <div class="flex flex-wrap justify-between">
            {{-- Funcionalidad de Busqueda --}}
            <form action="{{route('warehouseStates.show', $id)}}" class="flex items-center mb-3">
                <x-primary-button type="submit">
                    Buscar
                </x-primary-button> 

                <x-text-input
                    class="block ml-1 w-full" type="text" name="search" 
                    :value="$search"
                />

                <a 
                    href="{{route('warehouseStates.show', $id)}}"
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
                <tr>
                    <?php
                        $tableHeaders = [
                            'product' => 'Producto',
                            'total' => 'Total',
                            'previous' => 'Anterior',
                            'sales' => 'Ventas'
                        ];
                    ?>
                    @foreach($tableHeaders as $inputValue => $text)
                        <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 text-slate-400 dark:text-slate-200 text-left">
                            <form action="{{route('warehouseStates.show', $id)}}">
                                @csrf

                                <button type="submit">
                                    {{$text}}
                                </button> 

                                <x-text-input
                                    hidden type="text" name="orderBy" 
                                    :value="$inputValue"
                                />

                                <x-text-input 
                                    hidden type='text' name="page"
                                    :value="$rawRegisters->currentPage()"
                                />

                                <input
                                    type="checkbox"
                                    name="order" value="desc"
                                    <?php
                                        if(isset($_GET['order'])){
                                            echo $_GET['order'] === 'desc' ? 'checked' : '';
                                        }
                                    ?>
                                    class="
                                        orderInput
                                        bg-[url('http://liquorstore.test/storage/orderIcon.png')] bg-contain bg-no-repeat bg-center border-none rotate-180
                                        checked:bg-[url('http://liquorstore.test/storage/orderIcon.png')] checked:bg-contain checked:bg-no-repeat checked:bg-center border-none
                                        checked:rotate-0 checked:text-transparent
                                        focus:ring-0
                                    "
                                >       
                            </form>
                        </th>
                    @endforeach
                    {{-- Pasa la URL de PHP a CSS --}}
                    {{-- <p 
                        id="backgroundImageElement" class="hidden"
                    >{{asset(Storage::url('orderIcon.png'))}}</p>
                    <script>
                        let backgroundImageElement = document.getElementById('backgroundImageElement'),
                            orderInputs = document.getElementsByClassName('orderInput');
                        // backgroundImageElement.textContent
                        console.log(orderInputs);
                        // orderInput.style.backgroundImage = "url('data:image/jpeg;base64,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')";
                    </script> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($rawRegisters as $register)
                    <tr class="even:bg-slate-50">
                        <td class="border-b border-slate-100 dark:border-slate-700 sm:p-4 sm:pl-8 text-slate-500 dark:text-slate-400">
                            <a href="{{route('registers.edit', [$id, $register->id])}}" class="text-blue-400 underline">
                                Editar
                            </a> <br>
                            {{
                                ucfirst($register->type)
                                . " " .
                                ucfirst($register->name)
                                . " (" .
                                $register->content . "ml)"
                            }}
                        </td>
                        <td class="border-b border-slate-100 dark:border-slate-700 sm:p-4 sm:pl-8 text-slate-500 dark:text-slate-400">
                            {{-- Dropdown --}}
                            <div
                                class="relative mr-5" x-data="{ open: false }" 
                                @click.outside="open = false" @close.stop="open = false">
                                {{-- Toggle Button --}}
                                <div @click="open = ! open">
                                    {{-- Trigger --}}
                                    <button
                                        class="
                                            border border-transparent rounded-md
                                            inline-flex items-center 
                                            hover:text-gray-300 transition ease-in-out duration-150
                                        "
                                    >
                                        <div>{{$register->total_count}}</div>
                                        {{-- Dropdown Icon --}}
                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                            
                                <div x-show="open"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        class="absolute z-50 mt-2 rounded-md shadow-lg"
                                        style="display: none;"
                                        @click="open = false"
                                >
                                    <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                                        {{-- Content --}}
                                        <div
                                            class="
                                                block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 
                                                hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out
                                            ">
                                            {{
                                                "Deposito: " . $register->deposit
                                            }}
                                        </div>
                                        <div
                                            class="
                                                block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 
                                                hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out
                                            ">
                                            {{
                                                "Licoreria: " . $register->liquor_shop
                                            }}
                                        </div>
                                        <div
                                            class="
                                                block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 
                                                hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out
                                            ">
                                            {{
                                                "Pedido: " . $register->ordered
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>                        
                        <td class="text-center sm:text-left border-b border-slate-100 dark:border-slate-700 sm:p-4 sm:pl-8 text-slate-500 dark:text-slate-400">
                            <?php
                                $previous = $register->previous_count;
                            ?>
                            {{-- {{dump($previous)}} --}}
                            {{
                                $previous || ($previous === 0) ? $previous : 'Sin datos'
                            }}
                        </td>
                        <td class="text-center sm:text-left border-b border-slate-100 dark:border-slate-700 sm:p-4 sm:pl-8 text-slate-500 dark:text-slate-400">
                            {{
                                $register->sales || ($register->sales === 0) ? $register->sales : 'Sin datos'
                            }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3 px-4 sm:px-0">
            {{$rawRegisters->links()}}
        <div>
    </x-list-background>
</x-app-layout>