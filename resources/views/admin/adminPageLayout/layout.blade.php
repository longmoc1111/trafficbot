<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield("title")</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="MyraStudio" name="author">

    <!-- App favicon -->
    <link rel="icon" href="{{ asset('assets/logo/icon.png') }}" type="image/png">

    <!-- Icons css  (Mandatory in All Pages) -->
    <link href="/assets/adminPage/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- <link href="/assets/adminPage/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css"> -->
    <title>admin page</title>
    <!-- App css  (Mandatory in All Pages) -->
    <link href="/assets/adminPage/css/app.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/izitoast/css/iziToast.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    
    <!-- Custom Modal Styles -->
    <style>
        /* Modal CSS - Simplified and Fixed */
        #modal-profile {
            z-index: 99999 !important;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        
        #modal-profile.hs-overlay-open {
            background: rgba(0, 0, 0, 0.7) !important;
        }
        
        /* Custom Scrollbar */
        .modal-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .modal-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        .modal-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .modal-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Animation */
        .modal-content {
            animation: modalFadeIn 0.3s ease-out;
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
    </style>

</head>

<body>
    <!-- Tailwind spinner -->

    <div class="wrapper">
        <!-- Start Sidebar -->
        <aside id="app-menu"
            class="hs-overlay fixed inset-y-0 start-0 z-60 hidden w-sidenav min-w-sidenav bg-white border-e border-default-200 overflow-y-auto -translate-x-full transform transition-all duration-300 hs-overlay-open:translate-x-0 lg:bottom-0 lg:end-auto lg:z-30 lg:block lg:translate-x-0 rtl:translate-x-full rtl:hs-overlay-open:translate-x-0 rtl:lg:translate-x-0 print:hidden [--body-scroll:true] [--overlay-backdrop:true] lg:[--overlay-backdrop:false]">

            <!-- Sidenav Logo -->
            <div
                class="sticky top-0 flex h-topbar items-center justify-center px-6 border-b border-default-200 .bg-primary/5">
                <h2>TRAFFICBOT</h2>
            </div>

            <div class="p-4" data-simplebar>
                <ul class="admin-menu hs-accordion-group flex w-full flex-col gap-1.5">
                    <li class="menu-item">
                        <a class='group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5'
                            href='{{route("admintrafficbot.dashboard")}}'>
                            <i class="i-solar-home-smile-bold-duotone text-2xl"></i>
                            Bảng điều khiển
                        </a>
                    </li>

                    <li class="px-5 py-2 text-sm font-medium text-default-600">Hệ thống trắc nghiệm</li>

                    <li class="menu-item hs-accordion">
                        <a href="javascript:void(0)"
                            class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5 hs-accordion-active:bg-primary/10 hs-accordion-active:text-primary">
                            <i class="i-solar-box-minimalistic-bold-duotone text-2xl"></i>
                            <span class="menu-text">Quản lý đề thi & câu hỏi </span>
                            <span
                                class="i-tabler-chevron-right ms-auto text-sm transition-all hs-accordion-active:rotate-90"></span>
                        </a>

                        <div
                            class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                            <ul class="mt-2 space-y-2">
                                <li class="menu-item">
                                    <a class='flex items-center gap-x-3.5 rounded-md px-5 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5'
                                        href='{{ route("admintrafficbot.question.category") }}'>
                                        <i class="i-tabler-circle-filled scale-[.25] text-lg opacity-75"></i>
                                        Phân Loại câu hỏi
                                    </a>
                                </li>



                                <li class="menu-item">
                                    <a class='flex items-center gap-x-3.5 rounded-md px-5 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5'
                                        href='{{ route("admintrafficbot.question") }}'>
                                        <i class="i-tabler-circle-filled scale-[.25] text-lg opacity-75"></i>
                                        Danh sách câu hỏi
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class='flex items-center gap-x-3.5 rounded-md px-5 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5'
                                        href='{{ route("admintrafficbot.examset") }}'>
                                        <i class="i-tabler-circle-filled scale-[.25] text-lg opacity-75"></i>
                                        Danh sách đề thi
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="menu-item hs-accordion">
                        <a href="javascript:void(0)"
                            class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5 hs-accordion-active:bg-primary/10 hs-accordion-active:text-primary">
                            <i class="i-solar-document-text-bold-duotone text-2xl"></i>
                            <span class="menu-text"> Quản lý biển báo </span>
                            <span
                                class="i-tabler-chevron-right ms-auto text-sm transition-all hs-accordion-active:rotate-90"></span>
                        </a>

                        <div
                            class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                            <ul class="mt-2 space-y-2">
                                <li class="menu-item">
                                    <a class='flex items-center gap-x-3.5 rounded-md px-5 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5'
                                        href='{{ route("admintrafficbot.listsignagetypes") }}'>
                                        <i class="i-tabler-circle-filled scale-[.25] text-lg opacity-75"></i>
                                        <span class="menu-text">Phân loại biển báo</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a class='flex items-center gap-x-3.5 rounded-md px-5 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5'
                                        href='{{ route("admintrafficbot.listsignages") }}'>
                                        <i class="i-tabler-circle-filled scale-[.25] text-lg opacity-75"></i>
                                        <span class="menu-text">Danh sách biển báo</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="menu-item">
                        <a class='group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5 hs-accordion-active:bg-default-900/5'
                            href='{{ route("admintrafficbot.listlicensetype") }}'>
                            <i class="i-solar-file-bold-duotone text-2xl"></i>
                            <span class="menu-text">Quản lý giấy phép</span>
                        </a>
                    </li>

                    <li class="px-5 py-2 text-sm font-medium text-default-600">Quản lý người dùng</li>

                    <li class="menu-item hs-accordion">
                        <a href="javascript:void(0)"
                            class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5 hs-accordion-active:bg-primary/10 hs-accordion-active:text-primary">
                            <i class="i-solar-box-minimalistic-bold-duotone text-2xl"></i>
                            <span class="menu-text"> Quản lý tài khoản </span>
                            <span
                                class="i-tabler-chevron-right ms-auto text-sm transition-all hs-accordion-active:rotate-90"></span>
                        </a>

                        <div
                            class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                            <ul class="mt-2 space-y-2">

                                <li class="menu-item">
                                    <a class='flex items-center gap-x-3.5 rounded-md px-5 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5'
                                        href='{{ route("admintrafficbot.listaccount") }}'>
                                        <i class="i-tabler-circle-filled scale-[.25] text-lg opacity-75"></i>
                                        Danh sách tài khoản
                                    </a>
                                </li>

                                <!-- <li class="menu-item">
                                    <a class='flex items-center gap-x-3.5 rounded-md px-5 py-2 text-sm font-medium text-default-700 hover:bg-default-900/5'
                                        href='/opendash/ui-buttons'>
                                        <i class="i-tabler-circle-filled scale-[.25] text-lg opacity-75"></i>
                                        Buttons
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                    </li>

                    <li class="px-5 py-2 text-sm font-medium text-default-600">Quản lý chatbot</li>

                    <li class="menu-item">
                        <a class='group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5 hs-accordion-active:bg-default-900/5'
                            href='{{ route("admintrafficbot.chatbot") }}'>
                            <i class="i-solar-file-bold-duotone text-2xl"></i>
                            <span class="menu-text">Danh sách dữ liệu</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <!-- End Sidebar -->
        <!-- Start Page Content here -->
        <div class="page-content">

            <!-- Topbar Start -->
            <header
                class="app-header sticky top-0 z-50 h-topbar flex items-center px-5 bg-white border-b border-default-200">
                <div class="container flex items-center gap-4">
                    <!-- Topbar Brand Logo -->
                    <!-- <a class='md:hidden flex' href='/opendash/'>
                        <img src="assets/images/logo-sm.png" class="h-6" alt="Small logo">
                    </a> -->

                    <!-- Sidenav Menu Toggle Button -->
                    <button id="button-toggle-menu"
                        class="text-default-500 hover:text-default-600 p-2 rounded-full cursor-pointer"
                        data-hs-overlay="#app-menu" aria-label="Toggle navigation">
                        <i class="i-tabler-menu-2 text-2xl"></i>
                    </button>

                    <!-- Topbar Search -->


                    <!-- Language Dropdown Button -->
                    <div class="ms-auto hs-dropdown relative inline-flex [--placement:bottom-right]">

                    </div>

                    <!-- Fullscreen Toggle Button -->
                    <div class="md:flex hidden">
                        <button data-toggle="fullscreen" type="button" class="p-2">
                            <span class="sr-only">Fullscreen Mode</span>
                            <span class="flex items-center justify-center size-6">
                                <i class="i-tabler-maximize text-2xl flex group-[-fullscreen]:hidden"></i>
                                <i class="i-tabler-minimize text-2xl hidden group-[-fullscreen]:flex"></i>
                            </span>
                        </button>
                    </div>

                    <!-- Profile Dropdown Button -->
                    <div class="relative">
                        <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                            <div class="flex items-center space-x-3 bg-white rounded-xl shadow-md p-2"
                                style="width: 150px;">
                                <button type="button" class="hs-dropdown-toggle focus:outline-none">
                                    @if(!empty(Auth::user()->avatar))
                                    <img src="{{ asset('storage/uploads/avatar/' . Auth::user()->avatar)}}"
                                        alt="user-image"
                                        class="rounded-full h-10 w-10 object-cover border-2 border-red-500">
                                    @else
                                    <img src="/assets/avatar_default/avatar_default.png" alt="user-image"
                                        class="rounded-full h-10 w-10 object-cover border-2 border-gray-300">
                                    @endif
                                </button>
                                <p class="text-gray-800 font-semibold truncate">{{ Auth::user()->name }}</p>
                            </div>

                            <div
                                class="hs-dropdown-menu absolute mt-2 min-w-48 rounded-lg border border-gray-200 bg-white p-2 opacity-0 shadow-md transition-[opacity,margin] hs-dropdown-open:opacity-100 hidden">
                                <button type="button"
                                    class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100"
                                    data-hs-overlay="#modal-profile">
                                    Thông tin cá nhân
                                </button>
                                <hr class="my-2">
                                <form class="w-full" action="{{ route('logout.post') }}" method="post">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left flex items-center py-2 px-3 rounded-md text-sm text-red-600 hover:bg-red-50 hover:text-red-700">
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Topbar End -->

            @yield("main")

            <!-- Modal Profile Start -->
            <div id="modal-profile" class="hs-overlay hidden fixed inset-0 z-[99999] overflow-x-hidden overflow-y-auto">
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
                                        <p class="text-white/80 text-sm">Quản lý thông tin tài khoản</p>
                                    </div>
                                </div>
                                <button type="button" 
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors" 
                                        data-hs-overlay="#modal-profile">
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
                                    @if(!empty(Auth::user()->avatar))
                                    <img src="{{ asset('storage/uploads/avatar/' . Auth::user()->avatar)}}" 
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
                                    <h4 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h4>
                                    <p class="text-gray-500 text-sm">{{ Auth::user()->email }}</p>
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
                                            <p class="text-gray-900 font-semibold">{{ Auth::user()->name }}</p>
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
                                            <p class="text-gray-900 font-semibold truncate">{{ Auth::user()->email }}</p>
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
                                                {{ Auth::user()->role_User->roleName ?? 'Người dùng' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
                            <button type="button" 
                                    class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors" 
                                    data-hs-overlay="#modal-profile">
                                Đóng
                            </button>
                            <button type="button" 
                                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                Chỉnh sửa
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Profile End -->

            <!-- Footer Start -->
            <footer class="footer bg-white h-16 flex items-center px-6 border-t border-gray-200">
                <div class="container flex md:justify-between justify-center w-full gap-4">
                    <!-- <div>
                        <script>document.write(new Date().getFullYear())</script> © OpenDash
                    </div>
                    <div class="md:flex hidden gap-2 item-center md:justify-end">
                        Design &amp; Develop by<a href="#" class="text-primary">MyraStudio</a>
                    </div> -->
                </div>
            </footer>
            <!-- Footer End -->

        </div>
        <!-- End Page content -->


    </div>

    <!-- Plugin Js (Mandatory in All Pages) -->
    <script src="/assets/adminPage/libs/jquery/jquery.min.js"></script>
    <script src="/assets/adminPage/libs/preline/preline.js"></script>
    <script src="/assets/adminPage/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/adminPage/libs/iconify-icon/iconify-icon.min.js"></script>
    <script src="/assets/adminPage/libs/node-waves/waves.min.js"></script>

    <!-- App Js (Mandatory in All Pages) -->
    <script src="/assets/adminPage/js/app.js"></script>
    <script src="/assets/adminPage/libs/lodash/lodash.min.js"></script>
    <script src="/assets/adminPage/libs/dropzone/dropzone-min.js"></script>
    <script src="/assets/adminPage/libs/quill/quill.min.js"></script>
    <script src="/assets/adminPage/js/pages/form-editor.js"></script>
    <script src="/assets/izitoast/js/iziToast.min.js"></script>
    <script src="/assets/adminPage/libs/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/adminPage/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="/assets/adminPage/js/pages/dashboard.js"></script>
</body>
@yield("footer")
@yield("izitoast")

</html>