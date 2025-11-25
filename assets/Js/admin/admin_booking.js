// --- KHAI BÁO BIẾN TRẠNG THÁI VÀ MOCK DATA ---
let currentStep = 1;
let bookingData = {}; // Đối tượng lưu trữ dữ liệu của booking
const STORAGE_KEY = "tempBookingData";

// Hàm tiện ích: Hiển thị thông báo
function showMessage(text, type = "error") {
  const container = document.getElementById("message-container");
  container.textContent = text;
  container.className = `mb-4 p-3 rounded-lg font-medium ${
    type === "error" ? "bg-red-500" : "bg-green-500"
  }`;
  container.style.display = "block";
  setTimeout(() => (container.style.display = "none"), 5000);
}

// Hàm tiện ích: Định dạng số
function formatCurrency(number) {
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  })
    .format(number)
    .replace("₫", "VND");
}

// --- LOGIC GIAO DIỆN VÀ CHUYỂN BƯỚC ---

// Hàm cập nhật giao diện (Tiêu đề, Progress bar, Nội dung bước)
function renderStep() {
  // Cập nhật Progress bar
  const progress = (currentStep / 3) * 100;
  document.getElementById("progress-bar").style.width = `${progress}%`;
  document.getElementById("step-display").textContent = currentStep;

  // Cập nhật tiêu đề bước
  const titles = {
    1: "Lựa chọn Tour & Thông tin cơ bản",
    2: "Chi tiết Booking & Trạng thái",
    3: "Chi tiết bổ sung & Hoàn tất",
  };
  document.getElementById("step-title").textContent = titles[currentStep];

  // Ẩn/hiện nội dung bước
  document
    .querySelectorAll(".step-content")
    .forEach((el) => el.classList.add("hidden"));
  document
    .getElementById(`step-${currentStep}-content`)
    .classList.remove("hidden");

  // Nếu là Bước 2, tính và hiển thị giá
  if (currentStep === 2) {
    calculateTotalPrice(false);
  }

  // Nếu là Bước 3, render nội dung động
  if (currentStep === 3) {
    renderStep3DynamicContent();
  }

  // Đảm bảo không hiển thị view thành công
  document.getElementById("success-view").classList.add("hidden");
}

// Hàm tải dữ liệu đã lưu từ sessionStorage (Mô phỏng load Session)
function loadData() {
  const storedData = sessionStorage.getItem(STORAGE_KEY);
  if (storedData) {
    bookingData = JSON.parse(storedData);
    currentStep = bookingData.step || 1;

    // Điền lại dữ liệu vào form
    for (const key in bookingData) {
      const input = document.getElementById(key);
      if (input) {
        input.value = bookingData[key];
      }
    }
  }
  document.getElementById("booking-id-input").value =
    bookingData.booking_id || "";
  renderStep();
}

// Hàm lưu dữ liệu vào sessionStorage (Mô phỏng lưu Session)
function saveData(data) {
  bookingData = {
    ...bookingData,
    ...data,
    step: currentStep,
  };
  sessionStorage.setItem(STORAGE_KEY, JSON.stringify(bookingData));
}

// --- LOGIC XỬ LÝ SUBMIT TỪNG BƯỚC ---

// [BƯỚC 1: Chọn Tour & Khách hàng]
function handleStep1Submit() {
  const form = document.getElementById("multi-step-booking-form");
  const fields = [
    "tour_id",
    "tour_version_id",
    "customer_name",
    "customer_phone",
    "customer_email",
  ];

  // 1. Validation
  for (const field of fields) {
    if (!document.getElementById(field).value) {
      showMessage(
        `Vui lòng điền thông tin bắt buộc: ${document
          .querySelector(`label[for=${field}]`)
          .textContent.replace("*", "")
          .trim()}`
      );
      return;
    }
  }

  // 2. Tạo bản ghi Sơ bộ (DRAFT)
  const data = {};
  fields.forEach(
    (field) => (data[field] = document.getElementById(field).value)
  );

  // Mô phỏng DB: Tạo ID và trạng thái DRAFT
  data.booking_id =
    bookingData.booking_id ||
    `BK-${crypto.randomUUID().substring(0, 8).toUpperCase()}`;
  data.status = "DRAFT";

  saveData(data);

  // Chuyển sang Bước 2
  currentStep = 2;
  renderStep();
}

// Hàm tính toán tổng giá (Mô phỏng Backend Calculation)
function calculateTotalPrice(showAlert = true) {
  const versionSelect = document.getElementById("tour_version_id");
  const selectedOption = versionSelect.options[versionSelect.selectedIndex];
  const basePrice = selectedOption.getAttribute("data-price");
  const people =
    parseInt(document.getElementById("number_of_people").value) || 0;

  if (!basePrice || people <= 0) {
    document.getElementById("total-price-display").classList.add("hidden");
    if (showAlert && people > 0)
      showMessage("Vui lòng chọn Phiên bản Tour để tính giá.");
    return 0;
  }

  const totalPrice = parseFloat(basePrice) * people;

  // Hiển thị giá
  document.getElementById("calculated-price").textContent =
    formatCurrency(totalPrice);
  document.getElementById("total-price-display").classList.remove("hidden");

  return totalPrice;
}

