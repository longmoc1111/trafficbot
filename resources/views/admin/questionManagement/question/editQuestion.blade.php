@extends("admin.adminPageLayout.layout")
@section("main")

    <main>
        <form action="{{ route("admintrafficbot.question.update", $question->QuestionID) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <input type="text" name = "redirect-back" hidden value = "{{ url()->current() }}">


            <div class="flex flex-col gap-6">
                <div class="card border rounded shadow">
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <h4 class="text-lg font-semibold">Chỉnh sửa câu hỏi</h4>
                        <button type="submit"
                            class="btn border-success text-success hover:bg-success hover:text-white">Chỉnh sửa</button>
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
                                        @if(empty($question->categoryQuestion_Question->CategoryID))
                                            <option  value="">Chưa thuộc loại câu hỏi nào</option>
                                        @endif
                                            @foreach ($questionCategory as $category)
                                                <option value="{{ $category->CategoryID }}" {{ !empty($question->categoryQuestion_Question->CategoryID) && $category->CategoryID == $question->categoryQuestion_Question->CategoryID ? "selected" : '' }}>
                                                    {{ $category->CategoryName }}</option>
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
                                    <input type="text" name="QuestionName" class="form-input" placeholder=""
                                        value="{{ $question->QuestionName }}">
                                </div>


                                @if(!empty($arrAnswers[0]) && $arrAnswers[0]["AnswerLabel"] == "A")
                                    <div class="mb-3">
                                        <div class="flex items-center gap-4 mb-2">
                                            <!-- Label Đáp án A -->
                                            <label for="example-date" class="text-default-800 text-sm font-medium">
                                                Đáp án {{ $arrAnswers[0]["AnswerLabel"] }} (
                                            </label>

                                            <!-- Radio đáp án đúng -->
                                            <div class="flex items-center gap-1 form-check">
                                                <label class="text-default-800 text-sm font-medium" for="customRadio1">Đáp án
                                                    đúng </label>
                                                <input type="radio" name="IsCorrectIndex" value="0" {{ $arrAnswers[0]["IsCorrect"] == true ? "checked" : ''}}
                                                    class=" form-radio text-primary" id="customRadio1">)
                                            </div>
                                        </div>
                                        <input name="Answers[]" type="text" id="example-palaceholder" class="form-input"
                                            value="{{ $arrAnswers[0]["AnswerName"] }}">
                                               <input  name="AnswerIDs[]" type="hidden" id="example-palaceholder" class="form-input"
                                            value="{{ $arrAnswers[0]["AnswerID"] }}">
                                    </div>

                                @else
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
                                        <input name="Answers[]" type="text" id="example-palaceholder" class="form-input"
                                            value="">
                                    </div>
                                @endif


                                @if(!empty($arrAnswers[1]) && $arrAnswers[1]["AnswerLabel"] == "B")
                                    <div class="mb-3">
                                        <div class="flex items-center gap-4 mb-2">
                                            <!-- Label Đáp án A -->
                                            <label for="example-date" class="text-default-800 text-sm font-medium">
                                                Đáp án {{ $arrAnswers[1]["AnswerLabel"] }} (
                                            </label>

                                            <!-- Radio đáp án đúng -->
                                            <div class="flex items-center gap-1 form-check">
                                                <label class="text-default-800 text-sm font-medium" for="customRadio1">Đáp án
                                                    đúng </label>
                                                <input type="radio" name="IsCorrectIndex" value="1" {{ $arrAnswers[1]["IsCorrect"] == true ? "checked" : ''}}
                                                    class=" form-radio text-primary" id="customRadio1">)
                                            </div>
                                        </div>
                                        <input name="Answers[]" type="text" id="example-palaceholder" class="form-input"
                                            value="{{ $arrAnswers[1]["AnswerName"] }}">
                                             <input  name="AnswerIDs[]" type="hidden" id="example-palaceholder" class="form-input"
                                            value="{{ $arrAnswers[1]["AnswerID"] }}">
                                    </div>
                                  @else
                                    <div class="mb-3">
                                        <div class="flex items-center gap-4 mb-2">
                                            <!-- Label Đáp án A -->
                                            <label for="example-date" class="text-default-800 text-sm font-medium">
                                                Đáp án B (
                                            </label>

                                            <!-- Radio đáp án đúng -->
                                            <div class="flex items-center gap-1 form-check">
                                                <label class="text-default-800 text-sm font-medium" for="customRadio1">Đáp án
                                                    đúng </label>
                                                <input type="radio" name="IsCorrectIndex" value="1"
                                                    class=" form-radio text-primary" id="customRadio1">)
                                            </div>
                                        </div>
                                        <input name="Answers[]" type="text" id="example-palaceholder" class="form-input"
                                            value="">
                                    </div>
                                @endif
                                @if(!empty($arrAnswers[2]) && $arrAnswers[2]["AnswerLabel"] == "C")
                                    <div class="mb-3">
                                        <div class="flex items-center gap-4 mb-2">
                                            <!-- Label Đáp án A -->
                                            <label for="example-date" class="text-default-800 text-sm font-medium">
                                                Đáp án {{ $arrAnswers[2]["AnswerLabel"] }} (
                                            </label>

                                            <!-- Radio đáp án đúng -->
                                            <div class="flex items-center gap-1 form-check">
                                                <label class="text-default-800 text-sm font-medium" for="customRadio1">Đáp án
                                                    đúng </label>
                                                <input type="radio" name="IsCorrectIndex" value="2" {{ $arrAnswers[2]["IsCorrect"] == true ? "checked" : ''}}
                                                    class=" form-radio text-primary" id="customRadio1">)
                                            </div>
                                        </div>


                                        <input name="Answers[]" type="text" id="example-palaceholder" class="form-input"
                                            value="{{ $arrAnswers[2]["AnswerName"] }}">
                                            <input  name="AnswerIDs[]" type="hidden" id="example-palaceholder" class="form-input"
                                            value="{{ $arrAnswers[2]["AnswerID"] }}">
                                    </div>
                                  @else
                                    <div class="mb-3">
                                        <div class="flex items-center gap-4 mb-2">
                                            <!-- Label Đáp án A -->
                                            <label for="example-date" class="text-default-800 text-sm font-medium">
                                                Đáp án C (
                                            </label>

                                            <!-- Radio đáp án đúng -->
                                            <div class="flex items-center gap-1 form-check">
                                                <label class="text-default-800 text-sm font-medium" for="customRadio1">Đáp án
                                                    đúng </label>
                                                <input type="radio" name="IsCorrectIndex" value="2"
                                                    class=" form-radio text-primary" id="customRadio1">)
                                            </div>
                                        </div>
                                        <input name="Answers[]" type="text" id="example-palaceholder" class="form-input"
                                            value="">
                                    </div>
                                @endif
                                @if(!empty($arrAnswers[3]) && $arrAnswers[3]["AnswerLabel"] == "D")
                                    <div class="mb-3">
                                        <div class="flex items-center gap-4 mb-2">
                                            <!-- Label Đáp án D -->
                                            <label for="example-date" class="text-default-800 text-sm font-medium">
                                                Đáp án {{ $arrAnswers[3]["AnswerLabel"] }} (
                                            </label>

                                            <!-- Radio đáp án đúng -->
                                            <div class="flex items-center gap-1 form-check">
                                                <label class="text-default-800 text-sm font-medium" for="customRadio1">Đáp án
                                                    đúng </label>
                                                <input type="radio" name="IsCorrectIndex" value="3" {{ $arrAnswers[3]["IsCorrect"] == true ? "checked" : ''}}
                                                    class=" form-radio text-primary" id="customRadio1">)
                                            </div>
                                        </div>

                                        <input name="Answers[]" type="text" id="example-palaceholder" class="form-input"
                                            value="{{ $arrAnswers[3]["AnswerName"] }}">
                                              <input  name="AnswerIDs[]" type="hidden" id="example-palaceholder" class="form-input"
                                            value="{{ $arrAnswers[3]["AnswerID"] }}">
                                    </div>
                                    @else
                                    <div class="mb-3">
                                        <div class="flex items-center gap-4 mb-2">
                                            <!-- Label Đáp án A -->
                                            <label for="example-date" class="text-default-800 text-sm font-medium">
                                                Đáp án D (
                                            </label>

                                            <!-- Radio đáp án đúng -->
                                            <div class="flex items-center gap-1 form-check">
                                                <label class="text-default-800 text-sm font-medium" for="customRadio1">Đáp án
                                                    đúng </label>
                                                <input type="radio" name="IsCorrectIndex" value="3"
                                                    class=" form-radio text-primary" id="customRadio1">)
                                            </div>
                                        </div>
                                        <input name="Answers[]" type="text" id="example-palaceholder" class="form-input"
                                            value="">
                                    </div>
                                @endif


                                <div class="mb-3">
                                    <label for="example-date"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">giải
                                        thích về câu hỏi</label>
                                    @error("QuestionExplain")
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
                                    <textarea name="QuestionExplain" type="text" id="example-palaceholder"
                                        class="form-input" placeholder="">{{ $question->QuestionExplain }}</textarea>
                                </div>




                                <div class="mb-3">
                                    <label for="description_image"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">Ảnh mô tả(đối với câu
                                        hỏi biển báo, sa hình)</label>
                                    <input type="file" name="ImageDescription" id="description_image" accept="image/*"
                                        class="form-input">
                                    <input type="text" hidden name="OldImageDescription">
                                </div>


                            </div>
                            <div class="mb-4">
                                    <label class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Áp dụng cho giấy phép
                                    </label>
                                      <div
                                        class="flex items-center justify-between bg-gray-50 rounded-md border border-gray-200 shadow-sm  mb-3 p-3">
                                        <div class="flex justify-end w-full gap-6">
                                            <!-- Chọn tất cả Áp dụng -->
                                            <label style="margin-right: 4px;" class="inline-flex items-center text-sm text-gray-600 font-semibold">
                                                <span style="margin-right: 10px;">chọn Tất cả</span>
                                                <input type="checkbox" id="select-all-license"
                                                    class="form-checkbox text-blue-600 rounded-sm">

                                            </label>

                                            <!-- Chọn tất cả Là điểm liệt -->
                                            <label  class="inline-flex items-center text-sm text-red-600 font-semibold">
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
                                                            value="{{ $license->LicenseTypeID }}" {{ in_array($license->LicenseTypeID, $appliedLicenseIDs) ? "checked" : ""  }}
                                                            class="form-checkbox text-blue-600 rounded-sm">

                                                    </label>

                                                    <label class="inline-flex items-center text-sm text-red-600">
                                                        <span style="margin-right: 10px;">Câu điểm liệt</span>

                                                        <input type="checkbox" name="criticalTypes[]"
                                                            value="{{ $license->LicenseTypeID }}" {{ in_array($license->LicenseTypeID, $criticalLicenseIDs) ? "checked" : "" }}
                                                            class="form-checkbox text-red-500 rounded-sm">
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>


                        </div>
                    </div>
                </div> <!-- end card -->
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

    </script>
    <script>
        
        document.addEventListener("DOMContentLoaded", function(){
            const allLicenseType  = document.getElementById("select-all-license")
            const allCritical = document.getElementById("select-all-critical");

            const licenseCheckbox = document.querySelectorAll("input[name='licenseTypes[]']")
            const criticalCheckbox = document.querySelectorAll("input[name='criticalTypes[]']")

            allLicenseType.addEventListener("change" , function(){
                licenseCheckbox.forEach(checkbox => checkbox.checked = this.checked)
            })
            allCritical.addEventListener("change", function(){
                criticalCheckbox.forEach(checkbox => checkbox.checked = this.checked)
            })
        })
    </script>
@endsection