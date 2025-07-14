@extends("admin.adminPageLayout.layout")
@section("main")

   <main>
    <form action="{{ route("admintrafficbot.examset_question.store", $examSet->ExamSetID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="redirect-back" value="{{ url()->current() }}">

        <div class="bg-white border shadow-xl rounded-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r bg-primary p-6 border-b">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="ti ti-list-details text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-lg">
                                Tạo ngẫu nhiên: {{ $examSet->ExamSetName }}
                            </h3>
                            <p class="text-white/80 text-sm">
                                Hạng {{ $examSet->licenseType_ExamSet->pluck("LicenseTypeName")->first() }}
                            </p>
                        </div>
                    </div>

                    <button type="submit"
                        class="px-4 py-2 text-sm font-semibold rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors">
                        Tạo
                    </button>
                </div>
                <input type="hidden" name="licenseTypeID" value="{{ $examSet->licenseType_ExamSet->pluck("LicenseTypeID")->first() }}">
            </div>

            <!-- Body -->
            <div class="p-6 space-y-6">
                {{-- Hiển thị lỗi --}}
                @foreach (['quantity_error', 'question_created', 'iscritical_null'] as $errorKey)
                    @error($errorKey)
                        <div class="bg-red-100 border border-red-300 text-sm text-red-700 rounded-md px-4 py-3 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <i class="i-tabler-circle-x text-lg text-red-600"></i>
                                <span>{{ $message }}</span>
                            </div>
                            <button type="button" class="h-6 w-6 rounded-full bg-white hover:bg-red-200 flex items-center justify-center"
                                onclick="this.parentElement.remove()">
                                <i class="i-tabler-x text-red-600 text-base"></i>
                            </button>
                        </div>
                    @enderror
                @endforeach

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Chọn loại câu hỏi và số lượng cần random
                    </label>

                    @foreach ($questionCategory as $category)
                        @php
                            $categoryID = $category->CategoryID;
                            $quantity = $categoryQuantity[$categoryID] ?? null;
                        @endphp

                        <div class="grid grid-cols-12 items-center gap-3 mb-3">
                            <!-- Checkbox -->
                            <div class="col-span-1 flex justify-center">
                                <input type="checkbox" name="selected_categories[]"
                                    id="checkbox-{{ $categoryID }}" value="{{ $categoryID }}"
                                    class="form-checkbox text-blue-600 w-5 h-5"
                                    {{ $quantity !== null ? "checked" : "" }}>
                            </div>

                            <!-- Tên loại -->
                            <label for="checkbox-{{ $categoryID }}"
                                class="col-span-7 text-sm text-gray-800 font-medium">
                                {{ $category->CategoryName }}
                            </label>

                            <!-- Input số lượng -->
                            <div class="col-span-4">
                                <input type="number" name="amounts[{{ $categoryID }}]" min="0"
                                    placeholder="Số lượng" value="{{ $quantity ?? '' }}"
                                    class="form-input w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 text-sm">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t bg-gray-50 p-4 flex justify-end gap-3">
                <button type="reset"
                    class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                    Đặt lại
                </button>
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