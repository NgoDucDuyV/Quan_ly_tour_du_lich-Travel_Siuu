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
    <div class="w-full h-full bg-white rounded-lg shadow-md p-6 flex flex-col space-y-4 border border-gray-100">
    <div class="flex space-x-4 items-start animate-pulse">
        <div class="w-20 h-20 bg-gray-200 rounded-md"></div>
        
        <div class="flex-1 space-y-2 pt-2">
            <div class="h-4 bg-gray-300 rounded w-3/4"></div> <div class="h-3 bg-gray-200 rounded w-1/4"></div> <div class="h-3 bg-gray-200 rounded w-1/3"></div> </div>
    </div>

    <div class="h-px bg-gray-100"></div>

    <div class="space-y-4">
        <div class="h-5 bg-gray-200 rounded w-1/3 animate-pulse"></div> 

        <div class="flex items-center space-x-3 animate-pulse">
            <div class="w-6 h-6 bg-blue-500 rounded-full flex-shrink-0"></div>
            <div class="flex-1 h-10 bg-gray-100 rounded"></div>
        </div>

        <div class="flex items-center space-x-3 animate-pulse">
            <div class="w-6 h-6 bg-blue-500 rounded-full flex-shrink-0"></div>
            <div class="flex-1 h-10 bg-gray-100 rounded"></div>
        </div>

        <div class="flex items-center space-x-3 animate-pulse">
            <div class="w-6 h-6 bg-blue-500 rounded-full flex-shrink-0"></div>
            <div class="flex-1 h-10 bg-gray-100 rounded"></div>
        </div>
    </div>
    
    <div class="h-px bg-gray-100"></div>

    <div class="space-y-4">
        <div class="h-5 bg-gray-200 rounded w-1/3 animate-pulse"></div>

        <div class="h-10 bg-gray-100 rounded animate-pulse"></div>
        <div class="h-10 bg-gray-100 rounded animate-pulse"></div>
        <div class="h-10 bg-gray-100 rounded animate-pulse"></div>
    </div>
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
