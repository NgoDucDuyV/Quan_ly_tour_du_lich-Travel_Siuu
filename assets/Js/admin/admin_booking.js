// --- TRẠNG THÁI & SESSION STORAGE ---
let currentStep = 1;
let bookingData = {};
const STORAGE_KEY = "tempBookingData";

// Hiển thị thông báo
function showMessage(text, type = "error") {
  const container = document.getElementById("message-container");
  container.textContent = text;
  container.className = `mb-4 p-3 rounded-lg font-medium ${
    type === "error" ? "bg-red-500" : "bg-green-500"
  }`;
  container.style.display = "block";
  setTimeout(() => (container.style.display = "none"), 5000);
}

// Định dạng số tiền
function formatCurrency(number) {
  return new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" })
    .format(number)
    .replace("₫", "VND");
}

// --- GIAO DIỆN & CHUYỂN BƯỚC ---
function renderStep() {
  document.getElementById("progress-bar").style.width = `${
    (currentStep / 3) * 100
  }%`;
  const titles = {
    1: "Lựa chọn Tour & Thông tin cơ bản",
    2: "Chi tiết Booking & Trạng thái",
    3: "Chi tiết bổ sung & Hoàn tất",
  };
  document.getElementById("step-title").textContent = titles[currentStep];

  document
    .querySelectorAll(".step-content")
    .forEach((el) => el.classList.add("hidden"));
  document
    .getElementById(`step-${currentStep}-content`)
    .classList.remove("hidden");

  if (currentStep === 2) calculateTotalPrice(false);
  if (currentStep === 3) renderStep3DynamicContent();

  document.getElementById("success-view").classList.add("hidden");
}

// Load dữ liệu từ sessionStorage
function loadData() {
  const storedData = sessionStorage.getItem(STORAGE_KEY);
  if (storedData) {
    bookingData = JSON.parse(storedData);
    currentStep = bookingData.step || 1;
    Object.keys(bookingData).forEach((key) => {
      const input = document.getElementById(key);
      if (input) input.value = bookingData[key];
    });
  }
  renderStep();
}

// Lưu dữ liệu vào sessionStorage
function saveData(data) {
  bookingData = { ...bookingData, ...data, step: currentStep };
  sessionStorage.setItem(STORAGE_KEY, JSON.stringify(bookingData));
}

// --- TÍNH GIÁ ---
function calculateTotalPrice(showAlert = true) {
  const versionSelect = document.getElementById("tour_version_id");
  const selectedOption = versionSelect.options[versionSelect.selectedIndex];
  const basePrice = selectedOption?.getAttribute("data-price");
  const people = parseInt(
    document.getElementById("number_of_people")?.value || 0
  );

  if (!basePrice || people <= 0) {
    document.getElementById("total-price-display")?.classList.add("hidden");
    if (showAlert && people > 0)
      showMessage("Vui lòng chọn Phiên bản Tour để tính giá.");
    return 0;
  }

  const totalPrice = parseFloat(basePrice) * people;
  document.getElementById("calculated-price").textContent =
    formatCurrency(totalPrice);
  document.getElementById("total-price-display").classList.remove("hidden");
  return totalPrice;
}

// --- BƯỚC 3: Nội dung động ---
function renderStep3DynamicContent() {
  const container = document.getElementById("dynamic-step-3-content");
  container.innerHTML = "";
  const groupType = bookingData.group_type || "le";

  if (groupType === "doan") {
    container.className = "bg-red-50 border border-red-200 p-4 rounded-xl";
    container.innerHTML = `
      <p class="text-lg font-semibold text-red-700">Xử lý Booking Đoàn (Group Tour)</p>
      <textarea id="member_list" rows="5" placeholder="Họ tên thành viên, ngày sinh, yêu cầu..." class="w-full border-red-300 rounded-md p-3"></textarea>
      <div class="flex items-center mt-2">
        <input type="checkbox" id="require_quote" class="mr-2 rounded text-red-500">
        <label for="require_quote" class="text-sm font-medium">Yêu cầu tạo báo giá chi tiết</label>
      </div>`;
  } else {
    container.className = "bg-green-50 border border-green-200 p-4 rounded-xl";
    container.innerHTML = `
      <p class="text-lg font-semibold text-green-700">Xử lý Booking Lẻ (Individual Tour)</p>
      <div class="flex items-center mt-2">
        <input type="checkbox" id="confirm_policy" required class="mr-2 rounded text-green-500">
        <label for="confirm_policy" class="text-sm font-medium">Đã xác nhận chính sách đặt tour và hủy tour</label>
      </div>`;
  }
}

// --- KHỞI TẠO ---
document.addEventListener("DOMContentLoaded", loadData);
