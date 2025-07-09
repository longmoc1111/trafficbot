@extends("admin.adminPageLayout.layout")
@section("main")

    <main>

        <!-- Page Title Start -->
        <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
            <h4 class="text-default-900 text-lg font-medium mb-2">Quản lý dữ liệu chatbot</h4>

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
                    <div class="flex gap-2">
                        <div>
                            <select name="" class="form-select" id="example-select">
                                <option value="chưa có giấy phép">chưa có giấy phép</option>
                            </select>
                        </div>

                        <button id="open_modal_create" data-hs-overlay="#modal-create" data-fc-placement="bottom"
                            class="btn bg-primary/25 text-primary hover:bg-primary hover:text-white">
                            Thêm file
                        </button>

                    </div>
                    <!-- <a href="{{ route("admintrafficbot.question.create") }}"
                                                                                                                                                    class="btn bg-primary/25 text-primary hover:bg-primary hover:text-white">
                                                                                                                                                    Thêm câu hỏi
                                                                                                                                                </a> -->

                </div>
                <div>
                    <div class="overflow-x-auto">
                        <div class="min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                Tên file</th>
                                            <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                Mô tả
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                File
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @if(!empty($dataList))
                                            @foreach($dataList as $data)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">
                                                        {{ $data->FileName }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">
                                                        {{ $data->FileDesciption}}

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">
                                                        {{ $data->File}}

                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex justify-end gap-x-2">
                                                        <div class="hs-tooltip">
                                                            <button type="button"
                                                                class="text-red-500 hover:text-red-800 hs-tooltip-toggle"
                                                                data-hs-overlay="#modal_delete_{{ $data->ChatbotID }}"
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
                                                            <a id="open_modal_edit" href="" type="button"
                                                                onclick="event.preventDefault()"
                                                                class="text-info hover:text-info hs-tooltip-toggle"
                                                                data-fc-placement="top"
                                                                data-hs-overlay="#modal-edit_{{ $data->ChatbotID }}">
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
                                                            <a href="#" type="button"
                                                                class="text-blue-500 hover:text-blue-700 hs-tooltip-toggle"
                                                                data-fc-placement="top">
                                                                <span class="material-symbols-rounded text-2xl">
                                                                    arrow_right_alt
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

            </div> <!-- end card -->

            <!-- modal create -->
            <form action="{{ route("admintrafficbot.chatbot.store") }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="modal-create"
                    class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                    <div
                        class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                        <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                            <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                <h3 class="text-lg font-medium text-default-900 ">
                                    Thêm dữ liệu
                                </h3>
                                <button type="button" class="text-default-600 cursor-pointer"
                                    data-hs-overlay="#modal-create">
                                    <i class="i-tabler-x text-lg"></i>
                                </button>
                            </div>
                            <div class="p-3">
                                <label for="DataType" class="text-gray-700 text-sm font-semibold mb-2 block">
                                    Chọn loại dữ liệu
                                </label>
                                <select id="DataType" name="DataType" class="form-select" onchange="toggleDataTypeFields()">
                                    <option value="{{ $optionFile->CategoryID }}" {{ old('DataType') == $optionFile->CategoryID ? 'selected' : '' }}>
                                        {{ $optionFile->CategoryName }}
                                    </option>
                                    <option value="{{ $optionURL->CategoryID }}" {{ old('DataType') == $optionURL->CategoryID ? 'selected' : '' }}>
                                        {{ $optionURL->CategoryName }}
                                    </option>
                                </select>
                            </div>
                            <!-- lựa chon thêm file -->
                            <div id="file-fields" class="p-4">
                                <div class="mb-3">
                                    <label for="DocumentName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                        Tên file
                                    </label>
                                    @error('DocumentName', "create_file")
                                        <div id="DocumentName_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="text" id="DocumentName" name="DocumentName" value=""
                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        onfocus="document.getElementById('DocumentName_errorr')?.classList.add('hidden')">
                                </div>

                                <div class="mb-3">
                                    <label for="DocumentDesciption"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Mô tả file
                                    </label>
                                    @error('DocumentDesciption', "create_file")
                                        <div id="DocumentDesciption_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <textarea id="DocumentDesciption" name="DocumentDesciption" class="form-input"
                                        onfocus="document.getElementById('DocumentDesciption_errorr')?.classList.add('hidden')"></textarea>
                                </div>

                                <div class="mb-3" class="p-4">
                                    <label for="File" class="text-default-800 text-sm font-semibold mb-2 block">File PDF(Tối
                                        đa 2MB)</label>
                                    @error('File', "create_file")
                                        <div id="File_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="file" name="File" id="file" accept="application/pdf" class="form-input"
                                        value="" onfocus="document.getElementById('File_errorr')?.classList.add('hidden')">
                                    <div class="justify-center flex">
                                        <img id="preview-file_create" src="" alt="Image"
                                            class="hidden w-32 h-32 object-contain p-2">
                                    </div>
                                </div>
                            </div>
                            <!-- end phần lựa chọn thêm file -->

                            <!-- lựa chọn url -->
                            <div id="url-fields" class="hidden p-3">
                                <div class="mb-3">
                                    <label for="URLName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                        Tên đường dẫn
                                    </label>
                                    @error('URLName', "create_url")
                                        <div id="URLName_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="text" id="URLName" name="URLName" value=""
                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        onfocus="document.getElementById('URLName_errorr')?.classList.add('hidden')">
                                </div>
                                <div class="mb-3">
                                    <label for="LinkURL" class="text-gray-700 text-sm font-semibold mb-2 block">Nhập
                                        URL</label>
                                    @error('LinkURL', "create_url")
                                        <div id="LinkURL_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="url" id="LinkURL" name="LinkURL"
                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        onfocus="document.getElementById('LinkURL_errorr')?.classList.add('hidden')">
                                </div>


                                <div class="mb-3">
                                    <label for="DescriptionURL"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Mô tả đường dẫn
                                    </label>
                                    @error('DescriptionURL', "create_url")
                                        <div id="DocumentDesciption_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <textarea id="DescriptionURL" name="DescriptionURL" class="form-input"
                                        onfocus="document.getElementById('DescriptionURL_errorr')?.classList.add('hidden')"></textarea>
                                </div>
                            </div>
                            <!-- end phần lựa chọn url -->


                            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                <button type="button"
                                    class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                    data-hs-overlay="#modal-create">

                                    Đóng
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
            @if(!empty($dataList))
                @foreach($dataList as $data)
                    <form action="{{ route("admintrafficbot.chatbot.update", ["ID" => $data->ChatbotID]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="modal-edit_{{ $data->ChatbotID }}"
                            class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                            <div
                                class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                                <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                    <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                        <h3 class="text-lg font-medium text-default-900 ">
                                            Chỉnh sửa file
                                        </h3>
                                        <button type="button" class="text-default-600 cursor-pointer"
                                            data-hs-overlay="#modal-edit_{{ $data->ChatbotID }}">
                                            <i class="i-tabler-x text-lg"></i>
                                        </button>
                                    </div>
                                    <div class="p-4 overflow-y-auto">
                                        <div class="mb-3">
                                            <label for="FileName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                                Tên file
                                            </label>
                                            @error('FileName', "update")
                                                <div id="FileName_errorr"
                                                    class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <input type="text" id="FileName" name="DocumentName" value="{{ $data->FileName }}"
                                                class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                onfocus="document.getElementById('FileName_errorr')?.classList.add('hidden')">
                                        </div>

                                        <div class="mb-3">
                                            <label for="example-email"
                                                class="text-default-800 text-sm font-medium inline-block mb-2">
                                                Mô tả file</label>
                                            @error('FileDesciption', "update")
                                                <div id="FileDesciption_errorr"
                                                    class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <textarea type="text" id="FileDesciption" name="FileDesciption" class="form-input"
                                                onfocus="document.getElementById('FileDesciption_errorr')?.classList.add('hidden')">{{ $data->FileDesciption }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="File_errorr"
                                                class="text-default-800 text-sm font-semibold mb-2 block">File(PDF)</label>
                                            @error('File', "update")
                                                <div id="File_errorr"
                                                    class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <input type="text" name="oldFile" id="" hidden value="{{ $data->File }}">
                                            <input type="file" name="File" id="File" accept="application/pdf" class="form-input"
                                                value="" onfocus="document.getElementById('File_errorr')?.classList.add('hidden')">
                                            <div class="justify-center flex">
                                                <img id="preview-file_create" src="" alt="Image"
                                                    class="hidden w-32 h-32 object-contain p-2">
                                            </div>

                                        </div>

                                    </div>
                                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                        <button type="button"
                                            class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                            data-hs-overlay="#modal-edit_{{ $data->ChatbotID }}">
                                            Đóng
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

            <!-- modal delete -->
            @if(!empty($dataList))
                @foreach($dataList as $data)
                    <div id="modal_delete_{{ $data->ChatbotID }}"
                        class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none">
                        <div
                            class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                            <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                    <h3 class="text-lg font-medium text-default-900">
                                        xóa bộ đề
                                    </h3>
                                    <button type="button" class="text-default-600 cursor-pointer"
                                        data-hs-overlay="#modal_delete_{{ $data->ChatbotID }}">
                                        <i class="i-tabler-x text-lg"></i>
                                    </button>
                                </div>
                                <div class="p-4 overflow-y-auto">
                                    <p class="mt-1 text-default-600">
                                        Việc xóa sẽ gây ảnh hưởng đến các giấy phép khác,
                                        bạn có chắc muốn xóa bộ đề này ?
                                    </p>
                                </div>
                                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                    <button type="button"
                                        class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                        data-hs-overlay="#modal_delete_{{ $data->ChatbotID }}">

                                        Đóng
                                    </button>
                                    <form action="{{ route("admintrafficbot.chatbot.delete", ["ID" => $data->ChatbotID]) }}"
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
            <!-- end modal -->
        </div>

    </main>

@endsection

@section("footer")
    <script>
        function toggleDataTypeFields() {
            const selectedValue = document.getElementById('DataType').value;

            const fileCategoryID = "{{ $optionFile->CategoryID }}";
            const fileFields = document.getElementById('file-fields');
            const urlFields = document.getElementById('url-fields');

            if (selectedValue === fileCategoryID) {
                fileFields.classList.remove('hidden');
                urlFields.classList.add('hidden');
                document.getElementById("URLName").value = "";
                document.getElementById("LinkURL").value = "";
                document.getElementById("DescriptionURL").value = "";
            } else {
                document.getElementById("DocumentName").value = "";
                document.getElementById("DocumentDesciption").value = "";
                document.getElementById("file").value = "";
                fileFields.classList.add('hidden');
                urlFields.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleDataTypeFields();
        });
        @if($errors->create_file->any() || $errors->create_url->any())
            window.addEventListener("load", function () {
                setTimeout(function () {
                    document.getElementById("open_modal_create").click();
                    document.getElementById("DataType").value = "{{ old('DataType') }}";
                    toggleDataTypeFields();
                }, 300);
            });
        @endif

        @if($errors->update->any())
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
        @if(session("create_success"))
            iziToast.success({
                message: "{{ session("create_success") }}",
                position: "topRight"
            })
        @endif

        @if(session("create_fail"))
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
            iziToast.success({
                message: "{{ session("delete_fails") }}",
                position: "topRight"
            })
        @endif




        // document.getElementById("description_image").addEventListener("change", function (event) {
        //     const file = event.target.files[0];
        //     console.log(file)
        //     if (file) {
        //         const imageURL = URL.createObjectURL(file);
        //         console.log(imageURL);
        //         const imageElement = document.getElementById("preview-image");
        //         imageElement.src = imageURL;
        //         // imageElement.classList.remove("hidden")
        //     }
        // });


    </script>

@endsection