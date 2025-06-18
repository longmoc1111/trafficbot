@extends("admin.adminPageLayout.layout")
@section("title", "Quản lý loại câu hỏi")
@section("main")

    <main>

        <!-- Page Title Start -->
        <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
            <h4 class="text-default-900 text-lg font-medium mb-2">Phân loại câu hỏi</h4>

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
                  <div class="items-center relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <i class="i-ph-magnifying-glass text-base"></i>
                        </div>
                        <form action="{{ route('admintrafficbot.question.category.search') }}" method="get">
                        <input type="search" name = "search"
                            class="form-input px-10 rounded-lg  bg-gray-500/10 border-transparent focus:border-transparent w-80"
                            placeholder="Search...">
                        </form>
                    </div>
                    <div class="flex gap-2">
                        <button id="open_modal_create"
                            class="btn bg-primary/25 text-primary hover:bg-primary hover:text-white"
                            data-hs-overlay="#modal-create" data-fc-placement="bottom">
                            Tạo mới
                        </button>
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
                                                Tên loại câu hỏi</th>

                                            <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($categories as $category)

                                            <tr>
                                                 <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800"
                                                        style="white-space: normal; word-wrap: break-word; max-width: 300px;">
                                                    {{$category->CategoryName}}
                                                </td>

                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex justify-end gap-x-2">
                                                    <div class="hs-tooltip">
                                                        <button type="button"
                                                            class="text-red-500 hover:text-red-800 hs-tooltip-toggle"
                                                            data-hs-overlay="#modal-delete_{{ $category->CategoryID }}"
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
                                                            data-hs-overlay="#modal-edit_{{ $category->CategoryID }}">
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
                                                        <a href="" type="button" onclick = "event.preventDefault()"
                                                            class="text-blue-500 hover:text-blue-700 hs-tooltip-toggle"
                                                            data-hs-overlay="#modal-show_{{ $category->CategoryID }}"
                                                            data-fc-placement="top">
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
                <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                    <!-- Showing -->
                    <div>
                        <p class="text-sm text-gray-700">
                            <span class="font-medium">{{ $categories->firstItem() }}</span>
                            ->
                            <span class="font-medium">{{ $categories->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $categories->total() }}</span>
                        </p>
                    </div>

                    <!-- Pagination -->
                    <div class="flex flex-wrap items-center gap-1">
                        {{-- Previous Page --}}
                        @if ($categories->onFirstPage())
                            <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Trước</span>
                        @else
                            <a href="{{ $categories->previousPageUrl() }}"
                                class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Trước</a>
                        @endif

                        {{-- Page Numbers --}}
                        @php
                            $start = max($categories->currentPage() - 2, 1);
                            $end = min($categories->currentPage() + 2, $categories->lastPage());
                        @endphp

                        {{-- First Page Link --}}
                        @if ($start > 1)
                            <a href="{{ $categories->url(1) }}"
                                class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">1</a>
                            @if ($start > 2)
                                <span class="px-2 text-gray-500">...</span>
                            @endif
                        @endif

                        {{-- Page Links --}}
                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page == $categories->currentPage())
                                <span
                                    class="px-3 py-1 bg-primary/25 text-primary rounded border border-indigo-600">{{ $page }}</span>
                            @else
                                <a href="{{ $categories->url($page) }}"
                                    class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $page }}</a>
                            @endif
                        @endfor

                        {{-- Last Page Link --}}
                        @if ($end < $categories->lastPage())
                            @if ($end < $categories->lastPage() - 1)
                                <span class="px-2 text-gray-500">...</span>
                            @endif
                            <a href="{{ $categories->url($categories->lastPage()) }}"
                                class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $categories->lastPage() }}</a>
                        @endif

                        {{-- Next Page --}}
                        @if ($categories->hasMorePages())
                            <a href="{{ $categories->nextPageUrl() }}"
                                class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Sau</a>
                        @else
                            <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Sau</span>
                        @endif
                    </div>
                </div>
            </div> <!-- end card -->
            @if(!empty($categories))
                @foreach ($categories as $category)
                    <div id="modal-delete_{{ $category->CategoryID }}"
                        class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none">
                        <div
                            class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                            <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                    <h3 class="text-lg font-medium text-default-900">
                                        Xác nhận
                                    </h3>
                                    <button type="button" class="text-default-600 cursor-pointer"
                                        data-hs-overlay="#modal-delete_{{ $category->CategoryID }}">
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
                                        data-hs-overlay="#modal-delete_{{ $category->CategoryID }}">
                                        <i class="i-tabler-x me-1"></i>
                                        Thoát
                                    </button>
                                    <form action="{{ route("admintrafficbot.question.deletecategory",["ID"=>$category->CategoryID]) }}"
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
            <!-- modal create -->
            <form action="{{ route("admintrafficbot.question.storecategory") }}" method="post">
                @csrf
                <div id="modal-create"
                    class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                    <div
                        class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                        <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                            <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                <h3 class="text-lg font-medium text-default-900 ">
                                    Tạo mới loại câu hỏi
                                </h3>
                                <button type="button" class="text-default-600 cursor-pointer"
                                    data-hs-overlay="#modal-create">
                                    <i class="i-tabler-x text-lg"></i>
                                </button>
                            </div>
                            <div class="p-4 overflow-y-auto">
                                <div class="mb-3">
                                    <label for="SignageName" class="text-default-800 text-sm font-semibold mb-2 block">
                                        Tên loại câu hỏi
                                    </label>
                                    @error('CategoryName', 'create')
                                        <div id="create_errpr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="text" id="CategoryName" name="CategoryName"
                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                <button type="button"
                                    class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                    data-hs-overlay="#modal-create">
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
            <!--end modal create -->

            <!-- modal edit -->
            @if(!empty($categories))
                @foreach ($categories as $category)
                    <form action="{{ route("admintrafficbot.question.updatecategory", ["ID" => $category->CategoryID]) }}"
                        method="post">
                        @csrf
                        <div id="modal-edit_{{ $category->CategoryID }}"
                            class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                            <div
                                class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                                <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                    <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                        <h3 class="text-lg font-medium text-default-900 ">
                                            Chỉnh sửa loại câu hỏi
                                        </h3>
                                        <button type="button" class="text-default-600 cursor-pointer"
                                            data-hs-overlay="#modal-edit_{{ $category->CategoryID }}">
                                            <i class="i-tabler-x text-lg"></i>
                                        </button>
                                    </div>
                                    <div class="p-4 overflow-y-auto">
                                        <div class="mb-3">
                                            <label for="SignageName" class="text-default-800 text-sm font-semibold mb-2 block">
                                                Tên loại câu hỏi
                                            </label>
                                            @error('CategoryName', "edit")
                                                <div id="edit-error"
                                                    class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <input type="text" id="CategoryName" name="CategoryName"
                                                value="{{ $category->CategoryName }}"
                                                class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    </div>
                                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                        <button type="button"
                                            class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                            data-hs-overlay="#modal-edit_{{ $category->CategoryID }}">
                                            đóng
                                        </button>
                                        <button type="submit"
                                            class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary hover:bg-primary-700 border-primary hover:border-primary-700 text-white rounded-md">
                                            Chỉnh sửa
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endforeach
            @endif
            <!-- end modal edit-->
  @if(!empty($categories))
                @foreach ($categories as $category)
                        <div id="modal-show_{{ $category->CategoryID }}"
                            class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none flex items-center justify-center">
                            <div
                                class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                                <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                    <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                        <h3 class="text-lg font-medium text-default-900 ">
                                            Chi tiết loại câu hỏi
                                        </h3>
                                        <button type="button" class="text-default-600 cursor-pointer"
                                            data-hs-overlay="#modal-show_{{ $category->CategoryID }}">
                                            <i class="i-tabler-x text-lg"></i>
                                        </button>
                                    </div>
                                    <div class="p-4 overflow-y-auto">
                                        <div class="mb-3">
                                            <label for="SignageName" class="text-default-800 text-sm font-semibold mb-2 block">
                                                Tên loại câu hỏi
                                            </label>
                                        
                                            <textarea type="text" id="CategoryName" name="CategoryName"
                                                class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"> {{ $category->CategoryName }}</textarea>
                                        </div>
                                    </div>
                                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                        <button type="button"
                                            class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                            data-hs-overlay="#modal-show_{{ $category->CategoryID }}">
                                            đóng
                                        </button>
                                        <button type="submit"
                                            class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary hover:bg-primary-700 border-primary hover:border-primary-700 text-white rounded-md">
                                            Chỉnh sửa
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                
                @endforeach
            @endif

         



        </div>

    </main>

@endsection

@section("footer")

@endsection


<script>
    @if($errors->create->any())
        window.addEventListener("load", function () {
            setTimeout(function () {
                document.getElementById("open_modal_create").click();
            }, 300)
        });
    @endif

    @if($errors->edit->any()){
            window.addEventListener("load", function () {
                setTimeout(function () {
                    document.getElementById("open_modal_edit").click()
                }, 300)
            })
        }
    @endif
</script>

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
            iziToast.warning({
                message: "{{ session("delete_fails") }}",
                position: "topRight"
            })
        @endif
    </script>
@endsection