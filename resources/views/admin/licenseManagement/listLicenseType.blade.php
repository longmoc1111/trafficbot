@extends("admin.adminPageLayout.layout")
@section("title", "Quản lý giấy phép")
@section("main")


    <main>
        <!-- Tiêu đề -->
        <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
            <h4 class="text-default-900 text-xl font-semibold">📝 Quản lý giấy phép</h4>
            <a href="{{ route('admintrafficbot.licensetype.create') }}"
                class="btn bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md shadow text-sm">
                <i class="i-solar-plus-bold mr-1"></i> Thêm giấy phép
            </a>
        </div>

        <!-- Bảng danh sách -->
        <div class="card overflow-hidden border rounded-lg bg-white shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800">
                    <thead class="bg-gray-50 text-sm font-semibold text-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left">Tên giấy phép</th>
                            <th class="px-6 py-3 text-left">Thời gian thi</th>
                            <th class="px-6 py-3 text-left">Số câu hỏi</th>
                            <th class="px-6 py-3 text-left">Yêu cầu đúng</th>
                            <th class="px-6 py-3 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($ListLicenseType as $licensetype)
                            <tr>
                                <td class="px-6 py-4 font-medium">{{ $licensetype->LicenseTypeName }}</td>
                                <td class="px-6 py-4">{{ $licensetype->LicenseTypeDuration }} phút</td>
                                <td class="px-6 py-4">{{ $licensetype->LicenseTypeQuantity }} câu</td>
                                <td class="px-6 py-4">{{ $licensetype->LicenseTypePassCount }} câu</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <!-- Xem -->
                                        <a href="#" class="text-blue-500 hover:text-blue-700"
                                            data-hs-overlay="#modal_show_{{ $licensetype->LicenseTypeID }}">
                                            <span class="material-symbols-rounded text-2xl">visibility</span>
                                        </a>

                                        <!-- Sửa -->
                                        <a href="{{ route('admintrafficbot.licensetype.edit', ['ID' => $licensetype->LicenseTypeID]) }}"
                                            class="text-yellow-500 hover:text-yellow-700">
                                            <span class="material-symbols-rounded text-2xl">edit</span>
                                        </a>

                                        <!-- Xóa -->
                                        <button type="button" class="text-red-500 hover:text-red-700"
                                            data-hs-overlay="#modal_delete_{{ $licensetype->LicenseTypeID }}">
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
                    Hiển thị <span class="font-semibold">{{ $ListLicenseType->firstItem() }}</span> →
                    <span class="font-semibold">{{ $ListLicenseType->lastItem() }}</span> /
                    <span class="font-semibold">{{ $ListLicenseType->total() }}</span>
                </p>

                <div class="flex gap-1">
                    @if($ListLicenseType->onFirstPage())
                        <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded border">Trước</span>
                    @else
                        <a href="{{ $ListLicenseType->previousPageUrl() }}"
                            class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">Trước</a>
                    @endif

                    @php
                        $start = max($ListLicenseType->currentPage() - 2, 1);
                        $end = min($ListLicenseType->currentPage() + 2, $ListLicenseType->lastPage());
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $ListLicenseType->url(1) }}"
                            class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">1</a>
                        @if ($start > 2)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $ListLicenseType->currentPage())
                            <span class="px-3 py-1 bg-blue-600 text-white rounded border">{{ $i }}</span>
                        @else
                            <a href="{{ $ListLicenseType->url($i) }}"
                                class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($end < $ListLicenseType->lastPage())
                        @if ($end < $ListLicenseType->lastPage() - 1)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                        <a href="{{ $ListLicenseType->url($ListLicenseType->lastPage()) }}"
                            class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">{{ $ListLicenseType->lastPage() }}</a>
                    @endif

                    @if($ListLicenseType->hasMorePages())
                        <a href="{{ $ListLicenseType->nextPageUrl() }}"
                            class="px-3 py-1 bg-white text-gray-700 rounded border hover:bg-gray-50">Sau</a>
                    @else
                        <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded border">Sau</span>
                    @endif
                </div>
            </div>
        </div>


    </main>
    <!-- modal show -->
    @if(!empty($ListLicenseType))
        @foreach ($ListLicenseType as $licensetype)
            <div id="modal_show_{{ $licensetype->LicenseTypeID }}"
                class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
                <div
                    class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-xl sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                    <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">

                        <!-- Header -->
                        <div class="bg-gradient-to-r bg-indigo-600 p-6">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                        <i class="ti ti-eye text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-white text-lg">Chi tiết giấy phép</h3>
                                        <p class="text-white/80 text-sm">Thông tin giấy phép hiện tại</p>
                                    </div>
                                </div>
                                <button type="button"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                    data-hs-overlay="#modal_show_{{ $licensetype->LicenseTypeID }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                            @php
                                $fields = [
                                    ['name' => 'LicenseTypeName', 'label' => 'Tên giấy phép', 'value' => $licensetype->LicenseTypeName],
                                    ['name' => 'LicenseTypeDescription', 'label' => 'Mô tả giấy phép', 'value' => $licensetype->LicenseTypeDescription, 'type' => 'textarea'],
                                    ['name' => 'LicenseTypeDuration', 'label' => 'Thời gian thi (phút)', 'value' => $licensetype->LicenseTypeDuration],
                                    ['name' => 'LicenseTypeQuantity', 'label' => 'Số lượng câu hỏi', 'value' => $licensetype->LicenseTypeQuantity],
                                    ['name' => 'LicenseTypePassCount', 'label' => 'Số câu đúng tối thiểu', 'value' => $licensetype->LicenseTypePassCount],
                                ];
                            @endphp

                            @foreach ($fields as $field)
                                <div>
                                    <label for="{{ $field['name'] }}" class="text-gray-700 text-sm font-medium mb-1 block">
                                        {{ $field['label'] }}
                                    </label>
                                    @if (($field['type'] ?? 'text') === 'textarea')
                                        <textarea readonly id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                            rows="3">{{ $field['value'] }}</textarea>
                                    @else
                                        <input readonly type="text" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                                            value="{{ $field['value'] }}"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" />
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Footer -->
                        <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
                            <button type="button"
                                class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                data-hs-overlay="#modal_show_{{ $licensetype->LicenseTypeID }}">
                                Đóng
                            </button>
                            <a href="{{ route('admintrafficbot.licensetype.edit', $licensetype->LicenseTypeID) }}"
                                class="px-4 py-2 text-sm font-semibold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-colors">
                                Chỉnh sửa
                            </a>
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
                                <p class="text-white/80 text-sm">Bạn có chắc muốn xóa hạng giấy phép này?</p>
                            </div>
                        </div>
                        <button type="button"
                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                            data-hs-overlay="#modal_delete_{{ $licensetype->LicenseTypeID }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-6 space-y-4 text-center">
                    <p class="text-gray-700 text-sm">Bạn có chắc chắn muốn xóa hạng giấy phép {{ $licensetype->LicenseTypeName }} này
                     không? Hành động này không thể hoàn tác.
                    </p>
                </div>

                <!-- Footer -->
                <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
                    <button type="button"
                        class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                        data-hs-overlay="#modal_delete_{{ $licensetype->LicenseTypeID }}">
                        Hủy
                    </button>

                    <form
                        action="{{ route("admintrafficbot.licensetype.delete", ["ID" => $licensetype->LicenseTypeID]) }}"
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
    <!-- end modal delete -->


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