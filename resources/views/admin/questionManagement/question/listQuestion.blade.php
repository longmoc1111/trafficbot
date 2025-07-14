@extends("admin.adminPageLayout.layout")
@section("title", "Quản lý câu hỏi")
@section("main")
    <main>
        <!-- tiu đề -->
        <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
            <h4 class="text-default-900 text-xl font-semibold">📚 Danh sách câu hỏi</h4>
            <a href="{{ route('admintrafficbot.question.create') }}"
                class="btn bg-blue-600 text-white hover:bg-blue-700 text-sm px-4 py-2 rounded-md shadow">
                <i class="i-solar-plus-bold mr-1"></i> Thêm câu hỏi mới
            </a>
        </div>

        
        <div class="card p-4 mb-6 shadow border rounded-lg bg-white">
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <!-- search -->
                <form action="{{ route("admintrafficbot.question.search") }}" class="relative w-full md:w-1/2">
                    <input type="search" name="search" placeholder="🔍 Tìm kiếm câu hỏi..."
                        class="form-input w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400">
                </form>

                <!-- lọc -->
                <form action="" class="w-full md:w-1/3">
                    <select name="category" onchange="this.form.submit()"
                        class="form-select w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400">
                        @foreach($questionCategory as $category)
                            <option value="{{ $category->CategoryID }}" {{ !empty($categoryKey) && $categoryKey == $category->CategoryID ? 'selected' : '' }}>
                                {{ $category->CategoryName }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

      
        <div class="card p-0 overflow-hidden shadow border rounded-lg bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-left text-sm font-semibold text-gray-600">
                        <tr>
                            <th class="px-6 py-3">Tên câu hỏi</th>
                            <th class="px-6 py-3">Phân loại</th>
                            <th class="px-6 py-3">Câu điểm liệt</th>
                            <th class="px-6 py-3 text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        @foreach($Questions as $question)
                            <tr>
                                <td class="px-6 py-4 max-w-[300px] whitespace-normal">
                                    {{ $question->QuestionName }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ optional($question->categoryQuestion_Question)->CategoryName ?? 'Chưa phân loại' }}
                                </td>
                                @php
                                    $hasCritical = $question->licenseType_Question->contains(fn($license) => $license->pivot->IsCritical == 1);
                                @endphp
                                <td class="px-6 py-4">
                                    @if($hasCritical)
                                        <span class="inline-block px-2 py-1 bg-red-100 text-red-600 rounded text-xs">Có</span>
                                    @else
                                        <span
                                            class="inline-block px-2 py-1 bg-green-100 text-green-600 rounded text-xs">Không</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-end">
                                    <div class="flex justify-end gap-2">
                                        
                                        <button data-hs-overlay="#modal-detail-{{ $question->QuestionID }}"
                                            class="text-blue-600 hover:text-blue-800" title="Xem chi tiết">
                                            <span class="material-symbols-rounded text-2xl">visibility</span>
                                        </button>

                                        <a href="{{ route("admintrafficbot.question.edit", $question->QuestionID) }}"
                                            class="text-yellow-500 hover:text-yellow-700" title="Chỉnh sửa">
                                            <span class="material-symbols-rounded text-2xl">edit</span>
                                        </a>

                                        <button data-hs-overlay="#modal-delete-{{ $question->QuestionID }}"
                                            class="text-red-500 hover:text-red-700" title="Xóa vĩnh viễn">
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
                    <span class="font-medium">{{ $Questions->firstItem() }}</span> -
                    <span class="font-medium">{{ $Questions->lastItem() }}</span>
                    / <span class="font-medium">{{ $Questions->total() }}</span> câu hỏi
                </p>
                <div class="flex items-center space-x-1">
                    {{-- Trước --}}
                    @if($Questions->onFirstPage())
                        <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border">Trước</span>
                    @else
                        <a href="{{ $Questions->previousPageUrl() }}"
                            class="px-3 py-1 bg-white text-gray-700 hover:bg-gray-100 rounded border">Trước</a>
                    @endif

                    {{-- Trang --}}
                    @for($page = max(1, $Questions->currentPage() - 2); $page <= min($Questions->lastPage(), $Questions->currentPage() + 2); $page++)
                        @if($page == $Questions->currentPage())
                            <span class="px-3 py-1 bg-blue-600 text-white rounded border">{{ $page }}</span>
                        @else
                            <a href="{{ $Questions->url($page) }}"
                                class="px-3 py-1 bg-white text-gray-700 hover:bg-gray-100 rounded border">{{ $page }}</a>
                        @endif
                    @endfor

                    {{-- Sau --}}
                    @if($Questions->hasMorePages())
                        <a href="{{ $Questions->nextPageUrl() }}"
                            class="px-3 py-1 bg-white text-gray-700 hover:bg-gray-100 rounded border">Sau</a>
                    @else
                        <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border">Sau</span>
                    @endif
                </div>
            </div>
        </div>
    </main>

    



    <!-- end modal -->

    <!-- modal delete -->
    @if(isset($Questions))
        @foreach ($Questions as $question)
          
    <div id="modal-delete-{{ $question->QuestionID }}"
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
                            data-hs-overlay="#modal-delete-{{ $question->QuestionID }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-6 space-y-4 text-center">
                    <p class="text-gray-700 text-sm">Bạn có chắc chắn muốn <strong>xóa</strong> câu hỏi này
                     không? Hành động này không thể hoàn tác.
                    </p>
                </div>

                <!-- Footer -->
                <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
                    <button type="button"
                        class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                        data-hs-overlay="#modal-delete-{{ $question->QuestionID }}">
                        Hủy
                    </button>

                    <form
                        action="{{ route("admintrafficbot.question.delete", $question->QuestionID) }}"
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
    <!-- end modal -->
    @foreach($Questions as $question)
        <div id="modal-detail-{{ $question->QuestionID }}"
            class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
            <div
                class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-3xl sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">

                    <!-- Header -->
                    <div class="bg-gradient-to-r bg-indigo-600 p-6">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="i-solar-document-bold-duotone text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-lg">Xem chi tiết câu hỏi</h3>
                                    <p class="text-white/80 text-sm">Thông tin và đáp án câu hỏi</p>
                                </div>
                            </div>
                            <button type="button"
                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                data-hs-overlay="#modal-detail-{{ $question->QuestionID }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                        <!-- Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                                <p class="text-blue-600 font-medium text-sm">Thuộc giấy phép</p>
                                <p class="text-gray-900 font-semibold">
                                    {{ $question->licenseType_Question->isNotEmpty() ? $question->licenseType_Question->pluck("LicenseTypeName")->join(", ") : "Chưa thuộc giấy phép" }}
                                </p>
                            </div>

                            <div class="bg-green-50 border border-green-100 rounded-lg p-4">
                                <p class="text-green-600 font-medium text-sm">Thuộc bộ đề</p>
                                <p class="text-gray-900 font-semibold">
                                    {{ $question->examSet_Question->isNotEmpty() ? $question->examSet_Question->pluck("ExamSetName")->join(", ") : "Chưa nằm trong bộ đề nào" }}
                                </p>
                            </div>
                        </div>

                        <!-- Question -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Câu hỏi:</h4>
                            <p class="text-gray-900">{{ $question->QuestionName }}</p>
                        </div>

                        <!-- Image -->
                        @if(isset($question->ImageDescription))
                            <div class="flex justify-center">
                                <img src="/assets/adminPage/imageQuestion/{{ $question->ImageDescription }}" alt="Ảnh câu hỏi"
                                    class="rounded-lg max-w-xs border">
                            </div>
                        @endif

                        <!-- Answers -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Đáp án:</h4>
                            <ul class="space-y-3">
                                @foreach (["A", "B", "C", "D"] as $label)
                                    @php
                                        $answerlabel = $answer[$label]->AnswerLabel ?? null;
                                        $answerName = $answer[$label]->AnswerName ?? null;
                                    @endphp
                                    @if($answerName)
                                        <li
                                            class="flex items-center justify-between p-3 rounded-md border
                                                                    {{ $correctAnswer == $answerlabel ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                                            <div class="text-sm text-gray-800 font-medium">
                                                {{ $label }}. {{ $answerName }}
                                            </div>
                                            <div>
                                                @if($correctAnswer == $answerlabel)
                                                    <i class="text-green-600 material-symbols-rounded text-xl">done</i>
                                                @else
                                                    <i class="text-red-500 material-symbols-rounded text-xl">close</i>
                                                @endif
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="border-t bg-gray-50 p-4 flex justify-end">
                        <button type="button"
                            class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                            data-hs-overlay="#modal-detail-{{ $question->QuestionID }}">
                            Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


@endsection

@section("footer")

@endsection


@section("izitoast")
    <script>
        @if(session("delete_question"))
            iziToast.success({
                message: "{{ session("delete_question") }}",
                position: "topRight"
            })
        @endif

        @if(session("err_delete_question"))
            iziToast.warning({
                message: "{{ session("err_delete_question") }}",
                position: "topRight"
            })
        @endif
        @if(session("add_question"))
            iziToast.success({
                message: "{{ session("add_question") }}",
                position: "topRight"
            })
        @endif
        @if(session("update_question"))
            iziToast.success({
                message: "{{ session("update_question") }}",
                position: "topRight"
            })
        @endif

    </script>

@endsection