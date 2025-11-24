const viewsdetailtour = document.getElementById("viewsdetailtour");
// console.log(viewsdetailtour);
// console.log(axios);
const clickloadAdmindetailtours = document.querySelectorAll(
  ".clickloadAdmindetailtour"
);
// console.log(clickloadAdmindetailtour);
// console.log(clickloadAdmindetailtours);
clickloadAdmindetailtours.forEach((item, index) => {
  item.addEventListener("click", (e) => {
    e.preventDefault();
    const href = e.currentTarget.getAttribute("href");
    loadDetailtour(href);
  });
});
const loadDetailtour = (href) => {
  viewsdetailtour.innerHTML = `
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-6">
        <div id="spinner" class="w-16 h-16 border-4 border-gray-200 border-t-blue-500 rounded-full animate-spin mb-6"></div>
        <p id="loadingText" class="text-gray-700 text-lg opacity-0 animate-fadeIn">Đang tải dữ liệu, vui lòng đợi...</p>
            <button id="loadBtn" class="mt-6 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">
            Load dữ liệu
        </button>
        <div id="dataContainer" class="mt-8 p-4 w-full max-w-md bg-white rounded shadow opacity-0"></div>
    </div>
    `;
  //   console.log(`${BASE_URL}${href}`);
  axios
    .get(`${BASE_URL}${href}&ajax=1`)
    .then(({ data }) => {
      // console.log(data);
      viewsdetailtour.innerHTML = data;
      const btnshow_tabs = document.querySelectorAll(".btnshow_tab");
      console.log(btnshow_tabs);
      btnshow_tabs.forEach((item) => {
        item.addEventListener("click", (el) => {
          el.preventDefault();
          // console.log(item.dataset.tab);
          showTab(item.dataset.tab);
        });
      });
    })
    .catch(() => {
      console.log("Lỗi khôg có inter net");
    });
};

// ui hreader nhỏ xem chi tiét
function openTourDetail(btn) {
  const article = btn.closest("article");
  document.getElementById("detailTitle").innerText =
    article.querySelector("h4").innerText;
  document.getElementById("detailPrice").innerText =
    "Giá cơ bản: " +
    (article.querySelector(".font-semibold")?.innerText || "-");
  document.getElementById("detailThumb").src = article
    .querySelector("img")
    .src.replace("80x60", "400x300");
  showTab("info");
}

function cloneTour(btn) {
  alert(
    "Clone tour: chức năng demo — sẽ sao chép tour để tạo tour mới (thực hiện ở backend)."
  );
}

function generateQuote(btn) {
  alert("Báo giá nhanh: mở form chọn số khách và xuất PDF/Email (demo).");
}

const btnshow_tabs = document.querySelectorAll(".btnshow_tab");
console.log(btnshow_tabs);

function showTab(name) {
  // console.log(1);
  const tabpanes = document.querySelectorAll(".tab-pane");
  tabpanes.forEach((p) => p.classList.add("hidden"));
  document.getElementById("tab-" + name).classList.remove("hidden");
}
