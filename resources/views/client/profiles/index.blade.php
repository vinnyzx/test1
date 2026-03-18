@extends('client.profiles.layouts.app')

@section('profile_content')
    <section class="flex-1" data-purpose="user-main-section">
        <!-- Welcome Header -->
        <div class="mb-8" data-purpose="user-welcome">
            <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
            <p class="text-gray-500">Ngày tham gia: {{ $user->created_at->format('d/m/Y') }} • Chào mừng bạn trở lại Bee
                Phone</p>
        </div>
        <!-- Quick Stats Widgets -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8" data-purpose="quick-stats">
            <div
                class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4 transition-all duration-300 hover:shadow-md hover:border-[#f4c025] group cursor-default">
                <div class="bg-blue-50 p-3 rounded-full text-blue-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tổng đơn hàng</p>
                    <p class="text-xl font-bold">{{ $user->orders->count() }}</p>
                </div>
            </div>
            <div
                class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4 transition-all duration-300 hover:shadow-md hover:border-[#f4c025] group cursor-default">
                <div class="bg-yellow-50 p-3 rounded-full text-[#f4c025]">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Bee Point</p>
                    <p class="text-xl font-bold">1,450</p>
                </div>
            </div>
            <div
                class="bg-[#1a1a1a] p-5 rounded-xl shadow-sm flex items-center gap-4 text-white transition-all duration-300 hover:shadow-md hover:ring-1 hover:ring-[#f4c025] group cursor-default">
                <div class="bg-[#f4c025] p-3 rounded-full text-[#1a1a1a]">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Số dư ví</p>
                    <p class="text-xl font-bold">{{ number_format($user->wallet?->balance ?? 0, 0, ',', '.') }}đ</p>
                </div>
            </div>
        </div>
        <!-- Personal Info Card -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-6 overflow-hidden transition-all duration-300 hover:shadow-lg hover:border-yellow-200"
            data-purpose="personal-info-card">
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-6">
                    <!-- Profile Picture -->
                    <div class="relative group">
                        <div class="w-24 h-24 rounded-full border-4 border-gray-50 overflow-hidden">
                            <img alt="Full Profile Avatar" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAQVJC9cpfsIFbQhXD8aujVSj5ptuzSvKWXXehZXXlOUHCtaxouWX48yqalUwMwLpjhr9RxEy4Cn_KhiDRRpd4-Z2T5_mFFGt70BcjtUfR2TVsY7Jhfnom-mTzktPSHGUanNnQkKfVv0v62Wtey-hC4DUSvZIYFZtI0LY748LtRpW4PsQATMpRDoRudDZily2K6lb-q9L57T79DT86uJCizO1oDJ96uD0-37Diyx7B0EoD5uFFnCZtC5xIdcxtK6XeKl-3xkLLDu34" />
                        </div>
                        <button
                            class="absolute bottom-0 right-0 bg-white border border-gray-200 p-1.5 rounded-full shadow-md hover:bg-gray-50 transition"
                            title="Thay đổi ảnh">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                <path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"></path>
                            </svg>
                        </button>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">Thông tin cá nhân</h2>
                        <p class="text-sm text-gray-500">Quản lý thông tin hồ sơ của bạn</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button
                        class="px-4 py-2 bg-[#f4c025] text-[#1a1a1a] font-semibold rounded-lg hover:opacity-90 transition text-sm">Cập
                        nhật thông tin</button>
                    <button
                        class="px-4 py-2 bg-gray-100 text-[#1a1a1a] font-semibold rounded-lg hover:bg-gray-200 transition text-sm">Đổi
                        mật khẩu</button>
                </div>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Họ
                        và Tên</label>
                    <p class="text-base font-medium">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Email</label>
                    <p class="text-base font-medium">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Số
                        điện thoại</label>
                    @if ($user->phone == null)
                        <p class="text-base font-medium">Chưa có SĐT</p>
                    @else
                        <p class="text-base font-medium">{{ $user->phone }}</p>
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Ngày
                        sinh</label>
                    <p class="text-base font-medium">
                        {{ $user->birthday == null ? 'Chưa có ngày sinh' : $user->birthday->format('d/m/Y') }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Giới
                        tính</label>
                    <p class="text-base font-medium">{{ $user->gender }}</p>
                </div>
            </div>
        </div>
        <!-- Role & Permissions Card -->

        <!-- Address Card -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-8 overflow-hidden transition-all duration-300 hover:shadow-md hover:border-yellow-100"
            data-purpose="address-card">
            <div class="p-6 border-b border-gray-100">
                <h3 class="font-bold text-lg">Địa chỉ giao hàng</h3>
            </div>
            <div class="p-6">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Địa chỉ
                    chính</label>
                <p class="text-base font-medium">{{ $user->address }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-6 overflow-hidden transition-all duration-300 hover:shadow-md hover:border-yellow-100"
            data-purpose="role-permissions-card">
            <div class="p-6 border-b border-gray-100">
                <h3 class="font-bold text-lg">Vai trò &amp; Quyền hạn</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Vai
                        trò</label>
                    <p class="text-base font-medium">{{ $user->role->name_role }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Quyền
                        hạn</label>
                    @if ($user->role->name == 'admin')
                        <p class="text-base font-medium">Toàn quyền truy cập hệ thống</p>
                    @elseif ($user->role->name == 'staff')
                        @foreach ($user->permissions as $permission)
                            <p class="text-base font-medium">{{ $permission->name }}</p>
                        @endforeach
                    @else
                        <p class="text-base font-medium"> Mua hàng</p>
                    @endif
                </div>
            </div>
        </div>
        <!-- Recent Activity Summary -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-sm"
            data-purpose="recent-activity">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold">Hoạt động gần đây</h3>
                <a class="text-sm text-[#f4c025] font-semibold hover:underline" href="#">Xem tất cả</a>
            </div>

            <div class="divide-y divide-gray-100">
                <!-- Order Item 1 -->
                @foreach ($user->activityLogs()->latest()->take(3)->get() as $log)
                    <div
                        class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-colors duration-200 hover:bg-gray-50">
                        <div class="flex gap-4">
                            <div>
                                <h4 class="font-bold text-sm">{{ $log->description }}
                                    @if ($log->model)
                                        - <a class="text-blue-500" href="#">{{ $log->model->name ?? '' }}</a>
                                    @endif
                                </h4>
                                <p class="text-xs text-gray-500 mt-1">Ngày {{ $log->created_at->format('d/m/Y') }}</p>
                                {{-- <p class="text-sm font-bold mt-1 text-[#f4c025]">34.990.000₫</p> --}}
                            </div>
                        </div>

                    </div>
                @endforeach
                <!-- Order Item 2 -->
                {{-- <div
                            class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-colors duration-200 hover:bg-gray-50">
                            <div class="flex gap-4">
                                <div class="w-16 h-16 bg-gray-50 rounded-lg flex-shrink-0 border border-gray-100 p-2">
                                    <img alt="AirPods Pro" class="w-full h-full object-contain"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuDWFWvIy1yFD9N030EJix0um1cvujySUjEtemTx52GPpVhvekdMYCkJS55x6NhIlRoQDU108I5bZ3HHEoBWnLqbqooNxMibdjtzivO1CtKGp6x1aWIbvzPX2lHrEz1LEFlyx4HgA0txXTQsgyEpHpom7EzeF7DwLWYbCuSbkLrBXSDUdVwgh39k8MNIdTtS-3W9nZIz1smpUeeBW4BfBHqCzCTtwGsmzh5o_NlEoIsvOh5JFbI8k__BZs2pk5yo00sK8FoRRA6Fck4" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm">AirPods Pro (Gen 2) MagSafe USB-C</h4>
                                    <p class="text-xs text-gray-500 mt-1">Đơn hàng: #BP-88055 • Ngày: 05/10/2023</p>
                                    <p class="text-sm font-bold mt-1 text-[#f4c025]">5.890.000₫</p>
                                </div>
                            </div>
                            <div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Giao hàng thành công
                                </span>
                            </div>
                        </div>
                        <!-- Order Item 3 -->
                        <div
                            class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-colors duration-200 hover:bg-gray-50">
                            <div class="flex gap-4">
                                <div class="w-16 h-16 bg-gray-50 rounded-lg flex-shrink-0 border border-gray-100 p-2">
                                    <img alt="Samsung S23" class="w-full h-full object-contain"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuAnlgqAfgNUiMOqb6ktzkHscAdpjbgP_zOwVFbI7j1hkbhLNsfneFg46h2c_f8aEvzGLhmioZ1HDswXQbEVUVdoAskuPtMQS7a50SIX56bLFbe_a3wREhs9eevNJ_vko_YnW112mNhmZbl07xxzfNO5sv5imUM2JkUxQdtIGTmI_U82-OToXH3b2hfiGG3h9uW3Na-rBvBhMcEjJA8_xiS_-eQQ2dPFZ9uTX0bKkmLhQxult-PTZ27yhq-HOqRFgMM2wEjJuDIArzY" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm">Ốp lưng Silicone iPhone 15 Pro Max</h4>
                                    <p class="text-xs text-gray-500 mt-1">Đơn hàng: #BP-87990 • Ngày: 28/09/2023</p>
                                    <p class="text-sm font-bold mt-1 text-[#f4c025]">1.290.000₫</p>
                                </div>
                            </div>
                            <div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Đang giao hàng
                                </span>
                            </div>
                        </div> --}}
            </div>
        </div>
    </section>
@endsection
