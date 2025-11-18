<!-- Danh sách khách -->
<div class="px-4">
  <div class="flex justify-between items-center mt-6 mb-3">
    <h2 class="text-xl font-semibold text-dark">Danh sách khách</h2>
    <small class="text-xs text-gray-500">
      Quản lý khách theo từng tour bạn phụ trách
    </small>
  </div>

  <div class="bg-white shadow rounded-lg border border-light/40">
    <div class="p-4">
      <!-- Bộ lọc -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div>
          <label class="text-sm text-dark block mb-1">Tour</label>
          <select
            class="mt-1 w-full border border-light rounded text-sm px-2 py-1 focus:outline-none focus:ring-1 focus:ring-main focus:border-main"
          >
            <option>Tất cả tour</option>
            <option>City Tour Hà Nội</option>
            <option>Food Tour Phố Cổ</option>
            <option>Tour Sapa 3N2Đ</option>
          </select>
        </div>

        <div>
          <label class="text-sm text-dark block mb-1">Tìm theo tên khách</label>
          <input
            class="mt-1 w-full border border-light rounded text-sm px-2 py-1 focus:outline-none focus:ring-1 focus:ring-main focus:border-main"
            placeholder="Nhập tên khách..."
          />
        </div>

        <div>
          <label class="text-sm text-dark block mb-1">Quốc tịch</label>
          <select
            class="mt-1 w-full border border-light rounded text-sm px-2 py-1 focus:outline-none focus:ring-1 focus:ring-main focus:border-main"
          >
            <option>Tất cả</option>
            <option>Việt Nam</option>
            <option>Hàn Quốc</option>
            <option>USA</option>
          </select>
        </div>
      </div>

      <!-- Bảng -->
      <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
          <thead class="bg-light/30">
            <tr class="text-left text-dark">
              <th class="py-2 px-3">#</th>
              <th class="py-2 px-3">Họ tên</th>
              <th class="py-2 px-3">Quốc tịch</th>
              <th class="py-2 px-3">SĐT</th>
              <th class="py-2 px-3">Email</th>
              <th class="py-2 px-3">Tour</th>
              <th class="py-2 px-3">Trạng thái</th>
              <th class="py-2 px-3 text-right">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-t border-light/60">
              <td class="py-2 px-3">1</td>
              <td class="py-2 px-3">Nguyễn Văn A</td>
              <td class="py-2 px-3">Việt Nam</td>
              <td class="py-2 px-3">0987 123 456</td>
              <td class="py-2 px-3">a@example.com</td>
              <td class="py-2 px-3">City Tour Hà Nội</td>
              <td class="py-2 px-3">
                <span
                  class="inline-block bg-thea/10 text-thea text-xs px-2 py-1 rounded"
                >
                  Đã check-in
                </span>
              </td>
              <td class="py-2 px-3 text-right space-x-2">
                <button
                  class="px-2 py-1 border border-main/40 text-main text-xs rounded hover:bg-main hover:text-white transition"
                >
                  Chi tiết
                </button>
                <button
                  class="px-2 py-1 border border-light text-xs rounded hover:bg-light/40 transition text-dark"
                >
                  Nhật ký
                </button>
              </td>
            </tr>

            <tr class="border-t border-light/60">
              <td class="py-2 px-3">2</td>
              <td class="py-2 px-3">Kim Ji Soo</td>
              <td class="py-2 px-3">Hàn Quốc</td>
              <td class="py-2 px-3">+82 123 456</td>
              <td class="py-2 px-3">kim@example.com</td>
              <td class="py-2 px-3">Food Tour Phố Cổ</td>
              <td class="py-2 px-3">
                <span
                  class="inline-block bg-hover/10 text-hover text-xs px-2 py-1 rounded"
                >
                  Chưa check-in
                </span>
              </td>
              <td class="py-2 px-3 text-right space-x-2">
                <button
                  class="px-2 py-1 border border-main/40 text-main text-xs rounded hover:bg-main hover:text-white transition"
                >
                  Chi tiết
                </button>
                <button
                  class="px-2 py-1 border border-light text-xs rounded hover:bg-light/40 transition text-dark"
                >
                  Nhật ký
                </button>
              </td>
            </tr>

            <tr class="border-t border-light/60">
              <td class="py-2 px-3">3</td>
              <td class="py-2 px-3">John Smith</td>
              <td class="py-2 px-3">USA</td>
              <td class="py-2 px-3">+1 222 333</td>
              <td class="py-2 px-3">john@example.com</td>
              <td class="py-2 px-3">Tour Sapa 3N2Đ</td>
              <td class="py-2 px-3">
                <span
                  class="inline-block bg-gray-200 text-dark text-xs px-2 py-1 rounded"
                >
                  Đã kết thúc
                </span>
              </td>
              <td class="py-2 px-3 text-right space-x-2">
                <button
                  class="px-2 py-1 border border-main/40 text-main text-xs rounded hover:bg-main hover:text-white transition"
                >
                  Chi tiết
                </button>
                <button
                  class="px-2 py-1 border border-light text-xs rounded hover:bg-light/40 transition text-dark"
                >
                  Nhật ký
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Phân trang -->
      <div class="flex justify-end mt-4">
        <ul class="flex items-center space-x-1 text-sm">
          <li>
            <a
              class="px-2 py-1 border rounded text-gray-400 cursor-not-allowed"
              >«</a
            >
          </li>
          <li>
            <a
              class="px-3 py-1 border rounded bg-main text-white hover:bg-hover transition"
              >1</a
            >
          </li>
          <li>
            <a
              class="px-3 py-1 border rounded hover:bg-light/40 cursor-pointer text-dark"
              >2</a
            >
          </li>
          <li>
            <a
              class="px-3 py-1 border rounded hover:bg-light/40 cursor-pointer text-dark"
              >3</a
            >
          </li>
          <li>
            <a
              class="px-2 py-1 border rounded hover:bg-light/40 cursor-pointer text-dark"
              >»</a
            >
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
