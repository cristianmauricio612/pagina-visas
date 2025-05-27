@extends('layouts.admin')
@section('title', 'Admin | Crear Artículo')

@section('content')
    {{-- Botón para abrir el Sidebar (Solo en esta vista) --}}
    <button id="openSidebar"
        class="fixed top-4 left-4 bg-gray-900 text-white w-10 h-10 flex items-center justify-center rounded-md text-lg lg:hidden shadow-md z-20">
        <i class="fas fa-bars"></i>
    </button>

    <div class="py-4 sm:py-6 px-2 sm:px-4">
        {{-- Título --}}
        <h1 class="text-xl sm:text-2xl md:text-4xl font-bold text-gray-800 mb-4 text-center md:text-left">
            Crear Nuevo Artículo
        </h1>

        {{-- Formulario --}}
        <form id="blogForm" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            {{-- CSRF Token --}}
            <input type="hidden" name="_csrf" value="{{ csrf()->token() }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                {{-- Título --}}
                <div class="md:col-span-2">
                    <label for="titulo" class="block text-gray-700 font-medium mb-2">Título <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="titulo" name="titulo"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                {{-- Categoría --}}
                <div>
                    <label for="categoria_id" class="block text-gray-700 font-medium mb-2">Categoría <span
                            class="text-red-500">*</span></label>
                    <select id="categoria_id" name="categoria_id"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach(\App\Models\BlogCategoria::activas()->get() as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Autor --}}
                <div>
                    <label for="autor" class="block text-gray-700 font-medium mb-2">Autor</label>
                    <input type="text" id="autor" name="autor"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="Visas Travel">
                </div>

                {{-- Resumen --}}
                <div class="md:col-span-2">
                    <label for="resumen" class="block text-gray-700 font-medium mb-2">Resumen</label>
                    <textarea id="resumen" name="resumen" rows="3"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <p class="text-sm text-gray-500 mt-1">Breve descripción que aparecerá en las listas y resultados de
                        búsqueda.</p>
                </div>

                {{-- Imagen destacada --}}
                <div class="md:col-span-2">
                    <label for="imagen" class="block text-gray-700 font-medium mb-2">Imagen destacada</label>
                    <div class="border rounded p-4 bg-gray-50">
                        <div id="preview-container" class="hidden mb-4">
                            <img id="preview-image" src="" alt="Vista previa" class="max-h-48 mx-auto">
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="imagen"
                                class="cursor-pointer bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 inline-block">
                                <i class="fas fa-upload mr-2"></i> Seleccionar imagen
                            </label>
                            <input type="file" id="imagen" name="imagen" accept="image/*" class="hidden"
                                onchange="previewImage(this)">
                        </div>
                        <p class="text-sm text-gray-500 mt-2 text-center">Formatos: JPG, PNG, WebP. Tamaño máximo: 5MB.</p>
                    </div>
                </div>

                {{-- Contenido --}}
                <div class="md:col-span-2">
                    <label for="contenido-container" class="block text-gray-700 font-medium mb-2">Contenido <span
                            class="text-red-500">*</span></label>

                    {{-- Quill Editor Container - Con altura y overflow ajustados --}}
                    <div id="editor-wrapper" class="border rounded overflow-hidden" style="min-height: 500px;">
                        <div id="contenido-container" style="height: 450px;"></div>
                    </div>

                    {{-- Campo oculto que almacenará el HTML para enviar al servidor --}}
                    <input type="hidden" id="contenido" name="contenido">

                    <p class="text-sm text-gray-500 mt-1">Usa las herramientas de formato para estructurar tu artículo.</p>
                </div>

                {{-- Etiquetas (MEJORADO) --}}
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Etiquetas</label>
                    <div class="border rounded p-4 bg-gray-50">
                        <div class="mb-3">
                            <div class="flex flex-wrap gap-2 mb-2" id="selected-tags-container">
                                <!-- Aquí se mostrarán las etiquetas seleccionadas -->
                            </div>

                            <div class="flex gap-2">
                                <input type="text" id="tag-search"
                                    class="flex-grow p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Buscar o agregar nueva etiqueta...">
                                <button type="button" id="add-tag-btn"
                                    class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <!-- Campo hidden para almacenar los IDs de etiquetas seleccionadas -->
                            <input type="hidden" id="selected-tags" name="tags" value="">
                        </div>

                        <div>
                            <h4 class="font-medium mb-2">Etiquetas disponibles:</h4>
                            <div class="max-h-40 overflow-y-auto p-2 border rounded bg-white">
                                <div id="available-tags" class="flex flex-wrap gap-2">
                                    @foreach(\App\Models\BlogTag::all() as $tag)
                                        <span
                                            class="tag-item cursor-pointer px-2 py-1 bg-gray-200 text-gray-800 rounded-full text-sm hover:bg-gray-300"
                                            data-id="{{ $tag->id }}" data-name="{{ $tag->nombre }}">
                                            {{ $tag->nombre }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Estado y Fecha de publicación --}}
                <div>
                    <label for="estado" class="block text-gray-700 font-medium mb-2">Estado</label>
                    <select id="estado" name="estado"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="borrador">Borrador</option>
                        <option value="publicado">Publicado</option>
                    </select>
                </div>

                <div>
                    <label for="fecha_publicacion" class="block text-gray-700 font-medium mb-2">Fecha de publicación</label>
                    <input type="datetime-local" id="fecha_publicacion" name="fecha_publicacion"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Dejar en blanco para usar la fecha actual.</p>
                </div>

                {{-- SEO --}}
                <div class="md:col-span-2 border-t pt-4 mt-2">
                    <h3 class="text-lg font-semibold mb-2">SEO</h3>
                </div>

                <div class="md:col-span-2">
                    <label for="meta_description" class="block text-gray-700 font-medium mb-2">Meta Descripción</label>
                    <textarea id="meta_description" name="meta_description" rows="2"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <p class="text-sm text-gray-500 mt-1">Descripción que se mostrará en los resultados de búsqueda. Máximo
                        160 caracteres.</p>
                </div>

                <div class="md:col-span-2">
                    <label for="meta_keywords" class="block text-gray-700 font-medium mb-2">Meta Keywords</label>
                    <input type="text" id="meta_keywords" name="meta_keywords"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="palabra1, palabra2, palabra3...">
                    <p class="text-sm text-gray-500 mt-1">Palabras clave separadas por comas.</p>
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex justify-end gap-2 mt-6 border-t pt-4">
                <a href="{{ route('admin.blog.listView') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Guardar Artículo
                </button>
            </div>
        </form>
    </div>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        const csrfToken = "{{ csrf()->token() }}";
        document.getElementById('openSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            this.classList.add('hidden');
        });

        // SISTEMA DE TAGS MEJORADO
        document.addEventListener('DOMContentLoaded', function () {
            const selectedTagsContainer = document.getElementById('selected-tags-container');
            const availableTagsContainer = document.getElementById('available-tags');
            const tagSearchInput = document.getElementById('tag-search');
            const addTagButton = document.getElementById('add-tag-btn');
            const selectedTagsInput = document.getElementById('selected-tags');

            let selectedTags = [];

            // Agregar evento a los tags disponibles
            const tagItems = document.querySelectorAll('.tag-item');
            tagItems.forEach(tag => {
                tag.addEventListener('click', function () {
                    const tagId = this.getAttribute('data-id');
                    const tagName = this.getAttribute('data-name');

                    if (!selectedTags.includes(tagId)) {
                        selectedTags.push(tagId);
                        addSelectedTagElement(tagId, tagName);
                        updateSelectedTagsInput();
                        this.classList.add('opacity-50');
                    }
                });
            });

            // Función para crear elemento de tag seleccionado
            function addSelectedTagElement(id, name) {
                const tagElement = document.createElement('span');
                tagElement.className = 'selected-tag px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm flex items-center';
                tagElement.innerHTML = `
                            ${name}
                            <button type="button" class="ml-1 text-blue-500 hover:text-blue-700" data-id="${id}">
                                <i class="fas fa-times"></i>
                            </button>
                        `;

                // Agregar evento para eliminar tag
                const removeButton = tagElement.querySelector('button');
                removeButton.addEventListener('click', function () {
                    const tagId = this.getAttribute('data-id');
                    const index = selectedTags.indexOf(tagId);
                    if (index > -1) {
                        selectedTags.splice(index, 1);
                        selectedTagsContainer.removeChild(tagElement);
                        updateSelectedTagsInput();

                        // Restaurar opacidad del tag disponible
                        const availableTag = availableTagsContainer.querySelector(`[data-id="${tagId}"]`);
                        if (availableTag) {
                            availableTag.classList.remove('opacity-50');
                        }
                    }
                });

                selectedTagsContainer.appendChild(tagElement);
            }

            // Actualizar campo hidden con tags seleccionados
            function updateSelectedTagsInput() {
                selectedTagsInput.value = selectedTags.join(',');
            }

            // Buscar tags
            tagSearchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();

                tagItems.forEach(tag => {
                    const tagName = tag.getAttribute('data-name').toLowerCase();
                    if (tagName.includes(searchTerm)) {
                        tag.style.display = 'inline-flex';
                    } else {
                        tag.style.display = 'none';
                    }
                });
            });

            // Agregar nuevo tag
            addTagButton.addEventListener('click', function () {
                const newTagName = tagSearchInput.value.trim();
                if (newTagName) {
                    // Verificar si ya existe
                    const existingTag = Array.from(tagItems).find(tag =>
                        tag.getAttribute('data-name').toLowerCase() === newTagName.toLowerCase()
                    );

                    if (existingTag) {
                        // Si existe pero no está seleccionado, seleccionarlo
                        const tagId = existingTag.getAttribute('data-id');
                        if (!selectedTags.includes(tagId)) {
                            existingTag.click();
                        }
                    } else {
                        // Crear nuevo tag (primero en el servidor)
                        fetch('/admin/blog/tags/crear', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_csrf"]').value
                            },
                            body: JSON.stringify({ nombre: newTagName })
                        })
                            .then(response => response.json())
                            .then(result => {
                                if (result.status === 'success') {
                                    const newTag = result.data;

                                    // Agregar a la lista de disponibles
                                    const tagElement = document.createElement('span');
                                    tagElement.className = 'tag-item cursor-pointer px-2 py-1 bg-gray-200 text-gray-800 rounded-full text-sm hover:bg-gray-300 opacity-50';
                                    tagElement.setAttribute('data-id', newTag.id);
                                    tagElement.setAttribute('data-name', newTag.nombre);
                                    tagElement.textContent = newTag.nombre;

                                    // Agregar evento
                                    tagElement.addEventListener('click', function () {
                                        const tagId = this.getAttribute('data-id');
                                        const tagName = this.getAttribute('data-name');

                                        if (!selectedTags.includes(tagId)) {
                                            selectedTags.push(tagId);
                                            addSelectedTagElement(tagId, tagName);
                                            updateSelectedTagsInput();
                                            this.classList.add('opacity-50');
                                        }
                                    });

                                    availableTagsContainer.appendChild(tagElement);

                                    // Seleccionarlo automáticamente
                                    selectedTags.push(newTag.id);
                                    addSelectedTagElement(newTag.id, newTag.nombre);
                                    updateSelectedTagsInput();

                                    // Limpiar campo
                                    tagSearchInput.value = '';
                                } else {
                                    alert('Error al crear el tag: ' + result.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Error al crear el tag');
                            });
                    }
                }
            });

            // Permitir presionar Enter en el campo de búsqueda
            tagSearchInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addTagButton.click();
                }
            });
        });

        // Función para previsualizar la imagen destacada
        function previewImage(input) {
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.classList.add('hidden');
                previewImage.src = '';
            }
        }

        // Manejar envío del formulario
        document.getElementById('blogForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Asegurar que el contenido del editor Quill se transfiera al campo hidden ANTES de la validación
            if (window.quill) {
                const contenidoHTML = window.quill.root.innerHTML;
                document.getElementById('contenido').value = contenidoHTML;
                console.log("Contenido capturado: ", contenidoHTML.substring(0, 100) + "..."); // Para depuración
            }

            // Validar campos obligatorios
            const titulo = document.getElementById('titulo').value.trim();
            const categoria = document.getElementById('categoria_id').value;
            const contenido = document.getElementById('contenido').value.trim();

            if (!titulo) {
                alert('El título es obligatorio');
                return;
            }

            if (!categoria) {
                alert('Debe seleccionar una categoría');
                return;
            }

            if (!contenido) {
                alert('El contenido es obligatorio');
                return;
            }

            // Crear FormData para enviar el formulario incluyendo la imagen
            const formData = new FormData(this);

            // Botón de submit
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';
            submitBtn.disabled = true;

            // Enviar solicitud
            fetch('/admin/blog/crear', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        alert('Artículo creado exitosamente');
                        window.location.href = "{{ route('admin.blog.listView') }}";
                    } else {
                        let errorMessage = 'Error al crear el artículo';
                        if (result.message) {
                            errorMessage += ': ' + result.message;
                        }
                        if (result.errors && result.errors.length > 0) {
                            errorMessage += '\n' + result.errors.join('\n');
                        }
                        alert(errorMessage);
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al procesar la solicitud');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Configurar estado y fecha
        document.addEventListener('DOMContentLoaded', function () {
            // Establecer fecha actual como valor predeterminado
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            document.getElementById('fecha_publicacion').value = `${year}-${month}-${day}T${hours}:${minutes}`;

            // Función para aplicar visibilidad según el estado
            function actualizarVisibilidadFecha() {
                const estadoSeleccionado = document.getElementById('estado').value;
                const fechaPublicacionField = document.getElementById('fecha_publicacion').parentNode;
                if (estadoSeleccionado === 'publicado') {
                    fechaPublicacionField.classList.remove('hidden');
                } else {
                    fechaPublicacionField.classList.add('hidden');
                }
            }

            // Aplicar visibilidad inicial al cargar la página
            actualizarVisibilidadFecha();

            // Actualizar visibilidad cuando cambia el estado
            document.getElementById('estado').addEventListener('change', actualizarVisibilidadFecha);
        });
    </script>

    <script>
        // Inicializar Quill cuando el documento esté cargado
        document.addEventListener('DOMContentLoaded', function () {
            // Personalizar los formatos disponibles para tamaños de texto
            var SizeStyle = Quill.import('attributors/style/size');
            SizeStyle.whitelist = ['12px', '14px', '16px', '18px', '20px', '24px', '30px', '36px', '48px', '60px'];
            Quill.register(SizeStyle, true);

            // Configurar las herramientas del editor
            var toolbarOptions = [
                // Formato básico
                ['bold', 'italic', 'underline', 'strike'],

                // Bloques de texto
                ['blockquote', 'code-block'],

                // Párrafos y encabezados
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                // Listas
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],

                // Sangría
                [{ 'indent': '-1' }, { 'indent': '+1' }],

                // Alineación de texto
                [{ 'align': ['', 'center', 'right', 'justify'] }],

                // Tamaños personalizados en píxeles
                [{ 'size': ['12px', '14px', '16px', '18px', '20px', '24px', '30px', '36px', '48px', '60px'] }],

                // Fuentes
                [{ 'font': ['sans-serif', 'serif', 'monospace'] }],

                // Colores
                [{ 'color': [] }, { 'background': [] }],

                // Superíndice/subíndice
                [{ 'script': 'sub' }, { 'script': 'super' }],

                // Limpiar formato
                ['clean']
            ];

            // Inicializar el editor (variable en el ámbito global)
            window.quill = new Quill('#contenido-container', {
                modules: {
                    toolbar: toolbarOptions
                },
                theme: 'snow',
                bounds: '#editor-wrapper'
            });

            // Añadir CSS personalizado para los tamaños en píxeles
            let styleElement = document.createElement('style');
            styleElement.type = 'text/css';
            styleElement.textContent = `
                .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="12px"]::before { content: '12px'; font-size: 12px; }
                .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="14px"]::before { content: '14px'; font-size: 14px; }
                .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="16px"]::before { content: '16px'; font-size: 16px; }
                .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="18px"]::before { content: '18px'; font-size: 18px; }
                .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="20px"]::before { content: '20px'; font-size: 20px; }
                .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="24px"]::before { content: '24px'; font-size: 24px; }
                .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="30px"]::before { content: '30px'; font-size: 30px; }
                .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="36px"]::before { content: '36px'; font-size: 36px; }
                .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="48px"]::before { content: '48px'; font-size: 48px; }
                .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="60px"]::before { content: '60px'; font-size: 60px; }

                .ql-snow .ql-picker.ql-size .ql-picker-label::before { content: 'Tamaño'; }
            `;
            document.head.appendChild(styleElement);

            // Asociar al evento submit
            document.getElementById('blogForm').addEventListener('submit', function (e) {
                // Actualizar el campo oculto con el HTML antes de enviar
                document.getElementById('contenido').value = window.quill.root.innerHTML;
            });
        });
    </script>
@endsection
