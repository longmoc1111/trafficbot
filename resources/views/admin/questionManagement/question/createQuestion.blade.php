@extends("admin.adminPageLayout.layout")
@section("main")

    <main>
        <form action="{{ route("admintrafficbot.question.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            

            <div class="flex flex-col gap-6">
                <div class="card border rounded shadow">
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <h4 class="text-lg font-semibold">Thêm câu hỏi mới</h4>
                        <button type="submit"
                            class="btn border-success text-success hover:bg-success hover:text-white">Tạo</button>
                    </div>
                    @if(session('iscorrect_null'))
                        <div id="dismiss-alert"
                            class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-50 border border-red-200 rounded-md p-4"
                            role="alert">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <i class="i-tabler-circle-x text-xl text-red-600"></i>
                                </div>
                                <div class="flex-grow">
                                    <div class="text-sm text-red-800 font-medium">
                                        {{ session('iscorrect_null') }}
                                    </div>
                                </div>
                                <button data-hs-remove-element="#dismiss-alert" type="button" id="dismiss-test"
                                    class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                                    <i class="i-tabler-x text-xl text-red-600"></i>
                                </button>
                            </div>
                        </div>

                    @endif
                    @if(session('answer_null'))
                        <div id="dismiss-alert"
                            class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-50 border border-red-200 rounded-md p-4"
                            role="alert">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <i class="i-tabler-circle-x text-xl text-red-600"></i>
                                </div>
                                <div class="flex-grow">
                                    <div class="text-sm text-red-800 font-medium">
                                        {{ session('answer_null') }}
                                    </div>
                                </div>
                                <button data-hs-remove-element="#dismiss-alert" type="button" id="dismiss-test"
                                    class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                                    <i class="i-tabler-x text-xl text-red-600"></i>
                                </button>
                            </div>
                        </div>

                    @endif


                    <div class="p-6">
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label for="CategoryID" class="text-gray-700 text-sm font-medium mb-2 block">
                                        Loại câu hỏi
                                    </label>
                                    <select name="CategoryID" id="CategoryID"
                                        class="form-select w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        @foreach ($questionCategory as $category)
                                            <option value="{{ $category->CategoryID }}">{{ $category->CategoryName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="example-palaceholder"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">Tên câu hỏi</label>
                                    @error("QuestionName")
                                        <div id="dismiss-alert"
                                            class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-100 border rounded-md "
                                            role="alert">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0">
                                                    <i class="i-tabler-circle-x text-red-600"></i>
                                                </div>
                                                <div class="flex-grow">
                                                    <div class="text-sm text-red-800 font-medium">
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                                <button data-hs-remove-element="#dismiss-alert" type="button" id="dismiss-test"
                                                    class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                                                    <i class="i-tabler-x text-xl text-red-600"></i>
                                                </button>
                                            </div>
                                        </div>

                                    @enderror
                                    <input type="text" name="QuestionName" class="form-input" placeholder="">
                                </div>



                                <div class="mb-3">
                                    <div class="flex items-center gap-4 mb-2">
                                        <!-- Label Đáp án A -->
                                        <label for="example-date" class="text-default-800 text-sm font-medium">
                                            Đáp án A (
                                        </label>

                                        <!-- Radio đáp án đúng -->
                                        <div class="flex items-center gap-1 form-check">
                                            <label class="text-default-800 text-sm font-medium" for="customRadio1">Đáp án
                                                đúng </label>
                                            <input type="radio" name="IsCorrectIndex" value="0"
                                                class=" form-radio text-primary" id="customRadio1">)
                                        </div>
                                    </div>

                                    @error("CorrectAnswer")
                                        <div id="dismiss-alert_1"
                                            class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-100 border rounded-md "
                                            role="alert">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0">
                                                    <i class="i-tabler-circle-x text-red-600"></i>
                                                </div>
                                                <div class="flex-grow">
                                                    <div class="text-sm text-red-800 font-medium">
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                                <button data-hs-remove-element="#dismiss-alert_1" type="button"
                                                    id="dismiss-test"
                                                    class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                                                    <i class="i-tabler-x text-xl text-red-600"></i>
                                                </button>
                                            </div>
                                        </div>

                                    @enderror
                                    <input name="Answers[]" type="text" id="example-palaceholder" class="form-input"
                                        placeholder="">
                                </div>

                                <div class="mb-3">
                                    <div class="flex items-center gap-4 mb-2">
                                        <label for="example-date" class="text-default-800 text-sm font-medium">
                                            Đáp án B (
                                        </label>
                                        <div class="flex items-center gap-1 form-check">
                                            <label class="text-default-800 text-sm font-medium" for="customRadio1">Đáp án
                                                đúng </label>
                                            <input type="radio" name="IsCorrectIndex" value="1"
                                                class=" form-radio text-primary" id="customRadio1">)
                                        </div>
                                    </div>
                                    @error("WrongAnswer1")
                                        <div id="dismiss-alert_2"
                                            class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-100 border rounded-md "
                                            role="alert">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0">
                                                    <i class="i-tabler-circle-x text-red-600"></i>
                                                </div>
                                                <div class="flex-grow">
                                                    <div class="text-sm text-red-800 font-medium">
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                                <button data-hs-remove-element="#dismiss-alert_2" type="button"
                                                    id="dismiss-test"
                                                    class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                                                    <i class="i-tabler-x text-xl text-red-600"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @enderror
                                    <input name="Answers[]" type="text" id="example-palaceholder" class="form-input"
                                        placeholder="">
                                </div>
                                <div class="mb-3">
                                    <div class="flex items-center gap-4 mb-2">
                                        <label for="example-date" class="text-default-800 text-sm font-medium">
                                            Đáp án C (
                                        </label>
                                        <div class="flex items-center gap-1 form-check">
                                            <label class="text-default-800 text-sm font-medium" for="customRadio1">Đáp án
                                                đúng </label>
                                            <input type="radio" name="IsCorrectIndex" value="2"
                                                class=" form-radio text-primary" id="customRadio1">)
                                        </div>
                                    </div>
                                    @error("WrongAnswer2")
                                        <div id="dismiss-alert_3"
                                            class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-100 border rounded-md "
                                            role="alert">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0">
                                                    <i class="i-tabler-circle-x text-red-600"></i>
                                                </div>
                                                <div class="flex-grow">
                                                    <div class="text-sm text-red-800 font-medium">
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                                <button data-hs-remove-element="#dismiss-alert_3" type="button"
                                                    id="dismiss-test"
                                                    class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                                                    <i class="i-tabler-x text-xl text-red-600"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @enderror
                                    <input name="Answers[]" type="text" id="example-palaceholder" class="form-input"
                                        placeholder="">
                                </div>
                                <div class="mb-3">
                                    <div class="flex items-center gap-4 mb-2">
                                        <label for="example-date" class="text-default-800 text-sm font-medium">
                                            Đáp án D (
                                        </label>
                                        <div class="flex items-center gap-1 form-check">
                                            <label class="text-default-800 text-sm font-medium" for="customRadio1">Đáp án
                                                đúng </label>
                                            <input type="radio" name="IsCorrectIndex" value="3"
                                                class=" form-radio text-primary" id="customRadio1">)
                                        </div>
                                    </div>
                                    @error("WrongAnswer3")
                                        <div id="dismiss-alert_4"
                                            class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-100 border rounded-md "
                                            role="alert">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0">
                                                    <i class="i-tabler-circle-x text-red-600"></i>
                                                </div>
                                                <div class="flex-grow">
                                                    <div class="text-sm text-red-800 font-medium">
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                                <button data-hs-remove-element="#dismiss-alert_4" type="button"
                                                    id="dismiss-test"
                                                    class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                                                    <i class="i-tabler-x text-xl text-red-600"></i>
                                                </button>
                                            </div>
                                        </div>

                                    @enderror
                                    <input name="Answers[]" type="text" id="example-palaceholder" class="form-input"
                                        placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label for="example-date"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">giải
                                        thích về câu hỏi</label>
                                    @error("QuestionExplain")
                                        <div id="dismiss-alert_4"
                                            class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-100 border rounded-md "
                                            role="alert">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0">
                                                    <i class="i-tabler-circle-x text-red-600"></i>
                                                </div>
                                                <div class="flex-grow">
                                                    <div class="text-sm text-red-800 font-medium">
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                                <button data-hs-remove-element="#dismiss-alert_4" type="button"
                                                    id="dismiss-test"
                                                    class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                                                    <i class="i-tabler-x text-xl text-red-600"></i>
                                                </button>
                                            </div>
                                        </div>

                                    @enderror
                                    <textarea name="QuestionExplain" type="text" id="example-palaceholder"
                                        class="form-input" placeholder=""></textarea>

                                </div>



                                <div class="mb-3">
                                    <label for="description_image"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">Ảnh mô tả(đối với câu
                                        hỏi biển báo, sa hình)</label>
                                    <input type="file" name="ImageDescription" id="description_image" accept="image/*"
                                        class="form-input">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-gray-700 text-sm font-medium mb-2 block">
                                    Áp dụng cho giấy phép
                                </label>
                                <div
                                    class="flex items-center justify-between bg-gray-50 rounded-md border border-gray-200 shadow-sm  mb-3 p-3">
                                    <div class="flex justify-end w-full gap-6">
                                        <!-- Chọn tất cả Áp dụng -->
                                        <label style="margin-right: 4px;"
                                            class="inline-flex items-center text-sm text-gray-600 font-semibold">
                                            <span style="margin-right: 10px;">chọn Tất cả</span>
                                            <input type="checkbox" id="select-all-license"
                                                class="form-checkbox text-blue-600 rounded-sm">

                                        </label>

                                        <!-- Chọn tất cả Là điểm liệt -->
                                        <label class="inline-flex items-center text-sm text-red-600 font-semibold">
                                            <span style="margin-right: 10px;">chọn Tất cả</span>

                                            <input type="checkbox" id="select-all-critical"
                                                class="form-checkbox text-red-500 rounded-sm">

                                        </label>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    @foreach ($licenseTypes as $license)
                                        <div
                                            class="flex items-center justify-between bg-gray-50 p-3 rounded-md border border-gray-200 shadow-sm">
                                            <div class="text-sm font-medium text-gray-800 w-1/3">
                                                {{ $license->LicenseTypeName }}
                                            </div>

                                            <div class="flex items-center gap-4 w-2/3">
                                                <label class="inline-flex items-center text-sm text-gray-600">
                                                    <span style="margin-right: 10px;">Áp dụng</span>
                                                    <input type="checkbox" name="licenseTypes[]"
                                                        value="{{ $license->LicenseTypeID }}"
                                                        class="form-checkbox text-blue-600 rounded-sm">

                                                </label>

                                                <label class="inline-flex items-center text-sm text-red-600">
                                                    <span style="margin-right: 10px;">Câu điểm liệt</span>

                                                    <input type="checkbox" name="criticalTypes[]"
                                                        value="{{ $license->LicenseTypeID }}"
                                                        class="form-checkbox text-red-500 rounded-sm">
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div>





                            </div>

                        </div>
                    </div>
                </div> <!-- end card -->
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