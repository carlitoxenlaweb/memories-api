<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 m-0">
            <div class="row">
                <div class="col text-start">
                    {{ __('Crear Categoría') }}
                </div>
                <div class="col text-end">
                    <a class="btn btn-danger" href="{{route("categories.index")}}">{{__('Cancelar')}}</a>
                </div>
            </div>
        </h2>
    </x-slot>

    <form method="POST" action="{{route("categories.store")}}">
        @csrf
        <div class="form-group">
            <label class="label">{{ __('Título') }}</label>
            <input required autocomplete="off" name="title" class="form-control" type="text" placeholder="{{ __('Títle') }}">
        </div>
        
        <div class="form-group mt-2">
            <label class="label">{{ __('Descripción') }}</label>
            <input required autocomplete="off" name="description" class="form-control" type="text" placeholder="{{ __('Descripción') }}">
        </div>
        
        <div class="form-group mt-2">
            <label class="label">{{ __('Tamaño') }}</label>
            <input required autocomplete="off" name="size_on_screen" class="form-control" type="text" placeholder="{{ __('Tamaño') }}">
        </div>
        
        <div class="form-group mt-2">
            <label class="label">{{ __('Imagen') }}</label>
            <input required autocomplete="off" name="image_path" class="form-control" type="text" placeholder="{{ __('Imagen') }}">
        </div>

        <div class="form-group mt-2 text-center">
            <button class="btn btn-success">{{ __('Crear Categoría') }}</button>
        </div>
    </form>
</x-app-layout>
