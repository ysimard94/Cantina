<template>
    <div class="bg-white shadow-md rounded-md overflow-hidden h-full">
        <img
            class="w-full object-cover object-center h-48"
            :src="product.img_url"
            alt="Product"
        />

        <div class="p-4">
            <h5 class="text-xl font-semibold mb-2 text-gray-800">
                {{ product.name }}
            </h5>
            <p class="text-sm text-gray-700 mb-4">
                {{ product.description }}
            </p>
            <p class="text-sm text-gray-800 mb-4">
                Price: <span class="font-semibold">$ {{ product.price }}</span>
            </p>
            <p class="text-sm text-gray-800 mb-4">
                Category: <span class="font-semibold">{{ categoryName }}</span>
            </p>
            <div class="mt-4">
                <router-link
                    :to="{ name: 'update-product', params: { id: product.id } }"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2 transition-colors duration-200"
                >
                    Update
                </router-link>
                <button
                    @click="$emit('delete', product.id)"
                    type="button"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200"
                >
                    Delete
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        product: Object,
        categories: {
            type: Array,
            default: () => [],
        },
    },
    computed: {
        categoryName() {
            const category = this.categories.find(
                (category) => category.id === this.product.category_id
            );
            return category ? category.name : "Unknown";
        },
    },
    mounted() {
        console.log(this.categories);
    },
};
</script>

<style scoped>
/* Add any custom CSS styles here */
</style>
