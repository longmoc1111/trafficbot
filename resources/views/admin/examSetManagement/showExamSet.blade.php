@extends("admin.adminPageLayout.layout")
@section("main")

  <main>
    <!-- Tiêu đề trang -->
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <h4 class="text-default-900 text-xl font-semibold">📄 Danh sách câu hỏi</h4>
        <div>
             <!-- <a href="{{ route('admintrafficbot.examset_question.create', $ExamSetID->ExamSetID) }}"
            class="btn bg-red-500 text-white hover:bg-red-700 text-sm px-4 py-2 rounded-md shadow">
            <i class="i-solar-plus-bold mr-1"></i> Xóa toàn bộ
        </a> -->
            <a href="{{ route('admintrafficbot.examset_question.create', $ExamSetID->ExamSetID) }}"
            class="btn bg-blue-600 text-white hover:bg-blue-700 text-sm px-4 py-2 rounded-md shadow">
            <i class="i-solar-plus-bold mr-1"></i> Tạo 
        </a>
       
        </div>
        
       
    </div>

    <!-- Bảng danh sách câu hỏi -->
    <div class="card p-0 overflow-hidden shadow border rounded-lg bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-left text-sm font-semibold text-gray-600">
                    <tr>
                        <th class="px-6 py-3">Tên câu hỏi</th>
                        <th class="px-6 py-3">Loại câu hỏi</th>
                        <th class="px-6 py-3">Câu điểm liệt</th>
                        <th class="px-6 py-3 text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @foreach ($questions as $question)
                        <tr>
                            <td class="px-6 py-4 whitespace-normal max-w-[300px]">
                                {{ $question->QuestionName }}
                            </td>
                            <td class="px-6 py-4 whitespace-normal max-w-[250px]">
                                {{ $question->categoryQuestion_Question->CategoryName ?? 'Chưa thuộc loại câu hỏi nào' }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $hasCritical = collect($question->licenseType_Question)->contains(fn($license) => $license->pivot->IsCritical == 1);
                                @endphp
                                @if($hasCritical)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded">có</span>
                                @else
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">không</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-end">
                                <div class="flex justify-end gap-2">
                                    <!-- Xem -->
                                    <a href="{{ route('admintrafficbot.question.detail', $question->QuestionID) }}"
                                        class="text-blue-600 hover:text-blue-800" title="Xem chi tiết">
                                        <span class="material-symbols-rounded text-2xl">visibility</span>
                                    </a>
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
               Hiển thị <span class="font-semibold">{{ $questions->firstItem() }}</span> →
                <span class="font-semibold">{{ $questions->lastItem() }}</span>
                / <span class="font-semibold">{{ $questions->total() }}</span> 
            </p>
            <div class="flex items-center space-x-1">
                {{-- Trước --}}
                @if($questions->onFirstPage())
                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border">Trước</span>
                @else
                    <a href="{{ $questions->previousPageUrl() }}"
                        class="px-3 py-1 bg-white text-gray-700 hover:bg-gray-100 rounded border">Trước</a>
                @endif

                {{-- Trang --}}
                @for($page = max(1, $questions->currentPage() - 2); $page <= min($questions->lastPage(), $questions->currentPage() + 2); $page++)
                    @if($page == $questions->currentPage())
                        <span class="px-3 py-1 bg-blue-600 text-white rounded border">{{ $page }}</span>
                    @else
                        <a href="{{ $questions->url($page) }}"
                            class="px-3 py-1 bg-white text-gray-700 hover:bg-gray-100 rounded border">{{ $page }}</a>
                    @endif
                @endfor

                {{-- Sau --}}
                @if($questions->hasMorePages())
                    <a href="{{ $questions->nextPageUrl() }}"
                        class="px-3 py-1 bg-white text-gray-700 hover:bg-gray-100 rounded border">Sau</a>
                @else
                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border">Sau</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Xóa -->
    @if(isset($ExamSetID))
        @foreach ($ExamSetID->question_ExamSet as $question)
            <div id="modal-{{ $question->QuestionID }}"
                class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                <div class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                    <div class="flex flex-col border border-default-200 shadow-sm rounded-lg pointer-events-auto">
                        <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                            <h3 class="text-lg font-medium text-default-900">Xác nhận</h3>
                            <button type="button" class="text-default-600" data-hs-overlay="#modal-{{ $question->QuestionID }}">
                                <i class="i-tabler-x text-lg"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            <p class="text-default-600">Bạn có chắc muốn xóa câu hỏi này?</p>
                        </div>
                        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                            <button type="button"
                                class="py-2 px-5 border text-sm text-primary border-primary hover:bg-primary hover:text-white rounded-md"
                                data-hs-overlay="#modal-{{ $question->QuestionID }}">
                                <i class="i-tabler-x mr-1"></i> Thoát
                            </button>
                            <form action="{{ route('admintrafficbot.question.delete', $question->QuestionID) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="py-2 px-5 text-sm bg-red-600 text-white hover:bg-red-700 rounded-md">
                                    Đồng ý
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</main>


@endsection

@section("footer")

@endsection

@section("izitoast")
    <script>
        @if(session("add_question_success"))
            iziToast.success({
                message: "{{ session("add_question_success") }}",
                position: "topRight"
            })
        @endif
         @if(session("quantity_max"))
            iziToast.warning    ({
                message: "{{ session("quantity_max") }}",
                position: "topRight"
            })
        @endif quantity_max
    </script>
@endsection