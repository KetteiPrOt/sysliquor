<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Registro') }}
        </h2>
    </x-slot>

    <x-form-background>
        <form action="{{route('registers.update', [$warehouseStatus->id, $register->id])}}" method="POST" class="flex flex-col items-start">
            @csrf

            @method('put')
            
            {{-- Input Deposito --}}
            <div>
                <x-input-label for="deposit" :value="__('Deposito')" />
                <x-text-input id="deposit" class="block mt-1 w-full" type="number" min="0" name="deposit" :value="old('deposit', $register->deposit)" required autofocus />
                <x-input-error :messages="$errors->get('deposit')" class="mt-2" />
            </div>

            {{-- Input Licoreria --}}
            <div class="mt-2 self-stretch">
                <x-input-label for="liquor_shop" :value="__('Licoreria')" />
                <x-text-input id="liquor_shop" class="block mt-1 w-full" type="number" min="0" name="liquor_shop" :value="old('liquor_shop', $register->liquor_shop)" required autofocus />
                <x-input-error :messages="$errors->get('liquor_shop')" class="mt-2" />
            </div>

            {{-- Input Pedido --}}
            <div class="mt-2">
                <x-input-label for="ordered" :value="__('Pedido')" />
                <x-text-input id="ordered" class="block mt-1 w-full" type="number" min="0" name="ordered" :value="old('ordered', $register->ordered)" required autofocus />
                <x-input-error :messages="$errors->get('ordered')" class="mt-2" />
            </div>

            <div class="flex self-stretch justify-center">
                {{-- Send Button --}}
                <x-primary-button class="mt-3 mr-1 self-center">
                    {{ __('Guardar') }}
                </x-primary-button>

                {{-- Cancel Button --}}
                <x-secondary-button class="mt-3 ml-1 self-center">
                    <a href="{{route('warehouseStates.show', $warehouseStatus->id)}}">
                        {{ __('Cancelar') }}
                    </a>
                </x-secondary-button>
            </div>

        </form>
    </x-form-background>
</x-app-layout>