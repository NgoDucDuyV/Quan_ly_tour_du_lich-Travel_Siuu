<div class="max-w-[1600px] mx-auto p-6 space-y-10">

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-gray-300 text-gray-400">Phân tour & lịch trình</li>
        </ul>
    </nav>

    <h1 class="text-3xl font-bold text-gray-900 tracking-wide">Phân công tour cho hướng dẫn viên</h1>

    <!-- MAIN CARD -->
    <div class="bg-white p-8 rounded-3xl shadow-2xl border border-gray-200 space-y-10">

        <!-- Thông tin tour -->
        <div class="space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800">Thông tin tour</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label class="block font-semibold mb-2 text-gray-600">Mã tour</label>
                    <input value="TOUR-2025-001" disabled class="w-full p-3 bg-gray-100 rounded-xl border border-gray-300 text-gray-700 shadow-inner">
                </div>
                <div>
                    <label class="block font-semibold mb-2 text-gray-600">Tên tour</label>
                    <input value="Tour Hà Nội - Sapa 3N2Đ" disabled class="w-full p-3 bg-gray-100 rounded-xl border border-gray-300 text-gray-700 shadow-inner">
                </div>
                <div>
                    <label class="block font-semibold mb-2 text-gray-600">Ngày khởi hành</label>
                    <input id="tourStartDate" type="date" class="w-full p-3 bg-white rounded-xl border border-gray-300 text-gray-700 shadow-sm">
                </div>
                <div>
                    <label class="block font-semibold mb-2 text-gray-600">Ngày kết thúc</label>
                    <input id="tourEndDate" type="date" class="w-full p-3 bg-white rounded-xl border border-gray-300 text-gray-700 shadow-sm">
                </div>
            </div>
        </div>

        <!-- Danh sách HDV -->
        <div class="space-y-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h2 class="text-2xl font-semibold text-gray-800">Danh sách hướng dẫn viên</h2>
                <input id="searchHDV" type="text" placeholder="Tìm HDV..." class="p-3 border rounded-xl shadow-sm w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>
            <div id="hdvList" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <!-- JS render HDV -->
            </div>
        </div>

        <!-- Lịch trình tour -->
        <div class="space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800">Lịch trình tour</h2>
            <div id="tourSchedule" class="space-y-4">
                <!-- JS render lịch trình -->
            </div>
        </div>

        <!-- Button lưu phân công -->
        <div class="flex justify-end">
            <button id="saveAssignment" class="px-10 py-4 bg-blue-600 text-white font-semibold rounded-2xl shadow-lg hover:bg-blue-700 transition duration-300">Lưu phân công</button>
        </div>
    </div>

    <!-- Kiểm tra trùng lịch HDV -->
    <div class="space-y-4 mt-10">
        <h2 class="text-2xl font-semibold text-gray-800">Kiểm tra trùng lịch hướng dẫn viên</h2>
        <div id="scheduleCheck" class="p-6 bg-white border rounded-3xl shadow-xl space-y-4">
            <p class="text-gray-600 text-sm">Hệ thống sẽ kiểm tra xem HDV có đang dẫn tour khác trong thời gian này hay không.</p>
        </div>
    </div>
</div>

<!-- Modal phân công HDV -->
<div id="hdvModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center opacity-0 pointer-events-none transition duration-300">
    <div class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Phân công HDV</h2>
        <p class="mb-4" id="modalHDVName">HDV: </p>
        <label class="block mb-2 font-semibold text-gray-600">Ngày bắt đầu</label>
        <input id="modalDate" type="date" class="w-full p-3 border rounded-xl mb-4">
        <label class="block mb-2 font-semibold text-gray-600">Ngày kết thúc</label>
        <input id="modalEndDate" type="date" class="w-full p-3 border rounded-xl mb-6">
        <div class="flex justify-end gap-4">
            <button id="modalCancel" class="px-6 py-2 bg-gray-300 rounded-xl hover:bg-gray-400 transition">Hủy</button>
            <button id="modalAssign" class="px-6 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">Phân công</button>
        </div>
    </div>
</div>

