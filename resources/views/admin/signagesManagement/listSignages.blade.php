@extends("admin.adminPageLayout.layout")
@section("title", "quản lý biển báo")
@section("main")

    
  <main>
    <!-- Tiêu đề -->
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <h4 class="text-default-900 text-xl font-semibold">🚦 Danh sách biển báo</h4>
        <button class="btn bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md shadow text-sm"
                data-hs-overlay="#create_signage">
            <i class="i-solar-plus-bold mr-1"></i> Thêm biển báo
        </button>
    </div>

    <!-- Thanh công cụ: Tìm kiếm + Lọc loại -->
    <div class="card p-4 mb-6 bg-white border shadow rounded-lg flex flex-col md:flex-row justify-between gap-3">
        <!-- Form tìm kiếm -->
        <form action="{{ route('admintrafficbot.signage.sarch') }}" method="get" class="relative w-full md:w-1/2">
            <input type="search" name="search" placeholder="Tìm theo tên biển báo..."
                class="form-input pl-10 pr-4 py-2 rounded-lg w-full border-gray-300 focus:ring-2 focus:ring-blue-500 shadow-sm">
            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                <i class="i-ph-magnifying-glass"></i>
            </div>
        </form>

        <!-- Form lọc loại biển báo -->
        <form action="{{ route('admintrafficbot.listsignages') }}" method="get" class="w-full md:w-1/3">
            <select name="option" onchange="this.form.submit()"
                class="form-select w-full py-2 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @foreach ($signageTypes as $type)
                    <option value="{{ $type->SignageTypeID }}"
                        {{ !empty($option) && $option == $type->SignageTypeID ? 'selected' : '' }}>
                        {{ $type->SignagesTypeName }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Danh sách biển báo -->
    <div class="card overflow-hidden bg-white border shadow rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800">
                <thead class="bg-gray-50 text-sm font-semibold text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left">Tên biển báo</th>
                        <th class="px-6 py-3 text-left">Loại</th>
                        <th class="px-6 py-3 text-left">Ảnh mô tả</th>
                        <th class="px-6 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($signages as $signage)
                        <tr>
                            <td class="px-6 py-4 whitespace-normal break-words max-w-xs">
                                {{ trim($signage->SignageName) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $signage->signage_SignageType->SignagesTypeName ?? 'Không' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($signage->SignageImage)
                                    <img src="{{ asset('storage/uploads/imageSignage/' . $signage->SignageImage) }}"
                                         alt="Ảnh biển báo"
                                         class="w-24 h-24 object-contain border rounded shadow">
                                @else
                                    <span class="text-gray-400 italic">Không có ảnh</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex justify-end gap-2">
                                    <!-- Xem -->
                                    <a href="#" class="text-blue-500 hover:text-blue-700"
                                        data-hs-overlay="#show-{{ $signage->SignageID }}">
                                        <span class="material-symbols-rounded text-2xl">visibility</span>
                                    </a>

                                    <!-- Sửa -->
                                    <a href="#" class="text-yellow-500 hover:text-yellow-700"
                                        data-hs-overlay="#edit_{{ $signage->SignageID }}">
                                        <span class="material-symbols-rounded text-2xl">edit</span>
                                    </a>

                                    <!-- Xóa -->
                                    <button type="button" class="text-red-500 hover:text-red-700"
                                        data-hs-overlay="#delete_{{ $signage->SignageID }}">
                                        <span class="material-symbols-rounded text-2xl">delete_forever</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="border-t px-6 py-4 bg-gray-50 flex items-center justify-between text-sm text-gray-700">
            <p>
                Hiển thị <span class="font-semibold">{{ $signages->firstItem() }}</span> →
                <span class="font-semibold">{{ $signages->lastItem() }}</span> /
                <span class="font-semibold">{{ $signages->total() }}</span> 
            </p>

            <div class="flex gap-1">
                @if($signages->onFirstPage())
                    <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded border">Trước</span>
                @else
                    <a href="{{ $signages->previousPageUrl() }}"
                        class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">Trước</a>
                @endif

                @php
                    $start = max($signages->currentPage() - 2, 1);
                    $end = min($signages->currentPage() + 2, $signages->lastPage());
                @endphp

                @if ($start > 1)
                    <a href="{{ $signages->url(1) }}"
                        class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">1</a>
                    @if ($start > 2)
                        <span class="px-2 text-gray-400">...</span>
                    @endif
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $signages->currentPage())
                        <span class="px-3 py-1 bg-blue-600 text-white rounded border">{{ $i }}</span>
                    @else
                        <a href="{{ $signages->url($i) }}"
                            class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">{{ $i }}</a>
                    @endif
                @endfor

                @if ($end < $signages->lastPage())
                    @if ($end < $signages->lastPage() - 1)
                        <span class="px-2 text-gray-400">...</span>
                    @endif
                    <a href="{{ $signages->url($signages->lastPage()) }}"
                        class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">{{ $signages->lastPage() }}</a>
                @endif

                @if($signages->hasMorePages())
                    <a href="{{ $signages->nextPageUrl() }}"
                        class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">Sau</a>
                @else
                    <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded border">Sau</span>
                @endif
            </div>
        </div>
    </div>

         <!-- modal xóa -->
           @if(!empty($signages))
            @foreach ($signages as $signage)
                <div id="delete_{{ $signage->SignageID }}"
                    class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
                    <div
                        class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                        <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">

                            <!-- Header -->
                            <div class="bg-gradient-to-r bg-red-600 p-6">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                            <i class="ti ti-alert-triangle text-white text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-white text-lg">Xác nhận xóa</h3>
                                            <p class="text-white/80 text-sm">Bạn có chắc muốn xóa biển báo này?</p>
                                        </div>
                                    </div>
                                    <button type="button"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                        data-hs-overlay="#delete_{{ $signage->SignageID }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="p-6 space-y-4 text-center">
                                <p class="text-gray-700 text-sm">Bạn có chắc chắn muốn <strong>xóa</strong> biển báo
                                    <strong>{{ $signage->SignageName }}</strong> không? Hành động này không thể hoàn tác.</p>
                            </div>

                            <!-- Footer -->
                            <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
                                <button type="button"
                                    class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                    data-hs-overlay="#delete_{{ $signage->SignageID }}">
                                    Hủy
                                </button>

                                <form action="{{ route("admintrafficbot.signages.delete", ["ID" => $signage->SignageID]) }}"
                                    method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 transition-colors">
                                        Xóa
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        @endif

            <!-- end modal show -->
            @if(!empty($signages))
                @foreach ($signages as $signage)
                    <div id="show-{{ $signage->SignageID }}"
                        class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
                        <!-- Modal Container -->
                        <div
                            class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-2xl sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                            <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">

                                <!-- Header -->
                                <div class="bg-gradient-to-r bg-primary p-6">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                                    <i class="ti ti-eye text-white text-xl"></i> 



                                            </div>
                                            <div>
                                                <h3 class="font-bold text-white text-lg">Chi tiết biển báo</h3>
                                                <p class="text-white/80 text-sm">Thông tin đầy đủ về biển báo</p>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                            data-hs-overlay="#show-{{ $signage->SignageID }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Body -->
                                <div class="modal-scroll max-h-[60vh] overflow-y-auto p-6 space-y-6">
                                    <!-- Image and Info -->
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                                        <!-- Image -->
                                        <div class="flex-shrink-0 border rounded-lg p-2 bg-gray-50 shadow">
                                            <img src="{{ asset("storage/uploads/imageSignage/$signage->SignageImage") }}"
                                                alt="Biển báo" class="w-40 h-40 object-contain">
                                        </div>

                                        <!-- Info -->
                                        <div class="flex flex-col space-y-2">
                                            <h4 class="text-xl font-bold text-gray-900">{{ $signage->SignageName }}</h4>

                                            <div class="text-gray-700 text-sm">
                                                <p><strong>Loại biển báo:</strong>
                                                    {{ $signage->signage_SignageType->SignagesTypeName ?? 'Không' }}</p>
                                                <p><strong>Giải thích:</strong> {{ $signage->SignagesExplanation }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
                                    <button type="button"
                                        class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                        data-hs-overlay="#show-{{ $signage->SignageID }}">
                                        Đóng
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- end modal -->


            <!-- modal edit -->
            @if(!empty($signages))
                @foreach ($signages as $signage)

                    <div id="edit_{{ $signage->SignageID }}"
                        class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
                        <div
                            class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                            <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">

                                <!-- Header -->
                                <div class="bg-gradient-to-r bg-primary p-6">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                               <i class="ti ti-edit text-white text-xl"></i> 
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-white text-lg">Chỉnh sửa dữ liệu</h3>
                                                <p class="text-white/80 text-sm">Điền thông tin vào các trường bên dưới</p>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                            data-hs-overlay="#edit_{{ $signage->SignageID }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Body -->
                                <form action="{{ route("admintrafficbot.signages.update", ["ID" => $signage->SignageID]) }}"
                                    method="post" enctype="multipart/form-data" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-scroll max-h-[60vh] overflow-y-auto p-6 space-y-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1" for="signage_type">
                                                Loại biển báo
                                            </label>
                                            @error('SignageTypeID', 'edit')
                                                <p id="SignageTypeID_error"
                                                    class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                            <select id="SignageTypeID" name="SignageTypeID" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                                onfocus="document.getElementById('SignageTypeID')?.classList.add('hidden')">
                                                @if(empty($signage->signage_SignageType->SignageTypeID))
                                                    <option value="">Chưa thuộc loại biển báo nào</option>
                                                @endif
                                                 @foreach ($signageTypes as $type)
                                                    <option value="{{ $type->SignageTypeID }}" {{!empty($signage->signage_SignageType->SignageTypeID) && $signage->signage_SignageType->SignageTypeID == $type->SignageTypeID ? "selected" : "" }}>
                                                        {{ $type->SignagesTypeName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Tên -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                                                Tên biển báo</label>
                                            @error('SignageName ', 'edit')
                                                <p id="SignageName_error"
                                                    class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                            <input type="text" id="SignageName" name="SignageName" required value="{{ $signage->SignageName}}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                                onfocus="document.getElementById('SignageName_error')?.classList.add('hidden')">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                                                Mô tả biển báo</label>
                                            @error('SignagesExplanation', 'edit')
                                                <p id="SignagesExplanation_error"
                                                    class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                            <textarea type="text" id="SignagesExplanation" name="SignagesExplanation" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                                onfocus="document.getElementById('SignagesExplanation_error')?.classList.add('hidden')">{{ $signage->SignagesExplanation}}</textarea>
                                        </div>

                                        <div>
                                            <label for="description_image" class="block text-sm font-medium text-gray-700 mb-1">
                                                Ảnh mô tả
                                            </label>
                                            @error('SignageImage', 'edit')
                                                <p id="SignageImage_error"
                                                    class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                                    {{ $message }}
                                                </p>
                                            @enderror

                                            <input type="file" name="SignageImage"
                                                data-preview-target="preview-{{ $signage->SignageID }}"
                                                 accept="image/*"
                                                class="description-image w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                                onfocus="document.getElementById('SignageImage_error')?.classList.add('hidden')">
 
                                                <div class="flex justify-center mt-3">
                                                    <img 
                                                        id="preview-{{ $signage->SignageID }}"
                                                        src="{{ !empty($signage->SignageImage) ? asset('storage/uploads/imageSignage/' . $signage->SignageImage) : '' }}"
                                                        alt="Image preview"
                                                        class="preview-image w-32 h-32 object-contain p-2 border rounded-md shadow-sm">
                                                </div>
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="border-t p-4 flex justify-end gap-3">
                                        <button type="button"
                                            class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                            data-hs-overlay="#edit_{{ $signage->SignageID }}">
                                            Hủy
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                            Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @endforeach
            @endif
            <!-- end modal-->

            <!-- modal create -->

            <div id="create_signage" class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
                <div
                    class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                    <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">

                        <!-- Header -->
                        <div class="bg-gradient-to-r bg-primary p-6">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                            <i class="ti ti-library-plus text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-white text-lg">Thêm Dữ Liệu</h3>
                                        <p class="text-white/80 text-sm">Điền thông tin vào các trường bên dưới</p>
                                    </div>
                                </div>
                                <button type="button"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                    data-hs-overlay="#create_signage">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Body -->
                        <form action="{{ route("admintrafficbot.signages.store") }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-scroll max-h-[60vh] overflow-y-auto p-6 space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="signage_type">
                                        Loại biển báo
                                    </label>
                                    @error('SignageTypeID', 'create')
                                        <p id="SignageTypeID_error"
                                            class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <select id="SignageTypeID" name="SignageTypeID" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                        onfocus="document.getElementById('SignageTypeID')?.classList.add('hidden')">
                                        @foreach ($signageTypes as $type)
                                            <option value="{{ $type->SignageTypeID }}">
                                                {{ $type->SignagesTypeName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tên -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                                        Tên biển báo</label>
                                    @error('SignageName ', 'create')
                                        <p id="SignageName_error"
                                            class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <input type="text" id="SignageName" name="SignageName" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                        onfocus="document.getElementById('SignageName_error')?.classList.add('hidden')">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                                        Mô tả biển báo</label>
                                    @error('SignagesExplanation', 'create')
                                        <p id="SignagesExplanation_error"
                                            class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <textarea type="text" id="SignagesExplanation" name="SignagesExplanation" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                        onfocus="document.getElementById('SignagesExplanation_error')?.classList.add('hidden')"></textarea>
                                </div>

                                <div>
                                    <label for="description_image_create"
                                        class="block text-sm font-medium text-gray-700 mb-1">
                                        Ảnh mô tả
                                    </label>
                                    @error('SignageImage', 'create')
                                        <p id="SignageImage_error"
                                            class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                    <input type="file" name="SignageImage" id="description_image_create" accept="image/*"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        onfocus="document.getElementById('SignageImage_error')?.classList.add('hidden')">

                                    <div class="flex justify-center mt-3">
                                        <img id="preview-image_create" src="" alt="Image preview"
                                            class="hidden w-32 h-32 object-contain p-2 border rounded-md shadow-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="border-t p-4 flex justify-end gap-3">
                                <button type="button"
                                    class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                    data-hs-overlay="#create_signage">
                                    Hủy
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                    Lưu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

</main>

    
       



@endsection

@section("footer")
    <script>
        document.querySelectorAll(".description-image").forEach(function(input) {
        input.addEventListener("change", function (event) {
            const file = event.target.files[0];
            const previewId = input.getAttribute("data-preview-target");
            const imageElement = document.getElementById(previewId);

            if (file && imageElement) {
                const imageURL = URL.createObjectURL(file);
                imageElement.src = imageURL;
            }
            });
        });

        document.getElementById("description_image_create").addEventListener("change", function (event) {
            const file = event.target.files[0];
            console.log(file)
            if (file) {
                const imageURL = URL.createObjectURL(file);
                const imageElement = document.getElementById("preview-image_create");
                imageElement.src = imageURL;
                imageElement.classList.remove("hidden")
            } else {
                console.log("file k tồn tịa")
            }
        });


        @if($errors->create->any())
            window.addEventListener("load", function () {
                setTimeout(function () {
                    document.getElementById("open_modal_create").click();
                }, 300)
            });
        @endif

         @if($errors->edit->any())
            window.addEventListener("load", function () {
                setTimeout(function () {
                    document.getElementById("open_modal_edit").click();
                }, 300)
            });
        @endif
    </script>
@endsection

@section("izitoast")
    <script>
        @if(session("create_success"))
            iziToast.success({
                message: "{{ session("create_success") }}",
                position: "topRight"
            })
        @endif
        @if(session("create_fails"))
            iziToast.warning({
                message: "{{ session("create_fails") }}",
                position: "topRight"
            })
        @endif
        @if(session("delete_success"))
            iziToast.success({
                message: "{{ session("delete_success") }}",
                position: "topRight"
            })
        @endif
        @if(session("delete_fails"))
            iziToast.warning({
                message: "{{ session("delete_fails") }}",
                position: "topRight"
            })
        @endif
    </script>
@endsection