// [BƯỚC 2: Chi tiết Booking]
function handleStep2Submit(direction) {
  if (direction === "prev") {
    currentStep = 1;
    renderStep();
    return;
  }

  const people = document.getElementById("number_of_people").value;
  const groupType = document.getElementById("group_type").value;
  const initialStatus = document.getElementById("initial_status").value;

  // 1. Validation
  if (!people || parseInt(people) <= 0) {
    showMessage("Vui lòng nhập Số lượng khách hợp lệ.");
    return;
  }

  const calculatedPrice = calculateTotalPrice();
  if (calculatedPrice === 0) return;

  // 2. Cập nhật Booking & Ghi Log (Mô phỏng Transaction)
  const updateData = {
    number_of_people: people,
    group_type: groupType,
    initial_status: initialStatus,
    note: document.getElementById("note").value,
    total_price: calculatedPrice,
    // Mô phỏng Ghi Log: Chuyển từ DRAFT -> Trạng thái Khởi tạo
    status_log: `[${new Date().toISOString()}] - Trạng thái: DRAFT -> ${initialStatus}`,
  };
  saveData(updateData);

  // Chuyển sang Bước 3
  currentStep = 3;
  renderStep();
}

// Hàm tạo nội dung động cho Bước 3
function renderStep3DynamicContent() {
  const container = document.getElementById("dynamic-step-3-content");
  container.innerHTML = ""; // Xóa nội dung cũ
  const groupType = bookingData.group_type || "le";

  if (groupType === "doan") {
    // Lô-gic cho TOUR ĐOÀN
    container.classList.add("bg-red-50", "border-red-200");
    container.innerHTML = `
                            <p class="text-lg font-semibold text-red-700">Xử lý Booking Đoàn (Group Tour)</p>
                            <p class="text-sm text-slate-600">Vui lòng nhập danh sách thành viên hoặc các yêu cầu chi tiết về chỗ ở, dịch vụ bổ sung để tiến hành báo giá chính thức.</p>
                            <textarea id="member_list" rows="5" placeholder="Họ tên thành viên, ngày sinh, yêu cầu phòng..." 
                                    class="w-full border-red-300 rounded-md shadow-sm p-3 focus:ring-main focus:border-main"></textarea>
                            <div class="flex items-center">
                                <input type="checkbox" id="require_quote" class="mr-2 rounded text-red-500">
                                <label for="require_quote" class="text-sm font-medium text-slate-700">Yêu cầu tạo báo giá chi tiết (Req 5).</label>
                            </div>
                        `;
  } else {
    // Lô-gic cho KHÁCH LẺ
    container.classList.add("bg-green-50", "border-green-200");
    container.innerHTML = `
                            <p class="text-lg font-semibold text-green-700">Xử lý Booking Lẻ (Individual Tour)</p>
                            <p class="text-sm text-slate-600">Booking sẽ được xác nhận sau khi khách hàng thanh toán cọc. Xác nhận đã gửi chính sách tour.</p>
                            <div class="flex items-center">
                                <input type="checkbox" id="confirm_policy" required class="mr-2 rounded text-green-500">
                                <label for="confirm_policy" class="text-sm font-medium text-slate-700">Đã xác nhận chính sách đặt tour và hủy tour.</label>
                            </div>
                        `;
  }
}

// [BƯỚC 3: Hoàn tất]
function handleStep3Submit(direction) {
  if (direction === "prev") {
    currentStep = 2;
    renderStep();
    return;
  }

  // 1. Validation cuối cùng (Ví dụ: xác nhận chính sách)
  if (
    bookingData.group_type !== "doan" &&
    !document.getElementById("confirm_policy").checked
  ) {
    showMessage("Bạn phải xác nhận đã gửi chính sách tour cho khách hàng.");
    return;
  }

  // 2. Xử lý cuối cùng (Finalize)

  // Mô phỏng: Lưu dữ liệu bổ sung và xóa session
  const finalData = {
    ...bookingData,
    status: bookingData.initial_status, // Trạng thái chính thức
    finalized_at: new Date().toISOString(),
  };

  // Mô phỏng Lô-gic Tour Đoàn: Lưu danh sách thành viên
  if (bookingData.group_type === "doan") {
    finalData.member_list = document.getElementById("member_list").value;
    finalData.required_quote = document.getElementById("require_quote").checked;
  }

  // --- MÔ PHỎNG LƯU TRỮ VĨNH VIỄN ---
  console.log("--- DỮ LIỆU BOOKING HOÀN TẤT ---");
  console.log(finalData);
  // Ở môi trường thực: Gửi finalData đến Backend để lưu vào DB, xóa trạng thái DRAFT, và gửi email.

  // 3. Dọn dẹp Session và Hiển thị thành công
  sessionStorage.removeItem(STORAGE_KEY);

  // Hiển thị View thành công
  document.getElementById("app").classList.add("hidden");
  document.getElementById("success-view").classList.remove("hidden");
  document.getElementById("final-booking-id").textContent =
    finalData.booking_id;
  document.getElementById("final-status").textContent = finalData.status
    .toUpperCase()
    .replace("_", " ");
}

// Khởi tạo ứng dụng khi DOM đã tải
document.addEventListener("DOMContentLoaded", loadData);
