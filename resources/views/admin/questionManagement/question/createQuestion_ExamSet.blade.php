@extends("admin.adminPageLayout.layout")
@section("main")

    <main>
        <form action="{{ route("admintrafficbot.examset_question.store", $examSet->ExamSetID) }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <input type="text" name = "redirect-back" hidden value = "{{ url()->current() }}">
            <!-- Page Title Start -->
           
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
                      @error("question_created") 
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
                    @error( "iscritical_null") 
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
                                @php
                                    $categoryID = $category->CategoryID;
                                    $quantity = $categoryQuantity[$categoryID] ?? null;
                                @endphp
                                    <div class="flex items-center mb-2 w-full gap-2">
                                        <!-- Checkbox -->
                                        <div class="w-1/12 flex justify-center category-checkbox">
                                            <input type="checkbox" name="selected_categories[]"
                                                id="checkbox-{{ $categoryID }}" value="{{ $categoryID}}"
                                                class="form-checkbox text-blue-600 w-5 h-5"
                                                {{ $quantity !== null ? "checked" : "" }}>
                                        </div>

                                        <!-- Label -->
                                        <label for="checkbox-{{ $categoryID}}"
                                            class="w-7/12 text-sm font-medium text-gray-800">
                                            {{ $category->CategoryName }}
                                        </label>

                                        <!-- Input số lượng -->
                                        <div class="w-4/12">
                                            <input type="number" name="amounts[{{ $categoryID}}]" min="0"
                                                placeholder="Số lượng" value = {{ $quantity ?? 'null' }}
                                                class="category-input form-input w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
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

    </script>
@endsection