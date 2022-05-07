<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 m-0">
            <div class="row">
                <div class="col text-start">
                    {{ __('Acabados') }}
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
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('Nombre') }}</th>
                        <th class="text-end"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($finishes as $finish)
                        <tr>
                            <td>{{ $finish->name }}</td>
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
                <form method="POST" action="{{ route('finishes.create') }}" method="POST" id="create-form">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Crear Acabado') }}</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="label">{{ __('Nombre') }}</label>
                            <input required autocomplete="off" name="name" class="form-control" type="text" placeholder="{{ __('Nombre') }}">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Crear Acabado') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('finishes.update') }}" method="POST" id="update-form">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="" id="update-form-id">
                    <div class="modal-header bg-info text-white">
                        <h4 class="modal-title">{{ __('Actualizar Acabado') }}</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="label">{{ __('Nombre') }}</label>
                            <input required autocomplete="off" id="update-form-name" name="name" class="form-control" type="text" placeholder="{{ __('Nombre') }}">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-info text-white">{{ __('Actualizar Acabado') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('finishes.delete') }}" method="POST" id="delete-form">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="id" value="" id="delete-form-id">
                    <div class="modal-header bg-danger text-white">
                        <h4 class="modal-title">{{ __('Eliminar Acabado') }}</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>{{ __('¿Seguro que quieres eliminar el item seleccionado?') }}</h4>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Eliminar Acabado') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <script>
            const elements = @JSON($finishes);
    
            const updateModal = document.getElementById('update-modal');
            const deleteModal = document.getElementById('delete-modal');

            const updateModalInputId = document.getElementById('update-form-id');
            const updateModalInputName = document.getElementById('update-form-name');

            const deleteModalInputId = document.getElementById('delete-form-id');

            updateModal.addEventListener('show.bs.modal', function (event) {
                const data = elements[event.relatedTarget.dataset.element];
                updateModalInputId.value = data.id;
                updateModalInputName.value = data.name;
            });

            deleteModal.addEventListener('show.bs.modal', function (event) {
                deleteModalInputId.value = elements[event.relatedTarget.dataset.element].id;
            });
        </script>
    </x-slot>
</x-app-layout>