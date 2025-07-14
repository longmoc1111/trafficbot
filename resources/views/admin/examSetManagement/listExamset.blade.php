@extends("admin.adminPageLayout.layout")
@section("main")

   <main>
    <!-- Tiêu đề trang -->
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <h4 class="text-default-900 text-xl font-semibold">📋 Danh sách bộ đề</h4>

        @if(!empty($LicenseType->LicenseTypeID))
            <a href="{{ route("admintrafficbot.examset.create", ["ID" => $LicenseType->LicenseTypeID]) }}"
                class="btn bg-blue-600 text-white hover:bg-blue-700 text-sm px-4 py-2 rounded-md shadow">
                <i class="i-solar-plus-bold mr-1"></i> Thêm bộ đề
            </a>
        @else
            <a href="#" class="btn bg-blue-600 text-white hover:bg-blue-700 text-sm px-4 py-2 rounded-md shadow">
                <i class="i-solar-plus-bold mr-1"></i> Thêm bộ đề
            </a>
        @endif
    </div>

    <!-- Bộ lọc -->
    <div class="card p-4 mb-6 shadow border rounded-lg bg-white">
        @if(!empty($selectLicenseTypes))
            <form action="{{ route("admintrafficbot.examset")}}" method="get" class="w-full md:w-1/2">
                <select name="choose_License" onchange="this.form.submit()"
                    class="form-select w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400">
                    @foreach ($selectLicenseTypes as $license)
                        <option value="{{ $license->LicenseTypeID }}"
                            {{ isset($LicenseType) && $license->LicenseTypeName == $LicenseType->LicenseTypeName ? "selected" : "" }}>
                            Hạng {{ $license->LicenseTypeName }}
                        </option>
                    @endforeach
                </select>
            </form>
        @else
            <select name="" class="form-select w-full md:w-1/2" disabled>
                <option value="">Chưa có giấy phép</option>
            </select>
        @endif
    </div>

    <!-- Bảng danh sách bộ đề -->
    <div class="card p-0 overflow-hidden shadow border rounded-lg bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-left text-sm font-semibold text-gray-600">
                    <tr>
                        <th class="px-6 py-3">Tên bộ đề</th>
                        <th class="px-6 py-3">Sử dụng cho</th>
                        <th class="px-6 py-3">Số lượng câu hỏi</th>
                        <th class="px-6 py-3 text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @foreach ($examSet as $exam)
                        <tr>
                            <td class="px-6 py-4 whitespace-normal max-w-[300px]">
                                {{ $exam->ExamSetName }}
                            </td>
                            <td class="px-6 py-4">
                                hạng {{ $exam->licenseType_examset->pluck("LicenseTypeName")->join(", ") }}
                            </td>
                            <td class="px-6 py-4">
                                {{ count($exam->question_Examset) }}/{{ $exam->licenseType_Examset->pluck("LicenseTypeQuantity")->first() }}
                            </td>
                            <td class="px-6 py-4 text-end">
                                <div class="flex justify-end gap-2">
                                    <!-- Xem -->
                                    <a href="{{ route('admintrafficbot.examset.show', $exam->ExamSetID) }}"
                                        class="text-blue-600 hover:text-blue-800" title="Xem chi tiết">
                                        <span class="material-symbols-rounded text-2xl">arrow_right_alt</span>
                                    </a>

                                    <!-- Sửa -->
                                    <a href="{{ route('admintrafficbot.examset.edit', $exam->ExamSetID) }}"
                                        class="text-yellow-500 hover:text-yellow-700" title="Chỉnh sửa">
                                        <span class="material-symbols-rounded text-2xl">edit</span>
                                    </a>

                                    <!-- Xóa -->
                                    <button type="button" class="text-red-500 hover:text-red-700"
                                        data-hs-overlay="#modal-{{ $exam->ExamSetID }}" title="Xóa vĩnh viễn">
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
        <div class="border-t bg-gray-50 px-6 py-4 flex items-center justify-between text-sm">
            <p class="text-gray-600">
                Hiển thị <span class="font-semibold">{{ $examSet->firstItem() }}</span> →
                <span class="font-semibold">{{ $examSet->lastItem() }}</span>
                / <span class="font-semibold">{{ $examSet->total() }}</span>
            </p>
            <div class="flex items-center space-x-1">
                {{-- Trước --}}
                @if($examSet->onFirstPage())
                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border">Trước</span>
                @else
                    <a href="{{ $examSet->previousPageUrl() }}"
                        class="px-3 py-1 bg-white text-gray-700 hover:bg-gray-100 rounded border">Trước</a>
                @endif

                {{-- Trang --}}
                @for($page = max(1, $examSet->currentPage() - 2); $page <= min($examSet->lastPage(), $examSet->currentPage() + 2); $page++)
                    @if($page == $examSet->currentPage())
                        <span class="px-3 py-1 bg-blue-600 text-white rounded border">{{ $page }}</span>
                    @else
                        <a href="{{ $examSet->url($page) }}"
                            class="px-3 py-1 bg-white text-gray-700 hover:bg-gray-100 rounded border">{{ $page }}</a>
                    @endif
                @endfor

                {{-- Sau --}}
                @if($examSet->hasMorePages())
                    <a href="{{ $examSet->nextPageUrl() }}"
                        class="px-3 py-1 bg-white text-gray-700 hover:bg-gray-100 rounded border">Sau</a>
                @else
                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border">Sau</span>
                @endif
            </div>
        </div>
    </div>
</main>

 <!-- modal -->
            @if(isset($examSet))
                @foreach ($examSet as $exam)
                    <div id="modal-{{ $exam->ExamSetID }}"
                        class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none">
                        <div
                            class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                            <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                    <h3 class="text-lg font-medium text-default-900">
                                        xóa bộ đề
                                    </h3>
                                    <button type="button" class="text-default-600 cursor-pointer"
                                        data-hs-overlay="#modal-{{ $exam->ExamSetID }}">
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
                                        data-hs-overlay="#modal-{{ $exam->ExamSetID }}">
                                        <i class="i-tabler-x me-1"></i>
                                        Thoát
                                    </button>
                                    <form action="{{ route("admintrafficbot.examset.delete", $exam->ExamSetID) }}" method="post">
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
@endsection

@section("footer")
@endsection

@section("izitoast")
    <script>
        @if(session("update_success"))
            iziToast.success({
                message: "{{ session("update_success") }}",
                position: "topRight"
            })
        @endif

        @if(session("add_examset"))
            iziToast.success({
                message: "{{ session("add_examset") }}",
                position: "topRight"
            })
        @endif
        @if(session("delete_exam"))
            iziToast.success({
                message: "{{ session("delete_exam") }}",
                position: "topRight"
            })
        @endif
    </script>

@endsection