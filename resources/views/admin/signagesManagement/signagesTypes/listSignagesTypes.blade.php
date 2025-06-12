@extends("admin.adminPageLayout.layout")
@section("main")

    <main>

        <!-- Page Title Start -->
        <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
            <h4 class="text-default-900 text-lg font-medium mb-2">Danh sách bộ đề</h4>

            <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
                <a href="#" class="text-sm font-medium text-default-700">OpenDash</a>
                <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                <a href="#" class="text-sm font-medium text-default-700">Tables</a>
                <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Basic Tables</a>
            </div>
        </div>
        <!-- Page Title End -->

        <div class=" gap-6 mt-8">
            <div class="card overflow-hidden">
                <div class="card-header flex justify-end">
                    <div class="flex gap-2">
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


                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                                    {{ $signage->SignagesTypeDescript }}
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
                                <span class="px-3 py-1 bg-primary/25 text-primary rounded border border-indigo-600">{{ $page }}</span>
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

            <!-- modal tạo câu loại biển báo -->
            <form action="{{ route("admintrafficbot.signagestype.store") }}" method="post">
                @csrf
                <div id="modal-create"
                    class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                    <div
                        class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                        <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                            <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                <h3 class="text-lg font-medium text-default-900 ">
                                    Tạo mới loại biển báo mới
                                </h3>
                                <button type="button" class="text-default-600 cursor-pointer"
                                    data-hs-overlay="#modal-create">
                                    <i class="i-tabler-x text-lg"></i>
                                </button>
                            </div>
                            <div class="p-4 overflow-y-auto">
                                <div class="mb-3">
                                    <label for="LicenseTypeName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                        Tên loại biển báo
                                    </label>
                                    @error('LicenseTypeName')
                                        <div id="dismiss-alert" role="alert">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="i-tabler-circle-x text-xl text-red-600"></i>
                                                </div>
                                                <div class="flex-grow">
                                                    <div
                                                        class="flex items-center bg-red-100 text-red-700 text-sm px-4 rounded mb-2">
                                                        {{ $message }}
                                                        <button data-hs-remove-element="#dismiss-alert" type="button"
                                                            id="dismiss-test"
                                                            class="ms-auto h-6 w-6 rounded-full bg-gray-200 flex justify-center items-center">
                                                            <i class="i-tabler-x text-red-600"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @enderror

                                    <input type="text" id="LicenseTypeName" name="SignagesTypeName"
                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500
                                                                {{ $errors->has('LicenseTypeName') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}"
                                        value="{{ old('LicenseTypeName') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="example-email"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">Mô
                                        Mô tả loại biển báo</label>
                                    @error("LicenseTypeDescription")
                                        @error("LicenseTypeDescription")
                                            <div id="dismiss-alert_2" role="alert">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="i-tabler-circle-x text-red-600"></i>
                                                    </div>
                                                    <div class="flex-grow">
                                                        <div
                                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 rounded mb-2">
                                                            {{ $message }}
                                                            <button data-hs-remove-element="#dismiss-alert_2" type="button"
                                                                id="dismiss-test"
                                                                class="ms-auto h-6 w-6 rounded-full bg-gray-200 flex justify-center items-center">
                                                                <i class="i-tabler-x text-red-600"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @enderror

                                    @enderror
                                    <textarea type="text" id="example-email" name="SignagesTypeDescription"
                                        class="form-input"></textarea>
                                </div>

                            </div>
                            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                <button type="button"
                                    class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                    data-hs-overlay="#modal-create">
                                    <i class="i-tabler-x me-1"></i>
                                    Thoát
                                </button>
                                <button type="submit"
                                    class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary hover:bg-primary-700 border-primary hover:border-primary-700 text-white rounded-md">
                                    Tạo
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- end modal-->

            <!-- modal edit -->
            @foreach ($signagesType as $signage)
                <form action="{{ route("admintrafficbot.signagestype.update", ["ID" => $signage->SignageTypeID]) }}"
                    method="post">
                    @csrf
                    <div id="edit-{{ $signage->SignageTypeID }}"
                        class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                        <div
                            class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                            <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                    <h3 class="text-lg font-medium text-default-900 ">
                                        Chỉnh sửa loại biển báo
                                    </h3>
                                    <button type="button" class="text-default-600 cursor-pointer"
                                        data-hs-overlay="#edit-{{ $signage->SignageTypeID }}">
                                        <i class="i-tabler-x text-lg"></i>
                                    </button>
                                </div>
                                <div class="p-4 overflow-y-auto">
                                    <div class="mb-3">
                                        <label for="LicenseTypeName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                            Tên biển báo
                                        </label>
                                        @error('LicenseTypeName')
                                            <div id="dismiss-alert" role="alert">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="i-tabler-circle-x text-xl text-red-600"></i>
                                                    </div>
                                                    <div class="flex-grow">
                                                        <div
                                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 rounded mb-2">
                                                            {{ $message }}
                                                            <button data-hs-remove-element="#dismiss-alert" type="button"
                                                                id="dismiss-test"
                                                                class="ms-auto h-6 w-6 rounded-full bg-gray-200 flex justify-center items-center">
                                                                <i class="i-tabler-x text-red-600"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        @enderror

                                        <input type="text" id="LicenseTypeName" name="SignagesTypeName"
                                            value="{{ $signage->SignagesTypeName }}"
                                            class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>

                                    <div class="mb-3">
                                        <label for="example-email"
                                            class="text-default-800 text-sm font-medium inline-block mb-2">Mô
                                            Mô tả loại biển báo</label>
                                        @error("LicenseTypeDescription")
                                            @error("LicenseTypeDescription")
                                                <div id="dismiss-alert_2" role="alert">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="i-tabler-circle-x text-red-600"></i>
                                                        </div>
                                                        <div class="flex-grow">
                                                            <div
                                                                class="flex items-center bg-red-100 text-red-700 text-sm px-4 rounded mb-2">
                                                                {{ $message }}
                                                                <button data-hs-remove-element="#dismiss-alert_2" type="button"
                                                                    id="dismiss-test"
                                                                    class="ms-auto h-6 w-6 rounded-full bg-gray-200 flex justify-center items-center">
                                                                    <i class="i-tabler-x text-red-600"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @enderror

                                        @enderror
                                        <textarea type="text" id="example-email" name="SignagesTypeDescription"
                                            class="form-input">{{ $signage->SignagesTypeDescription }}</textarea>
                                    </div>

                                </div>
                                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                    <button type="button"
                                        class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                        data-hs-overlay="#edit-{{ $signage->SignageTypeID }}">
                                        <i class="i-tabler-x me-1"></i>
                                        Thoát
                                    </button>
                                    <button type="submit"
                                        class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary hover:bg-primary-700 border-primary hover:border-primary-700 text-white rounded-md">
                                        Cập nhật
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endforeach
            <!-- end modal-->


            <!-- modal xóa -->
            @foreach ($signagesType as $signage)
                <div id="delete-{{ $signage->SignageTypeID }}"
                    class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none">
                    <div
                        class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                        <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                            <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                <h3 class="text-lg font-medium text-default-900">
                                    Xác nhận
                                </h3>
                                <button type="button" class="text-default-600 cursor-pointer"
                                    data-hs-overlay="#delete-{{ $signage->SignageTypeID }}">
                                    <i class="i-tabler-x text-lg"></i>
                                </button>
                            </div>
                            <div class="p-4 overflow-y-auto">
                                <p class="mt-1 text-default-600">
                                    bạn có chắc muốn xóa loại biển báo này ?
                                </p>
                            </div>
                            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                <button type="button"
                                    class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                    data-hs-overlay="#delete-{{ $signage->SignageTypeID }}">
                                    <i class="i-tabler-x me-1"></i>
                                    Thoát
                                </button>
                                <form
                                    action="{{ route("admintrafficbot.signagestype.delete", parameters: ["ID" => $signage->SignageTypeID]) }}"
                                    method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit"
                                        class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary hover:bg-primary-700 border-primary hover:border-primary-700 text-white rounded-md">
                                        Đồng ý
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
                    <!-- modal chỉnh sửa câu loại biển báo -->
                    <div id="show-{{ $signage->SignageTypeID }}"
                        class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                        <div
                            class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                            <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                    <h3 class="text-lg font-medium text-default-900 ">
                                        Chi tiết loại biển báo
                                    </h3>
                                    <button type="button" class="text-default-600 cursor-pointer"
                                        data-hs-overlay="#show-{{ $signage->SignageTypeID }}">
                                        <i class="i-tabler-x text-lg"></i>
                                    </button>
                                </div>
                                <div class="p-4 overflow-y-auto">
                                    <div class="mb-3">
                                        <label for="LicenseTypeName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                            Tên biển báo
                                        </label>
                                        <input readonly type="text" id="LicenseTypeName" name="SignagesTypeName"
                                            value="{{ $signage->SignagesTypeName }}"
                                            class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>

                                    <div class="mb-3">
                                        <label for="example-email" class="text-default-800 text-sm font-medium inline-block mb-2">Mô
                                            Mô tả loại biển báo</label>
                                        <textarea readonly type="text" id="example-email" name="SignagesTypeDescription"
                                            class="form-input">{{ $signage->SignagesTypeDescription }}</textarea>
                                    </div>

                                </div>
                                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                    <button type="button"
                                        class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                        data-hs-overlay="#show-{{ $signage->SignageTypeID }}">
                                        <i class="i-tabler-x me-1"></i>
                                        Thoát
                                    </button>
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