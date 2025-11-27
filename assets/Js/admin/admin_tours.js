const viewsdetailtour = document.getElementById("viewsdetailtour");
// console.log(viewsdetailtour);
// console.log(axios);
function bindClickDetailTour() {
  const clickloadAdmindetailtours = document.querySelectorAll(
    ".clickloadAdmindetailtour"
  );
  // console.log(clickloadAdmindetailtours);

  clickloadAdmindetailtours.forEach((item) => {
    item.addEventListener("click", (e) => {
      e.preventDefault();
      const href = e.currentTarget.getAttribute("href");
      loadDetailtour(href);
    });
  });
}
bindClickDetailTour();
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

const searchTourListContainer = document.getElementById(
  "searchTourListContainer"
);
// console.log(searchTourListContainer);

const tourListContainer = document.getElementById("tourListContainer");

searchTourListContainer.addEventListener("change", (el) => {
  const valueSearch = el.target.value.trim();
  console.log(valueSearch);

  tourListContainer.innerHTML = `
  <div class="w-full h-full bg-white rounded-lg shadow-md p-6 flex flex-col space-y-4 border border-gray-100 animate-pulse">
    <div class="flex space-x-4 items-start">
      <div class="w-20 h-20 bg-gray-200 rounded-md"></div>
      <div class="flex-1 space-y-2 pt-2">
        <div class="h-4 bg-gray-300 rounded w-3/4"></div>
        <div class="h-3 bg-gray-200 rounded w-1/4"></div>
        <div class="h-3 bg-gray-200 rounded w-1/3"></div>
      </div>
    </div>
    <div class="h-px bg-gray-100"></div>
    <div class="space-y-4">
      <div class="h-5 bg-gray-200 rounded w-1/3"></div>
      <div class="h-10 bg-gray-100 rounded"></div>
      <div class="h-10 bg-gray-100 rounded"></div>
      <div class="h-10 bg-gray-100 rounded"></div>
    </div>
  </div>`;
  // if (valueSearch) {
  axios
    .post(`${BASE_URL}?act=admin_searchtour&ajax=1`, {
      valueSearch: valueSearch,
    })
    .then(({ data }) => {
      console.log(data);
      if (!data || data.length === 0) {
        tourListContainer.innerHTML = `
            <div class="flex flex-col items-center justify-center py-16 text-center bg-gray-50 rounded-xl shadow-md border border-gray-200">
              <div class="text-red-400 text-6xl mb-4 animate-bounce">
                  <i class="fa-regular fa-circle-xmark"></i>
              </div>
              <h3 class="text-xl font-semibold text-gray-700 mb-2">Oops!</h3>
              <p class="text-gray-500 text-sm">Không tìm thấy tour nào với tên <span class="font-medium text-gray-800">${valueSearch}</span></p>
              <button 
                  onclick="document.getElementById('searchTourListContainer').value=''; location.reload();" 
                  class="mt-4 px-6 py-2 bg-main text-white rounded-md shadow hover:bg-hover transition">
                  Thử lại
              </button>
          </div>
          `;
        return;
      }
      // Nếu có dữ liệu
      let html = "";
      data.forEach((tour) => {
        html += `
            <article class="p-3 rounded-lg border hover:shadow-md transition-shadow bg-gray-50">
              <div class="flex items-start gap-3">
                <img src="${
                  BASE_URL + tour.images
                }" alt="thumb" class="w-20 h-14 object-cover rounded">
                <div class="flex-1">
                  <div class="flex items-center justify-between">
                    <h4 class="font-medium text-gray-800">${tour.name}</h4>
                    <div class="text-sm text-gray-500"></div>
                  </div>
                  <p class="text-xs text-gray-500 mt-1">
                    Giá từ <span class="font-semibold text-gray-800">${Number(
                      tour.price
                    ).toLocaleString()} VND</span>
                  </p>
                  <div class="flex flex-wrap gap-2 pt-1">
                    <button onclick="window.location.href='?act=admintour&tour_id=${
                      tour.id
                    }'"
                        class="clickloadAdmindetailtour text-xs px-3 py-1.5 rounded-md bg-main text-white hover:bg-hover transition">
                        Chi tiết
                    </button>
                    <button onclick="cloneTour(this)"
                        class="text-xs px-3 py-1.5 rounded-md bg-accent text-white hover:bg-hover transition">
                        Clone
                    </button>
                    <a href="?act=newBooking&tour_id=${
                      tour.id
                    }" onclick="generateQuote(this)"
                        class="text-xs px-3 py-1.5 rounded-md bg-dark text-white hover:bg-hover transition">
                        Báo giá nhanh
                    </a>
                  </div>
                </div>
                <div class="relative group">
                  <button class="py-1 px-2 rounded-lg text-slate-600 hover:bg-slate-200 transition">
                    <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                  </button>
                  <div class="absolute right-0 mt-2 w-40 bg-white border rounded-md shadow-lg text-sm py-1
                          opacity-0 invisible group-hover:opacity-100 group-hover:visible
                          transition-all duration-200 z-20 overflow-hidden">
                    <a href="?act=admintour&tour_id=${tour.id}"
                        class="clickloadAdmindetailtour flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                        <i class="fa-regular fa-eye w-5 mr-3"></i> Chi Tiết
                    </a>
                    <a href="?act=newBooking&tour_id=${tour.id}"
                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                        <i class="fa-solid fa-plus w-5 mr-3"></i> tạo booking
                    </a>
                    <a href="?act=edittour&id=${tour.id}"
                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                        <i class="fa-regular fa-pen-to-square w-5 mr-3"></i> Edit
                    </a>
                    <a href="?act=admin_deleteTour&tour_id=${tour.id}"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa ?')"
                        class="flex items-center px-3 py-2 text-red-600 hover:bg-red-50 transition">
                        <i class="fa-regular fa-trash-can w-5 mr-3"></i> Xóa bỏ
                    </a>
                  </div>
                </div>
              </div>
            </article>
          `;
      });
      tourListContainer.innerHTML = html;
      bindClickDetailTour();
    })
    .catch(() => {
      console.log("Lỗi không có internet");
      tourListContainer.innerHTML = `
            <div class="text-center py-10 text-red-500">
                <i class="fa-regular fa-circle-xmark text-4xl mb-3"></i>
                <p>Lỗi kết nối mạng</p>
            </div>
        `;
    });
  // } else {
  //   // Nếu input rỗng, reset container
  //   tourListContainer.innerHTML = `
  //       <div class="text-center py-10 text-gray-400">
  //           <p>Nhập tên tour để tìm kiếm</p>
  //       </div>
  //   `;
  // }
});
