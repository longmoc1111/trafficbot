@extends("admin.adminPageLayout.layout")
@section("title", "Quản lý loại câu hỏi")
@section("main")

  <main>
    <!-- Tiêu đề trang -->
    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <h4 class="text-default-900 text-xl font-semibold">📂 Phân loại câu hỏi</h4>
        <button id="open_modal_create"
            class="btn bg-blue-600 text-white hover:bg-blue-700 text-sm px-4 py-2 rounded-md shadow"
            data-hs-overlay="#modal-create">
            <i class="i-solar-plus-bold mr-1"></i> Tạo mới
        </button>
    </div>

    <!-- Tìm kiếm -->
    <div class="card p-4 mb-6 shadow border rounded-lg bg-white">
        <form action="{{ route('admintrafficbot.question.category.search') }}" method="get"
            class="relative w-full md:w-1/2">
            <input type="search" name="search" placeholder="🔍 Tìm kiếm phân loại câu hỏi..."
                class="form-input w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400">
        </form>
    </div>

    <!-- Danh sách phân loại -->
    <div class="card p-0 overflow-hidden shadow border rounded-lg bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-left text-sm font-semibold text-gray-600">
                    <tr>
                        <th class="px-6 py-3">Tên loại câu hỏi</th>
                        <th class="px-6 py-3 text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-6 py-4 max-w-[300px] whitespace-normal">
                                {{ $category->CategoryName }}
                            </td>
                            <td class="px-6 py-4 text-end">
                                <div class="flex justify-end gap-2">
                                    <!-- Xem -->
                                    <a href="#" class="text-blue-600 hover:text-blue-800"
                                        data-hs-overlay="#modal-show_{{ $category->CategoryID }}" title="Xem chi tiết"
                                        onclick="event.preventDefault()">
                                        <span class="material-symbols-rounded text-2xl">visibility</span>
                                    </a>

                                    <!-- Sửa -->
                                    <a href="#" class="text-yellow-500 hover:text-yellow-700"
                                        data-hs-overlay="#modal-edit_{{ $category->CategoryID }}" title="Chỉnh sửa"
                                        onclick="event.preventDefault()">
                                        <span class="material-symbols-rounded text-2xl">edit</span>
                                    </a>

                                    <!-- Xóa -->
                                    <button type="button" class="text-red-500 hover:text-red-700"
                                        data-hs-overlay="#modal-delete_{{ $category->CategoryID }}" title="Xóa vĩnh viễn">
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
               Hiển thị <span class="font-medium">{{ $categories->firstItem() }}</span> →
                <span class="font-medium">{{ $categories->lastItem() }}</span> /
                <span class="font-medium">{{ $categories->total() }}</span> 
            </p>

            <div class="flex items-center space-x-1">
                {{-- Trước --}}
                @if ($categories->onFirstPage())
                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border">Trước</span>
                @else
                    <a href="{{ $categories->previousPageUrl() }}"
                        class="px-3 py-1 bg-white text-gray-700 hover:bg-gray-100 rounded border">Trước</a>
                @endif

                {{-- Trang --}}
                @for ($page = max(1, $categories->currentPage() - 2); $page <= min($categories->lastPage(), $categories->currentPage() + 2); $page++)
                    @if ($page == $categories->currentPage())
                        <span class="px-3 py-1 bg-blue-600 text-white rounded border">{{ $page }}</span>
                    @else
                        <a href="{{ $categories->url($page) }}"
                            class="px-3 py-1 bg-white text-gray-700 hover:bg-gray-100 rounded border">{{ $page }}</a>
                    @endif
                @endfor

                {{-- Sau --}}
                @if ($categories->hasMorePages())
                    <a href="{{ $categories->nextPageUrl() }}"
                        class="px-3 py-1 bg-white text-gray-700 hover:bg-gray-100 rounded border">Sau</a>
                @else
                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border">Sau</span>
                @endif
            </div>
        </div>
    </div>
