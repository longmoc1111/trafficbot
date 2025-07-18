@extends("admin.adminPageLayout.layout")
@section("title", "Phân loại biển báo")

@section("main")

    <main>
        <!-- Tiêu đề trang -->
        <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
            <h4 class="text-default-900 text-xl font-semibold">🚧 Phân loại biển báo</h4>
            <button class="btn bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md shadow text-sm"
                data-hs-overlay="#modal-create">
                <i class="i-solar-plus-bold mr-1"></i> Tạo mới
            </button>
        </div>

        <!-- Tìm kiếm -->
        <div class="card p-4 mb-6 bg-white border shadow rounded-lg">
            <form action="{{ route('admintrafficbot.signagetypes.sarch') }}" method="get" class="flex items-center gap-3">
                <div class="relative w-full max-w-md">
                    <input type="search" name="search" placeholder="Tìm loại biển báo..."
                        class="form-input pl-10 pr-4 py-2 rounded-lg w-full border-gray-300 focus:ring-2 focus:ring-blue-500 shadow-sm">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <i class="i-ph-magnifying-glass"></i>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bảng dữ liệu -->
        <div class="card p-0 overflow-hidden bg-white border shadow rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-sm font-semibold text-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left">Tên loại</th>
                            <th class="px-6 py-3 text-left">Mô tả</th>
                            <th class="px-6 py-3 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-800">
                        @foreach ($signagesType as $signage)
                            <tr>
                                <td class="px-6 py-4 font-medium">{{ $signage->SignagesTypeName }}</td>
                                <td class="px-6 py-4 max-w-xs whitespace-normal break-words">
                                    {{ $signage->SignagesTypeDescription }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex justify-end gap-2">
                                        <!-- Xem -->
                                        <a href="#" class="text-blue-500 hover:text-blue-700"
                                            data-hs-overlay="#show-{{ $signage->SignageTypeID }}">
                                            <span class="material-symbols-rounded text-2xl">visibility</span>
                                        </a>

                                        <!-- Sửa -->
                                        <a href="#" class="text-yellow-500 hover:text-yellow-700"
                                            data-hs-overlay="#edit-{{ $signage->SignageTypeID }}">
                                            <span class="material-symbols-rounded text-2xl">edit</span>
                                        </a>

                                        <!-- Xóa -->
                                        <button type="button" class="text-red-500 hover:text-red-700"
                                            data-hs-overlay="#delete-{{ $signage->SignageTypeID }}">
                                            <span class="material-symbols-rounded text-2xl">delete_forever</span>
                                        </button>

                                        <!-- Đến liên kết -->
                                        <a href="{{ route('admintrafficbot.listsignages') }}"
                                            class="text-indigo-500 hover:text-indigo-700">
                                            <span class="material-symbols-rounded text-2xl">arrow_right_alt</span>
                                        </a>
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
                    Hiển thị <span class="font-semibold">{{ $signagesType->firstItem() }}</span> →
                    <span class="font-semibold">{{ $signagesType->lastItem() }}</span> /
                    <span class="font-semibold">{{ $signagesType->total() }}</span>
                </p>

                <div class="flex gap-1">
                    @if($signagesType->onFirstPage())
                        <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded border">Trước</span>
                    @else
                        <a href="{{ $signagesType->previousPageUrl() }}"
                            class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">Trước</a>
                    @endif

                    @php
                        $start = max($signagesType->currentPage() - 2, 1);
                        $end = min($signagesType->currentPage() + 2, $signagesType->lastPage());
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $signagesType->url(1) }}"
                            class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">1</a>
                        @if ($start > 2)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $signagesType->currentPage())
                            <span class="px-3 py-1 bg-blue-600 text-white rounded border">{{ $i }}</span>
                        @else
                            <a href="{{ $signagesType->url($i) }}"
                                class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($end < $signagesType->lastPage())
                        @if ($end < $signagesType->lastPage() - 1)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                        <a href="{{ $signagesType->url($signagesType->lastPage()) }}"
                            class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">
                            {{ $signagesType->lastPage() }}
                        </a>
                    @endif

                    @if($signagesType->hasMorePages())
                        <a href="{{ $signagesType->nextPageUrl() }}"
                            class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">Sau</a>
                    @else
                        <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded border">Sau</span>
                    @endif
                </div>
            </div>
        </div>
    </main>


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
                <form action="{{ route("admintrafficbot.signagestype.store") }}" method="post" class="p-6 space-y-5">
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
                            <strong>{{ $signage->SignageName }}</strong> không? Hành động này không thể hoàn tác.
                        </p>
                    </div>

                    <!-- Footer -->
                    <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
                        <button type="button"
                            class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                            data-hs-overlay="#delete-{{ $signage->SignageTypeID }}">
                            Hủy
                        </button>

                        <form
                            action="{{ route("admintrafficbot.signagestype.delete", parameters: ["ID" => $signage->SignageTypeID]) }}"
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
                                <div id="err_SignagesTypeName" class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
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
                            <textarea readonly type="text" id="SignagesTypeDescription" name="SignagesTypeDescription" required
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