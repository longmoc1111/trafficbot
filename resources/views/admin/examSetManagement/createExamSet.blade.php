@extends("admin.adminPageLayout.layout")
@section("main")

    <main>
        <form action={{ route("admintrafficbot.examset.store") }} method="POST">
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
                        <h4 class="text-lg font-semibold">Tạo bộ đề mới cho {{ $listLicense->LicenseTypeName }}</h4>
                        <button type="submit"
                            class="btn border-success text-success hover:bg-success hover:text-white">Tạo</button>
                    </div>
                    @if(session('errmissing'))
                        <div id="dismiss-alert"
                            class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-50 border border-red-200 rounded-md p-4"
                            role="alert">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <i class="i-tabler-circle-x text-xl text-red-600"></i>
                                </div>
                                <div class="flex-grow">
                                    <div class="text-sm text-red-800 font-medium">
                                        {{ session('errmissing') }}
                                    </div>
                                </div>
                                <button data-hs-remove-element="#dismiss-alert" type="button" id="dismiss-test"
                                    class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                                    <i class="i-tabler-x text-xl text-red-600"></i>
                                </button>
                            </div>
                        </div>

                    @endif
                    @if(session('erronly'))
                        <div id="dismiss-alert"
                            class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-50 border border-red-200 rounded-md p-4"
                            role="alert">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <i class="i-tabler-circle-x text-xl text-red-600"></i>
                                </div>
                                <div class="flex-grow">
                                    <div class="text-sm text-red-800 font-medium">
                                        {{ session('erronly') }}
                                    </div>
                                </div>
                                <button data-hs-remove-element="#dismiss-alert" type="button" id="dismiss-test"
                                    class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                                    <i class="i-tabler-x text-xl text-red-600"></i>
                                </button>
                            </div>
                        </div>

                    @endif

                    @if(session('error_examset_exists'))
                        <div id="dismiss-alert"
                            class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-50 border border-red-200 rounded-md p-4"
                            role="alert">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <i class="i-tabler-circle-x text-xl text-red-600"></i>
                                </div>
                                <div class="flex-grow">
                                    <div class="text-sm text-red-800 font-medium">
                                        {{ session('error_examset_exists') }}
                                    </div>
                                </div>
                                <button data-hs-remove-element="#dismiss-alert" type="button" id="dismiss-test"
                                    class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                                    <i class="i-tabler-x text-xl text-red-600"></i>
                                </button>
                            </div>
                        </div>

                    @endif

                    @if(session('err_examset_not_found'))
                        <div id="dismiss-alert"
                            class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-50 border border-red-200 rounded-md p-4"
                            role="alert">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <i class="i-tabler-circle-x text-xl text-red-600"></i>
                                </div>
                                <div class="flex-grow">
                                    <div class="text-sm text-red-800 font-medium">
                                        {{ session('err_examset_not_found') }}
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
                                <label for="LicenseTypeName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                    Tên bộ đề
                                </label>
                                <input type="text" id="LicenseTypeName" name="ExamSetName"
                                    class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>


                            <input hidden name="LicenseTypeID" type="text" value="{{ $currenlicenseID }}">
                            <div>
                                <label for="example-email" class="text-default-800 text-sm font-medium inline-block mb-2">
                                    Chọn bộ đề đã có sẵn(đối với hệ thống câu hỏi giống nhau)</label>
                                <select name="ExamSetID" class="form-select" id="example-select">
                                    <option value="">chọn bộ đề có sẵn</option>
                                    @foreach ($listExamset as $examset)
                                        <option value="{{ $examset->ExamSetID }}">
                                            {{ $examset->ExamSetName . "   (" . $examset->licenseType_Examset->pluck("LicenseTypeName")->join(",") . ")"  }}
                                        </option>
                                    @endforeach
                                </select>
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
@endsection