</main>






            @if(!empty($categories))
                @foreach ($categories as $category)

                    <div id="modal-delete_{{ $category->CategoryID }}"
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
                                                <p class="text-white/80 text-sm">Bạn có chắc muốn xóa loại câu hỏi này?</p>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                            data-hs-overlay="#modal-delete_{{ $category->CategoryID }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Body -->
                                <div class="p-6 space-y-4 text-center">
                                    <p class="text-gray-700 text-sm">Bạn có chắc chắn muốn <strong>xóa</strong> loại câu hỏi 
                                        <strong>{{ $category->CategoryName }}</strong> không? Hành động này không thể hoàn tác.
                                    </p>
                                </div>

                                <!-- Footer -->
                                <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
                                    <button type="button"
                                        class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                        data-hs-overlay="#modal-delete_{{ $category->CategoryID }}">
                                        Hủy
                                    </button>

                                    <form
                                        action="{{ route("admintrafficbot.question.deletecategory", ["ID" => $category->CategoryID]) }}"
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
            <!-- modal delte -->




            <div id="modal-create" class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
                <div
                    class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                    <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">

                        <!-- Header -->
                        <div class="bg-gradient-to-r bg-primary p-6">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                                    <i class="ti ti-library-plus text-white text-xl"></i>
                                                </div>
                                    <div>
                                        <h3 class="font-bold text-white text-lg">Thêm Dữ Liệu</h3>
                                        <p class="text-white/80 text-sm">Điền thông tin vào các trường bên dưới</p>
                                    </div>
                                </div>
                                <button type="button"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                    data-hs-overlay="#modal-create">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Body -->
                        <form action="{{ route("admintrafficbot.question.storecategory") }}" method="post"
                            class="p-6 space-y-5">
                            @csrf

                            <!-- Tên -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                                    Tên loại câu hỏi</label>
                                @error('CategoryName', 'create')
                                    <div id="create_errpr" class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <input type="text" id="CategoryName" name="CategoryName" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                            </div>
                            <!-- Footer -->
                            <div class="border-t pt-4 flex justify-end gap-3">
                                <button type="button"
                                    class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                    data-hs-overlay="#modal-create">
                                    Hủy
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                    Lưu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!--end modal create -->


            <!-- modal edit -->
            @if(!empty($categories))
                @foreach ($categories as $category)
                    <div id="modal-edit_{{ $category->CategoryID }}"
                        class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
                        <div
                            class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                            <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">

                                <!-- Header -->
                                <div class="bg-gradient-to-r bg-primary p-6">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                                <i class="ti ti-edit text-white text-xl"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-white text-lg">Chỉnh sửa dữ liệu</h3>
                                                <p class="text-white/80 text-sm">Điền thông tin vào các trường bên dưới</p>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                            data-hs-overlay="#modal-edit_{{ $category->CategoryID }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Body -->
                                <form
                                    action="{{ route("admintrafficbot.question.updatecategory", ["ID" => $category->CategoryID]) }}"
                                    class="p-6 space-y-5">
                                    @csrf

                                    <!-- Tên -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                                            Tên loại câu hỏi</label>
                                        @error('CategoryName', "edit")
                                            <div id="edit-error" class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <input type="text" id="CategoryName" name="CategoryName"
                                            value="{{ $category->CategoryName }}" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                                    </div>


                                    <!-- Footer -->
                                    <div class="border-t pt-4 flex justify-end gap-3">
                                        <button type="button"
                                            class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                            data-hs-overlay="#modal-edit_{{ $category->CategoryID }}">
                                            Hủy
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                            cập nhật
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @endforeach
            @endif

            <!-- end modal edit-->
           @if(!empty($categories))
                @foreach ($categories as $category)
                    <div id="modal-show_{{ $category->CategoryID }}"
                        class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
                        <div
                            class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                            <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">

                                <!-- Header -->
                                <div class="bg-gradient-to-r bg-primary p-6">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                                <i class="ti ti-eye text-white text-xl"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-white text-lg">Chi tiết loại câu hỏi</h3>
                                                <p class="text-white/80 text-sm">Thông tin chi tiết về loại câu hỏi</p>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                            data-hs-overlay="#modal-show_{{ $category->CategoryID }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Body -->
                                <div
                                    class="p-6 space-y-5">
                                    @csrf

                                    <!-- Tên -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                                            Tên loại câu hỏi</label>
                                        @error('CategoryName', "edit")
                                            <div id="edit-error" class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <input type="text" id="CategoryName" name="CategoryName"
                                            value="{{ $category->CategoryName }}" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                                    </div>


                                    <!-- Footer -->
                                    <div class="border-t pt-4 flex justify-end gap-3">
                                        <button type="button"
                                            class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors"
                                            data-hs-overlay="#modal-show_{{ $category->CategoryID }}">
                                            Đóng
                                        </button>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            @endif




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