const adminContent = document.getElementById("adminContent");
// console.log(adminContent);
// console.log(axios);

const clickloadAdminPage = document.querySelectorAll(".clickloadAdminPage");
// console.log(clickloadAdminPage);

clickloadAdminPage.forEach((item, index) => {
  item.addEventListener("click", (e) => {
    e.preventDefault();
    clickloadAdminPage.forEach((el) => {
      // text-hover bg-indigo-50
      el.classList.remove("text-hover", "bg-indigo-50");
      el.classList.add("text-slate-700", "hover:bg-indigo-50");
    });

    e.currentTarget.classList.remove("text-slate-700", "hover:bg-indigo-50");
    e.currentTarget.classList.add("text-hover", "bg-indigo-50");
    const href = e.currentTarget.getAttribute("href");
    loadAdminPage(href);
  });
});
const loadAdminPage = (href) => {
  adminContent.innerHTML = `
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
      adminContent.innerHTML = data;
      function reloadAdminScript() {
        const module = import(
          `${BASE_URL}assets/Js/admin/admin_tours.js?ts=${Date.now()}`
        );
      }
      if (href == "?act=admintour") {
        reloadAdminScript();
      }
    })
    .catch(() => {
      console.log("Lỗi khôg có inter net");
    });
};

// bật tắt sider bar
const siderbaradmin = document.getElementById("siderbaradmin");
function toggleSidebar() {
  const screenWidth = window.innerWidth;
  if (screenWidth <= 640) {
    siderbaradmin.classList.toggle("-translate-x-full"); // chỉ trượt
  }
}
