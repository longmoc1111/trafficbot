@extends("admin.adminPageLayout.layout")
@section("main")

    <main>
        <form action="{{ route("admintrafficbot.examset_question.store", $examSet->ExamSetID) }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <input type="text" name = "redirect-back" hidden value = "{{ url()->current() }}">
            <!-- Page Title Start -->
            <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
                <h4 class="text-default-900 text-lg font-medium mb-2"></h4>

                <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
                    <a href="#" class="text-sm font-medium text-default-700">OpenDash</a>
                    <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                    <a href="#" class="text-sm font-medium text-default-700">Forms</a>
                    <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                    <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Input</a>
                </div>
            </div>
            <!-- Page Title End -->
            <div class="flex flex-col mb-3">
                <div class="card border rounded shadow w-full">
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <span> <strong class = "text-red-600"> Lưu ý: </strong> Câu điểm liệt sẽ được chọn ngẫu nhiên, số lượng câu cần nhập {{ $examSet->licenseType_ExamSet->pluck("LicenseTypeQuantity")->first() - 1 }}
                    </span>
                    </div>
                </div>  
            </div>
            <div class="flex flex-col">
                <div class="card border rounded shadow w-full">
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <h4 class="text-lg font-semibold">
                            Tạo ngẫu nhiên
                            {{ $examSet->ExamSetName }}
                            ({{ $examSet->licenseType_ExamSet->pluck("LicenseTypeName")->first() }})
                            <input hidden name="licenseTypeID" type="text" value={{  $examSet->licenseType_ExamSet->pluck("LicenseTypeID")->first() }}>
                        </h4>
                        <button type="submit"
                            class="btn border-success text-success hover:bg-success hover:text-white">Tạo</button>
                    </div>

                    @error("quantity_error")
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
                                <button data-hs-remove-element="#dismiss-alert_1" type="button" id="dismiss-test"
                                    class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                                    <i class="i-tabler-x text-xl text-red-600"></i>
                                </button>
                            </div>
                        </div>

                    @enderror
                    <div class="p-6">
                        <!-- Bỏ grid-col-2 để không chia cột -->
                        <div class="w-full">
                            <div class="mb-4 w-full">
                                <label class="text-default-800 text-sm font-medium mb-2 inline-block">
                                    Chọn loại câu hỏi và số lượng cần random
                                </label>

                                @foreach ($questionCategory as $category)
                                    <div class="flex items-center mb-2 w-full gap-2">
                                        <!-- Checkbox -->
                                        <div class="w-1/12 flex justify-center category-checkbox">
                                            <input type="checkbox" name="selected_categories[]"
                                                id="checkbox-{{ $category->CategoryID }}" value="{{ $category->CategoryID }}"
                                                class="form-checkbox text-blue-600 w-5 h-5">
                                        </div>

                                        <!-- Label -->
                                        <label for="checkbox-{{ $category->CategoryID }}"
                                            class="w-7/12 text-sm font-medium text-gray-800">
                                            {{ $category->CategoryName }}
                                        </label>

                                        <!-- Input số lượng -->
                                        <div class="w-4/12">
                                            <input type="number" name="amounts[{{ $category->CategoryID }}]" min="0"
                                                placeholder="Số lượng"
                                                class="category-input form-input w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="flex flex-col gap-6">
                                <div class="card border rounded shadow">
                                    <div class="flex items-center justify-between px-6 py-4 border-b">
                                        <h4 class="text-lg font-semibold">Thêm câu hỏi mới cho
                                            {{ $examSet->ExamSetName }}({{ $examSet->licenseType_ExamSet->pluck("LicenseTypeName")->join(", ") }})
                                        </h4>
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
                                                <div class="mb-3">
                                                    <label for="simpleinput" class="text-default-800 text-sm font-medium inline-block mb-2">
                                                        loại câu hỏi</label>
                                                    <select name="CategoryID" class="form-select" id="example-select">
                                                        @foreach ($questionCategory as $category)
                                                            <option value="{{ $category->CategoryID }}">{{ $category->CategoryName }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div style="display: none" class="mb-3">
                                                    <label for="example-password"
                                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                                        Giấy phép</label>
                                                    <select hidden name="LicenseTypeID[]" class="form-select" id="example-select" multiple>
                                                        @foreach ($licenseTypeExs as $id => $name)
                                                            <option value="{{ $id }}" {{ array_key_exists($id, $allLicenseType) ? "selected" : "" }}>{{ $name }}</option>
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
                                                    <label for="description_image"
                                                        class="text-default-800 text-sm font-medium inline-block mb-2">Ảnh mô tả(đối với câu
                                                        hỏi biển báo, sa hình)</label>
                                                    <input type="file" name="ImageDescription" id="description_image" accept="image/*"
                                                        class="form-input">
                                                </div>



                                                <div>
                                                    <h6 class="text-sm mb-2">Câu điểm liệt</h6>
                                                    <div class="flex flex-col gap-2">
                                                        <div class="form-check">
                                                            <input value="0" type="radio" class="form-radio text-primary" name="IsCritical"
                                                                id="formRadio01" checked>
                                                            <label class="ms-1.5" for="formRadio01">Không</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input value="1" type="radio" class="form-radio text-primary" name="IsCritical"
                                                                id="formRadio02">
                                                            <label class="ms-1.5" for="formRadio02">Có</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>

                                                <div class="mb-3">
                                                    <div class="flex items-center gap-4 mb-2">

                                                        <label for="example-date" class="text-default-800 text-sm font-medium">
                                                            Đáp án A (
                                                        </label>


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



                                            </div>

                                        </div>
                                    </div>
                                </div> 
                            </div> -->

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

    </script>
@endsection