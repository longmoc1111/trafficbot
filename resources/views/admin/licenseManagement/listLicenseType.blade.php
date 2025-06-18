@extends("admin.adminPageLayout.layout")
@section("title", "Quản lý giấy phép")
@section("main")


    <main>
        <!-- Page Title Start -->
        <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
            <h4 class="text-default-900 text-lg font-medium mb-2">Quản lý giấy phép</h4>

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
                <div class="card-header flex justify-end">
                    <button id="open_modal_create" class="btn bg-primary/25 text-primary hover:bg-primary hover:text-white"
                        data-hs-overlay="#create_license_type" data-fc-placement="bottom">
                        Thêm giấy phép
                    </button>

                </div>
                <div>
                    <div class="overflow-x-auto">
                        <div class="min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                Tên giấy phép</th>
                                            <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                Mô tả giấy phép
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($ListLicenseType as $licensetype)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">
                                                    {{ $licensetype->LicenseTypeName }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                                    {{ $licensetype->LicenseTypeDescription }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex justify-end gap-x-2">
                                                    <div class="hs-tooltip">
                                                            <button type="button"
                                                                class="text-red-500 hover:text-red-800 hs-tooltip-toggle"
                                                                data-hs-overlay="#modal_delete_{{ $licensetype->LicenseTypeID }}"
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
                                                        <a id="open_modal_edit" href="" onclick="event.preventDefault()"
                                                            type="button" class="text-info hover:text-info hs-tooltip-toggle"
                                                            data-hs-overlay="#modal_edit_{{ $licensetype->LicenseTypeID }}"
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
                                                            data-hs-overlay="#modal_show_{{ $licensetype->LicenseTypeID }}">
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end card -->

            <!-- modal create -->
            <form action="{{ route("admintrafficbot.licensetype.store") }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="create_license_type"
                    class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                    <div
                        class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                        <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                            <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                <h3 class="text-lg font-medium text-default-900 ">
                                    Thêm biển báo
                                </h3>
                                <button type="button" class="text-default-600 cursor-pointer"
                                    data-hs-overlay="#create_license_type">
                                    <i class="i-tabler-x text-lg"></i>
                                </button>
                            </div>
                            <div class="p-4 overflow-y-auto">
                                <div class="mb-3">
                                    <label for="LicenseTypeName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                        Tên giấy phép
                                    </label>
                                    @error('LicenseTypeName', 'create')
                                        <div id="license_Type_error"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <input type="text" id="LicenseTypeName" name="LicenseTypeName" value=""
                                        onfocus="document.getElementById('license_Type_error')?.classList.add('hidden')"
                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div class="mb-3">
                                    <label for="example-email"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Mô tả giấy phép</label>

                                    @error("LicenseTypeDescription", 'create')
                                        <div id="license_type_description_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <textarea type="text" id="example-email" name="LicenseTypeDescription"
                                        class="form-input"
                                        onfocus="document.getElementById('license_type_description_errorr')?.classList.add('hidden')"></textarea>
                                </div>
                            </div>
                            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                <button type="button"
                                    class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                    data-hs-overlay="#create_license_type">
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

            <!-- end modal-->

            <!-- modal edit -->
            @if(!empty($ListLicenseType))
                @foreach ($ListLicenseType as $licensetype)
                    <form action="{{ route("admintrafficbot.licensetype.update", ["ID" => $licensetype->LicenseTypeID]) }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div id="modal_edit_{{ $licensetype->LicenseTypeID }}"
                            class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                            <div
                                class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                                <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                    <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                        <h3 class="text-lg font-medium text-default-900 ">
                                            Thêm biển báo
                                        </h3>
                                        <button type="button" class="text-default-600 cursor-pointer"
                                            data-hs-overlay="#modal_edit_{{ $licensetype->LicenseTypeID }}">
                                            <i class="i-tabler-x text-lg"></i>
                                        </button>
                                    </div>
                                    <div class="p-4 overflow-y-auto">
                                        <div class="mb-3">
                                            <label for="LicenseTypeName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                                Tên giấy phép
                                            </label>
                                            @error('LicenseTypeName', 'edit')
                                                <div id="license_Type_error"
                                                    class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <input type="text" id="LicenseTypeName" name="LicenseTypeName"
                                                value="{{ $licensetype->LicenseTypeName }}"
                                                onfocus="document.getElementById('license_Type_error')?.classList.add('hidden')"
                                                class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>

                                        <div class="mb-3">
                                            <label for="example-email"
                                                class="text-default-800 text-sm font-medium inline-block mb-2">
                                                Mô tả giấy phép</label>

                                            @error("LicenseTypeDescription", 'edit')
                                                <div id="license_type_description_errorr"
                                                    class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <textarea type="text" id="example-email" name="LicenseTypeDescription"
                                                class="form-input"
                                                onfocus="document.getElementById('license_type_description_errorr')?.classList.add('hidden')">{{ $licensetype->LicenseTypeDescription }}</textarea>
                                        </div>
                                    </div>
                                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                        <button type="button"
                                            class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                            data-hs-overlay="#modal_edit_{{ $licensetype->LicenseTypeID }}">
                                            <i class="i-tabler-x me-1" id="icon_closed"></i>
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
            <!-- modal edit -->
            @if(!empty($ListLicenseType))
                @foreach ($ListLicenseType as $licensetype)
                    <div id="modal_show_{{ $licensetype->LicenseTypeID }}"
                        class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                        <div
                            class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                            <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                    <h3 class="text-lg font-medium text-default-900 ">
                                        Chi tiết giấy phép
                                    </h3>
                                    <button type="button" class="text-default-600 cursor-pointer"
                                        data-hs-overlay="#modal_show_{{ $licensetype->LicenseTypeID }}">
                                        <i class="i-tabler-x text-lg"></i>
                                    </button>
                                </div>
                                <div class="p-4 overflow-y-auto">
                                    <div class="mb-3">
                                        <label for="LicenseTypeName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                            Tên giấy phép
                                        </label>
                                        <input readonly type="text" id="LicenseTypeName" name="LicenseTypeName"
                                            value="{{ $licensetype->LicenseTypeName }}"
                                            class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>

                                    <div class="mb-3">
                                        <label for="example-email" class="text-default-800 text-sm font-medium inline-block mb-2">
                                            Mô tả giấy phép</label>
                                        <textarea readonly type="text" id="example-email" name="LicenseTypeDescription"
                                            class="form-input">{{ $licensetype->LicenseTypeDescription }}</textarea>
                                    </div>
                                </div>
                                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                    <button type="button"
                                        class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                        data-hs-overlay="#modal_show_{{ $licensetype->LicenseTypeID }}">
                                        <i class="i-tabler-x me-1" id="icon_closed"></i>
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
                @endforeach
            @endif
            <!-- end modal-->




           <!-- modal xóa -->
            @if(!empty($ListLicenseType))
                 @foreach ($ListLicenseType as $licensetype)
                    <div id="modal_delete_{{ $licensetype->LicenseTypeID }}"
                        class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none">
                        <div
                            class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                            <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                    <h3 class="text-lg font-medium text-default-900">
                                        Xác nhận
                                    </h3>
                                    <button type="button" class="text-default-600 cursor-pointer"
                                        data-hs-overlay="#modal_delete_{{ $licensetype->LicenseTypeID }}">
                                        <i class="i-tabler-x text-lg"></i>
                                    </button>
                                </div>
                                <div class="p-4 overflow-y-auto">
                                    <p class="mt-1 text-default-600">
                                        Bạn có chắc muốn xóa tài khoản này?
                                    </p>
                                </div>
                                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                    <button type="button"
                                        class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                        data-hs-overlay="#modal_delete_{{ $licensetype->LicenseTypeID }}">
                                        Đóng
                                    </button>
                                    <form action="{{ route("admintrafficbot.licensetype.delete", ["ID" => $licensetype->LicenseTypeID ]) }}"
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



        </div>

    </main>

@endsection

@section("footer")

    <script>
        @if($errors->create->any())
            window.addEventListener("load", function () {
                setTimeout(function () {
                    document.getElementById("open_modal_create").click()
                }, 300)
            })
        @endif
        @if($errors->edit->any())
            window.addEventListener("load", function () {
                setTimeout(function () {
                    document.getElementById("open_modal_edit").click()
                }, 300)
            })
        @endif

    </script>
@endsection



@section("izitoast")
    <script>
        @if(session("add_license"))
            iziToast.success({
                message: "{{ session("add_license") }}",
                position: "topRight"
            })
        @endif

        @if(session("delete_license"))
            iziToast.success({
                message: "{{ session("delete_license") }}",
                position: "topRight"
            })
        @endif
        @if(session("update_license"))
            iziToast.success({
                message: "{{ session("update_license") }}",
                position: "topRight"
            })
        @endif
    


    </script>

@endsection