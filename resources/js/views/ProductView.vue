<template>
    <section class="contact-section bg-white pt-8 pb-8 mt-12 mb-12">
        <div class="container mx-auto px-4 bg-white">
            <div v-if="!$store.getters.isLoading">
                <div class="flex flex-wrap mb-4">
                    <div class="w-full md:w-1/2">
                        <h1 class="text-2xl font-semibold">Products</h1>
                    </div>
                    <div class="w-full md:w-1/2 text-right">
                        <router-link
                            :to="{ name: 'add-product' }"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Add Product
                        </router-link>
                    </div>
                </div>
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4"
                >
                    <div v-for="product in products" :key="product.id">
                        <ProductCard
                            :product="product"
                            :categories="categories"
                            :isLoading="isLoading"
                            @delete="DeleteProduct"
                        />
                    </div>
                    <div
                        v-if="products.length === 0"
                        class="col-span-full text-center"
                    >
                        <h3 class="mt-4 mb-4 text-xl font-semibold">
                            No products available.
                        </h3>
                        <p>
                            Please click the "Add Product" button to add new
                            products.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import ProductCard from "@/components/ProductCard.vue";
import ProductDataService from "@/services/ProductDataService";
import CategoryDataService from "@/services/CategoryDataService";
// import LoadingSpinner from "@/components/LoadingSpinner.vue";

export default {
    components: {
        ProductCard,
    },
    data() {
        return {
            products: [],
            categories: [],
        };
    },
    methods: {
        async DeleteProduct(id) {
            // Handle delete product event
            try {
                await ProductDataService.delete(id);
                this.products = this.products.filter(
                    (product) => product.id !== id
                );
            } catch (error) {
                console.error("Error deleting product:", error);
            } finally {
                this.$router.push({ name: "products" });
            }
        },
    },
    async mounted() {
        // this.$store.dispatch("setLoading", true);
        this.$emit("loading:start");
        try {
            this.products = (await ProductDataService.getAll()).data;
            this.categories = (await CategoryDataService.getAll()).data;
        } catch (error) {
            console.error("Error fetching data:", error);
        } finally {
            // this.$store.dispatch("setLoading", false);
            this.$emit("loading:end");
        }
    },
};
</script>

<style scoped>
/* Add any custom CSS styles here */
</style>
