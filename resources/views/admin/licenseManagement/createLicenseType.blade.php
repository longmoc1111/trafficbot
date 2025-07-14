@extends("admin.adminPageLayout.layout")
@section("main")

    <main>
     <form action="{{ route('admintrafficbot.licensetype.store') }}" method="POST">
    @csrf

    <div class="bg-white border shadow-xl rounded-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r bg-primary p-6 border-b">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="ti ti-id text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg">Thêm mới giấy phép</h3>
                        <p class="text-white/80 text-sm">Nhập thông tin giấy phép bên dưới</p>
                    </div>
                </div>
                <button type="submit"
                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors">
                    Tạo
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left -->
                <div class="space-y-4">
                    {{-- Tên --}}
                    <div>
                        <label for="LicenseTypeName" class="block text-sm font-medium text-gray-700 mb-1">
                            Tên giấy phép
                        </label>
                        @error('LicenseTypeName', 'create')
                            <p class="mb-1 text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">{{ $message }}</p>
                        @enderror
                        <input type="text" id="LicenseTypeName" name="LicenseTypeName"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                    </div>

                    {{-- Mô tả --}}
                    <div>
                        <label for="LicenseTypeDescription" class="block text-sm font-medium text-gray-700 mb-1">
                            Mô tả giấy phép
                        </label>
                        @error('LicenseTypeDescription', 'create')
                            <p class="mb-1 text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">{{ $message }}</p>
                        @enderror
                        <textarea id="LicenseTypeDescription" name="LicenseTypeDescription"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"></textarea>
                    </div>

                    {{-- Thời gian thi --}}
                    <div>
                        <label for="LicenseTypeDuration" class="block text-sm font-medium text-gray-700 mb-1">
                            Thời gian thi (phút)
                        </label>
                        @error('LicenseTypeDuration', 'create')
                            <p class="mb-1 text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">{{ $message }}</p>
                        @enderror
                        <input type="number" id="LicenseTypeDuration" name="LicenseTypeDuration"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                    </div>

                    {{-- Số lượng câu hỏi --}}
                    <div>
                        <label for="LicenseTypeQuantity" class="block text-sm font-medium text-gray-700 mb-1">
                            Số lượng câu hỏi
                        </label>
                        @error('LicenseTypeQuantity', 'create')
                            <p class="mb-1 text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">{{ $message }}</p>
                        @enderror
                        <input type="number" id="LicenseTypeQuantity" name="LicenseTypeQuantity"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                    </div>

                    {{-- Số câu đúng tối thiểu --}}
                    <div>
                        <label for="LicenseTypePassCount" class="block text-sm font-medium text-gray-700 mb-1">
                            Số câu đúng tối thiểu
                        </label>
                        @error('LicenseTypePassCount', 'create')
                            <p class="mb-1 text-sm text-red-600 bg-red-50 rounded-md px-2 py-1">{{ $message }}</p>
                        @enderror
                        <input type="number" id="LicenseTypePassCount" name="LicenseTypePassCount"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                    </div>
                </div>

                <!-- Right -->
                <div class="space-y-4">
                    @foreach ($QuestionCategory as $category)
                        <div>
                            <label for="questionCategory_{{ $category->CategoryID }}"
                                class="block text-sm font-medium text-gray-700 mb-1">
                                {{ $category->CategoryName }}
                            </label>
                            <input type="number"
                                id="questionCategory_{{ $category->CategoryID }}"
                                name="questionCategory[{{ $category->CategoryID }}]"
                                placeholder="Số lượng câu hỏi"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
            <button type="reset"
                class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                Đặt lại
            </button>
        </div>
    </div>
</form>




    </main>

@endsection

@section("footer")
    <script>
        (function () {
            const { element } = HSFileUpload.getInstance('#hs-file-upload-with-limited-file-size', true);

            element.dropzone.on('error', (file, response) => {
                if (file.size > element.concatOptions.maxFilesize * 1024 * 1024) {
                    const successEls = document.querySelectorAll('[data-hs-file-upload-file-success]');
                    const errorEls = document.querySelectorAll('[data-hs-file-upload-file-error]');

                    successEls.forEach((el) => el.style.display = 'none');
                    errorEls.forEach((el) => el.style.display = '');
                    HSStaticMethods.autoInit(['tooltip']);
                }
            });
        })();


        document.addEventListener("DOMContentLoaded", function () {
            const alert = document.getElementById("dismiss-alert_2");

            if (alert) {
                setTimeout(() => {
                    // Thêm hiệu ứng mờ dần nếu muốn
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = 0;

                    setTimeout(() => {
                        alert.remove(); // Xóa khỏi DOM sau khi ẩn
                    }, 500); // đợi hiệu ứng ẩn hoàn tất
                }, 3000);
            }
        });



    </script>
@endsection