<script>
    // Mock HDV
    const hdvs = [{
            id: 1,
            name: "Nguyễn Văn An",
            experience: 5,
            phone: "0987123456",
            status: "free"
        },
        {
            id: 2,
            name: "Trần Quang Minh",
            experience: 3,
            phone: "0902888111",
            status: "busy"
        },
        {
            id: 3,
            name: "Phạm Thị Hương",
            experience: 2,
            phone: "0915222333",
            status: "free"
        }
    ];

    // Mock lịch trình
    const schedule = [{
            day: 1,
            title: "Hà Nội → Sapa",
            desc: "Xe đón khách — Dùng bữa trưa — Tham quan Cat Cat — Nhận phòng khách sạn"
        },
        {
            day: 2,
            title: "Fansipan",
            desc: "Di chuyển cáp treo — Chinh phục đỉnh Fansipan — Tham quan thị trấn Sapa"
        },
        {
            day: 3,
            title: "Sapa → Hà Nội",
            desc: "Dùng sáng — Mua sắm — Trả khách về Hà Nội"
        }
    ];

    const hdvListEl = document.getElementById("hdvList");
    const tourScheduleEl = document.getElementById("tourSchedule");
    const scheduleCheckEl = document.getElementById("scheduleCheck");
    const searchInput = document.getElementById("searchHDV");
    const modal = document.getElementById("hdvModal");
    const modalHDVName = document.getElementById("modalHDVName");
    const modalCancel = document.getElementById("modalCancel");
    const modalAssign = document.getElementById("modalAssign");
    const modalDate = document.getElementById("modalDate");
    const modalEndDate = document.getElementById("modalEndDate");
    let currentHDV = null;

    function renderHDV(filter = "") {
        hdvListEl.innerHTML = "";
        hdvs.filter(h => h.name.toLowerCase().includes(filter.toLowerCase())).forEach(hdv => {
            const color = hdv.status === "free" ? "bg-green-50 border-green-200 text-green-700" : "bg-red-50 border-red-200 text-red-700";
            const div = document.createElement("div");
            div.className = "p-6 bg-white border border-gray-200 rounded-2xl shadow hover:shadow-2xl transition transform hover:-translate-y-1 duration-300";
            div.innerHTML = `
                <div class="flex items-center gap-4">
                    <img src="https://i.pravatar.cc/150?img=${hdv.id*10}" class="w-16 h-16 rounded-xl shadow-lg" />
                    <div>
                        <h3 class="font-semibold text-gray-900 text-lg">${hdv.name}</h3>
                        <p class="text-gray-500 text-sm">Kinh nghiệm: ${hdv.experience} năm</p>
                        <p class="text-gray-500 text-sm">SĐT: ${hdv.phone}</p>
                    </div>
                </div>
                <button class="w-full mt-5 py-3 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 font-semibold transition assignBtn">Phân công</button>
            `;
            div.querySelector(".assignBtn").addEventListener("click", () => openModal(hdv));
            hdvListEl.appendChild(div);
        });
    }

    function renderSchedule() {
        tourScheduleEl.innerHTML = "";
        schedule.forEach(s => {
            const div = document.createElement("div");
            div.className = "p-6 bg-gray-50 border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition";
            div.innerHTML = `<h3 class="font-semibold text-gray-900 text-lg">Ngày ${s.day}: ${s.title}</h3><p class="text-gray-600 text-sm">${s.desc}</p>`;
            tourScheduleEl.appendChild(div);
        });
    }

    function renderScheduleCheck() {
        scheduleCheckEl.innerHTML = "";
        hdvs.forEach(hdv => {
            const div = document.createElement("div");
            let statusText = "",
                bg = "",
                text = "";
            if (hdv.status === "busy") {
                statusText = "đang bận";
                bg = "bg-red-50 border-red-200";
                text = "text-red-700";
            } else {
                statusText = "rảnh";
                bg = "bg-green-50 border-green-200";
                text = "text-green-700";
            }
            div.className = `p-4 ${bg} border rounded-xl shadow-sm`;
            div.innerHTML = `<h3 class="font-semibold ${text}">${hdv.name} ${statusText}</h3>`;
            scheduleCheckEl.appendChild(div);
        });
    }

    searchInput.addEventListener("input", (e) => renderHDV(e.target.value));

    function openModal(hdv) {
        currentHDV = hdv;
        modalHDVName.textContent = `HDV: ${hdv.name}`;
        modalDate.value = document.getElementById("tourStartDate").value;
        modalEndDate.value = document.getElementById("tourEndDate").value;
        modal.classList.remove("opacity-0", "pointer-events-none");
    }

    modalCancel.addEventListener("click", () => modal.classList.add("opacity-0", "pointer-events-none"));

    modalAssign.addEventListener("click", () => {
        if (!modalDate.value || !modalEndDate.value) {
            alert("Chọn ngày bắt đầu và kết thúc!");
            return;
        }
        alert(`Đã phân công ${currentHDV.name} từ ${modalDate.value} đến ${modalEndDate.value}`);
        currentHDV.status = "busy";
        renderHDV(searchInput.value);
        renderScheduleCheck();
        modal.classList.add("opacity-0", "pointer-events-none");
    });

    document.getElementById("saveAssignment").addEventListener("click", () => alert("Đã lưu toàn bộ phân công!"));

    renderHDV();
    renderSchedule();
    renderScheduleCheck();
</script>