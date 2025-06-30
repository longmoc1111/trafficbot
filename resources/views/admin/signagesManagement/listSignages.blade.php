@extends("admin.adminPageLayout.layout")
@section("title", "quản lý biển báo")
@section("main")

    <main>

        <!-- Page Title Start -->
        <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
            <h4 class="text-default-900 text-lg font-medium mb-2">Danh sách biển báo</h4>

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
                <div class="card overflow-hidden">
                    <div class="card-header flex justify-between items-center">
                        <div class="items-center relative">
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


                            <button class="btn bg-primary/25 text-primary hover:bg-primary hover:text-white"
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
                                                            <a href="#" type="button"
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
                        class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none">
                        <div
                            class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                            <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                    <h3 class="text-lg font-medium text-default-900">
                                        Xác nhận
                                    </h3>
                                    <button type="button" class="text-default-600 cursor-pointer"
                                        data-hs-overlay="#delete_{{ $signage->SignageID }}">
                                        <i class="i-tabler-x text-lg"></i>
                                    </button>
                                </div>
                                <div class="p-4 overflow-y-auto">
                                    <p class="mt-1 text-default-600">
                                        Bạn có chắc muốn xóa biển báo này?
                                    </p>
                                </div>
                                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                    <button type="button"
                                        class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                        data-hs-overlay="#delete_{{ $signage->SignageID }}">
                                        Đóng
                                    </button>
                                    <form action="{{ route("admintrafficbot.signages.delete", ["ID" => $signage->SignageID]) }}"
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
                @endforeach
            @endif
            <!-- end modal delete -->
            @if(!empty($signages))
                @foreach ($signages as $signage)
                    <div id="show-{{ $signage->SignageID }}"
                        class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                        <div
                            class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-2xl sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                            <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                    <h3 class="text-lg font-medium text-default-900" style="text-align: center;">
                                        Chi tiết biển báo
                                    </h3>
                                    <button type="button" class="text-default-600 cursor-pointer"
                                        data-hs-overlay="#show-{{ $signage->SignageID }}">
                                        <i class="i-tabler-x text-lg"></i>
                                    </button>
                                </div>
                                <div class="flex border rounded-lg shadow-sm overflow-hidden bg-white max-w-full">
                                    <!-- Phần ảnh bên trái -->
                                    <div class="flex-shrink-0 " style="border-right: 3px solid #6b72801A">
                                        <img src="{{ asset("storage/uploads/imageSignage/$signage->SignageImage") }} " alt="Image"
                                            class="w-40 h-40 object-contain p-2">
                                    </div>

                                    <!-- Phần text bên phải -->
                                    <div class="flex flex-col r p-4 flex-grow">
                                        <h3 class="text-lg font-bold text-gray-800 mb-2">
                                            {{ $signage->SignageName }}
                                        </h3>
                                        @if(!empty($signage->signage_SignageType->SignagesTypeName))
                                            <p class="text-gray-600 mb-1">
                                                <strong>Loại biển báo :</strong> {{ $signage->signage_SignageType->SignagesTypeName }}
                                            </p>
                                        @else
                                            <p class="text-gray-600 mb-1">
                                                <strong>Loại biển báo :</strong> Không
                                            </p>
                                        @endif

                                        <p class="text-gray-600">
                                            <strong>Giải thích:</strong> {{ $signage->SignagesExplanation }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                    <button type="button"
                                        class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
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
                    <form action="{{ route("admintrafficbot.signages.update", ["ID" => $signage->SignageID]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="edit_{{ $signage->SignageID }}"
                            class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                            <div
                                class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                                <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                    <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                        <h3 class="text-lg font-medium text-default-900 ">
                                            Chỉnh sửa biển báo
                                        </h3>
                                        <button type="button" class="text-default-600 cursor-pointer"
                                            data-hs-overlay="#edit_{{ $signage->SignageID }}">
                                            <i class="i-tabler-x text-lg"></i>
                                        </button>
                                    </div>
                                    <div class="p-4 overflow-y-auto">
                                        <div class="mb-3">
                                            <label for="example-password"
                                                class="text-default-800 text-sm font-medium inline-block mb-2">
                                                Loại biển báo</label>
                                            <select name="SignageTypeID" class="form-select" id="example-select">
                                                @foreach ($signageTypes as $type)
                                                    <option value="{{ $type->SignageTypeID }}" {{ $type->SignageTypeID == $signage->SignageTypeID ? "selected" : ''  }}>
                                                        {{ $type->SignagesTypeName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="LicenseName" class="text-gray-700 text-sm font-semibold mb-2 block">
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

                                            <input type="text" id="SignageName" name="SignageName"
                                                value="{{ $signage->SignageName }}"
                                                class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>

                                        <div class="mb-3">
                                            <label for="example-email"
                                                class="text-default-800 text-sm font-medium inline-block mb-2">Mô
                                                Mô tả loại biển báo</label>

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
                                                <div class="mb-3">
                                                    <label for="description_image"
                                                        class="text-default-800 text-sm font-semibold mb-2 block">Ảnh mô tả</label>
                                                    <input type="file" name="SignageImage" id="description_image" accept="image/*"
                                                        class="form-input">
                                                </div>
                                            @enderror
                                            <textarea type="text" id="example-email" name="SignagesExplanation"
                                                class="form-input">{{ $signage->SignagesExplanation }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description_image"
                                                class="text-default-800 text-sm font-semibold mb-2 block">Ảnh mô tả</label>
                                            <input type="file" name="NewImage" id="description_image" accept="image/*"
                                                class="form-input" value="">
                                            <input class="hidden" type="text" name="OldImage" id="description_image"
                                                accept="image/*" class="form-input" value="{{ $signage->SignageImage }}">
                                            <div class="justify-center flex">
                                                <img id="preview-image"
                                                    src="/assets/adminPage/SignagesImage/{{ $signage->SignageImage }}" alt="Image"
                                                    class="w-32 h-32 object-contain p-2">
                                            </div>

                                        </div>

                                    </div>
                                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                        <button type="button"
                                            class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                            data-hs-overlay="#edit_{{ $signage->SignageID }}">
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
            @endif
            <!-- end modal-->
            <!-- modal create -->
            <form action="{{ route("admintrafficbot.signages.store") }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="create_signage"
                    class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                    <div
                        class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                        <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                            <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                <h3 class="text-lg font-medium text-default-900 ">
                                    Thêm biển báo
                                </h3>
                                <button type="button" class="text-default-600 cursor-pointer"
                                    data-hs-overlay="#create_signage">
                                    <i class="i-tabler-x text-lg"></i>
                                </button>
                            </div>
                            <div class="p-4 overflow-y-auto">
                                <div class="mb-3">
                                    <label for="example-password"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Loại biển báo</label>
                                    <select name="SignageTypeID" class="form-select" id="example-select">
                                        @foreach ($signageTypes as $type)
                                            <option value="{{ $type->SignageTypeID }}">
                                                {{ $type->SignagesTypeName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="LicenseName" class="text-gray-700 text-sm font-semibold mb-2 block">
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

                                    <input type="text" id="SignageName" name="SignageName" value=""
                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div class="mb-3">
                                    <label for="example-email"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">Mô
                                        Mô tả loại biển báo</label>

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
                                        <div class="mb-3">
                                            <label for="description_image"
                                                class="text-default-800 text-sm font-semibold mb-2 block">Ảnh mô tả</label>
                                            <input type="file" name="SignageImage" id="description_image" accept="image/*"
                                                class="form-input">
                                        </div>
                                    @enderror
                                    <textarea type="text" id="example-email" name="SignagesExplanation"
                                        class="form-input"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="description_image"
                                        class="text-default-800 text-sm font-semibold mb-2 block">Ảnh mô tả</label>
                                    <input type="file" name="SignageImage" id="description_image_create" accept="image/*"
                                        class="form-input" value="">
                                    <div class="justify-center flex">
                                        <img id="preview-image_create" src="" alt="Image"
                                            class="hidden w-32 h-32 object-contain p-2">
                                    </div>

                                </div>

                            </div>
                            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                <button type="button"
                                    class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                    data-hs-overlay="#create_signage">
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


        </div>



    </main>

@endsection

@section("footer")
    <script>
        document.getElementById("description_image").addEventListener("change", function (event) {
            const file = event.target.files[0];
            console.log(file)
            if (file) {
                const imageURL = URL.createObjectURL(file);
                console.log(imageURL);
                const imageElement = document.getElementById("preview-image");
                imageElement.src = imageURL;
                // imageElement.classList.remove("hidden")
            }
        });
        document.getElementById("description_image_create").addEventListener("change", function (event) {
            const file = event.target.files[0];
            console.log(file)
            if (file) {
                const imageURL = URL.createObjectURL(file);
                console.log(imageURL);
                const imageElement = document.getElementById("preview-image_create");
                imageElement.src = imageURL;
                imageElement.classList.remove("hidden")
            }
        });
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