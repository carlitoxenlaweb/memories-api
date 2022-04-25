<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 m-0">
            <div class="row">
                <div class="col text-start">
                    {{ __('Categorías') }}
                </div>
                <div class="col text-end">
                    <a href="{{route("categories.create")}}" class="btn btn-success mb-2">{{__('Crear')}}</a>
                </div>
            </div>
        </h2>
    </x-slot>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Imágen</th>
                        <th>Titulo</th>
                        <th>Descripción</th>
                        <th>Tamaño</th>
                        <th class="text-end">Editar</th>
                        <th class="text-end">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->image_path }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->description }}</td>
                        <td>{{ $category->size_on_screen }}</td>
                        <td class="text-end">
                            <a class="btn btn-warning" href="{{route("categories.edit",[$category])}}">
                                {{-- <i class="fa fa-edit"></i> --}}{{__('Editar')}}
                            </a>
                        </td>
                        <td class="text-end">
                            <form action="{{route("categories.destroy", [$category])}}" method="post">
                                @method("delete")
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    {{-- <i class="fa fa-trash"></i> --}}{{__('Eliminar')}}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
