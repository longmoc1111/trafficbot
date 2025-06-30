@extends("admin.adminPageLayout.layout")
@section("main")

    <main>
        <form action={{ route("admintrafficbot.licensetype.store") }} method="POST">
            @csrf
           

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
                                <div class="mb-3">
                                    <label for="LicenseTypeName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                        Tên giấy phép
                                    </label>
                                    @error('LicenseTypeName', 'create')
                                        <div id="license_Type_error"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <input type="text" id="LicenseTypeName" name="LicenseTypeName" value=""
                                        onfocus="document.getElementById('license_Type_error')?.classList.add('hidden')"
                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div class="mb-3">
                                    <label for="example-email"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Mô tả giấy phép</label>

                                    @error("LicenseTypeDescription", 'create')
                                        <div id="license_type_description_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <textarea type="text" id="example-email" name="LicenseTypeDescription"
                                        class="form-input"
                                        onfocus="document.getElementById('license_type_description_errorr')?.classList.add('hidden')"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="example-email"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Thời gian thi</label>

                                    @error("LicenseTypeDuration", 'create')
                                        <div id="license_type_duration_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="number" id="" name="LicenseTypeDuration" class="form-input"
                                        onfocus="document.getElementById('license_type_duration_errorr')?.classList.add('hidden')">
                                </div>
                                <div class="mb-3">
                                    <label for="example-email"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Số lượng câu hỏi</label>

                                    @error("LicenseTypeQuantity", 'create')
                                        <div id="license_type_quantity_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="number" id="" name="LicenseTypeQuantity" class="form-input"
                                        onfocus="document.getElementById('license_type_quantity_errorr')?.classList.add('hidden')">
                                </div>
                                <div class="">
                                    <label for="example-email"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Số câu đúng tối thiểu</label>

                                    @error("LicenseTypePasscount", 'create')
                                        <div id="license_type_pass_count_errorr"
                                            class="flex items-center bg-red-100 text-red-700 text-sm px-4 mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="number" id="" name="LicenseTypePassCount" class="form-input"
                                        onfocus="document.getElementById('license_type_pass_count_errorr')?.classList.add('hidden')">
                                </div>
                            </div>
                            <div class="p-4 overflow-y-auto">
                                @foreach($QuestionCategory as $category)
                                    <div class="mb-3">
                                        <label for="questionCategory" class="text-gray-700 text-sm font-semibold mb-2 block">
                                            {{ $category->CategoryName }}
                                        </label>
                                        <input type="number" id="questionCategory"
                                             name="questionCategory[{{ $category->CategoryID }}]"
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