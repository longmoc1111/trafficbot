@extends("admin.adminPageLayout.layout")
@section("main")

    <main>

        <!-- Page Title Start -->
        <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
            <h4 class="text-default-900 text-lg font-medium mb-2">Danh sách bộ đề</h4>
        </div>
        <!-- Page Title End -->

        <div class=" gap-6 mt-8">
            <div class="card overflow-hidden">
                <div class="card-header flex justify-end">
                    <div class="flex gap-2">
                        <div>
                            @if(!empty($selectLicenseTypes))
                                <form action="{{ route("admintrafficbot.examset")}}" method="get">
                                    <select name="choose_License" class="form-select" id="example-select"
                                        onchange="this.form.submit()">
                                        @foreach ($selectLicenseTypes as $license)
                                            <option value="{{$license->LicenseTypeID}}" {{isset($LicenseType) && $license->LicenseTypeName == $LicenseType->LicenseTypeName ? "selected" : "" }}>
                                                {{ $license->LicenseTypeName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>

                            @else
                                <select name="" class="form-select" id="example-select">
                                    <option value="chưa có giấy phép">chưa có giấy phép</option>
                                </select>
                            @endif
                        </div>
                        @if(empty($LicenseType->LicenseTypeID))
                            <a href="" class="btn bg-primary/25 text-primary hover:bg-primary hover:text-white">
                                Thêm bộ đề
                            </a>
                        @else
                            <a href="{{ route("admintrafficbot.examset.create", ["ID" => $LicenseType->LicenseTypeID]) }}"
                                class="btn bg-primary/25 text-primary hover:bg-primary hover:text-white">
                                Thêm bộ đề
                            </a>
                        @endif

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
                                                Tên bộ đề</th>
                                            <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                sử dụng đối với
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                số lượng câu hỏi
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @if(isset($examSet))
                                            @foreach ($examSet as $exam)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">
                                                        {{ $exam->ExamSetName }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                                        {{ $exam->licenseType_examset->pluck("LicenseTypeName")->join(", ") }}
                                                    </td>
                                    
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                                        {{ count($exam->question_Examset) }}/ {{ $exam->licenseType_Examset->pluck("LicenseTypeQuantity")->first() }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex justify-end gap-x-2">
                                                        <div class="hs-tooltip">
                                                            <button type="button"
                                                                class="text-red-500 hover:text-red-800 hs-tooltip-toggle"
                                                                data-hs-overlay="#modal-{{ $exam->ExamSetID }}"
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
                                                            <a href="{{ route("admintrafficbot.examset.edit", $exam->ExamSetID) }}"
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
                                                            <a href="{{ route("admintrafficbot.examset.show", $exam->ExamSetID) }}"
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
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                         <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                        <!-- Showing -->
                        <div>
                            <p class="text-sm text-gray-700">
                                <span class="font-medium">{{ $examSet->firstItem() }}</span>
                                ->
                                <span class="font-medium">{{ $examSet->lastItem() }}</span>
                                of
                                <span class="font-medium">{{$examSet->total()}}</span>
                            </p>
                        </div>

                        <!-- Pagination -->
                        <div class="flex flex-wrap items-center gap-1">
                            <!-- trước -->
                            @if($examSet->onFirstPage())
                                <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Trước</span>
                            @else
                                <a href="{{ $examSet->previousPageUrl() }}"
                                    class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Trước</a>
                            @endif

                            @php
                            $start = max($examSet->currentPage() - 2, 1);
                            $end = min($examSet->currentPage() + 2, $examSet->lastPage());
                            @endphp

                            <!-- trang đầu tiên -->
                            @if($start > 1)
                                <a href="{{ $examSet->url(1) }}"
                                    class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">1</a>
                                @if($start > 2)
                                    <span class="px-2 text-gray-500">...</span>
                                @endif
                            @endif

                            <!-- link các trang -->
                            @for($page = $start; $page <= $end; $page++)
                                @if($page == $examSet->currentPage())
                                    <span
                                        class="px-3 py-1 bg-primary/25 text-primary rounded border border-indigo-600">{{ $page }}</span>
                                @else
                                    <a href="{{ $examSet->url($page) }}"
                                        class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $page}}</a>
                                @endif
                            @endfor

                            <!-- page cuối -->
                            @if($end < $examSet->lastPage())
                                @if($end < $examSet->lastPage() - 1)
                                    <span class="px-2 text-gray-500">...</span>
                                @endif
                                <a href="{{ $examSet->url($examSet->lastPage()) }}"
                                    class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $examSet->lastPage() }}</a>
                            @endif

                            <!-- trang tiếp -->
                            @if($examSet->hasMorePages())
                                <a href="{{ $examSet->nextPageUrl() }}"
                                    class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Sau</a>
                            @else
                                <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Sau</span>
                            @endif

                        </div>
                    </div>
                </div>
                
            </div> <!-- end card -->

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
        </div>

    </main>

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