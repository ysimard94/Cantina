<template>
    <div>
        <section
            class="hero-section bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 text-white py-20"
        >
            <div class="container mx-auto px-4">
                <div class="flex flex-col items-center justify-center">
                    <h1 class="font-bold text-4xl sm:text-5xl lg:text-6xl mb-6">
                        Discover the Future of Innovation
                    </h1>
                    <p class="text-lg sm:text-xl lg:text-2xl mb-6 mx-auto">
                        We're excited to bring you a cutting-edge product that
                        will revolutionize the way you live, work, and play.
                        Stay tuned for the big reveal!
                    </p>
                    <router-link
                        to="/catalogue"
                        class="btn btn-primary bg-white text-purple-600 font-semibold py-3 px-6 rounded-lg hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50 transition duration-150"
                    >
                        Voir le catalogue
                    </router-link>
                </div>
            </div>
        </section>
        <section class="features-section py-20">
            <div class="container mx-auto px-4">
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div class="card p-6 bg-white shadow-md rounded-lg">
                        <div class="card-body">
                            <h5 class="card-title font-semibold text-xl mb-4">
                                Easy to Use
                            </h5>
                            <p class="card-text text-gray-600">
                                Our e-commerce platform is designed for ease of
                                use, allowing you to effortlessly browse and
                                purchase products, even if you have no technical
                                experience.
                            </p>
                        </div>
                    </div>
                    <div class="card p-6 bg-white shadow-md rounded-lg">
                        <div class="card-body">
                            <h5 class="card-title font-semibold text-xl mb-4">
                                Flexible Product Selection
                            </h5>
                            <p class="card-text text-gray-600">
                                We are continuously expanding our product range
                                to cater to your needs and preferences, ensuring
                                a diverse and personalized shopping experience.
                            </p>
                        </div>
                    </div>
                    <div class="card p-6 bg-white shadow-md rounded-lg">
                        <div class="card-body">
                            <h5 class="card-title font-semibold text-xl mb-4">
                                Affordable Options
                            </h5>
                            <p class="card-text text-gray-600">
                                We strive to provide high-quality products at
                                competitive prices, making our platform
                                accessible for customers with different budgets.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
