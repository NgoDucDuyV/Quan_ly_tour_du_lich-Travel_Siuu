<div class="max-w-[1200px] mx-auto p-6">

    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 text-slate-400">Cập nhật thanh toán</li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-semibold text-slate-900">Cập nhật Thanh Toán</h1>
        <a href="?mode=admin&act=booking"
            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm transition">
            Quay lại
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 space-y-6">

        <!-- Booking Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Mã Booking</label>
                <div class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg">
                    #12345
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tên khách hàng</label>
                <div class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg">
                    Nguyễn Văn A
                </div>
            </div>
        </div>

        <hr class="border-slate-200">

        <!-- Payment Form -->
        <form class="space-y-6">

            <!-- Amount + Method -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-1 block">Số tiền</label>
                    <input type="text" value="1500000"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-main focus:border-main transition">
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-1 block">Phương thức thanh toán</label>
                    <select class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-main">
                        <option value="bank">Chuyển khoản ngân hàng</option>
                        <option value="momo">Ví MoMo</option>
                        <option value="zalo">ZaloPay</option>
                        <option value="cash">Tiền mặt</option>
                    </select>
                </div>

            </div>

            <!-- Transaction Code -->
            <div>
                <label class="text-sm font-semibold text-slate-700 mb-1 block">Mã giao dịch</label>
                <input type="text" value="TXN002"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-main">
            </div>

            <!-- Payment Image -->
            <div>
                <label class="text-sm font-semibold text-slate-700 mb-2 block">Ảnh chứng từ thanh toán</label>

                <div class="flex items-center gap-6">

                    <!-- Preview Box -->
                    <div class="w-40 h-40 border border-slate-300 rounded-lg overflow-hidden bg-slate-100 flex items-center justify-center">
                        <img src="https://via.placeholder.com/200" class="w-full h-full object-cover">
                    </div>

                    <!-- Upload -->
                    <label class="cursor-pointer">
                        <span class="px-4 py-2 bg-main text-white rounded-lg hover:bg-hover 
                        transition text-sm">Tải ảnh lên</span>
                        <input type="file" class="hidden">
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <button class="w-full md:w-auto px-6 py-3 bg-main text-white rounded-lg 
                hover:bg-hover transition text-sm font-medium shadow-sm">
                Cập nhật thanh toán
            </button>
        </form>

    </div>
</div>