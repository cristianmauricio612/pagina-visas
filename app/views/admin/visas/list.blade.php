@extends('layouts.admin')
@section('title', 'Admin | Listar visas')

@section('content')
    @php
        $visas = \App\Models\Visa::all(); // Obtener todas las visas
        $paises_origen_ids = $visas->pluck('pais1_id')->unique()->toArray();
        $paises_destino_ids = $visas->pluck('pais2_id')->unique()->toArray();
        $paises_origen = \App\Models\Pais::whereIn('id', $paises_origen_ids)->orderBy('nombre')->get();
        $paises_destino = \App\Models\Pais::whereIn('id', $paises_destino_ids)->orderBy('nombre')->get();
    @endphp

    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar" class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-6">
        {{-- Título --}}
        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Gestión de Visas
        </h1>

        {{-- Selectores personalizados y Botón Agregar --}}
        <div class="flex flex-col md:flex-row justify-between mb-6 gap-4 items-end">
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-2/3">
                <div>
                    <label for="filtro-pais-origen" class="block text-sm font-medium text-gray-700 mb-1">¿De dónde soy?</label>
                    <div class="relative">
                        <button id="btn-pais-origen" type="button" class="p-2 border rounded w-full min-w-[200px] bg-white flex items-center justify-between">
                            <span id="selected-pais-origen" class="flex items-center gap-2 text-left">
                                <span class="text-gray-400">Selecciona un país</span>
                            </span>
                            <svg class="h-4 w-4 text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <ul id="custom-list-origen" class="absolute z-10 w-full bg-white border rounded shadow-lg mt-1 hidden max-h-60 overflow-y-auto">
                            <li class="flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100" data-value=""><span>Todos los países</span></li>
                            @foreach($paises_origen as $pais)
                                <li class="flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100" data-value="{{ $pais->id }}">
                                    <img src="{{ $pais->imagen }}" alt="{{ $pais->nombre }}" class="h-7 w-7 rounded-full object-cover border">
                                    <span>{{ $pais->nombre }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <input type="hidden" id="filtro-pais-origen" value="">
                    </div>
                </div>
                <div>
                    <label for="filtro-pais-destino" class="block text-sm font-medium text-gray-700 mb-1">¿A dónde viajo?</label>
                    <div class="relative">
                        <button id="btn-pais-destino" type="button" class="p-2 border rounded w-full min-w-[200px] bg-white flex items-center justify-between">
                            <span id="selected-pais-destino" class="flex items-center gap-2 text-left">
                                <span class="text-gray-400">Selecciona un país</span>
                            </span>
                            <svg class="h-4 w-4 text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <ul id="custom-list-destino" class="absolute z-10 w-full bg-white border rounded shadow-lg mt-1 hidden max-h-60 overflow-y-auto">
                            <li class="flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100" data-value=""><span>Todos los países</span></li>
                            @foreach($paises_destino as $pais)
                                <li class="flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100" data-value="{{ $pais->id }}">
                                    <img src="{{ $pais->imagen }}" alt="{{ $pais->nombre }}" class="h-7 w-7 rounded-full object-cover border">
                                    <span>{{ $pais->nombre }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <input type="hidden" id="filtro-pais-destino" value="">
                    </div>
                </div>
            </div>
            <div class="flex items-end md:items-end">
                <a href="{{ route('admin.visas.addView') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Agregar Visa
                </a>
            </div>
        </div>

        {{-- Contenedor con scroll horizontal y vertical --}}
        <div class="w-full max-w-[100%] max-h-[600px] overflow-y-auto overflow-x-auto border rounded-lg">
            <table class="w-full md:min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left w-12 whitespace-nowrap">ID</th>
                        <th class="py-2 px-4 text-left w-48 whitespace-nowrap">País 1</th>
                        <th class="py-2 px-4 text-left w-48 whitespace-nowrap">País 2</th>
                        <th class="py-2 px-4 text-left w-48 whitespace-nowrap">Nombre</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Tiempo Validez</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Entradas</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Estancia Máxima</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Necesita Visa</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Precio</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Tasa Gobierno</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Meses de Espera</th>
                        <th class="py-2 px-4 text-left w-32 whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody id="visas-table-body">
                    @forelse ($visas as $visa)
                        @php
                            $pais1 = \App\Models\Pais::find($visa->pais1_id);
                            $pais2 = \App\Models\Pais::find($visa->pais2_id);
                        @endphp
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->id }}</td>
                            <td class="py-2 px-4 whitespace-nowrap" data-pais-id="{{ $pais1 ? $pais1->id : '' }}">{{ $pais1 ? $pais1->nombre : '' }}</td>
                            <td class="py-2 px-4 whitespace-nowrap" data-pais-id="{{ $pais2 ? $pais2->id : '' }}">{{ $pais2 ? $pais2->nombre : '' }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->nombre }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->tiempo_validez }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->numero_entradas }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->estancia_maxima }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->necesita_visa ? 'Sí' : 'No' }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">$ {{ number_format($visa->precio, 2) }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">$ {{ number_format($visa->tasa_gobierno, 2) }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $visa->meses_espera }} meses</td>
                            <td class="py-2 px-4 flex space-x-2 whitespace-nowrap">
                                <a href="{{route('admin.visas.editView', $visa->id)}}" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="submit" class="text-red-500 hover:text-red-700" data-id="{{ $visa->id }}"
                                    onclick="deleteVisa(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="py-2 px-4 text-center text-gray-500">No hay visas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('openSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden'); // Oculta el botón de abrir
        });

        document.addEventListener('DOMContentLoaded', function () {
            customDropdownPais('btn-pais-origen', 'custom-list-origen', 'selected-pais-origen', 'filtro-pais-origen', filtrarVisasLocal);
            customDropdownPais('btn-pais-destino', 'custom-list-destino', 'selected-pais-destino', 'filtro-pais-destino', filtrarVisasLocal);
        });

        function customDropdownPais(btnId, listId, selectedId, hiddenId, onChange) {
            const btn = document.getElementById(btnId);
            const ul = document.getElementById(listId);
            const selected = document.getElementById(selectedId);
            const hidden = document.getElementById(hiddenId);
            let open = false;
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                ul.classList.toggle('hidden');
                open = !ul.classList.contains('hidden');
            });
            ul.querySelectorAll('li').forEach(function(li) {
                li.addEventListener('click', function(e) {
                    e.stopPropagation();
                    ul.classList.add('hidden');
                    open = false;
                    hidden.value = li.getAttribute('data-value');
                    if (li.querySelector('img')) {
                        selected.innerHTML = `<img src="${li.querySelector('img').src}" class="h-7 w-7 rounded-full object-cover border"> <span>${li.querySelector('span').textContent}</span>`;
                    } else {
                        selected.innerHTML = `<span>${li.querySelector('span').textContent}</span>`;
                    }
                    if (typeof onChange === 'function') onChange();
                });
            });
            document.addEventListener('click', function(e) {
                if (open) {
                    ul.classList.add('hidden');
                    open = false;
                }
            });
            // Evita que el menú se cierre si haces click dentro del ul
            ul.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Custom dropdown para país de origen
            customDropdown('filtro-pais-origen', 'custom-list-origen');
            customDropdown('filtro-pais-destino', 'custom-list-destino');
            document.getElementById('filtro-pais-origen').addEventListener('change', filtrarVisasLocal);
            document.getElementById('filtro-pais-destino').addEventListener('change', filtrarVisasLocal);
        });

        function customDropdown(selectId, listId) {
            const select = document.getElementById(selectId);
            const ul = document.getElementById(listId);
            select.addEventListener('focus', function() {
                ul.innerHTML = '';
                for (let i = 0; i < select.options.length; i++) {
                    const opt = select.options[i];
                    const li = document.createElement('li');
                    li.className = 'flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100';
                    if (opt.value === select.value) li.classList.add('bg-gray-200');
                    if (opt.value) {
                        const img = opt.getAttribute('data-img');
                        if (img) {
                            const imgEl = document.createElement('img');
                            imgEl.src = img;
                            imgEl.alt = opt.text;
                            imgEl.className = 'h-7 w-7 rounded-full object-cover border';
                            li.appendChild(imgEl);
                        }
                    }
                    const span = document.createElement('span');
                    span.textContent = opt.text;
                    li.appendChild(span);
                    li.onclick = function() {
                        select.value = opt.value;
                        select.dispatchEvent(new Event('change'));
                        ul.classList.add('hidden');
                    };
                    ul.appendChild(li);
                }
                ul.classList.remove('hidden');
            });
            select.addEventListener('blur', function() {
                setTimeout(() => ul.classList.add('hidden'), 150);
            });
        }

        function filtrarVisasLocal() {
            let paisOrigen = document.getElementById('filtro-pais-origen').value;
            let paisDestino = document.getElementById('filtro-pais-destino').value;
            let filas = document.querySelectorAll('#visas-table-body tr');
            filas.forEach(function(fila) {
                let tdPais1 = fila.querySelector('td:nth-child(2)');
                let tdPais2 = fila.querySelector('td:nth-child(3)');
                if (!tdPais1 || !tdPais2) return;
                let mostrar = true;
                if (paisOrigen && tdPais1.dataset.paisId !== paisOrigen) mostrar = false;
                if (paisDestino && tdPais2.dataset.paisId !== paisDestino) mostrar = false;
                fila.style.display = mostrar ? '' : 'none';
            });
        }

        const csrfToken = "{{ csrf()->token() }}";

        function deleteVisa(button) {
            let id = $(button).data("id");

            if (!id) {
                alert("Error: ID de la visa no encontrada.");
                return;
            }

            if (!confirm("¿Estás seguro de eliminar esta visa?")) {
                return;
            }

            $.ajax({
                url: "/admin/visas/eliminar/" + id,
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken // Incluir el token en los headers
                },
                success: function (response) {
                    alert("✅ Visa eliminada correctamente");
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                },
                error: function (xhr) {
                    alert("❌ Error al eliminar visa: " + xhr.responseText);
                }
            });
        }

        function filterVisas() {
            let paisOrigen = $("#filtro-pais-origen").val();
            let paisDestino = $("#filtro-pais-destino").val();

            $("#visas-table-body").html('<tr><td colspan="6">Cargando...</td></tr>');

            $.ajax({
                url: "/admin/visas/buscar",
                type: "GET",
                data: {
                    pais_origen: paisOrigen,
                    pais_destino: paisDestino
                },
                dataType: "json",
                success: function (data) {
                    $("#visas-table-body").empty();

                    if (!Array.isArray(data) || data.length === 0) {
                        $("#visas-table-body").html('<tr><td colspan="6">No se encontraron visas.</td></tr>');
                        return;
                    }

                    let html = "";
                    data.forEach(visa => {
                        html += `
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.id}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.pais1.nombre}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.pais2.nombre}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.nombre}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.tiempo_validez}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.numero_entradas}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.estancia_maxima}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.necesita_visa ? 'Si' : 'No'}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">$ ${visa.precio ? parseFloat(visa.precio).toFixed(2) : '0.00'}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">$ ${visa.tasa_gobierno ? parseFloat(visa.tasa_gobierno).toFixed(2) : '0.00'}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">${visa.meses_espera} meses</td>

                                    <td class="py-2 px-4 flex space-x-2 whitespace-nowrap">
                                        <a href="/admin/visas/editar/${visa.id}" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="submit" class="text-red-500 hover:text-red-700" data-id="${visa.id}"
                                            onclick="deleteVisa(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                    });

                    $("#visas-table-body").html(html);
                },
                error: function (xhr) {
                    let errorMessage = "Error al cargar las visas.";
                    if (xhr.status === 404) {
                        errorMessage = "No se encontraron visas.";
                    } else if (xhr.status === 500) {
                        errorMessage = "Error interno del servidor.";
                    }

                    $("#visas-table-body").html(`<tr><td colspan="6">${errorMessage}</td></tr>`);
                    console.error("Error en la búsqueda:", xhr.responseText);
                }
            });
        }
    </script>
@endsection
