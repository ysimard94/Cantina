<template>
    <section class="py-12 px-4">
        <div class="container mx-auto">
            <div class="text-center">
                <h2 class="text-2xl font-semibold mb-2">About Us</h2>
                <p class="text-base">
                    Learn more about our business and the passionate team behind
                    it.
                </p>
            </div>
            <div class="mt-8">
                <p>
                    At our company, we are dedicated to providing top-quality
                    products and services to our customers. Our team is
                    passionate about innovation, technology, and creating a
                    unique and memorable experience for everyone who visits our
                    platform. We believe in empowering our customers and always
                    striving to improve and grow.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
                <div class="mb-4">
                    <img
                        src="https://source.unsplash.com/random?featured&query=business"
                        alt="Business"
                        class="w-full h-auto"
                    />
                </div>
                <div class="mb-4">
                    <img
                        src="https://source.unsplash.com/random?featured&query=teamwork"
                        alt="Teamwork"
                        class="w-full h-auto"
                    />
                </div>
                <div class="mb-4">
                    <img
                        src="https://source.unsplash.com/random?featured&query=innovation"
                        alt="Innovation"
                        class="w-full h-auto"
                    />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "AboutView",
};
</script>

<style scoped>
/* Add any custom styles here */
</style>
