@extends("admin.adminPageLayout.layout")
@section("title", "quản lý biển báo")
@section("main")

    
    <main>

        <!-- Page Title Start -->
        <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
            <h4 class="text-default-900 text-lg font-medium mb-2">Danh sách biển báo</h4>
        </div>
        <!-- Page Title End -->

        <div class=" gap-6 mt-8">
            <div class="card overflow-hidden">
                <div class="card overflow-hidden">
                    <div class="card-header flex justify-between items-center">
                        <div class="md:flex hidden items-center relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <i class="i-ph-magnifying-glass text-base"></i>
                            </div>
                            <form action="{{ route("admintrafficbot.signage.sarch") }}">
                                <input type="search" name="search"
                                    class="form-input px-10 rounded-lg bg-gray-500/10 border-transparent focus:border-transparent w-80"
                                    placeholder="Search...">
                            </form>

                        </div>
                        <div class="flex items-center gap-3">
                            <form action="{{route("admintrafficbot.listsignages")}}">
                                <select name="option" class="form-select" id="example-select" onchange="this.form.submit()">
                                    @foreach ($signageTypes as $type)
                                        <option value="{{ $type->SignageTypeID }}" {{!empty($option) && $option == $type->SignageTypeID ? "selected" : "" }}>{{ $type->SignagesTypeName }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>


                            <button id="open_modal_create"
                                class="btn bg-primary/25 text-primary hover:bg-primary hover:text-white"
                                data-fc-placement="top" data-hs-overlay="#create_signage">
                                Thêm biển báo
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <div class=" overflow-x-auto">
                        <div class="min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                Tên biển báo</th>
                                            <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                Loại biển báo
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                Ảnh mô tả
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @if(!empty($signages))
                                            @foreach ($signages as $signage)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-normal text-sm text-default-800"
                                                        style="max-width: 200px; word-wrap: break-word;">
                                                        {{ trim($signage->SignageName) }}
                                                    </td>
                                                    @if(!empty($signage->signage_SignageType->SignagesTypeName))
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                                            {{ $signage->signage_SignageType->SignagesTypeName }}
                                                        </td>
                                                    @else
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                                            Không
                                                        </td>
                                                    @endif
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                                        <img style="max-width: 100px;" class=""
                                                            src="{{ asset("storage/uploads/imageSignage/$signage->SignageImage")}}"
                                                            alt="">
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex justify-end gap-x-2">
                                                        <div class="hs-tooltip">
                                                            <button type="button"
                                                                class="text-red-500 hover:text-red-800 hs-tooltip-toggle"
                                                                data-hs-overlay="#delete_{{ $signage->SignageID }}"
                                                                data-fc-placement="bottom">
                                                                <span class="material-symbols-rounded text-2xl">
                                                                    delete_forever
                                                                </span>
                                                            </button>
                                                            <span
                                                                class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                                                                role="tooltip">
                                                                Xóa vĩnh viễn
                                                            </span>
                                                        </div>
                                                        <div class="hs-tooltip">
                                                            <a id ="open_modal_edit" href="#" type="button"
                                                                class="text-info hover:text-info hs-tooltip-toggle"
                                                                data-fc-placement="top"
                                                                data-hs-overlay="#edit_{{ $signage->SignageID }}">
                                                                <span class="material-symbols-rounded text-2xl">
                                                                    edit
                                                                </span>
                                                            </a>
                                                            <span
                                                                class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                                                                role="tooltip">
                                                                chỉnh sửa
                                                            </span>
                                                        </div>
                                                        <div class="hs-tooltip">
                                                            <a href="" type="button" onclick="event.preventDefault()"
                                                                class="text-blue-500 hover:text-blue-700 hs-tooltip-toggle"
                                                                data-fc-placement="top"
                                                                data-hs-overlay="#show-{{ $signage->SignageID }}">
                                                                <span class="material-symbols-rounded text-2xl">
                                                                    visibility
                                                                </span>
                                                            </a>
                                                            <span
                                                                class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                                                                role="tooltip">
                                                                xem chi tiết
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                    <!-- Showing -->
                    <div>
                        <p class="text-sm text-gray-700">
                            <span class="font-medium">{{ $signages->firstItem() }}</span>
                            ->
                            <span class="font-medium">{{ $signages->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $signages->total() }}</span>
                        </p>
                    </div>

                    <!-- Pagination -->
                    <div class="flex flex-wrap items-center gap-1">
                        {{-- Previous Page --}}
                        @if ($signages->onFirstPage())
                            <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Trước</span>
                        @else
                            <a href="{{ $signages->previousPageUrl() }}"
                                class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Trước</a>
                        @endif

                        {{-- Page Numbers --}}
                        @php
                            $start = max($signages->currentPage() - 2, 1);
                            $end = min($signages->currentPage() + 2, $signages->lastPage());
                        @endphp

                        {{-- First Page Link --}}
                        @if ($start > 1)
                            <a href="{{ $signages->url(1) }}"
                                class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">1</a>
                            @if ($start > 2)
                                <span class="px-2 text-gray-500">...</span>
                            @endif
                        @endif

                        {{-- Page Links --}}
                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page == $signages->currentPage())
                                <span
                                    class="px-3 py-1 bg-primary/25 text-primary rounded border border-indigo-600">{{ $page }}</span>
                            @else
                                <a href="{{ $signages->url($page) }}"
                                    class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $page }}</a>
                            @endif
                        @endfor

                        {{-- Last Page Link --}}
                        @if ($end < $signages->lastPage())
                            @if ($end < $signages->lastPage() - 1)
                                <span class="px-2 text-gray-500">...</span>
                            @endif
                            <a href="{{ $signages->url($signages->lastPage()) }}"
                                class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $signages->lastPage() }}</a>
                        @endif

                        {{-- Next Page --}}
                        @if ($signages->hasMorePages())
                            <a href="{{ $signages->nextPageUrl() }}"
                                class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Sau</a>
                        @else
                            <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Sau</span>
                        @endif
                    </div>
                </div>


            </div> <!-- end card -->

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