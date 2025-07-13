@extends("admin.adminPageLayout.layout")
@section("title", "Quản lý tài khoản")
@section("main")

            <main>

                <!-- Page Title Start -->
                <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
                    <h4 class="text-default-900 text-lg font-medium mb-2">Danh sách tài khoản</h4>

                    <!-- <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
                                    <a href="#" class="text-sm font-medium text-default-700">OpenDash</a>
                                    <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                                    <a href="#" class="text-sm font-medium text-default-700">Tables</a>
                                    <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                                    <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Basic Tables</a>
                                </div> -->
                </div>
                <!-- Page Title End -->

                <div class="gap-6 mt-8 d-flex flex-column">
                    <div class="card flex-grow-1 overflow-hidden">
                        <div class="card-header flex justify-end">
                            <div class="flex gap-2 ">
                                <div>
                                    <!-- <form action="">
                                                    <select name="option" class="form-select">
                                                        <option value="">test</option>
                                                    </select>
                                                </form> -->
                                </div>
                                <button id="opendModalCreate"
                                    class="btn bg-primary/25 text-primary hover:bg-primary hover:text-white" data-fc-placement="top"
                                    data-hs-overlay="#modal_create">
                                    Thêm tài khoản
                                </button>
                            </div>
                        </div>
                        <div>
                            <div class=" overflow-x-auto">
                                <div class="min-w-full inline-block align-middle">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                        Tên người dùng</th>
                                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                        Email
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                        Ảnh đại diện
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                                        Trạng thái
                                                    </th>

                                                    <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">
                                                        Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @if(!empty($accounts))
                                                    @foreach ($accounts as $account)

                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-normal text-sm text-default-800"
                                                                style="max-width: 200px; word-wrap: break-word;">
                                                                {{ $account->name }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-normal text-sm text-default-800"
                                                                style="max-width: 200px; word-wrap: break-word;">
                                                                {{ $account->email }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                                                @if(!empty($account->avatar))
                                                                    <img style="max-width: 50px;" class="" src="/assets/adminPage/avatar_user/{{ $account->avatar }}" alt="">
                                                                @else
                                                                    <img style="max-width: 50px;" class="" src="/assets/adminPage/avatar_user/avatar_default.jpg" alt="">
                                                                @endif
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                                                @if ($account->status === 'active')
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                                        <span class="flex w-2 h-2 mr-2 bg-green-500 rounded-full"></span>đã kích hoạt</span>
                                                                @else
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                                                                        <span class="flex w-2 h-2 mr-3 bg-gray-400 rounded-full"></span>Chưa kích hoạt</span>
                                                                @endif
                                                            </td>

                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex justify-end gap-x-2">
                                                                <div class="hs-tooltip">
                                                                    <button type="button"
                                                                        class="text-red-500 hover:text-red-800 hs-tooltip-toggle"
                                                                        data-hs-overlay="#modal_delete_{{$account->userID}}"
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
                                                                    <a href="#" type="button"
                                                                        class="text-info hover:text-info hs-tooltip-toggle"
                                                                        data-fc-placement="top"
                                                                        data-hs-overlay="#modal_edit_{{ $account->userID }}">
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
                                                                    <a href="" type="button" onclick="event.preventDefault()"
                                                                        class="text-blue-500 hover:text-blue-700 hs-tooltip-toggle"
                                                                        data-fc-placement="top" data-hs-overlay="#show-">
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
                                                @endif
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
                                    <span class="font-medium">{{ $accounts->firstItem() }}</span>
                                    ->
                                    <span class="font-medium">{{ $accounts->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{$accounts->total()}}</span>
                                </p>
                            </div>

                            <!-- Pagination -->
                            <div class="flex flex-wrap items-center gap-1">
                                <!-- trước -->
                                @if($accounts->onFirstPage())
                                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Trước</span>
                                @else
                                    <a href="{{ $accounts->previousPageUrl() }}"
                                        class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Trước</a>
                                @endif

                                @php
                                    $start = max($accounts->currentPage() - 2, 1);
                                    $end = min($accounts->currentPage() + 2, $accounts->lastPage());
                                @endphp

                                <!-- trang đầu tiên -->
                                @if($start > 1)
                                    <a href="{{ $accounts->url(1) }}"
                                        class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">1</a>
                                    @if($start > 2)
                                        <span class="px-2 text-gray-500">...</span>
                                    @endif
                                @endif

                                <!-- link các trang -->
                                @for($page = $start; $page <= $end; $page++)
                                    @if($page == $accounts->currentPage())
                                        <span
                                            class="px-3 py-1 bg-primary/25 text-primary rounded border border-indigo-600">{{ $page }}</span>
                                    @else
                                        <a href="{{ $accounts->url($page) }}"
                                            class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $page}}</a>
                                    @endif
                                @endfor

                                <!-- page cuối -->
                                @if($end < $accounts->lastPage())
                                    @if($end < $accounts->lastPage() - 1)
                                        <span class="px-2 text-gray-500">...</span>
                                    @endif
                                    <a href="{{ $accounts->url($accounts->lastPage()) }}"
                                        class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $accounts->lastPage() }}</a>
                                @endif

                                <!-- trang tiếp -->
                                @if($accounts->hasMorePages())
                                    <a href="{{ $accounts->nextPageUrl() }}"
                                        class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Sau</a>
                                @else
                                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Sau</span>
                                @endif

                            </div>
                        </div>

                    </div> <!-- end card -->

                    <!-- modal xóa -->
                    @if(!empty($accounts))
                        @foreach ($accounts as $account)
                            <div id="modal_delete_{{$account->userID}}"
                                class="hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto hidden pointer-events-none">
                                <div
                                    class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                                    <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                        <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                            <h3 class="text-lg font-medium text-default-900">
                                                Xác nhận
                                            </h3>
                                            <button type="button" class="text-default-600 cursor-pointer"
                                                data-hs-overlay="#modal_delete_{{$account->userID}}">
                                                <i class="i-tabler-x text-lg"></i>
                                            </button>
                                        </div>
                                        <div class="p-4 overflow-y-auto">
                                            <p class="mt-1 text-default-600">
                                                Bạn có chắc muốn xóa tài khoản này?
                                            </p>
                                        </div>
                                        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                            <button type="button"
                                                class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                                data-hs-overlay="#modal_delete_{{$account->userID}}">
                                                Đóng
                                            </button>
                                            <form action="{{ route("admintrafficbot.account.delete", ["ID" => $account->userID]) }}"
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
                    <!-- end modal delete -->

                    <!-- modal create -->
                    <form action="{{ route("admintrafficbot.account.create") }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div id="modal_create"
                            class="hidden pointer-events-none hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto  flex items-center justify-center">
                            <div
                                class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                                <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                    <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                        <h3 class="text-lg font-medium text-default-900 ">
                                            Thêm tài khoản
                                        </h3>

                                        <button type="button" class="text-default-600 cursor-pointer"
                                            data-hs-overlay="#modal_create">
                                            <i class="i-tabler-x text-lg"></i>
                                        </button>
                                    </div>
                                    <div class="p-4 overflow-y-auto">

                                        <div class="mb-3">
                                            <label for="LicenseName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                                Tên tài khoản
                                            </label>
                                            @error('name')
                                                <div id="name_error"
                                                    class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <input type="text" id="name" name="name" value=""
                                                class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                onfocus="document.getElementById('name_error')?.classList.add('hidden')">
                                        </div>

                                        <div class="mb-3">
                                            <label for="LicenseName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                                Email
                                            </label>
                                            @error('email')
                                                <div id="email_error"
                                                    class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <input type="email" id="email" name="email" value=""
                                                class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                onfocus="document.getElementById('email_error')?.classList.add('hidden')">
                                        </div>
                                        <div class="mb-3">
                                            <label for="LicenseName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                                Mật khẩu
                                            </label>
                                            @error('password')
                                                <div id="password_error"
                                                    class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <input type="password" id="password" name="password" value=""
                                                class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                onfocus="document.getElementById('password_error')?.classList.add('hidden')">
                                        </div>
                                        <div class="mb-3">
                                            <label for="LicenseName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                                Mật khẩu xác nhận
                                            </label>
                                            @error('confirmPassword')
                                                <div id="confirmPassword-error"
                                                    class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <input type="password" id="confirmPassword" name="confirmPassword" value=""
                                                class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                onfocus="document.getElementById('confirmPassword-error')?.classList.add('hidden')">
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-password"
                                                class="text-default-800 text-sm font-medium inline-block mb-2">
                                                Phân quyền</label>
                                            @error('role')
                                                <div id="role-error"
                                                    class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <select name="roleID" class="form-select" id="example-select"
                                                onfocus="document.getElementById('role-error')?.classList.add('hidden')">
                                                @foreach ($roles as $role)
                                                    @if($role->roleName == "admin")
                                                        <option value="{{ $role->roleID }}">quản trị viên</option>
                                                    @elseif($role->roleName == "user")
                                                        <option value="{{ $role->roleID }}">người dùng</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description_image"
                                                class="text-default-800 text-sm font-semibold mb-2 block">Ảnh
                                                đại diện</label>
                                            <input type="file" name="avatar" id="avatar" accept="image/*" class="form-input"
                                                value="">
                                            <div class="justify-center flex">
                                                <img id="preview-avatar" src="" alt="Image"
                                                    class="hidden w-32 h-32 object-contain p-2">
                                            </div>

                                        </div>

                                    </div>
                                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                        <button type="button"
                                            class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                            data-hs-overlay="#modal_create">
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

                    <!-- end modal-->



                    <!-- modal update -->
                    @if(!empty($accounts))
                        @foreach ($accounts as $account)
                            <form action="{{ route("admintrafficbot.account.update", ["ID" => $account->userID]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div id="modal_edit_{{ $account->userID }}"
                                    class="hidden pointer-events-none hs-overlay w-full h-full fixed top-0 left-0 z-70 transition-all duration-500 overflow-y-auto  flex items-center justify-center">
                                    <div
                                        class="translate-y-10 hs-overlay-open:translate-y-0 hs-overlay-open:opacity-100 opacity-0 ease-in-out transition-all duration-500 sm:max-w-lg sm:w-full my-8 sm:mx-auto flex flex-col bg-white shadow-sm rounded">
                                        <div class="flex flex-col border border-default-200 shadow-sm rounded-lg  pointer-events-auto">
                                            <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                                <h3 class="text-lg font-medium text-default-900 ">
                                                    Thêm tài khoản
                                                </h3>

                                                <button type="button" class="text-default-600 cursor-pointer"
                                                    data-hs-overlay="#modal_edit_{{ $account->userID }}">
                                                    <i class="i-tabler-x text-lg"></i>
                                                </button>
                                            </div>
                                            <div class="p-4 overflow-y-auto">

                                                <div class="mb-3">
                                                    <label for="LicenseName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                                        Tên tài khoản
                                                    </label>
                                                    @error('name')
                                                        <div id="name_error"
                                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <input type="text" id="name" name="name" value="{{ $account->name }}"
                                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        onfocus="document.getElementById('name_error')?.classList.add('hidden')">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="LicenseName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                                        Email
                                                    </label>
                                                    @error('email')
                                                        <div id="email_error"
                                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror

                                                    <input type="email" id="email" name="email" value="{{ $account->email }}"
                                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        onfocus="document.getElementById('email_error')?.classList.add('hidden')">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="LicenseName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                                        Mật khẩu
                                                    </label>
                                                    @error('password')
                                                        <div id="password_error"
                                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror

                                                    <input type="password" id="password" name="password" value=""
                                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        onfocus="document.getElementById('password_error')?.classList.add('hidden')">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="LicenseName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                                        Mật khẩu xác nhận
                                                    </label>
                                                    @error('confirmPassword')
                                                        <div id="confirmPassword-error"
                                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <input type="password" id="confirmPassword" name="confirmPassword" value=""
                                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        onfocus="document.getElementById('confirmPassword-error')?.classList.add('hidden')">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="example-password"
                                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                                        Phân quyền</label>
                                                    @error('role')
                                                        <div id="role-error"
                                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <select name="roleID" class="form-select" id="example-select"
                                                        onfocus="document.getElementById('role-error')?.classList.add('hidden')">
                                                        @foreach ($roles as $role)
                                                            @if($role->roleName == "admin" && $account->roleID == $role->roleID)
                                                                <option value="{{ $role->roleID }}">quản trị viên</option>
                                                            @elseif($role->roleName == "user" && $account->roleID == $role->roleID)
                                                                <option value="{{ $role->roleID }}">người dùng</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="example-password"
                                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                                        Trạng thái</label>
                                                    @error('role')
                                                        <div id="status-error"
                                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <select name="status" class="form-select" id="example-select"
                                                        onfocus="document.getElementById('status-error')?.classList.add('hidden')">
                                                        <option value="active" {{ $account->status == "active" ? "selected" : '' }}>kích hoạt
                                                        </option>
                                                        <option value="pending" {{ $account->status == "pending" ? "selected" : '' }}>Chưa
                                                            kích hoạt</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description_image"
                                                        class="text-default-800 text-sm font-semibold mb-2 block">Ảnh
                                                        đại diện</label>
                                                    <input type="file" name="avatar" id="avatar" accept="image/*" class="form-input"
                                                        value="">
                                                    <div class="justify-center flex">
                                                        <img id="preview-avatar" src="" alt="Image"
                                                            class="hidden w-32 h-32 object-contain p-2">
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default-200">
                                                <button type="button"
                                                    class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-md"
                                                    data-hs-overlay="#modal_edit_{{ $account->userID }}">
                                                    <i class="i-tabler-x me-1"></i>
                                                    Thoát
                                                </button>
                                                <button type="submit"
                                                    class="py-2 px-5 inline-flex items-center justify-center font-medium tracking-wide border align-middle duration-500 text-sm text-center bg-primary hover:bg-primary-700 border-primary hover:border-primary-700 text-white rounded-md">
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

                </div>



            </main>

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