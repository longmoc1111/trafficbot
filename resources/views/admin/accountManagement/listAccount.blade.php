@extends("admin.adminPageLayout.layout")
@section("title", "Quản lý tài khoản")
@section("main")

    <main>
        <!-- Tiêu đề -->
        <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
            <h4 class="text-default-900 text-xl font-semibold">👤 Danh sách tài khoản</h4>
            <button id="opendModalCreate"
                class="btn bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md shadow text-sm"
                data-fc-placement="top" data-hs-overlay="#modal_create">
                <i class="i-solar-plus-bold mr-1"></i> Thêm tài khoản
            </button>
        </div>

        <!-- Bảng danh sách -->
        <div class="card overflow-hidden border rounded-lg bg-white shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800">
                    <thead class="bg-gray-50 text-sm font-semibold text-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left">Tên người dùng</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Ảnh đại diện</th>
                            <th class="px-6 py-3 text-left">Trạng thái</th>
                            <th class="px-6 py-3 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($accounts as $account)
                            <tr>
                                <td class="px-6 py-4 max-w-xs break-words">{{ $account->name }}</td>
                                <td class="px-6 py-4 max-w-xs break-words">{{ $account->email }}</td>
                                <td class="px-6 py-4">
                                    @if(empty($account->avatar))
                                        <img src="/assets/avatar_default/avatar_default.png"
                                            class="w-12 h-12 object-cover rounded-full border" alt="Avatar">
                                    @else
                                        <img  src = "{{ asset("storage/uploads/avatar/$account->avatar") }}"
                                            class="w-12 h-12 object-cover rounded-full border" alt="Avatar">
                                    @endif

                                </td>
                                <td class="px-6 py-4">
                                    @if ($account->status === 'active')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>Đã kích hoạt
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                                            <span class="w-2 h-2 mr-2 bg-gray-400 rounded-full"></span>Chưa kích hoạt
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <!-- Xem -->
                                        <a href="#" class="text-blue-500 hover:text-blue-700"
                                            data-hs-overlay="#modal-profile-{{ $account->userID }}">
                                            <span class="material-symbols-rounded text-2xl">visibility</span>
                                        </a>

                                        <!-- Sửa -->
                                        <a href="#" class="text-yellow-500 hover:text-yellow-700"
                                            data-hs-overlay="#modal_edit_{{ $account->userID }}">
                                            <span class="material-symbols-rounded text-2xl">edit</span>
                                        </a>

                                        <!-- Xóa -->
                                        <button type="button" class="text-red-500 hover:text-red-700"
                                            data-hs-overlay="#modal_delete_{{ $account->userID }}">
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
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div>
                    <p class="text-sm text-gray-700">
                        Hiển thị <span class="font-semibold">{{ $accounts->firstItem() }}</span> →
                        <span class="font-semibold">{{ $accounts->lastItem() }}</span>
                        / <span class="font-semibold">{{ $accounts->total() }}</span>
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-1">
                    {{-- Trang trước --}}
                    @if($accounts->onFirstPage())
                        <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Trước</span>
                    @else
                        <a href="{{ $accounts->previousPageUrl() }}"
                            class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Trước</a>
                    @endif

                    {{-- Trang cụ thể --}}
                    @php
                        $start = max($accounts->currentPage() - 2, 1);
                        $end = min($accounts->currentPage() + 2, $accounts->lastPage());
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $accounts->url(1) }}"
                            class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">1</a>
                        @if ($start > 2)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $accounts->currentPage())
                            <span class="px-3 py-1 bg-primary/25 text-primary rounded border border-indigo-600">{{ $i }}</span>
                        @else
                            <a href="{{ $accounts->url($i) }}"
                                class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($end < $accounts->lastPage())
                        @if ($end < $accounts->lastPage() - 1)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                        <a href="{{ $accounts->url($accounts->lastPage()) }}"
                            class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $accounts->lastPage() }}</a>
                    @endif

                    {{-- Trang tiếp --}}
                    @if($accounts->hasMorePages())
                        <a href="{{ $accounts->nextPageUrl() }}"
                            class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Sau</a>
                    @else
                        <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Sau</span>
                    @endif
                </div>
            </div>
        </div>
    </main>

                   

    <!-- modal xóa -->
    @if(!empty($accounts))
        @foreach ($accounts as $account)
            <div id="modal_delete_{{$account->userID}}"
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
                                                <p class="text-white/80 text-sm">Bạn có chắc muốn xóa tài khoản này?</p>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                            data-hs-overlay="#modal_delete_{{$account->userID}}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Body -->
                                <div class="p-6 space-y-4 text-center">
                                    <p class="text-gray-700 text-sm">Bạn có chắc chắn muốn xóa tài khoản 
                                       này không? Hành động này không thể hoàn tác.
                                    </p>
                                </div>

                                <!-- Footer -->
                                <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
                                    <button type="button"
                                        class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                        data-hs-overlay="#modal_delete_{{$account->userID}}">
                                        Hủy
                                    </button>

                                    <form
                                         action="{{ route("admintrafficbot.account.delete", ["ID" => $account->userID]) }}"  
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

    <!-- modal create -->
   <!-- modal create -->
