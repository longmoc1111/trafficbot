@extends("admin.adminPageLayout.layout")
@section("main")
    <main>

        <!-- Page Title Start -->
        <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
            <!-- <h4 class="text-default-900 text-lg font-medium mb-2">Skeleton</h4> -->

            <!-- <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
                <a href="#" class="text-sm font-medium text-default-700">OpenDash</a>
                <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                <a href="#" class="text-sm font-medium text-default-700">Components</a>
                <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Skeleton</a>
            </div> -->
        </div>
        <!-- Page Title End -->

        <div class="grid grid-cols-1 gap-6">
            <div class="card">
                <div class="card-header">
                    @if($question->licenseType_Question->isNotEmpty())
                        <h4 class="card-title">Thuộc giấy phép:
                            {{ $question->licenseType_Question->pluck("LicenseTypeName")->join(", ")}}</h4>
                    @else
                        <h4 class="card-title">Thuộc giấy phép: chưa thuộc giấy phép</h4>
                    @endif
                    @if($question->examSet_Question->isNotEmpty())
                        <h4 class="card-title">Thuộc bộ đề: {{ $question->examSet_Question->pluck("ExamSetName")->join(",")}}
                        </h4>
                    @else
                        <h4 class="card-title">Thuộc bộ đề: chưa nằm trong bộ đề nào</h4>
                    @endif
                </div>

                <div class="p-6">
                    <h4 class="card-title">Câu hỏi: {{ $question->QuestionName }}</h4>
                    @if(isset($question->ImageDescription))
                        <div class="flex justify-center mb-6">
                            <img style="max-width: 300px;"
                                src="/assets/adminPage/imageQuestion/{{ $question->ImageDescription }}" alt="">
                        </div>
                    @endif
                    <div class="flex">
                        <!-- <div class="flex-shrink-0">
                                                <span class="w-12 h-12 block bg-gray-200 rounded-full"></span>
                                            </div> -->

                        <div class="ms-4 mt-2 w-full">
                            <ul class="mt-5 space-y-3">
                                @foreach (["A", "B", "C", "D"] as $label)
                                    @php
                                        $answerlabel = $answer[$label]->AnswerLabel ?? null;
                                        $answerName = $answer[$label]->AnswerName ?? null;

                                    @endphp
                                    @if($correctAnswer == $answerlabel)
                                        <li class="">
                                            <div class="inline-flex items-center gap-4 text-default-60">
                                                <span>{{ $label }}. {{ $answerName}}</span><i
                                                    class="text-success material-symbols-rounded text-2xl">done</i>
                                            </div>
                                        </li>
                                    @else
                                        <li class="">
                                            <div class="inline-flex items-center gap-4 text-default-60">
                                                <span>{{ $label }}. {{ $answerName}}</span><i
                                                    class="text-red-500 material-symbols-rounded text-2xl">close</i>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@section("footer")

@endsection