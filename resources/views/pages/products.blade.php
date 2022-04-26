<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 m-0">
            <div class="row">
                <div class="col text-start">
                    {{ __('Productos') }}
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
                        <th>{{ __('Titulo') }}</th>
                        <th>{{ __('Descripción') }}</th>
                        <th>{{ __('Tamaño') }}</th>
                        <th>{{ __('Papel') }}</th>
                        <th>{{ __('Categoría') }}</th>
                        <th class="text-end"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->size }}</td>
                            <td>{{ $product->paper }}</td>
                            <td>{{ $product->category->title }}</td>
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
                <form method="POST" action="{{ route('products.create') }}" method="POST" id="create-form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Crear Producto') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="label">{{ __('Título') }}</label>
                                    <input required autocomplete="off" name="title" class="form-control" type="text" placeholder="{{ __('Títle') }}">
                                </div>
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Descripción') }}</label>
                                    <input required autocomplete="off" name="description" class="form-control" type="text" placeholder="{{ __('Descripción') }}">
                                </div>
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Características') }}</label>
                                    <textarea autocomplete="off" name="specs" class="form-control" type="text" placeholder="{{ __('Listado separado por punto y coma (;)') }}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Tamaño') }}</label>
                                    <input required autocomplete="off" name="size" class="form-control" type="text" placeholder="{{ __('Tamaño') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Papel') }}</label>
                                    <input required autocomplete="off" name="paper" class="form-control" type="text" placeholder="{{ __('Papel') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Categoría') }}</label>
                                    <select required name="category" class="form-select" aria-label="Default select example">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 mb-2" id="extra-prices-base">
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Precio') }}</label>
                                    <input required autocomplete="off" name="prices[0][price]" min="0" step=".01" class="form-control" type="number" placeholder="{{ __('Precio') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Minínimo') }}</label>
                                    <input required autocomplete="off" name="prices[0][min]" min="0" class="form-control" type="number" placeholder="{{ __('Minínimo') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Náximo') }}</label>
                                    <input required autocomplete="off" name="prices[0][max]" min="0" class="form-control" type="number" placeholder="{{ __('Náximo') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Prioridad') }}</label>
                                    <input required autocomplete="off" name="prices[0][priority]" min="0" class="form-control" type="number" placeholder="{{ __('Prioridad') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">&nbsp;</label><br/>
                                    <button id="btn-add-price" type="button" class="btn btn-success">Agregar</button>
                                </div>
                            </div>
                        </div>
                        <div id="extra-prices"></div>
                        <div class="row mt-4 mb-2">
                            <div class="col">
                                <label>Acabados</label>
                                @foreach ($finishes as $finish)
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" value="{{ $finish->id }}" id="create-input-finish-{{ $loop->index }}" name="finishes[]">
                                        <label class="form-check-label" for="create-input-finish-{{ $loop->index }}">
                                            {{ $finish->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Imagenes') }}</label>
                                    <input type="file" name="images[]" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Crear Producto') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('products.update') }}" method="POST" id="update-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="" id="update-form-id">
                    <div class="modal-header bg-info text-white">
                        <h4 class="modal-title">{{ __('Actualizar Producto') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="label">{{ __('Título') }}</label>
                                    <input id="update-form-title" required autocomplete="off" name="title" class="form-control" type="text" placeholder="{{ __('Títle') }}">
                                </div>
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Descripción') }}</label>
                                    <input id="update-form-description" required autocomplete="off" name="description" class="form-control" type="text" placeholder="{{ __('Descripción') }}">
                                </div>
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Características') }}</label>
                                    <textarea id="update-form-specs" required autocomplete="off" name="specs" class="form-control" type="text" placeholder="{{ __('Listado separado por punto y coma (;)') }}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Tamaño') }}</label>
                                    <input id="update-form-size" required autocomplete="off" name="size" class="form-control" type="text" placeholder="{{ __('Tamaño') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Papel') }}</label>
                                    <input id="update-form-paper" required autocomplete="off" name="paper" class="form-control" type="text" placeholder="{{ __('Papel') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Categoría') }}</label>
                                    <select id="update-form-category" required name="category" class="form-select" aria-label="Default select example">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 mb-2">
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Precio') }}</label>
                                    <input id="update-form-price" required autocomplete="off" name="prices[0][price]" min="0" step=".01" class="form-control" type="number" placeholder="{{ __('Precio') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Minínimo') }}</label>
                                    <input id="update-form-min" required autocomplete="off" name="prices[0][min]" min="0" class="form-control" type="number" placeholder="{{ __('Minínimo') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Náximo') }}</label>
                                    <input id="update-form-max" required autocomplete="off" name="prices[0][max]" min="0" class="form-control" type="number" placeholder="{{ __('Náximo') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Prioridad') }}</label>
                                    <input id="update-form-priority" required autocomplete="off" name="prices[0][priority]" min="0" class="form-control" type="number" placeholder="{{ __('Prioridad') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">&nbsp;</label><br/>
                                    <button id="btn-add-price-update" type="button" class="btn btn-success">Agregar</button>
                                </div>
                            </div>
                        </div>
                        <div id="extra-prices-update"></div>
                        <div class="row mt-4 mb-2">
                            <div class="col">
                                <label>Acabados</label>
                                @foreach ($finishes as $finish)
                                    <div class="form-check mt-2">
                                        <input id="update-form-finish-{{ $finish->id }}" class="form-check-input" type="checkbox" value="{{ $finish->id }}" id="create-input-finish-{{ $loop->index }}" name="finishes[]">
                                        <label class="form-check-label" for="create-input-finish-{{ $loop->index }}">
                                            {{ $finish->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <div class="form-group mt-2">
                                    <label class="label">{{ __('Imagenes') }}</label>
                                    <input type="file" name="images[]" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-info text-white">{{ __('Actualizar Producto') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('products.delete') }}" method="POST" id="delete-form">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="id" value="" id="delete-form-id">
                    <div class="modal-header bg-danger text-white">
                        <h4 class="modal-title">{{ __('Eliminar Producto') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>{{ __('¿Seguro que quieres eliminar el item seleccionado?') }}</h4>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Eliminar Producto') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <script>
            const elements = @JSON($products);
            let count = 0;

            $(document).on('click', '#btn-add-price', function () {
                if (count > 0) $('#btn-remove-price-' + count,).prop('disabled', true);
                count++;
                $base = $('#extra-prices-base').clone();
                $base.attr('id', $base.attr('id') + '-' + count);
                $inputs = $base.find('input');
                $($inputs[0]).attr('name', 'prices[' + count + '][price]').val('');
                $($inputs[1]).attr('name', 'prices[' + count + '][min]').val('');
                $($inputs[2]).attr('name', 'prices[' + count + '][max]').val('');
                $($inputs[3]).attr('name', 'prices[' + count + '][priority]').val('');
                $base.find('button')
                    .attr('id', 'btn-remove-price-' + count)
                    .removeClass('btn-success')
                    .addClass('btn-danger btn-remove-price')
                    .text('{{ __('Eliminar') }}');
                $('#extra-prices').append($base);
            }).on('click', '#btn-add-price-update', function () {
                if (count > 0) $('#btn-remove-price-update-' + count,).prop('disabled', true);
                count++;
                $base = $('#extra-prices-base').clone();
                $base.attr('id', $base.attr('id') + '-update-' + count);
                $inputs = $base.find('input');
                $($inputs[0]).attr('name', 'prices[' + count + '][price]').val('');
                $($inputs[1]).attr('name', 'prices[' + count + '][min]').val('');
                $($inputs[2]).attr('name', 'prices[' + count + '][max]').val('');
                $($inputs[3]).attr('name', 'prices[' + count + '][priority]').val('');
                $base.find('button')
                    .attr('id', 'btn-remove-price-update-' + count)
                    .removeClass('btn-success')
                    .addClass('btn-danger btn-remove-price')
                    .text('{{ __('Eliminar') }}');
                $('#extra-prices-update').append($base);
            }).on('click', '.btn-remove-price', function () {
                $('#extra-prices-base-' + count).remove();
                $('#extra-prices-base-update-' + count).remove();
                count--;
                if (count > 0) {
                    $('#btn-remove-price-' + count).prop('disabled', false);
                    $('#btn-remove-price-update-' + count).prop('disabled', false);
                }
            });
    
            const createModal = document.getElementById('create-modal');
            const updateModal = document.getElementById('update-modal');
            const deleteModal = document.getElementById('delete-modal');

            const createForm = document.getElementById('create-form');
            const updateForm = document.getElementById('update-form');

            const updateModalInputId = document.getElementById('update-form-id');
            const updateModalInputTitle = document.getElementById('update-form-title');
            const updateModalInputDescription = document.getElementById('update-form-description');
            const updateModalInputSpecs = document.getElementById('update-form-specs');
            const updateModalInputSize = document.getElementById('update-form-size');
            const updateModalInputPaper = document.getElementById('update-form-paper');
            const updateModalInputCategory = document.getElementById('update-form-category');
            const updateModalInputPrice = document.getElementById('update-form-price');
            const updateModalInputMin = document.getElementById('update-form-min');
            const updateModalInputMax = document.getElementById('update-form-max');
            const updateModalInputPriority = document.getElementById('update-form-priority');

            const deleteModalInputId = document.getElementById('delete-form-id');

            const resetModal = function (event) {
                count = 0;
                createForm.reset();
                updateForm.reset();
                $('#extra-prices').find('>div').each(function () {
                    $(this).remove();
                });
            };

            createModal.addEventListener('hide.bs.modal', resetModal);
            updateModal.addEventListener('hide.bs.modal', resetModal);

            updateModal.addEventListener('show.bs.modal', function (event) {
                const data = elements[event.relatedTarget.dataset.element];
                
                updateModalInputId.value = data.id;
                updateModalInputTitle.value = data.title;
                updateModalInputDescription.value = data.description;
                updateModalInputSpecs.value = data.specs;
                updateModalInputSize.value = data.size;
                updateModalInputPaper.value = data.paper;
                updateModalInputCategory.value = data.category_id;
                updateModalInputPrice.value = data.prices[0].price;
                updateModalInputMin.value = data.prices[0].min;
                updateModalInputMax.value = data.prices[0].max;
                updateModalInputPriority.value = data.prices[0].priority;
                
                for (const item of data.finishes) {
                    const checkItem = document.getElementById('update-form-finish-' + item.finish_id);
                    if (!!checkItem) checkItem.checked = true;
                }

                for (let i = 1; i < data.prices.length; i++) {
                    const item = data.prices[i];
                    count++;
                    $base = $('#extra-prices-base').clone();
                    $base.attr('id', $base.attr('id') + '-update-' + count);
                    $inputs = $base.find('input');
                    $($inputs[0]).attr('name', 'prices[' + count + '][price]').val(item.price);
                    $($inputs[1]).attr('name', 'prices[' + count + '][min]').val(item.min);
                    $($inputs[2]).attr('name', 'prices[' + count + '][max]').val(item.max);
                    $($inputs[3]).attr('name', 'prices[' + count + '][priority]').val(item.priority);
                    $base.find('button')
                        .attr('id', 'btn-remove-price-update-' + count)
                        .removeClass('btn-success')
                        .addClass('btn-danger btn-remove-price')
                        .text('{{ __('Eliminar') }}');
                    $('#extra-prices-update').append($base);
                }
            });

            deleteModal.addEventListener('show.bs.modal', function (event) {
                deleteModalInputId.value = elements[event.relatedTarget.dataset.element].id;
            });
        </script>
    </x-slot>
</x-app-layout>