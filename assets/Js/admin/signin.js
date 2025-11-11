const checkkeds = document.querySelectorAll(".checkpasswrod");
const passwordInputs = document.querySelectorAll('input[type="password"]');
if (checkkeds || passwordInputs) {
  function checkedPass() {
    passwordInputs.forEach((input) => {
      if (this.checked) {
        input.type = "text";
      } else {
        input.type = "password";
      }
    });
  }
  checkkeds.forEach((el) => {
    el.addEventListener("click", checkedPass);
  });
}
const fromsignin = document.getElementById("fromsignin");

if (fromsignin) {
  fromsignin.addEventListener("submit", (e) => {
    e.preventDefault();
    signin();
  });
}

const signin = () => {
  console.log(1);
  axios
    .post(`${BASE_URL}?mode=admin&act=signin`, {
      email: document.getElementById("signin_email").value,
      password: document.getElementById("signin_password").value,
    })
    .then(({ data }) => {
      console.log("gửi dữ liệu thành công", data);
      document.getElementById("errorsignin").innerHTML = `
        <p class="font-medium text-sm ${
          data.success
            ? "bg-blue-100 border border-blue-400 text-blue-700"
            : "bg-red-100 border border-red-400 text-red-700"
        } px-4 py-3 rounded relative mb-6">
          ${data.errorsignin}
        </p>`;

      if (data.success) {
        document.getElementById("signin_email").value = "";
        document.getElementById("signin_password").value = "";
        if (remember_me.checked) {
          console.log(data.datauser);
          localStorage.setItem("user", JSON.stringify(data.datauser));
        }
        window.location.replace(`${data.redirect}`);
      }
    })
    .catch(() => {
      console.log("signin thất bại");
    });
};
