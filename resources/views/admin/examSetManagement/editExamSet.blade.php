@extends("admin.adminPageLayout.layout")
@section("main")

    <main>
        <form action={{ route("admintrafficbot.examset.update", $editExamSet) }} method="POST">
            @csrf
            @method("PUT")
          

            <div class="flex flex-col gap-6">
                <div class="card border rounded shadow">
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <h4 class="text-lg font-semibold">Chỉnh sửa bộ đề </h4>
                        <button type="submit"
                            class="btn border-success text-success hover:bg-success hover:text-white">Chỉnh sửa</button>
                    </div>
                    @if(session('exists_exam'))
                        <div id="dismiss-alert"
                            class="hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 bg-red-50 border border-red-200 rounded-md p-4"
                            role="alert">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <i class="i-tabler-circle-x text-xl text-red-600"></i>
                                </div>
                                <div class="flex-grow">
                                    <div class="text-sm text-red-800 font-medium">
                                        {{ session('exists_exam') }}
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
                        <div>

                        </div>
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
                                <div>
                                    <label for="LicenseTypeName" class="text-gray-700 text-sm font-semibold mb-2 block">
                                        Tên bộ đề
                                    </label>
                                    <input type="text" name="ExamSetName"
                                        class="form-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        value="{{ $editExamSet->ExamSetName }}">
                                    <input name="OldExamSetName" type="text" hidden value="{{ $editExamSet->ExamSetName }}">
                                </div>
                            </div>


                            <div>
                                <div class="mb-3">
                                    <label for="example-email"
                                        class="text-default-800 text-sm font-medium inline-block mb-2">
                                        Giấy phép sử dụng bộ đề</label>
                                    <select name="LicenseTypeID[]" class="form-select" id="example-select" multiple>
                                        @foreach ($AllLicense as $id => $name)
                                            <option value="{{ $id }}" {{ array_key_exists($id, $ExsLicense) ? "selected" : ""}}>
                                                {{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
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