<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 m-0">
            <div class="row">
                <div class="col text-start">
                    {{ __('Categorias') }}
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#create-modal">
                        {{ __('Crear') }}
                    </button>
                </div>
            </div>
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered stripe">
                <thead>
                    <tr>
                        <th>{{ __('Imágen') }}</th>
                        <th>{{ __('Titulo') }}</th>
                        <th>{{ __('Descripción') }}</th>
                        <th>{{ __('Tamaño') }}</th>
                        <th>{{ __('Categoría Principal') }}</th>
                        <th class="text-end"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                <img src="{{ $category->image_path }}" class="img-thumbnail" alt="{{ $category->title }}" style="width:3.5rem">
                            </td>
                            <td>{{ $category->title }}</td>
                            <td>{{ $category->description }}</td>
                            <td>{{ $category->size_on_screen }}</td>
                            <td>{{ is_null($category->parent_id) ? '-' : $category->parent_category->title }}</td>
                            <td class="text-end">
                                <a data-element="{{ $loop->index }}" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#update-modal" href="#!">
                                    {{ __('Editar') }}
                                </a>&nbsp;
                                <a data-element="{{ $loop->index }}" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal" href="#!">
                                    {{ __('Eliminar') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="create-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('categories.create') }}" method="POST" id="create-form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Crear Categoria') }}</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                            <label class="label">{{ __('Categoría Padre') }}</label>
                            <select required name="parent_id" class="form-select" aria-label="Category">
                            <option value="none">Ninguna</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-4">
                            <label class="label">{{ __('Imagen') }}</label>
                            <input type="file" name="image">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Crear Categoria') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('categories.update') }}" method="POST" id="update-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="" id="update-form-id">
                    <div class="modal-header bg-info text-white">
                        <h4 class="modal-title">{{ __('Actualizar Categoría') }}</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="label">{{ __('Título') }}</label>
                            <input id="update-form-title" required autocomplete="off" name="title" class="form-control" type="text" placeholder="{{ __('Títle') }}">
                        </div>
                        <div class="form-group mt-2">
                            <label class="label">{{ __('Descripción') }}</label>
                            <input id="update-form-description" required autocomplete="off" name="description" class="form-control" type="text" placeholder="{{ __('Descripción') }}">
                        </div>
                        <div class="form-group mt-2">
                            <label class="label">{{ __('Tamaño') }}</label>
                            <input id="update-form-size-on-screen" required autocomplete="off" name="size_on_screen" class="form-control" type="text" placeholder="{{ __('Tamaño') }}">
                        </div>
                        <div class="form-group mt-2">
                            <label class="label">{{ __('Categoría Padre') }}</label>
                            <select id="update-form-parent-id" required name="parent_id" class="form-select" aria-label="Category">
                                <option value="none">Ninguna</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-4">
                            <label class="label">{{ __('Actualizar Imagen') }}</label>
                            <input type="file" name="image"><br/>
                            <small class="text-danger">{{ __('Si no deseas cambiar de imagen puedes dejar este campo vacío y se utilizará la imagen anterior') }}</small>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-info text-white">{{ __('Actualizar Categoría') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('categories.delete') }}" method="POST" id="delete-form">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="id" value="" id="delete-form-id">
                    <div class="modal-header bg-danger text-white">
                        <h4 class="modal-title">{{ __('Eliminar Categoría') }}</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>{{ __('¿Seguro que quieres eliminar el item seleccionado?') }}</h4>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Eliminar Categoría') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <script>
            const elements = @JSON($categories);
    
            const updateModal = document.getElementById('update-modal');
            const deleteModal = document.getElementById('delete-modal');

            const updateModalInputId = document.getElementById('update-form-id');
            const updateModalInputTitle = document.getElementById('update-form-title');
            const updateModalInputDescription = document.getElementById('update-form-description');
            const updateModalInputSizeOnScreen = document.getElementById('update-form-size-on-screen');
            const updateModalInputParentId = document.getElementById('update-form-parent-id');

            const deleteModalInputId = document.getElementById('delete-form-id');

            updateModal.addEventListener('show.bs.modal', function (event) {
                const data = elements[event.relatedTarget.dataset.element];
                updateModalInputId.value = data.id;
                updateModalInputTitle.value = data.title;
                updateModalInputDescription.value = data.description;
                updateModalInputSizeOnScreen.value = data.size_on_screen;
                updateModalInputParentId.value = !data.parent_id ? 'none' : data.parent_id;
            });

            deleteModal.addEventListener('show.bs.modal', function (event) {
                deleteModalInputId.value = elements[event.relatedTarget.dataset.element].id;
            });
        </script>
    </x-slot>
</x-app-layout>