<div id="modal_create" class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
    <div
        class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
        <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r bg-primary p-6">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="ti ti-user-plus text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-lg">Thêm tài khoản</h3>
                            <p class="text-white/80 text-sm">Điền thông tin vào các trường bên dưới</p>
                        </div>
                    </div>
                    <button type="button"
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                        data-hs-overlay="#modal_create">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Body -->
            <form action="{{ route('admintrafficbot.account.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-scroll max-h-[60vh] overflow-y-auto p-6 space-y-6">

                    <!-- Tên -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên tài khoản</label>
                        @error('name')
                        <p id="name_error"
                            class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">{{ $message }}</p>
                        @enderror
                        <input type="text" id="name" name="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                            onfocus="document.getElementById('name_error')?.classList.add('hidden')">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        @error('email')
                        <p id="email_error"
                            class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">{{ $message }}</p>
                        @enderror
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                            onfocus="document.getElementById('email_error')?.classList.add('hidden')">
                    </div>

                    <!-- Mật khẩu -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                        @error('password')
                        <p id="password_error"
                            class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">{{ $message }}</p>
                        @enderror
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                            onfocus="document.getElementById('password_error')?.classList.add('hidden')">
                    </div>

                    <!-- Mật khẩu xác nhận -->
                    <div>
                        <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu xác nhận</label>
                        @error('confirmPassword')
                        <p id="confirmPassword-error"
                            class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">{{ $message }}</p>
                        @enderror
                        <input type="password" id="confirmPassword" name="confirmPassword"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                            onfocus="document.getElementById('confirmPassword-error')?.classList.add('hidden')">
                    </div>

                    <!-- Phân quyền -->
                    <div>
                        <label for="roleID" class="block text-sm font-medium text-gray-700 mb-1">Phân quyền</label>
                        @error('role')
                        <p id="role-error"
                            class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">{{ $message }}</p>
                        @enderror
                        <select name="roleID" id="roleID"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                            onfocus="document.getElementById('role-error')?.classList.add('hidden')">
                            @foreach ($roles as $role)
                                @if($role->roleName == "admin")
                                    <option value="{{ $role->roleID }}">Quản trị viên</option>
                                @elseif($role->roleName == "user")
                                    <option value="{{ $role->roleID }}">Người dùng</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Avatar -->
                    <div>
                        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Ảnh đại diện</label>
                        <input type="file" name="avatar" id="avatar" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <div class="flex justify-center mt-3">
                            <img id="preview-avatar" src="" alt="Avatar preview"
                                class="hidden w-32 h-32 object-contain p-2 border rounded-md shadow-sm">
                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="border-t p-4 flex justify-end gap-3">
                    <button type="button"
                        class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                        data-hs-overlay="#modal_create">
                        Hủy
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                        Tạo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- end modal-->



    <!-- modal update -->
    @if(!empty($accounts))
    @foreach ($accounts as $account)
        <div id="modal_edit_{{ $account->userID }}" class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
            <div
                class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">

                    <!-- Header -->
                    <div class="bg-gradient-to-r bg-primary p-6">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="ti ti-user-edit text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-lg">Chỉnh sửa tài khoản</h3>
                                    <p class="text-white/80 text-sm">Cập nhật thông tin tài khoản bên dưới</p>
                                </div>
                            </div>
                            <button type="button"
                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors"
                                data-hs-overlay="#modal_edit_{{ $account->userID }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Body -->
                    <form action="{{ route('admintrafficbot.account.update', ['ID' => $account->userID]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-scroll max-h-[60vh] overflow-y-auto p-6 space-y-6">

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên tài khoản</label>
                                @error('name')
                                <p id="name_error" class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                    {{ $message }}
                                </p>
                                @enderror
                                <input readonly type="text" id="name" name="name" value="{{ $account->name }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                    onfocus="document.getElementById('name_error')?.classList.add('hidden')">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                @error('email')
                                <p id="email_error" class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                    {{ $message }}
                                </p>
                                @enderror
                                <input readonly type="email" id="email" name="email" value="{{ $account->email }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                    onfocus="document.getElementById('email_error')?.classList.add('hidden')">
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                                @error('password')
                                <p id="password_error" class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                    {{ $message }}
                                </p>
                                @enderror
                                <input type="password" id="password" name="password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                    onfocus="document.getElementById('password_error')?.classList.add('hidden')">
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu xác nhận</label>
                                @error('confirmPassword')
                                <p id="confirmPassword-error" class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                    {{ $message }}
                                </p>
                                @enderror
                                <input type="password" id="confirmPassword" name="confirmPassword"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                    onfocus="document.getElementById('confirmPassword-error')?.classList.add('hidden')">
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="roleID" class="block text-sm font-medium text-gray-700 mb-1">Phân quyền</label>
                                @error('role')
                                <p id="role-error" class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                    {{ $message }}
                                </p>
                                @enderror
                                <select name="roleID" id="roleID"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                    onfocus="document.getElementById('role-error')?.classList.add('hidden')">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->roleID }}" {{ $account->roleID == $role->roleID ? 'selected' : '' }}>
                                            {{ $role->roleName == 'admin' ? 'Quản trị viên' : 'Người dùng' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                                @error('status')
                                <p id="status-error" class="mb-1 text-xs text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">
                                    {{ $message }}
                                </p>
                                @enderror
                                <select name="status" id="status"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                    onfocus="document.getElementById('status-error')?.classList.add('hidden')">
                                    <option value="active" {{ $account->status == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="pending" {{ $account->status == 'pending' ? 'selected' : '' }}>Chưa kích hoạt</option>
                                </select>
                            </div>

                            <!-- Avatar -->
                            <div>
                                <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Ảnh đại diện</label>
                                <input type="file" name="avatar" id="avatar" accept="image/*"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <div class="flex justify-center mt-3">
                                    <img id="preview-avatar-{{ $account->userID }}" src="{{ asset('storage/path-to-avatar/'.$account->avatar) }}"
                                        alt="Avatar preview" class="w-32 h-32 object-contain p-2 border rounded-md shadow-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="border-t p-4 flex justify-end gap-3">
                            <button type="button"
                                class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors"
                                data-hs-overlay="#modal_edit_{{ $account->userID }}">
                                Hủy
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif

    <!-- end modal-->


   @if(!empty($accounts))
    @foreach ($accounts as $account)
     <!-- Modal Profile Start -->
            <div id="modal-profile-{{ $account->userID }}" class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
                <!-- Modal Container -->
                <div class="hs-overlay-open:opacity-100 hs-overlay-open:scale-100 opacity-0 scale-95 ease-out transition-all duration-300 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
                    <div class="modal-content w-full bg-white border shadow-xl rounded-xl overflow-hidden">
                        
                        <!-- Header -->
                        <div class="bg-gradient-to-r bg-primary p-6">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                        <i class="ti ti-id text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-white text-lg">Thông tin cá nhân</h3>
                                        <p class="text-white/80 text-sm">Quản lý thông tin người dùng</p>
                                    </div>
                                </div>
                                <button type="button" 
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors" 
                                        data-hs-overlay="#modal-profile-{{ $account->userID }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="modal-scroll max-h-[60vh] overflow-y-auto p-6 space-y-6">
                            
                            <!-- Avatar Section -->
                            <div class="flex flex-col items-center">
                                <div class="relative">
                                    @if(!empty($account->avatar))
                                    <img src="{{ asset('storage/uploads/avatar/' . $account->avatar)}}" 
                                         alt="avatar" 
                                         class="w-24 h-24 rounded-full object-cover border-4 border-gray-100 shadow-lg">
                                    @else
                                    <img src="/assets/avatar_default/avatar_default.png" 
                                         alt="avatar" 
                                         class="w-24 h-24 rounded-full object-cover border-4 border-gray-100 shadow-lg">
                                    @endif
                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 border-2 border-white rounded-full"></div>
                                </div>
                                <div class="mt-4 text-center">
                                    <h4 class="text-xl font-bold text-gray-900">{{ $account->name }}</h4>
                                    <p class="text-gray-500 text-sm">{{ $account->email }}</p>
                                </div>
                            </div>

                            <!-- Information Cards -->
                            <div class="space-y-4">
                                <!-- Name Card -->
                                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="ti ti-user text-white"></i>
                                        </div>
                                        <div>
                                            <p class="text-blue-600 font-medium text-sm">Họ và tên</p>
                                            <p class="text-gray-900 font-semibold">{{ $account->name }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Card -->
                                <div class="bg-green-50 border border-green-100 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="ti ti-mail text-white"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-green-600 font-medium text-sm">Email</p>
                                            <p class="text-gray-900 font-semibold truncate">{{ $account->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Role Card -->
                                <div class="bg-purple-50 border border-purple-100 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="ti ti-shield text-white"></i>
                                        </div>
                                        <div>
                                            <p class="text-purple-600 font-medium text-sm">Vai trò</p>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                                {{ $account->role_User->roleName ?? 'Người dùng' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-yellow-50 border border-purple-100 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="ti ti-activity text-white"></i>
                                        </div>
                                        <div>
                                            <p class="text-yellow-800 font-medium text-sm">Trạng thái</p>
                                            @if($account->status == "active")
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                    Đã kích hoạt
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                    Chưa kích hoạt
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Statistics -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <i class="i-solar-chart-square-bold text-orange-500 mr-2"></i>
                                    Thống kê hoạt động
                                </h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center p-3 bg-orange-100 rounded-lg">
                                        <div class="text-2xl font-bold text-orange-600">12</div>
                                        <div class="text-xs text-orange-600">Bài thi đã làm</div>
                                    </div>
                                    <div class="text-center p-3 bg-teal-100 rounded-lg">
                                        <div class="text-2xl font-bold text-teal-600">8.5</div>
                                        <div class="text-xs text-teal-600">Điểm trung bình</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
                            <button type="button" 
                                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors" 
                                    data-hs-overlay="#modal-profile-{{ $account->userID }}">
                                Đóng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @endif
            <!-- Modal Profile End -->

@endsection
@section("footer")
    <script>
        document.getElementById("avatar").addEventListener("change", function (event) {
            const file = event.target.files[0]
            if (file) {
                console.log("done")
                const imageURL = URL.createObjectURL(file)
                const imageElement = document.getElementById("preview-avatar")
                imageElement.src = imageURL
                imageElement.classList.remove("hidden")
            }
        })

                                 @if($errors->any()){
                                        window.addEventListener("load", function () {
                                            setTimeout(function () {
                                                document.getElementById("opendModalCreate").click()
                                            }, 300)
                                        })
                                    }
                                @endif

        // document.addEventListener("DOMContentLoaded", function() {
        // const modal = document.getElementById("modal_create");
        // if (modal) {
        // modal.classList.remove("hidden");
        // modal.classList.add("open","opened")
        // modal.classList.add("opacity-100"); // Nếu modal của bạn cần class này khi mở
        // }
        // });

        //
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
        @if(session("create_fails"))
            iziToast.warning({
                message: "{{ session("create_fails") }}",
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