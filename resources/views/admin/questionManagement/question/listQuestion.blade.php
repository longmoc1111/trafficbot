@extends("admin.adminPageLayout.layout")
@section("title", "Quản lý câu hỏi")
@section("main")

        <main>

            <!-- Page Title Start -->
            <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
                <h4 class="text-default-900 text-lg font-medium mb-2">Danh sách câu hỏi</h4>

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
                    <div class="card-header flex justify-between items-center">
                        <!-- LEFT: Search input -->
                        <div class="md:flex hidden items-center relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <i class="i-ph-magnifying-glass text-base"></i>
                            </div>
                            <form action="{{ route("admintrafficbot.question.search") }}">
                                <input type="search" name="search"
                                    class="form-input px-10 rounded-lg bg-gray-500/10 border-transparent focus:border-transparent w-80"
                                    placeholder="Search...">
                            </form>

                        </div>
                        <!-- RIGHT: Select + Button -->
                        <div class="flex items-center gap-3">
                            <form action="">
                                <select onchange="this.form.submit()" name="category" class="form-select" id="example-select"
                                    style="max-width: 200px;">
                                    @foreach($questionCategory as $category)
                                        <option value="{{ $category->CategoryID }}" {{ !empty($categoryKey) && $categoryKey == $category->CategoryID ? "selected" : "" }}>{{ $category->CategoryName }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                            <a href="{{ route('admintrafficbot.question.create') }}" style="white-space: nowrap"
                                class="btn bg-primary/25 text-primary hover:bg-primary hover:text-white">
                                Thêm câu hỏi mới
                            </a>
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
                                                    Tên câu hỏi</th>
                                                <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                    Loại câu hỏi</th>
                                                <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                    Câu điểm liệt</th>

                                                <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($Questions as $question)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800"
                                                        style="white-space: normal; word-wrap: break-word; max-width: 300px;">
                                                        {{ $question->QuestionName  }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800"
                                                        style="white-space: normal; word-wrap: break-word; max-width: 230px;">
                                                        {{ optional($question->categoryQuestion_Question)->CategoryName ?? 'Chưa phân loại' }}
                                                    </td>
                                                    </td>

                                                @php
                                                    $hasCritical = false;
                                                    foreach ($question->licenseType_Question as $license) {
                                                        if ($license->pivot->IsCritical == 1) {
                                                            $hasCritical = true;
                                                            break;
                                                        }
                                                    }
                                                @endphp

                                                @if($hasCritical)
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">
                                                       <span class="px-2 py-1 bg-success/10 text-success text-xs rounded">có</span>                                             
                                                    </td>                                                 
                                                @else
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">
                                                        <span class="px-2 py-1 bg-blue-100 text-secondary text-xs rounded">không</span>
                                                    </td>
                                                @endif
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex justify-end gap-x-2">
                                                        <div class="hs-tooltip">
                                                            <button type="button"
                                                                class="text-red-500 hover:text-red-800 hs-tooltip-toggle"
                                                                data-hs-overlay="#modal-{{ $question->QuestionID }}"
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
                                                            <a href="{{ route("admintrafficbot.question.edit", $question->QuestionID) }}"
                                                                type="button" class="text-info hover:text-info hs-tooltip-toggle"
                                                                data-fc-placement="top">
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
                                                            <a href="{{ route("admintrafficbot.question.detail", $question->QuestionID) }}"
                                                                type="button"
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
                                <span class="font-medium">{{ $Questions->firstItem() }}</span>
                                ->
                                <span class="font-medium">{{ $Questions->lastItem() }}</span>
                                of
                                <span class="font-medium">{{$Questions->total()}}</span>
                            </p>
                        </div>

                        <!-- Pagination -->
                        <div class="flex flex-wrap items-center gap-1">
                            <!-- trước -->
                            @if($Questions->onFirstPage())
                                <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Trước</span>
                            @else
                                <a href="{{ $Questions->previousPageUrl() }}"
                                    class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Trước</a>
                            @endif

                            @php
    $start = max($Questions->currentPage() - 2, 1);
    $end = min($Questions->currentPage() + 2, $Questions->lastPage());
                            @endphp

                            <!-- trang đầu tiên -->
                            @if($start > 1)
                                <a href="{{ $Questions->url(1) }}"
                                    class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">1</a>
                                @if($start > 2)
                                    <span class="px-2 text-gray-500">...</span>
                                @endif
                            @endif

                            <!-- link các trang -->
                            @for($page = $start; $page <= $end; $page++)
                                @if($page == $Questions->currentPage())
                                    <span
                                        class="px-3 py-1 bg-primary/25 text-primary rounded border border-indigo-600">{{ $page }}</span>
                                @else
                                    <a href="{{ $Questions->url($page) }}"
                                        class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $page}}</a>
                                @endif
                            @endfor

                            <!-- page cuối -->
                            @if($end < $Questions->lastPage())
                                @if($end < $Questions->lastPage() - 1)
                                    <span class="px-2 text-gray-500">...</span>
                                @endif
                                <a href="{{ $Questions->url($Questions->lastPage()) }}"
                                    class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $Questions->lastPage() }}</a>
                            @endif

                            <!-- trang tiếp -->
                            @if($Questions->hasMorePages())
                                <a href="{{ $Questions->nextPageUrl() }}"
                                    class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Sau</a>
                            @else
                                <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Sau</span>
                            @endif

                        </div>
                    </div>

                </div> <!-- end card -->
                <!-- modal delete -->
                @if(isset($Questions))
                    @foreach ($Questions as $question)
                        <div id="modal-{{ $question->QuestionID }}"
                            class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none">
                            <div
                                class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                                <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                    <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                        <h3 class="text-lg font-medium text-default-900">
                                            Xác nhận
                                        </h3>
                                        <button type="button" class="text-default-600 cursor-pointer"
                                            data-hs-overlay="#modal-{{  $question->QuestionID }}">
                                            <i class="i-tabler-x text-lg"></i>
                                        </button>
                                    </div>
                                    <div class="p-4 overflow-y-auto">
                                        <p class="mt-1 text-default-600">
                                            Bạn có chắc muốn xóa câu hỏi này ?
                                        </p>

                                    </div>
                                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                        <button type="button"
                                            class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                            data-hs-overlay="#modal-{{  $question->QuestionID }}">
                                            <i class="i-tabler-x me-1"></i>
                                            Thoát
                                        </button>
                                        <form action="{{ route("admintrafficbot.question.delete", $question->QuestionID) }}"
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