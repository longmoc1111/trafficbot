@extends("admin.adminPageLayout.layout")
@section("main")

    <main>
       <form action="{{ route('admintrafficbot.question.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="bg-white border shadow-xl rounded-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r bg-primary p-6 border-b">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="ti ti-square-plus text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg">Thêm câu hỏi mới</h3>
                        <p class="text-white/80 text-sm">Nhập nội dung câu hỏi và đáp án bên dưới</p>
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
            <!-- Alert nếu có -->
            @foreach (['iscorrect_null', 'answer_null'] as $key)
                @if(session($key))
                    <div class="flex items-center gap-3 bg-red-50 border border-red-200 rounded-md p-4">
                        <i class="ti ti-alert-circle text-red-600 text-xl"></i>
                        <div class="text-sm text-red-800 font-medium flex-grow">
                            {{ session($key) }}
                        </div>
                        <button type="button" onclick="this.closest('div').remove();"
                            class="h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                            <i class="ti ti-x text-red-600 text-xl"></i>
                        </button>
                    </div>
                @endif
            @endforeach

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left column -->
                <div class="space-y-4">
                    <!-- Loại câu hỏi -->
                    <div>
                        <label for="CategoryID" class="text-sm font-medium text-gray-700 mb-1 block">Loại câu hỏi</label>
                        <select name="CategoryID" id="CategoryID"
                            class="form-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500">
                            @foreach ($questionCategory as $category)
                                <option value="{{ $category->CategoryID }}">{{ $category->CategoryName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tên câu hỏi -->
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-1 block">Tên câu hỏi</label>
                        @error('QuestionName')
                            <p class="text-sm text-red-600 bg-red-50 px-2 py-1 rounded mb-1">{{ $message }}</p>
                        @enderror
                        <input type="text" name="QuestionName"
                            class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                    </div>

                    <!-- Đáp án A - D -->
                    @foreach (['A', 'B', 'C', 'D'] as $index => $label)
                        <div>
                            <div class="flex items-center gap-4 mb-1">
                                <label class="text-sm font-medium text-gray-700">Đáp án {{ $label }} (</label>
                                <div class="flex items-center gap-1">
                                    <label class="text-sm font-medium text-gray-700">Đáp án đúng</label>
                                    <input type="radio" name="IsCorrectIndex" value="{{ $index }}"
                                        class="form-radio text-primary">)
                                </div>
                            </div>
                            <input type="text" name="Answers[]" class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                        </div>
                    @endforeach

                    <!-- Giải thích -->
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-1 block">Giải thích về câu hỏi</label>
                        @error('QuestionExplain')
                            <p class="text-sm text-red-600 bg-red-50 px-2 py-1 rounded mb-1">{{ $message }}</p>
                        @enderror
                        <textarea name="QuestionExplain" class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"></textarea>
                    </div>

                    <!-- Ảnh -->
                    <div>
                        <label for="description_image" class="text-sm font-medium text-gray-700 mb-1 block">
                            Ảnh mô tả (cho biển báo / sa hình)
                        </label>
                        <input type="file" name="ImageDescription" id="description_image" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

                <!-- Right column: Áp dụng -->
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700 block mb-2">Áp dụng cho giấy phép</label>

                        <!-- Chọn tất cả -->
                        <div class="flex justify-content-around gap-4 bg-gray-50 p-3 rounded-md border border-gray-200 mb-3">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-600">
                                <span>Chọn tất cả</span>
                                <input type="checkbox" id="select-all-license" class="form-checkbox text-blue-600">
                            </label>
                            <label class="flex items-center gap-2 text-sm font-semibold text-red-600">
                                <span>Chọn tất cả điểm liệt</span>
                                <input type="checkbox" id="select-all-critical" class="form-checkbox text-red-500">
                            </label>
                        </div>

                        <!-- Danh sách giấy phép -->
                        <div class="space-y-3">
                            @foreach ($licenseTypes as $license)
                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-md border border-gray-200">
                                    <div class="text-sm font-medium text-gray-800 w-1/3">
                                        {{ $license->LicenseTypeName }}
                                    </div>
                                    <div class="flex items-center gap-4 w-2/3">
                                        <label class="flex items-center text-sm text-gray-600 gap-2">
                                            <span>Áp dụng</span>
                                            <input type="checkbox" name="licenseTypes[]"
                                                value="{{ $license->LicenseTypeID }}" class="form-checkbox text-blue-600">
                                        </label>
                                        <label class="flex items-center text-sm text-red-600 gap-2">
                                            <span>Điểm liệt</span>
                                            <input type="checkbox" name="criticalTypes[]"
                                                value="{{ $license->LicenseTypeID }}" class="form-checkbox text-red-500">
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
            <button type="reset"
                class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                Đặt lại
            </button>
            <button type="submit"
                class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                Lưu
            </button>
        </div>
    </div>
</form>



    </main>
    <script>

    </script>

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
    </script>

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            const allLicenseType = document.getElementById("select-all-license")
            const allCritical = document.getElementById("select-all-critical");

            const licenseCheckbox = document.querySelectorAll("input[name='licenseTypes[]']")
            const criticalCheckbox = document.querySelectorAll("input[name='criticalTypes[]']")

            allLicenseType.addEventListener("change", function () {
                licenseCheckbox.forEach(checkbox => checkbox.checked = this.checked)
            })
            allCritical.addEventListener("change", function () {
                criticalCheckbox.forEach(checkbox => checkbox.checked = this.checked)
            })
        })
    </script>
@endsection