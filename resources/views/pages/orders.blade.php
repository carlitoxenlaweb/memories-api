<x-app-layout>
    <style>
        small { font-size: 1rem; }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 m-0">
            <div class="row">
                <div class="col text-start">
                    {{ __('Ordenes') }}
                </div>
            </div>
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('Nro') }}</th>
                        <th>{{ __('Cliente') }}</th>
                        <th>{{ __('Estatus') }}</th>
                        <th>{{ __('Pagado') }}</th>
                        <th>{{ __('Fecha') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th class="text-end"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                {{ $order->client->name }}<br/>
                                ({{ $order->client->email }})
                            </td>
                            <td>
                                @switch($order->status)
                                    @case('received')
                                        {{ __('Recibida') }}
                                        @break
                                    @case('progress')
                                        {{ __('En progreso') }}
                                        @break
                                    @case('delivered')
                                        {{ __('Finalizada') }}
                                        @break
                                @endswitch
                            </td>
                            <td class="text-{{ $order->paid ? 'success' : 'danger' }}">
                                {{ $order->paid ? 'SI' : 'NO' }}
                            </td>
                            <td>
                                {{ $order->created_at->format('j F, Y') }}<br/>
                                {{ $order->created_at->format('g:i a') }}
                            </td>
                            <td>
                                @currency($order->total_price)
                            </td>
                            <td class="text-end">
                                <a data-element="{{ $loop->index }}" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#view-modal" href="#!">
                                    {{ __('Ver') }}
                                </a>&nbsp;
                                <a data-element="{{ $loop->index }}" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#update-modal" href="#!">
                                    {{ __('Editar') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="view-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('Orden #') }}<span id="view-modal-id"></span><br/>
                        <small id="view-modal-date"></small>
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col">
                            <b>Cliente: </b><span id="view-modal-client"></span>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col">
                            <b>Estatus: </b><span id="view-modal-status"></span>
                        </div>
                        <div class="col">
                            <b>Pagada: </b><span id="view-modal-paid"></span>
                        </div>
                        <div class="col">
                            <b>Total: </b><span id="view-modal-total"></span>
                        </div>
                    </div>
                    <div class="row py-3 mt-4 mb-1 border-top">
                        <div class="col">
                            <b>Producto: </b><span id="view-modal-product-name"></span>
                        </div>
                        <div class="col">
                            <b>Papel: </b><span id="view-modal-paper"></span>
                        </div>
                        <div class="col">
                            <b>Acabado: </b><span id="view-modal-finish"></span>
                        </div>
                    </div>
                    <div class="row pb-3 mt-1 mb-4 border-bottom">
                        <div class="col">
                            <b>Formato: </b><span id="view-modal-format"></span>
                        </div>
                        <div class="col">
                            <b>Cant. Fotos: </b><span id="view-modal-photos"></span>
                        </div>
                        <div class="col">&nbsp;</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <b class="pb-2">Extras: </b><br/>
                            <ul class="my-2" id="view-modal-extras"></ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Volver') }}</button>
                    <button type="button" class="btn btn-success" id="download-images">{{ __('Descargar Imagenes') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('orders.patch') }}" method="POST" id="update-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="id" value="" id="update-form-id">
                    <div class="modal-header bg-info text-white">
                        <h4 class="modal-title">{{ __('Actualizar Orden') }}</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="label">{{ __('Pagada') }}</label>
                                    <select id="update-form-paid" required name="paid" class="form-select" aria-label="Default select example">
                                        <option value="0">{{ __('No') }}</option>
                                        <option value="1">{{ __('Si') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="label">{{ __('Estatus') }}</label>
                                    <select id="update-form-status" required name="status" class="form-select" aria-label="Default select example">
                                        <option value="received">{{ __('Recibida') }}</option>
                                        <option value="progress">{{ __('En progreso') }}</option>
                                        <option value="delivered">{{ __('Finalizada') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-info text-white">{{ __('Actualizar Orden') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <script>
            let currentOrder = {};
            const elements = @JSON($orders);

            const formatter = new Intl.NumberFormat('es-ES', {
                style: 'currency',
                currency: 'EUR',
            });

            const translation = function (string) {
                switch (string) {
                    case 'received': return '{{ __('Recibida') }}';
                    case 'progress': return '{{ __('En progreso') }}';
                    case 'delivered': return '{{ __('Finalizada') }}';
                }
            };

            const viewModal = document.getElementById('view-modal');
            const updateModal = document.getElementById('update-modal');

            const downloadButton = document.getElementById('download-images');
            
            const viewModalInfoId = document.getElementById('view-modal-id');
            const viewModalInfoDate = document.getElementById('view-modal-date');
            const viewModalInfoPaid = document.getElementById('view-modal-paid');
            const viewModalInfoTotal = document.getElementById('view-modal-total');
            const viewModalInfoStatus = document.getElementById('view-modal-status');
            const viewModalInfoClient = document.getElementById('view-modal-client');
            const viewModalInfoProductName = document.getElementById('view-modal-product-name');
            const viewModalInfoPaper = document.getElementById('view-modal-paper');
            const viewModalInfoFinish = document.getElementById('view-modal-finish');
            const viewModalInfoFormat = document.getElementById('view-modal-format');
            const viewModalInfoPhotos = document.getElementById('view-modal-photos');
            const viewModalInfoExtras = document.getElementById('view-modal-extras');

            const updateModalInputId = document.getElementById('update-form-id');
            const updateModalInputPaid = document.getElementById('update-form-paid');
            const updateModalInputStatus = document.getElementById('update-form-status');

            updateModal.addEventListener('show.bs.modal', function (event) {
                const data = elements[event.relatedTarget.dataset.element];

                updateModalInputId.value = data.id;
                updateModalInputPaid.value = data.paid;
                updateModalInputStatus.value = data.status;
            });
            
            viewModal.addEventListener('show.bs.modal', function (event) {
                currentOrder = elements[event.relatedTarget.dataset.element];

                viewModalInfoId.textContent = currentOrder.id;
                viewModalInfoDate.textContent = currentOrder.created_at;
                viewModalInfoPaid.textContent = !!currentOrder.paid ? 'Si' : 'No';
                viewModalInfoTotal.textContent = formatter.format(currentOrder.total_price);
                viewModalInfoStatus.textContent = translation(currentOrder.status);
                viewModalInfoClient.textContent = currentOrder.client.name;
                viewModalInfoProductName.textContent = currentOrder.product.title;
                viewModalInfoPaper.textContent = currentOrder.paper;
                viewModalInfoFinish.textContent = currentOrder.finish.name;
                viewModalInfoFormat.textContent = currentOrder.format;
                viewModalInfoPhotos.textContent = currentOrder.total_photos;

                try {
                    let extraHTML = "";
                    const extraList = JSON.parse(currentOrder.extras);

                    for (const key in extraList) {
                        if (Object.hasOwnProperty.call(extraList, key)) {
                            extraHTML += `<li>${key}: ${extraList[key]}</li>`;
                        }
                    }

                    viewModalInfoExtras.innerHTML = extraHTML;
                } catch (e) {
                    viewModalInfoExtras.innerHTML = "<li>{{ __('Sin Extras') }}</li>";
                }
            });

            downloadButton.addEventListener('click', function (event) {
                let imgTmp = [];
                for (let i = 0; i < currentOrder.images.length; i++) {
                    imgTmp[i] = document.createElement('a');
                    imgTmp[i].href = currentOrder.images[i].image_path;
                    imgTmp[i].download = `memories_order_${currentOrder.id}_img_${i+1}.${currentOrder.images[i].image_name.split('.').pop()}`;
                    document.body.appendChild(imgTmp[i]);
                    imgTmp[i].click();
                    document.body.removeChild(imgTmp[i]);
                }
            });
        </script>
    </x-slot>
</x-app-layout>