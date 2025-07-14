@extends("admin.adminPageLayout.layout")
@section("title", "Phân loại biển báo")

@section("main")

                <main>

                    <!-- Page Title Start -->
                    <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
                        <h4 class="text-default-900 text-lg font-medium mb-2">Phân loại biển báo</h4>

                        <!-- <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
                                                    <a href="#" class="text-sm font-medium text-default-700">OpenDash</a>
                                                    <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                                                    <a href="#" class="text-sm font-medium text-default-700">Tables</a>
                                                    <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                                                    <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Basic Tables</a>
                                                </div> -->
                    </div>
                    <!-- Page Title End -->

                    <div class=" gap-6 mt-8">
                        <div class="card overflow-hidden">
                            <div class="card-header flex justify-between items-center">
                                <div class="items-center relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <i class="i-ph-magnifying-glass text-base"></i>
                                    </div>
                                    <form action="{{ route("admintrafficbot.signagetypes.sarch") }}">
                                        <input type="search" name="search"
                                            class="form-input px-10 rounded-lg bg-gray-500/10 border-transparent focus:border-transparent w-80"
                                            placeholder="Search...">
                                    </form>

                                </div>
                                <div class="flex items-center gap-3">
                                    <button class="btn bg-primary/25 text-primary hover:bg-primary hover:text-white"
                                        data-hs-overlay="#modal-create" data-fc-placement="bottom">

                                        Tạo mới
                                    </button>
                                </div>
                            </div>
                            <div>
                                <div class="overflow-x-auto">
                                    <div class="min-w-full inline-block align-middle">
                                        <div class="overflow-hidden">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                            Loại biển báo</th>

                                                        <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                            Mô tả
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200">
                                                    @foreach ($signagesType as $signage)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">
                                                                {{ $signage->SignagesTypeName }}
                                                            </td>


                                                            <td class="px-6 py-4 whitespace-normal text-sm text-default-800"
                                                                style="max-width: 250px; word-wrap: break-word;">
                                                                {{ $signage->SignagesTypeDescription }}
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex justify-end gap-x-2">
                                                                <div class="hs-tooltip">
                                                                    <button type="button"
                                                                        class="text-red-500 hover:text-red-800 hs-tooltip-toggle"
                                                                        data-hs-overlay="#delete-{{ $signage->SignageTypeID }}"
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
                                                                    <a href="" type="button"
                                                                        class="text-info hover:text-info hs-tooltip-toggle"
                                                                        onclick="event.preventDefault()"
                                                                        data-hs-overlay="#edit-{{ $signage->SignageTypeID }}"
                                                                        data-fc-placement="bottom">
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
                                                                        data-hs-overlay="#show-{{ $signage->SignageTypeID }}">
                                                                        <span class="material-symbols-rounded text-2xl">
                                                                            <span class="material-symbols-rounded">
                                                                                visibility
                                                                            </span>
                                                                        </span>
                                                                    </a>
                                                                    <span
                                                                        class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                                                                        role="tooltip">
                                                                        xem chi tiết
                                                                    </span>
                                                                </div>
                                                                <div class="hs-tooltip">

                                                                    <a href="{{ route("admintrafficbot.listsignages") }}" type="button"
                                                                        class="text-blue-500 hover:text-blue-700 hs-tooltip-toggle"
                                                                        data-fc-placement="top">
                                                                        <span class="material-symbols-rounded text-2xl">
                                                                            <span class="material-symbols-rounded">
                                                                                arrow_right_alt

                                                                            </span>
                                                                        </span>
                                                                    </a>
                                                                    <span
                                                                        class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                                                                        role="tooltip">
                                                                        Đến liên kết
                                                                    </span>
                                                                </div>

                                                            </td>
                                                        </tr>

                                                    @endforeach
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
                                        <span class="font-medium">{{ $signagesType->firstItem() }}</span>
                                        ->
                                        <span class="font-medium">{{ $signagesType->lastItem() }}</span>
                                        of
                                        <span class="font-medium">{{ $signagesType->total() }}</span>
                                    </p>
                                </div>

                                <!-- Pagination -->
                                <div class="flex flex-wrap items-center gap-1">
                                    {{-- Previous Page --}}
                                    @if ($signagesType->onFirstPage())
                                        <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Trước</span>
                                    @else
                                        <a href="{{ $signagesType->previousPageUrl() }}"
                                            class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Trước</a>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @php
                                        $start = max($signagesType->currentPage() - 2, 1);
                                        $end = min($signagesType->currentPage() + 2, $signagesType->lastPage());
                                    @endphp

                                    {{-- First Page Link --}}
                                    @if ($start > 1)
                                        <a href="{{ $signagesType->url(1) }}"
                                            class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">1</a>
                                        @if ($start > 2)
                                            <span class="px-2 text-gray-500">...</span>
                                        @endif
                                    @endif

                                    {{-- Page Links --}}
                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $signagesType->currentPage())
                                            <span
                                                class="px-3 py-1 bg-primary/25 text-primary rounded border border-indigo-600">{{ $page }}</span>
                                        @else
                                            <a href="{{ $signagesType->url($page) }}"
                                                class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $page }}</a>
                                        @endif
                                    @endfor

                                    {{-- Last Page Link --}}
                                    @if ($end < $signagesType->lastPage())
                                        @if ($end < $signagesType->lastPage() - 1)
                                            <span class="px-2 text-gray-500">...</span>
                                        @endif
                                        <a href="{{ $signagesType->url($signagesType->lastPage()) }}"
                                            class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $signagesType->lastPage() }}</a>
                                    @endif

                                    {{-- Next Page --}}
                                    @if ($signagesType->hasMorePages())
                                        <a href="{{ $signagesType->nextPageUrl() }}"
                                            class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Sau</a>
                                    @else
                                        <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Sau</span>
                                    @endif
                                </div>
                            </div>
                        </div> <!-- end card -->

                        <!-- modal tạo loại biển báo -->

                        <div id="modal-create" class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
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
                                                data-hs-overlay="#modal-create">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Body -->
                                    <form action="{{ route("admintrafficbot.signagestype.store") }}" method="post"
                                        class="p-6 space-y-5">
                                        @csrf

                                        <!-- Tên -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                                                Tên loại biển báo</label>
                                            @error('SignagesTypeName', 'create')
                                                <div id="create_errpr" class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <input type="text" id="SignagesTypeName" name="SignagesTypeName" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                                                Mô tả loại biển báo</label>
                                            @error('SignagesTypeDescription', 'create')
                                                <div id="create_errpr" class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <textarea type="text" id="SignagesTypeDescription" name="SignagesTypeDescription" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"></textarea>
                                        </div>

                                        <!-- Footer -->
                                        <div class="border-t pt-4 flex justify-end gap-3">
                                            <button type="button"
                                                class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                                data-hs-overlay="#modal-create">
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

                        <!-- end modal-->

                        <!-- modal edit -->

                        @foreach ($signagesType as $signage)
                            <div id="edit-{{ $signage->SignageTypeID }}"
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
                                                    data-hs-overlay="#edit-{{ $signage->SignageTypeID }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Body -->
                                        <form action="{{ route("admintrafficbot.signagestype.update", ["ID" => $signage->SignageTypeID]) }}"
                                            method="POST" class="p-6 space-y-5">
                                            @csrf
                                            <!-- Tên -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                                                    Tên loại biển báo</label>
                                                @error('SignagesTypeName', 'edit')
                                                    <div id="create_errpr" class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <input type="text" id="LicenseTypeName" name="SignagesTypeName"
                                                    value="{{ $signage->SignagesTypeName }}" required
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                                                    Mô tả loại biển báo</label>
                                                @error('SignagesTypeDescription', 'edit')
                                                    <div id="create_errpr" class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <textarea type="text" id="SignagesTypeDescription" name="SignagesTypeDescription" required
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">{{ $signage->SignagesTypeDescription }}</textarea>
                                            </div>

                                            <!-- Footer -->
                                            <div class="border-t pt-4 flex justify-end gap-3">
                                                <button type="button"
                                                    class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                                    data-hs-overlay="#edit-{{ $signage->SignageTypeID }}">
                                                    Hủy
                                                </button>
                                                <button type="submit"
                                                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                                    cập nhât
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- end modal-->





                        <!-- modal xóa -->
                        @foreach ($signagesType as $signage)
                           <div id="delete-{{ $signage->SignageTypeID }}"
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
                                                        <p class="text-white/80 text-sm">Bạn có chắc muốn xóa loại biển báo này?</p>
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                                    data-hs-overlay="#delete-{{ $signage->SignageTypeID }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Body -->
                                        <div class="p-6 space-y-4 text-center">
                                            <p class="text-gray-700 text-sm">Bạn có chắc chắn muốn <strong>xóa</strong> loại biển báo
                                                <strong>{{ $signage->SignageName }}</strong> không? Hành động này không thể hoàn tác.</p>
                                        </div>

                                        <!-- Footer -->
                                        <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
                                            <button type="button"
                                                class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                                data-hs-overlay="#delete-{{ $signage->SignageTypeID }}">
                                                Hủy
                                            </button>

                                            <form  action="{{ route("admintrafficbot.signagestype.delete", parameters: ["ID" => $signage->SignageTypeID]) }}"
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


                            <!-- end modal -->
                        @endforeach


                        <!-- modal show -->
                        @foreach ($signagesType as $signage)
                            <div id="show-{{ $signage->SignageTypeID }}"
                                class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
                                <div
                                    class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                                    <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">

                                        <!-- Header -->
                                        <div class="bg-gradient-to-r bg-primary p-6">
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                                        <i class="ti ti-eye text-white text-xl"></i>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-bold text-white text-lg">Chi tiết dữ liệu</h3>
                                                        <p class="text-white/80 text-sm">Thông tin chi tiết về loại biển báo</p>
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                                    data-hs-overlay="#show-{{ $signage->SignageTypeID }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Body -->
                                        <div class="p-6 space-y-5">

                                            <!-- Tên -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                                                    Tên loại biển báo</label>
                                                @error('SignagesTypeName', 'edit')
                                                    <div id="err_SignagesTypeName"
                                                        class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <input readonly type="text" id="LicenseTypeName" name="SignagesTypeName"
                                                    value="{{ $signage->SignagesTypeName }}" required
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                                                    Mô tả loại biển báo</label>
                                                @error('SignagesTypeDescription', 'edit')
                                                    <div id="err_SignagesTypeDescription"
                                                        class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <textarea readonly type="text" id="SignagesTypeDescription" name="SignagesTypeDescription"
                                                    required
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">{{ $signage->SignagesTypeDescription }}</textarea>
                                            </div>

                                            <!-- Footer -->
                                            <div class="border-t pt-4 flex justify-end gap-3">
                                                <button type="button"
                                                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors"
                                                    data-hs-overlay="#show-{{ $signage->SignageTypeID }}">
                                                    Đóng
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- end modal-->


                    </div>

                </main>

@endsection

@section("footer")
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

        @if(session("update_success"))
            iziToast.success({
                message: "{{ session("update_success") }}",
                position: "topRight"
            })
        @endif
        @if(session("update_fails"))
            iziToast.warning({
                message: "{{ session("update_fails") }}",
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