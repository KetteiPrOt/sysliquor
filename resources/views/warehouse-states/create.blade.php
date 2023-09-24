<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Estado de Bodega') }}
        </h2>
    </x-slot>

    <x-form-background>
        <form action="{{route('warehouseStates.store')}}" method="POST" class="flex flex-col items-start">
            @csrf

            {{-- Input Fecha --}}
            <div class="mt-2 self-stretch">
                <x-input-label for="date" :value="__('Fecha')" />
                <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" />
                <x-input-error :messages="$errors->get('date')" class="mt-2" />
            </div>

            {{-- Send Button --}}
            <x-primary-button class="mt-3 self-center">
                {{ __('Guardar') }}
            </x-primary-button>

        </form>
    </x-form-background>
</x-app-layout>