@extends("admin.adminPageLayout.layout")
@section("main")

    <main>
        <form action="" method="POST" enctype="multipart/form-data" >
            @csrf
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

            <div class="flex flex-col gap-6">
                <div class="card border rounded shadow">
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <h4 class="text-lg font-semibold">Thêm loại câu hỏi mới</h4>
                        <button type="submit"
                            class="btn border-success text-success hover:bg-success hover:text-white">Tạo</button>
                    </div>

                    <div class="p-6">
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
 
                                <div class = "mb-3">
                                    <label for="SignageName" class="text-default-800 text-sm font-semibold mb-2 block">
                                        Tên loại câu hỏi
                                    </label>
                                    <input type="text" id="SignageName" name="SignageName"
                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500
                                            {{ $errors->has('LicenseTypeName') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300' }}" value="{{ old('LicenseTypeName') }}">
                                </div>

                            </div>



                            <div>

                                <div class="mb-3">
                                    <label for="description_image"
                                        class="text-default-800 text-sm font-semibold mb-2 block">Ảnh mô tả</label>
                                    <input type="file" name="SignageImage" id="description_image" accept="image/*"
                                        class="form-input">
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