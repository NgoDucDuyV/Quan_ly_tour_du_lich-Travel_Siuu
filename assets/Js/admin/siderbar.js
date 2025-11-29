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
          <div class="flex h-screen bg-gray-50 p-4">
          <div class="w-1/4 bg-white rounded-lg shadow-md p-4 space-y-4 mr-4 animate-pulse">
              <div class="flex justify-between items-center mb-4">
                  <div class="h-6 bg-gray-200 rounded w-1/3"></div> <div class="h-8 bg-blue-100 rounded-lg w-1/4"></div> </div>

              <div class="h-10 bg-gray-100 rounded-lg mb-6"></div>

              <div class="space-y-3">
                  <div class="flex items-start space-x-2 p-2 bg-gray-50 rounded-lg">
                      <div class="w-12 h-12 bg-gray-200 rounded-md flex-shrink-0"></div>
                      <div class="flex-1 space-y-1">
                          <div class="h-4 bg-gray-300 rounded w-3/4"></div>
                          <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                      </div>
                  </div>
                  <div class="flex items-start space-x-2 p-2 rounded-lg">
                      <div class="w-12 h-12 bg-gray-100 rounded-md flex-shrink-0"></div>
                      <div class="flex-1 space-y-1">
                          <div class="h-4 bg-gray-200 rounded w-2/3"></div>
                          <div class="h-3 bg-gray-100 rounded w-2/5"></div>
                      </div>
                  </div>
                  <div class="flex items-start space-x-2 p-2 rounded-lg">
                      <div class="w-12 h-12 bg-gray-100 rounded-md flex-shrink-0"></div>
                      <div class="flex-1 space-y-1">
                          <div class="h-4 bg-gray-200 rounded w-3/5"></div>
                          <div class="h-3 bg-gray-100 rounded w-1/3"></div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="flex-1 space-y-6">
              
              <div class="bg-white rounded-lg shadow-md p-6 space-y-6 animate-pulse">
                  <div class="w-full h-48 bg-gray-200 rounded-lg"></div> 
                  
                  <div class="space-y-2">
                      <div class="h-4 bg-gray-300 rounded w-1/4 mx-auto"></div>
                      <div class="h-3 bg-gray-100 rounded w-full"></div>
                      <div class="h-3 bg-gray-100 rounded w-5/6 mx-auto"></div>
                  </div>

                  <div class="flex justify-around pt-4">
                      <div class="w-1/5 h-20 bg-gray-100 rounded-lg"></div>
                      <div class="w-1/5 h-20 bg-gray-100 rounded-lg"></div>
                      <div class="w-1/5 h-20 bg-gray-100 rounded-lg"></div>
                      <div class="w-1/5 h-20 bg-gray-100 rounded-lg"></div>
                  </div>
                  
                  <div class="h-10 bg-blue-200 rounded-md w-1/3 mx-auto"></div>
              </div>
              
              <div class="bg-white rounded-lg shadow-md p-4 animate-pulse">
                  <div class="flex justify-between p-2 border-b border-gray-100">
                      <div class="h-4 bg-gray-200 rounded w-1/6"></div>
                      <div class="h-4 bg-gray-200 rounded w-1/6"></div>
                      <div class="h-4 bg-gray-200 rounded w-1/6"></div>
                      <div class="h-4 bg-gray-200 rounded w-1/6"></div>
                      <div class="h-4 bg-gray-200 rounded w-1/12"></div>
                  </div>
                  
                  <div class="space-y-3 pt-3">
                      <div class="h-8 bg-gray-100 rounded"></div>
                      <div class="h-8 bg-gray-100 rounded"></div>
                      <div class="h-8 bg-gray-100 rounded"></div>
                      <div class="h-8 bg-gray-100 rounded"></div>
                  </div>
              </div>

          </div>
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

const sidebars = [
  document.getElementById("siderbaradmin"),
  document.getElementById("sidebarHDV"),
].filter(Boolean); // loại bỏ các phần tử null

const toggleBtn = document.getElementById("toggleButtonId"); // id nút toggle

if (toggleBtn) {
  // bật/tắt cả sidebar khi bấm nút
  toggleBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    const screenWidth = window.innerWidth;
    if (screenWidth <= 640) {
      sidebars.forEach((sidebar) =>
        sidebar.classList.toggle("-translate-x-full")
      );
    }
  });
}

// tắt sidebar khi bấm ngoài (chỉ khi <= 640px)
document.addEventListener("click", (e) => {
  const screenWidth = window.innerWidth;
  if (screenWidth <= 640) {
    sidebars.forEach((sidebar) => {
      if (
        !sidebar.contains(e.target) &&
        (!toggleBtn || !toggleBtn.contains(e.target))
      ) {
        sidebar.classList.add("-translate-x-full");
      }
    });
  }
});

// ngăn click trong sidebar tự đóng
sidebars.forEach((sidebar) => {
  sidebar.addEventListener("click", (e) => e.stopPropagation());
});
