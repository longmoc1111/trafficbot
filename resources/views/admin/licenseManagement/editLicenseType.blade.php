@extends("admin.adminPageLayout.layout")
@section("main")

    <main>
        <form action={{ route("admintrafficbot.licensetype.update", ["ID"=>$editLicenseType->LicenseTypeID]) }} method="POST">
            @csrf
            @method("PUT")
            <!-- Page Title Start -->
            <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
                <h4 class="text-default-900 text-lg font-medium mb-2"></h4>

                <!-- <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
                    <a href="#" class="text-sm font-medium text-default-700">OpenDash</a>
                    <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                    <a href="#" class="text-sm font-medium text-default-700">Forms</a>
                    <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                    <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Input</a>
                </div> -->
            </div>
            <!-- Page Title End -->

               <div class="flex flex-col gap-6">
                <div class="card border rounded shadow">
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <h4 class="text-lg font-semibold">Thêm mới giấy phép</h4>
                        <button type="submit"
                            class="btn border-success text-success hover:bg-success hover:text-white">Tạo</button>
                    </div>
                   
                    <div class="p-6">
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div class="p-4 overflow-y-auto">
                                @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
        <ul class="list-disc pl-5 text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                                <div class="mb-3">
                                    <label for="LicenseTypeName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                        Tên giấy phép
                                    </label>
                                    @error('LicenseTypeName', 'edit')
                                        <div id="license_Type_error"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <input type="text" id="LicenseTypeName" name="LicenseTypeName" value="{{ $editLicenseType->LicenseTypeName }}"
                                        onfocus="document.getElementById('license_Type_error')?.classList.add('hidden')"
                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div class="mb-3">
                                    <label for="example-email"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Mô tả giấy phép</label>

                                    @error("LicenseTypeDescription", 'edit')
                                        <div id="license_type_description_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <textarea type="text" id="example-email" name="LicenseTypeDescription"
                                        class="form-input"
                                        onfocus="document.getElementById('license_type_description_errorr')?.classList.add('hidden')">{{ $editLicenseType->LicenseTypeDescription }}"</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="example-email"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Thời gian thi</label>

                                    @error("LicenseTypeDuration", 'edit')
                                        <div id="license_type_duration_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="number" id="" name="LicenseTypeDuration" class="form-input" value="{{ $editLicenseType->LicenseTypeDuration }}"
                                        onfocus="document.getElementById('license_type_duration_errorr')?.classList.add('hidden')">
                                </div>
                                <div class="mb-3">
                                    <label for="example-email"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Số lượng câu hỏi</label>

                                    @error("LicenseTypeQuantity", 'edit')
                                        <div id="license_type_quantity_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="number" id="" name="LicenseTypeQuantity" class="form-input" value="{{ $editLicenseType->LicenseTypeQuantity }}"
                                        onfocus="document.getElementById('license_type_quantity_errorr')?.classList.add('hidden')">
                                </div>
                                <div class="">
                                    <label for="example-email"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Số câu đúng tối thiểu</label>

                                    @error("LicenseTypePasscount", 'edit')
                                        <div id="license_type_pass_count_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="number" id="" name="LicenseTypePassCount" class="form-input" value="{{ $editLicenseType->LicenseTypePassCount }}"
                                        onfocus="document.getElementById('license_type_pass_count_errorr')?.classList.add('hidden')">
                                </div>
                            </div>
                       
                            <div class="p-4 overflow-y-auto">
                                @foreach($questionCategory as $category)
                                    <div class="mb-3">
                                        <label for="questionCategory" class="text-gray-700 text-sm font-semibold mb-2 block">
                                            {{ $category->CategoryName }}
                                        </label>
                                            <input type="number" id="questionCategory"
                                                name="questionCategory[{{ $category->CategoryID }}]"
                                                    value="{{ $categoryQuantity[$category->CategoryID] ?? '' }}"
                                                placeholder="Số lượng câu hỏi"
                                                onfocus="document.getElementById('license_Type_error')?.classList.add('hidden')"
                                                class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div> <!-- end card -->
            </div>


        </form>


    </main>

@endsection
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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


        // multiple select
        function multiSelect() {
            return {
                open: false,
                options: ['Option 1', 'Option 2', 'Option 3', 'Option 4', 'Option 5'],
                selectedOptions: [],
                toggleOption(option) {
                    if (this.selectedOptions.includes(option)) {
                        this.selectedOptions = this.selectedOptions.filter(item => item !== option);
                    } else {
                        this.selectedOptions.push(option);
                    }
                }
            }
        }
        // end multiple select
    </script>
@endsection