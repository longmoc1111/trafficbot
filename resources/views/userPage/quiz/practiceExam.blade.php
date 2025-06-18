@extends("userPage.layout.layout")
@section("title", "thi thử bằng  $lastWordA ")

@section("main")
    <!-- About Start -->

     <div class="container-lg mt-4 mb-3" style="box-shadow: 0 0 45px rgba(0, 0, 0, .06)">
        <div class="row g-0">
            <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                <div class="bg-white rounded-top p-5">
                     <h1 class="display-6"><strong>Thi thử lý thuyết hạng {{ $lastWordA }}</strong></h1>
                    <div class="mb-2">
                        <p class="mb-2">Cấu trúc đề thi sát hạch giấy phép lái xe hạng {{ $lastWordA }} bao gồm {{ $license->LicenseTypeQuantity }} câu hỏi, mỗi câu hỏi
                            chỉ có duy nhất một câu trả lời đúng.</p>
                        <h5>Bao gồm</h5>
                        <ul>
                            <li>số lượng câu hỏi: <strong style = "color:#ff0000" >{{ $license->LicenseTypeQuantity }}  câu </strong></li>
                            <li>yêu cầu : <strong style = "color:#ff0000" >đúng {{ $license->LicenseTypePassCount }}/{{ $license->LicenseTypeQuantity }} câu</strong> </li>
                            <li>Thời gian: <strong style = "color:#ff0000" >{{ $license->LicenseTypeDuration }} phút</strong> </li>
                        </ul>
                    </div>
                    <p class="mb-4">
                    <span id="short-text"><strong>Lưu ý đặc biệt: </strong>Chọn sai <strong style = "color:#ff0000">"CÂU ĐIỂM LIỆT"</strong>  đồng nghĩa với việc <strong style = "color:#ff0000">KHÔNG ĐẠT"</strong> dù các câu hỏi khác trả lời đúng</span>
                    <span id="full-text" style="display: none;">
                        Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet
                        diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo
                    </span>
                </p>
                </div>
            </div>
        </div>
    </div>


    <!-- About End -->

    <!-- Page Header End -->


    <div class="container-lg py-5">

        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="display-5 mb-5"><strong> Chọn đề thi</strong></h1>
        </div>

        <div class="wow fadeInUp" data-wow-delay="0.1s">
            <div class="service-item position-relative h-100">
                <div class="service-text rounded p-5">
                    <div class="row g-4 wow fadeInUp" data-wow-delay="0.1s">
                        <!-- Dùng col-1 để mỗi hàng chứa tối đa 12 thẻ -->
                        <!-- Nếu thêm thẻ thứ 13 trở đi, nó tự xuống hàng -->

                        <!-- Ví dụ: 15 thẻ -->
                        @foreach ($examSets as $examSet)
                            <a href="{{ route("userpage.practiceStart", ["licenseID"=>$license,"examsetID" => $examSet->ExamSetID]) }}" class="col-2" style="text-decoration:none">
                                <div class="testimonial-item rounded text-center p-2">
                                
                                    <p style="color:rgb(43, 39, 39);text-decoration:none" class="small mb-1">{{ $examSet->ExamSetName}}</p>
                                </div>
                            </a>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- script cho mở rọng thu gọn -->
    <script>
        document.getElementById("toggle-btn").addEventListener("click", function () {
            var fullText = document.getElementById("full-text");
            var shortText = document.getElementById("short-text");
            var btn = this;

            if (fullText.style.display === "none") {
                fullText.style.display = "inline";
                shortText.style.display = "none";
                btn.innerText = "Thu gọn";
            } else {
                fullText.style.display = "none";
                shortText.style.display = "inline";
                btn.innerText = "Xem thêm";
            }
        });
    </script>
    <!-- end script -->

@endsection