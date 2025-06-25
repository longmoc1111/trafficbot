@extends("admin.adminPageLayout.layout")
@section("title", "Bảng điều khiển")
@section("main")


    <main>

        <!-- Page Title Start -->
        <div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
            <h4 class="text-default-900 text-lg font-medium mb-2">Bảng điều khiển</h4>

            <!-- <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
                            <a href="#" class="text-sm font-medium text-default-700">OpenDash</a>
                            <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                            <a href="#" class="text-sm font-medium text-default-700">Menu</a>
                            <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                            <a href="#" class="text-sm font-medium text-default-700" aria-current="page">Dashboard</a>
                        </div> -->
        </div>
        <!-- Page Title End -->
        <!-- 
                    <div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
                        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
                            <div class="card-body">
                                <div class="flex items- justify-between">
                                    <div>
                                        <p class="text-base mb-1">Total Order</p>
                                        <h4 class="text-xl">2415</h4>
                                    </div>

                                    <div
                                        class="rounded-lg flex justify-center items-center size-16 bg-success/10 text-success">
                                        <i
                                            class="material-symbols-rounded text-4xl transition-all group-hover:fill-1">shopping_bag</i>
                                    </div>
                                </div>
                            </div>
                            <div id="total-order"></div>
                        </div>

                        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
                            <div class="card-body">
                                <div class="flex items- justify-between">
                                    <div>
                                        <p class="text-base mb-1">Total Sale</p>
                                        <h4 class="text-xl">$78.5K</h4>
                                    </div>

                                    <div
                                        class="rounded-lg flex justify-center items-center size-16 bg-primary/10 text-primary">
                                        <i
                                            class="material-symbols-rounded text-4xl transition-all group-hover:fill-1">payments</i>
                                    </div>
                                </div>
                            </div>
                            <div id="total-sale"></div>
                        </div>

                        <div class="card group overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-0.5">
                            <div class="card-body">
                                <div class="flex items- justify-between">
                                    <div>
                                        <p class="text-base mb-1">Total Visits</p>
                                        <h4 class="text-xl">145.2K</h4>
                                    </div>

                                    <div class="rounded-lg flex justify-center items-center size-16 bg-info/10 text-info">
                                        <i
                                            class="material-symbols-rounded text-4xl transition-all group-hover:fill-1">visibility</i>
                                    </div>
                                </div>
                            </div>
                            <div id="total-visits"></div>
                        </div>
                    </div> -->

        <div class="grid xl:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h4 class="card-title">Tổng số lượng đạt - không đạt</h4>
                    <!-- <a href="#!" class="btn btn-sm bg-light !text-sm text-gray-800 ">Export</a> -->
                </div>

                <div class="card-body">
                    <div id="month-sales-chart" class="apex-charts"></div>
                </div>

                <div class="border-t border-default-200 border-dashed card-body">
                    <div class="flex items-center justify-center gap-3">
                        <div class="flex items-center gap-1">
                            <div class="size-3 rounded-full" style="background-color:#22c55e;"></div>
                            <p class="text-sm text-default-700">đạt</p>
                        </div>

                        <div class="flex items-center gap-1">
                            <div class="size-3 rounded-full bg-danger" style="background-color:#fa5944;"></div>
                            <p class="text-sm text-default-700">không đạt</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-base">Số lượng người thi trong tháng</h5>
                    </div>
                    <div class="card-body">
                        <div id="revenue-chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>


        </div>


        <div class="grid xl:grid-cols-12 md:grid-cols-12 gap-6 mb-6">

            <div class="card overflow-hidden">
                <div class="card-header flex justify-between items-center">
                    <h4 class="card-title">Danh sách thi</h4>
                </div>

                <div class="overflow-x-auto custom-scroll">
                    <div class="min-w-full inline-block align-middle whitespace-nowrap">
                        <div class="overflow-hidden">
                            <table class="min-w-full">
                                <thead class="bg-light/40 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-start">Tên</th>
                                        <th class="px-6 py-3 text-start">Giấy phép</th>
                                        <th class="px-6 py-3 text-start">Thời gian</th>
                                        <th class="px-6 py-3 text-start">Điểm</th>
                                        <th class="px-6 py-3 text-start">Kết quả</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($results as $result)
                                        <tr class="border-b border-gray-200">
                                            <td class="px-6 py-3">{{ optional($result->user_Result)->name ?? 'Khách' }}</td>
                                            <td class="px-6 py-3">
                                                {{ optional($result->licenseType_Result)->LicenseTypeName ?? '' }}</td>
                                            <td class="px-6 py-3">{{ gmdate("i:s", $result->Duration) }}</td>
                                            <td class="px-6 py-3">{{ $result->score }}</td>
                                            <td class="px-6 py-3">

                                                @if($result->passed == true)
                                                    <span class="px-2 py-1 bg-success/10 text-success text-xs rounded">đạt</span>
                                                @else
                                                    <span class="px-2 py-1 bg-red-100 text-red-500 text-xs rounded"
                                                        style="white-space:nowrap">Không đạt</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                            <!-- Showing -->
                            <div>
                                <p class="text-sm text-gray-700">
                                    <span class="font-medium">{{ $results->firstItem() }}</span>
                                    ->
                                    <span class="font-medium">{{ $results->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $results->total() }}</span>
                                </p>
                            </div>

                            <!-- Pagination -->
                            <div class="flex flex-wrap items-center gap-1">
                                {{-- Previous Page --}}
                                @if ($results->onFirstPage())
                                    <span
                                        class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Trước</span>
                                @else
                                    <a href="{{ $results->previousPageUrl() }}"
                                        class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Trước</a>
                                @endif

                                {{-- Page Numbers --}}
                                @php
                                    $start = max($results->currentPage() - 2, 1);
                                    $end = min($results->currentPage() + 2, $results->lastPage());
                                @endphp

                                {{-- First Page Link --}}
                                @if ($start > 1)
                                    <a href="{{ $results->url(1) }}"
                                        class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">1</a>
                                    @if ($start > 2)
                                        <span class="px-2 text-gray-500">...</span>
                                    @endif
                                @endif

                                {{-- Page Links --}}
                                @for ($page = $start; $page <= $end; $page++)
                                    @if ($page == $results->currentPage())
                                        <span
                                            class="px-3 py-1 bg-primary/25 text-primary rounded border border-indigo-600">{{ $page }}</span>
                                    @else
                                        <a href="{{ $results->url($page) }}"
                                            class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $page }}</a>
                                    @endif
                                @endfor

                                {{-- Last Page Link --}}
                                @if ($end < $results->lastPage())
                                    @if ($end < $results->lastPage() - 1)
                                        <span class="px-2 text-gray-500">...</span>
                                    @endif
                                    <a href="{{ $results->url($results->lastPage()) }}"
                                        class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">{{ $results->lastPage() }}</a>
                                @endif

                                {{-- Next Page --}}
                                @if ($results->hasMorePages())
                                    <a href="{{ $results->nextPageUrl() }}"
                                        class="px-3 py-1 text-gray-700 bg-white rounded border border-gray-300 hover:bg-gray-50">Sau</a>
                                @else
                                    <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded border border-gray-300">Sau</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
<script>
    const charData = @json($charData);
    const peopleData = charData.map(item => item.people);
    const passed = charData.map(item => item.passed);
    const notPassed = charData.map(item => item.notPassed);
    const countPasser = passed.reduce((sum, value) => sum + value, 0);
    const countNotPassed = notPassed.reduce((sum, value) => sum + value, 0);
    console.log(countPasser)


</script>

@section("footer")
@endsection