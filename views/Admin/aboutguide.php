<style>
    @keyframes float {
        0% {
            transform: scale(1) translateY(0);
        }

        50% {
            transform: scale(1.04) translateY(-8px);
        }

        100% {
            transform: scale(1) translateY(0);
        }
    }
</style>

<main class="flex-1 p-8 space-y-16">

    <!-- BANNER -->
    <section class="relative rounded-3xl overflow-hidden shadow">
        <img src="https://images.unsplash.com/photo-1526772662000-3f88f10405ff"
            class="w-full h-60 md:h-72 lg:h-80 object-cover rounded-3xl 
                   animate-[float_10s_ease-in-out_infinite]
                   hover:scale-105 transition duration-500">
        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
            <h1 class="text-4xl font-bold text-white drop-shadow-md">Giới thiệu Travel Siuu</h1>
        </div>
    </section>

    <!-- GIỚI THIỆU -->
    <section class="grid md:grid-cols-2 gap-12 items-center">
        <div class="space-y-5">
            <h2 class="text-3xl font-bold text-gray-800">Chúng tôi là Travel_Siuu</h2>

            <p class="text-gray-600 leading-relaxed text-lg">
                Travel_Siuu là nền tảng đặt tour du lịch thông minh, cung cấp giải pháp tối ưu
                giúp khách hàng dễ dàng tìm kiếm, so sánh và đặt tour chỉ trong vài cú nhấp chuột.
            </p>

            <p class="text-gray-600 leading-relaxed text-lg">
                Với đội ngũ hướng dẫn viên giàu kinh nghiệm, hệ thống vận hành hiện đại và đối tác
                uy tín trên toàn quốc, Travel_Siuu giúp mọi chuyến đi trở nên trọn vẹn – từ tour cá nhân
                đến các đoàn lớn.
            </p>
        </div>

        <!-- ẢNH GIỚI THIỆU -->
        <img src="https://images.unsplash.com/photo-1500375592092-40eb2168fd21"
            class="rounded-2xl shadow-lg h-60 md:h-72 lg:h-80 w-full object-cover
                   animate-[float_12s_ease-in-out_infinite]
                   hover:scale-105 transition duration-500">
    </section>

    <!-- TẦM NHÌN - SỨ MỆNH - GIÁ TRỊ -->
    <section class="grid md:grid-cols-3 gap-8">

        <!-- TẦM NHÌN -->
        <div
            class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm 
                   hover:-translate-y-2 hover:shadow-2xl hover:border-blue-500
                   transition-all duration-300">
            <h3 class="text-2xl font-bold text-blue-700 mb-4">Tầm nhìn</h3>
            <p class="text-gray-600 leading-relaxed">
                Trở thành nền tảng du lịch hàng đầu Việt Nam, nơi kết nối hàng triệu du khách
                với hành trình chất lượng và đậm dấu ấn trải nghiệm.
            </p>
            <p class="mt-3 text-gray-600 leading-relaxed">
                Travel_Siuu hướng đến việc ứng dụng công nghệ vào du lịch giúp mọi chuyến đi minh bạch, dễ dàng.
            </p>
        </div>

        <!-- SỨ MỆNH -->
        <div
            class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm 
                   hover:-translate-y-2 hover:shadow-2xl hover:border-blue-500
                   transition-all duration-300">
            <h3 class="text-2xl font-bold text-blue-700 mb-4">Sứ mệnh</h3>
            <p class="text-gray-600 leading-relaxed">
                Mang lại trải nghiệm du lịch an toàn, vui vẻ và trọn vẹn cho khách hàng.
            </p>

            <p class="mt-3 text-gray-600 leading-relaxed">
                Travel_Siuu phát triển giải pháp quản lý thông minh cho doanh nghiệp du lịch.
            </p>
        </div>

        <!-- GIÁ TRỊ CỐT LÕI -->
        <div
            class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm 
                   hover:-translate-y-2 hover:shadow-2xl hover:border-blue-500
                   transition-all duration-300">
            <h3 class="text-2xl font-bold text-blue-700 mb-4">Giá trị cốt lõi</h3>

            <ul class="text-gray-600 leading-relaxed space-y-2">
                <li><strong class="text-gray-800">• Chuyên nghiệp:</strong> Dịch vụ tiêu chuẩn cao.</li>
                <li><strong class="text-gray-800">• Tận tâm:</strong> Luôn đặt khách hàng làm trung tâm.</li>
                <li><strong class="text-gray-800">• Minh bạch:</strong> Thông tin rõ ràng – chi phí hợp lý.</li>
                <li><strong class="text-gray-800">• Đổi mới:</strong> Ứng dụng công nghệ hiện đại giúp nâng tầm trải nghiệm.</li>
            </ul>
        </div>

    </section>
    <!-- CÂU CHUYỆN CỦA CHÚNG TÔI -->
    <section class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 space-y-5">

        <h2 class="text-3xl font-bold text-gray-800 text-center">Câu chuyện của Travel_Siuu</h2>

        <p class="text-gray-600 leading-relaxed text-lg">
            Travel_Siuu được thành lập với mong muốn đưa công nghệ vào ngành du lịch, giúp mọi chuyến đi
            trở nên đơn giản và dễ dàng hơn. Chúng tôi tin rằng mỗi hành trình đều là một câu chuyện –
            và nhiệm vụ của chúng tôi là giúp khách hàng viết nên những trải nghiệm tuyệt vời nhất.
        </p>

        <p class="text-gray-600 leading-relaxed text-lg">
            Bắt đầu từ một nhóm trẻ đam mê du lịch và phát triển công nghệ, Travel_Siuu lớn mạnh nhờ sự tin tưởng
            của khách hàng và sự nỗ lực không ngừng của đội ngũ hướng dẫn viên trên khắp cả nước.
            Chúng tôi không chỉ mang đến những tour chất lượng, mà còn xây dựng một hệ sinh thái du lịch
            an toàn, linh hoạt và minh bạch.
        </p>

        <p class="text-gray-600 leading-relaxed text-lg">
            Với phương châm <strong class="text-gray-800 italic">"Trải nghiệm tốt – Giá trị thật – Công nghệ nhanh"</strong>,
            Travel_Siuu luôn đặt khách hàng làm trọng tâm trong mọi hoạt động. Chúng tôi liên tục cải tiến quy trình,
            mở rộng dịch vụ và hợp tác với các đơn vị uy tín nhằm mang đến những hành trình đáng nhớ nhất.
        </p>

        <!-- LÝ DO CHỌN -->
        <div class="grid md:grid-cols-3 gap-8 pt-6">

            <div
                class="bg-blue-50 p-6 rounded-2xl border border-blue-100 shadow-sm
               hover:-translate-y-2 hover:scale-105 hover:shadow-xl hover:border-blue-500
               transition-all duration-300 ease-smooth">
                <h4 class="text-xl font-semibold text-blue-700 mb-2">Công nghệ dẫn đầu</h4>
                <p class="text-gray-600">
                    Hệ thống đặt tour, quản lý lịch trình và hỗ trợ khách hàng hoàn toàn tự động,
                    nhanh chóng và bảo mật.
                </p>
            </div>

            <div
                class="bg-blue-50 p-6 rounded-2xl border border-blue-100 shadow-sm
               hover:-translate-y-2 hover:scale-105 hover:shadow-xl hover:border-blue-500
               transition-all duration-300 ease-smooth">
                <h4 class="text-xl font-semibold text-blue-700 mb-2">HDV chuyên nghiệp</h4>
                <p class="text-gray-600">
                    Đội ngũ hướng dẫn viên giàu kinh nghiệm, tận tâm và luôn sẵn sàng đồng hành
                    cùng khách hàng.
                </p>
            </div>

            <div
                class="bg-blue-50 p-6 rounded-2xl border border-blue-100 shadow-sm
               hover:-translate-y-2 hover:scale-105 hover:shadow-xl hover:border-blue-500
               transition-all duration-300 ease-smooth">
                <h4 class="text-xl font-semibold text-blue-700 mb-2">Trải nghiệm tối ưu</h4>
                <p class="text-gray-600">
                    Tour đa dạng, chi phí minh bạch, hỗ trợ nhanh chóng và chính sách linh hoạt
                    cho mọi nhu cầu.
                </p>
            </div>

        </div>


    </section>

</main>