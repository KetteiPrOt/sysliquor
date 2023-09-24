<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <x-form-background>
        <form action="{{route('products.update', $product->id)}}" method="POST" class="flex flex-col items-start">
            @csrf

            @method('put')
            
            {{-- Input Type --}}
            <div>
                <x-input-label for="type" :value="__('Tipo')" />
                <select
                    class="z-50 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    name="type"
                    id="type"
                    placeholder="Tipo"
                >
                    @foreach($types as $type)
                        <option value="{{$type->name}}" @selected(old('type', $product->type->name) == $type->name)>
                            {{$type->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Input Name --}}
            <div class="mt-2 self-stretch">
                <x-input-label for="name" :value="__('Nombre')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Input Presentation --}}
            <div class="mt-2">
                <x-input-label for="presentation" :value="__('Presentacion')" />
                <select
                    class="z-50 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    name="presentation"
                    id="presentation"
                    placeholder="Tipo"
                >
                    @foreach($presentations as $presentation)
                        <option value="{{$presentation->content}}" @selected(old('presentation', $product->presentation->content) == $presentation->content)>
                            {{"$presentation->content ml"}}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Send Button --}}
            <x-primary-button class="mt-3 self-center">
                {{ __('Guardar') }}
            </x-primary-button>

        </form>
    </x-form-background>
</x-app-layout>