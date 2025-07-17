@extends("admin.adminPageLayout.layout")
@section("main")

    <main>
        <!-- Tiêu đề -->
        <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
            <h4 class="text-default-900 text-xl font-semibold">💬 Quản lý dữ liệu chatbot</h4>
        </div>

        <!-- Bảng dữ liệu -->
        <div class="card overflow-hidden border rounded-lg bg-white shadow">
            <div class="card-header flex justify-between items-center gap-2 px-4 py-3">
                <select name="" class="form-select w-48 text-sm">
                    <option value="chưa có giấy phép">update later</option>
                </select>

                <button id="open_modal_create" data-hs-overlay="#modal-create" data-fc-placement="bottom"
                    class="btn bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md shadow text-sm">
                    <i class="i-solar-plus-bold mr-1"></i> Thêm dữ liệu mới
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800">
                    <thead class="bg-gray-50 text-sm font-semibold text-gray-600">
                        <tr>

                            <th class="px-6 py-3 text-left">Tên file</th>
                            <th class="px-6 py-3 text-left">Loại dữ liệu</th>
                            <th class="px-6 py-3 text-left">Mô tả</th>
                            <th class="px-6 py-3 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($dataList as $data)
                            <tr>
                                <td class="px-6 py-4 break-words max-w-sm">
                                    {{ $data->DocumentName }}
                                </td>
                                <td class="px-6 py-4 break-words max-w-sm">
                                    {{ $data->category_Chatbot->CategoryName }}
                                </td>
                                <td class="px-6 py-4 break-words max-w-sm">
                                    {{ $data->DocumentDesciption }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <!-- Xem -->
                                        <a href="#" class="text-blue-500 hover:text-blue-700"
                                            data-hs-overlay="#show-detail-{{ $data->ChatbotID }}">
                                            <span class="material-symbols-rounded text-2xl">visibility</span>
                                        </a>

                                        <!-- Sửa -->
                                        <a id = "open_modal_edit_{{ $data->ChatbotID }}" href="#" class="text-yellow-500 hover:text-yellow-700"
                                            onclick="event.preventDefault()"
                                            data-hs-overlay="#modal-edit_{{ $data->ChatbotID }}">
                                            <span class="material-symbols-rounded text-2xl">edit</span>
                                        </a>

                                        <!-- Xóa -->
                                        <button  type="button" class="text-red-500 hover:text-red-700"
                                            data-hs-overlay="#modal_delete_{{ $data->ChatbotID }}">
                                            <span class="material-symbols-rounded text-2xl">delete_forever</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t px-6 py-4 bg-gray-50 flex items-center justify-between text-sm text-gray-700">
                <p>
                    Hiển thị <span class="font-semibold">{{ $dataList->firstItem() }}</span> →
                    <span class="font-semibold">{{ $dataList->lastItem() }}</span> /
                    <span class="font-semibold">{{ $dataList->total() }}</span>
                </p>

                <div class="flex gap-1">
                    @if($dataList->onFirstPage())
                        <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded border">Trước</span>
                    @else
                        <a href="{{ $dataList->previousPageUrl() }}"
                            class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">Trước</a>
                    @endif

                    @php
                        $start = max($dataList->currentPage() - 2, 1);
                        $end = min($dataList->currentPage() + 2, $dataList->lastPage());
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $dataList->url(1) }}"
                            class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">1</a>
                        @if ($start > 2)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $dataList->currentPage())
                            <span class="px-3 py-1 bg-blue-600 text-white rounded border">{{ $i }}</span>
                        @else
                            <a href="{{ $dataList->url($i) }}"
                                class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($end < $dataList->lastPage())
                        @if ($end < $dataList->lastPage() - 1)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                        <a href="{{ $dataList->url($dataList->lastPage()) }}"
                            class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">{{ $dataList->lastPage() }}</a>
                    @endif

                    @if($dataList->hasMorePages())
                        <a href="{{ $dataList->nextPageUrl() }}"
                            class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">Sau</a>
                    @else
                        <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded border">Sau</span>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- modal create -->
    <form action="{{ route('admintrafficbot.chatbot.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div id="modal-create"
            class="hs-overlay w-full h-full fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto hidden">
            <div
                class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r bg-primary p-6">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="ti ti-folder-plus text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-lg">Thêm dữ liệu</h3>
                                    <p class="text-white/80 text-sm">Chọn và nhập dữ liệu phù hợp bên dưới</p>
                                </div>
                            </div>
                            <button type="button"
                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                data-hs-overlay="#modal-create">
                                <i class="ti ti-x text-base"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="modal-scroll max-h-[60vh] overflow-y-auto p-6 space-y-6">
                        <!-- Chọn loại dữ liệu -->
                        <div>
                            <label for="DataType" class="block text-sm font-medium text-gray-700 mb-1">Chọn loại dữ
                                liệu</label>
                            <select id="DataType" name="DataType" class="form-select w-full"
                                onchange="toggleDataTypeFields()">
                                @if($optionFile->CategoryID == null && $optionURL->CategoryID == null)
                                    <option value="">chưa tồn tại</option>
                                @else
                                    <option value="{{ $optionFile->CategoryID }}" {{ old('DataType') == $optionFile->CategoryID ? 'selected' : '' }}>{{ $optionFile->CategoryName }}</option>
                                    <option value="{{ $optionURL->CategoryID }}" {{ old('DataType') == $optionURL->CategoryID ? 'selected' : '' }}>{{ $optionURL->CategoryName }}</option>
                                @endif
                            </select>
                        </div>

                        <!-- Dữ liệu File -->
                        <div id="file-fields">
                            <div class="mb-3">
                                <label for="DocumentName" class="block text-sm font-medium text-gray-700 mb-1">Tên
                                    file</label>
                                @error('DocumentName', 'create_file')
                                    <p id="DocumentName_errorr" class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                        {{ $message }}</p>
                                @enderror
                                <input type="text" id="DocumentName" name="DocumentName" class="form-input w-full"
                                    onfocus="document.getElementById('DocumentName_errorr')?.classList.add('hidden')">
                            </div>
                            <div class="mb-3">
                                <label for="DocumentDesciption" class="block text-sm font-medium text-gray-700 mb-1">Mô tả
                                    file</label>
                                @error('DocumentDesciption', 'create_file')
                                    <p id="DocumentDesciption_errorr"
                                        class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">{{ $message }}</p>
                                @enderror
                                <textarea id="DocumentDesciption" name="DocumentDesciption" class="form-input w-full"
                                    onfocus="document.getElementById('DocumentDesciption_errorr')?.classList.add('hidden')"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File PDF (Tối đa
                                    5MB)</label>
                                @error('File', 'create_file')
                                    <p id="File_errorr" class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                        {{ $message }}</p>
                                @enderror
                                <input type="file" name="File" id="file" accept="application/pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                    onfocus="document.getElementById('File_errorr')?.classList.add('hidden')">
                            </div>
                        </div>

                        <!-- Dữ liệu URL -->
                        <div id="url-fields" class="hidden">
                            <div class="mb-3">
                                <label for="URLName" class="block text-sm font-medium text-gray-700 mb-1">Tên đường
                                    dẫn</label>
                                @error('URLName', 'create_url')
                                    <p id="URLName_errorr" class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                        {{ $message }}</p>
                                @enderror
                                <input type="text" id="URLName" name="URLName" class="form-input w-full"
                                    onfocus="document.getElementById('URLName_errorr')?.classList.add('hidden')">
                            </div>
                            <div class="mb-3">
                                <label for="LinkURL" class="block text-sm font-medium text-gray-700 mb-1">Nhập URL</label>
                                @error('LinkURL', 'create_url')
                                    <p id="LinkURL_errorr" class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                        {{ $message }}</p>
                                @enderror
                                <input type="url" id="LinkURL" name="LinkURL" class="form-input w-full"
                                    onfocus="document.getElementById('LinkURL_errorr')?.classList.add('hidden')">
                            </div>
                            <div class="mb-3">
                                <label for="selectorURL" class="block text-sm font-medium text-gray-700 mb-1">Vị trí cần lấy
                                    dữ liệu (class hoặc ID)</label>
                                @error('selectorURL', 'create_url')
                                    <p id="selectorURL_errorr" class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                        {{ $message }}</p>
                                @enderror
                                <input type="text" id="selectorURL" name="selectorURL" class="form-input w-full"
                                    onfocus="document.getElementById('selectorURL_errorr')?.classList.add('hidden')">
                            </div>
                            <div class="mb-3">
                                <label for="DescriptionURL" class="block text-sm font-medium text-gray-700 mb-1">Mô tả đường
                                    dẫn</label>
                                @error('DescriptionURL', 'create_url')
                                    <p id="DescriptionURL_errorr" class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                        {{ $message }}</p>
                                @enderror
                                <textarea id="DescriptionURL" name="DescriptionURL" class="form-input w-full"
                                    onfocus="document.getElementById('DescriptionURL_errorr')?.classList.add('hidden')"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="border-t p-4 flex justify-end gap-3">
                        <button type="button"
                            class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                            data-hs-overlay="#modal-create">
                            Đóng
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                            Lưu
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
        @php
            $isOldModal = session("edit_chatbotID") == $data->ChatbotID;
            $dataType = $isOldModal ? old("DataType", $data->CategoryID) : $data->CategoryID;
        @endphp
            <form action="{{ route("admintrafficbot.chatbot.update", ["ID" => $data->ChatbotID]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="modal-edit_{{ $data->ChatbotID }}"
                    class="hs-overlay w-full h-full fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto hidden">
                    <div
                        class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                        <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">
                            <!-- Header -->
                            <div class="bg-gradient-to-r bg-primary p-6">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                            <i class="ti ti-folder-plus text-white text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-white text-lg">Chỉnh sửa dữ liệu</h3>
                                            <p class="text-white/80 text-sm">Chọn và nhập dữ liệu phù hợp bên dưới</p>
                                        </div>
                                    </div>
                                    <button type="button"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                        data-hs-overlay="#modal-edit_{{ $data->ChatbotID }}">
                                        <i class="ti ti-x text-base"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="modal-scroll max-h-[60vh] overflow-y-auto p-6 space-y-6">
                                @if($dataType == $optionFile->CategoryID)
                                <div id="update-file-fields">
                                    <div class="mb-3">
                                        <label for="DocumentName" class="block text-sm font-medium text-gray-700 mb-1">Loại dữ liệu</label>
                                        <input readonly type="text" id="" name="" class="form-input w-full" value="{{ $optionFile->CategoryName }}">
                                        <input readonly type="text" id="CategoryID" name="DataType" class="form-input w-full hidden" value="{{ $optionFile->CategoryID }}">

                                    </div>
                                    <div class="mb-3">
                                        <label for="DocumentName" class="block text-sm font-medium text-gray-700 mb-1">Tên
                                            file</label>
                                        @error('DocumentName', 'update_file')
                                            <p id="update_DocumentName_errors" class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                                {{ $message }}</p>
                                        @enderror
                                        <input type="text" id="DocumentName" name="DocumentName" class="form-input w-full" value="{{ $data->DocumentName }}"
                                            onfocus="document.getElementById('update_DocumentName_errors')?.classList.add('hidden')">
                                    </div>
                                    <div class="mb-3">
                                        <label for="DocumentDesciption" class="block text-sm font-medium text-gray-700 mb-1">Mô tả
                                            file</label>
                                        @error('DocumentDesciption', 'update_file')
                                            <p id="update_DocumentDesciption_errorr"
                                                class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">{{ $message }}</p>
                                        @enderror
                                        <textarea id="DocumentDesciption" name="DocumentDesciption" class="form-input w-full"
                                            onfocus="document.getElementById('update_DocumentDesciption_errorr')?.classList.add('hidden')">{{ $data->DocumentDesciption }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File PDF (Tối đa
                                            5MB)</label>
                                        @error('File', 'update_file')
                                            <p id="update_File_errorr" class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                                {{ $message }}</p>
                                        @enderror
                                        <input type="file" name="File" id="file" accept="application/pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                            onfocus="document.getElementById('update_File_errorr')?.classList.add('hidden')">
                                        <input type="text" class = "hidden" name = "oldFile" value="{{ $data->File }}">
                                    </div>
                                </div>
                                @elseif($dataType == $optionURL->CategoryID)
                                <!-- Dữ liệu URL -->
                                <div id="update-url-fields">
                                    <div class="mb-3">
                                        <label for="DocumentName" class="block text-sm font-medium text-gray-700 mb-1">Loại dữ liệu</label>
                                        <input readonly type="text" id="" name="" class="form-input w-full" value="{{ $optionURL->CategoryName }}">
                                        <input readonly type="text" id="dataType" name="DataType" class="hidden form-input w-full" value="{{ $optionURL->CategoryID }}">

                                    </div>
                                    <div class="mb-3">
                                        <label for="URLName" class="block text-sm font-medium text-gray-700 mb-1">Tên đường
                                            dẫn</label>
                                        @error('URLName', 'update_url')
                                            <p id="update_URLName_errorr" class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                                {{ $message }}</p>
                                        @enderror
                                        <input type="text" id="URLName" name="URLName" class="form-input w-full" value="{{ $data->DocumentName }}"
                                            onfocus="document.getElementById('update_URLName_errorr')?.classList.add('hidden')">
                                    </div>
                                    <div class="mb-3">
                                        <label for="LinkURL" class="block text-sm font-medium text-gray-700 mb-1">Nhập URL</label>
                                        @error('LinkURL', 'update_url')
                                            <p id="update_LinkURL_errorr" class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                                {{ $message }}</p>
                                        @enderror
                                        <input type="url" id="LinkURL" name="LinkURL" class="form-input w-full" value="{{ $data->LinkURL }}"
                                            onfocus="document.getElementById('update_LinkURL_errorr')?.classList.add('hidden')">
                                    </div>
                                    <div class="mb-3">
                                        <label for="selectorURL" class="block text-sm font-medium text-gray-700 mb-1">Vị trí cần lấy
                                            dữ liệu (class hoặc ID)</label>
                                        @error('selectorURL', 'update_url')
                                            <p id="update_selectorURL_errorr" class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                                {{ $message }}</p>
                                        @enderror
                                        <input type="text" id="selectorURL" name="selectorURL" class="form-input w-full" value="{{ $data->SelectorURL }}"
                                            onfocus="document.getElementById('update_selectorURL_errorr')?.classList.add('hidden')">
                                    </div>
                                    <div class="mb-3">
                                        <label for="DescriptionURL" class="block text-sm font-medium text-gray-700 mb-1">Mô tả đường
                                            dẫn</label>
                                        @error('DescriptionURL', 'update_url')
                                            <p id="update_DescriptionURL_errorr" class="text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                                {{ $message }}</p>
                                        @enderror
                                        <textarea id="DescriptionURL" name="DescriptionURL" class="form-input w-full"
                                            onfocus="document.getElementById('update_DescriptionURL_errorr')?.classList.add('hidden')">{{ $data->DocumentDesciption }}</textarea>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="border-t p-4 flex justify-end gap-3">
                                <button type="button"
                                    class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                    data-hs-overlay="#modal-edit_{{ $data->ChatbotID }}">
                                    Đóng
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
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


    <!-- modal show -->
  @if(!empty($dataList))
        @foreach($dataList as $data)
                <div id="show-detail-{{ $data->ChatbotID }}"
                    class="hs-overlay w-full h-full fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto hidden">
                    <div
                        class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                        <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">
                            <!-- Header -->
                            <div class="bg-gradient-to-r bg-primary p-6">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                            <i class="ti ti-folder-plus text-white text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-white text-lg">Chi tiết dữ liệu</h3>
                                            <p class="text-white/80 text-sm">Thông tin chi tiết dữ liệu chatbot</p>
                                        </div>
                                    </div>
                                    <button type="button"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                        data-hs-overlay="#show-detail-{{ $data->ChatbotID }}">
                                        <i class="ti ti-x text-base"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Body -->
                            <div class="modal-scroll max-h-[60vh] overflow-y-auto p-6 space-y-6">
                                @if($data->CategoryID == $optionFile->CategoryID)
                                <div id="update-file-fields">
                                    <div class="mb-3">
                                        <label for="DocumentName" class="block text-sm font-medium text-gray-700 mb-1">Loại dữ liệu</label>
                                        <input readonly type="text" id="" name="" class="form-input w-full" value="{{ $optionFile->CategoryName }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="DocumentName" class="block text-sm font-medium text-gray-700 mb-1">Tên
                                            file</label>
                                        <input readonly type="text" id="DocumentName" name="DocumentName" class="form-input w-full" value="{{ $data->DocumentName }}"  >
                                    </div>
                                    <div class="mb-3">
                                        <label for="DocumentDesciption" class="block text-sm font-medium text-gray-700 mb-1">Mô tả
                                            file</label>
                                        <textarea readonly id="DocumentDesciption" name="DocumentDesciption" class="form-input w-full" >{{ $data->DocumentDesciption }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Tên file</label>
                                        <input readonly type="text" name="File" id="file" accept="application/pdf" class="form-input w-full"  value="{{ $data->File }}">
                                    </div>
                                </div>
                                @elseif($data->CategoryID == $optionURL->CategoryID)
                                <!-- Dữ liệu URL -->
                                <div id="update-url-fields">
                                    <div class="mb-3">
                                        <label for="DocumentName" class="block text-sm font-medium text-gray-700 mb-1">Loại dữ liệu</label>
                                        <input readonly type="text" id="" name="" class="form-input w-full" value="{{ $optionURL->CategoryName }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="URLName" class="block text-sm font-medium text-gray-700 mb-1">Tên đường
                                            dẫn</label>
                                        <input readonly type="text" id="URLName" name="URLName" class="form-input w-full" value="{{ $data->DocumentName }}"  >
                                    </div>
                                    <div class="mb-3">
                                        <label for="LinkURL" class="block text-sm font-medium text-gray-700 mb-1">Nhập URL</label>
                                        <input readonly type="url" id="LinkURL" name="LinkURL" class="form-input w-full" value="{{ $data->LinkURL }}" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="selectorURL" class="block text-sm font-medium text-gray-700 mb-1">Vị trí cần lấy
                                            dữ liệu (class hoặc ID)</label>
                                        
                                        <input readonly type="text" id="selectorURL" name="selectorURL" class="form-input w-full" value="{{ $data->SelectorURL }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="DescriptionURL" class="block text-sm font-medium text-gray-700 mb-1">Mô tả đường
                                            dẫn</label>
                                      
                                        <textarea readonly id="DescriptionURL" name="DescriptionURL" class="form-input w-full">{{ $data->DocumentDesciption }}</textarea>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="border-t p-4 flex justify-end gap-3">
                                <button type="button"
                                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors"
                                    data-hs-overlay="#show-detail-{{ $data->ChatbotID }}">
                                    Đóng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endforeach
    @endif

    <!-- end modal show -->
    

    <!-- modal delete -->
    @if(!empty($dataList))
        @foreach($dataList as $data)
            <div id="modal_delete_{{ $data->ChatbotID }}"
                class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
                <div
                    class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                    <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">

                        <!-- Header -->
                        <div class="bg-gradient-to-r bg-red-600 p-6">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                        <i class="ti ti-alert-triangle   text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-white text-lg">Xác nhận xóa</h3>
                                        <p class="text-white/80 text-sm">Bạn có chắc muốn xóa dữ liệu này?</p>
                                    </div>
                                </div>
                                <button type="button"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                    data-hs-overlay="#modal_delete_{{ $data->ChatbotID }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="p-6 space-y-4 text-center">
                            <p class="text-gray-700 text-sm">Bạn có chắc chắn muốn xóa dữ liệu này
                                này không? Hành động này không thể hoàn tác.
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
                            <button type="button"
                                class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                data-hs-overlay="#modal_delete_{{ $data->ChatbotID }}">
                                Hủy
                            </button>

                            <form action="{{ route("admintrafficbot.chatbot.delete", ["ID" => $data->ChatbotID]) }}" method="post">
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
    <!-- end modal -->

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

        @if($errors->update_file->any() || $errors->update_url->any() && session("edit_chatbotID"))
            window.addEventListener("load", function () {
                setTimeout(function () {
                    const modalID = "open_modal_edit_{{ session("edit_chatbotID") }}"
                    document.getElementById(modalID).click()
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