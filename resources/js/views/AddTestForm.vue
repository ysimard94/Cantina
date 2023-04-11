<template>
    <div class="bg-white min-h-screen">
        <div class="container mx-auto py-12 px-4">
            <h2 class="text-2xl font-semibold mb-6">Add new product</h2>
            <formComponent
                formName="testForm"
                title="test"
                class="bg-gray-100 p-6 rounded shadow"
            >
                <div v-if="!submitted" class="grid grid-cols-1 gap-6">
                    <!-- Product Name -->
                    <fieldComponent
                        :field="{ name: 'input' }"
                        label="Product Name"
                        name="name"
                        placeholder="Enter product name"
                        type="text"
                        required
                    />

                    <!-- Product price -->
                    <fieldComponent
                        :field="{ name: 'input' }"
                        label="Price"
                        name="price"
                        type="number"
                    />

                    <!-- Save Button -->
                    <button
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mt-3 transition-colors duration-200"
                        type="button"
                        @click="saveProduct"
                        :disabled="!isFormValid"
                        :class="{
                            'opacity-50 cursor-not-allowed': !isFormValid,
                        }"
                    >
                        Save
                    </button>
                </div>
                <div v-else>
                    <div class="alert alert-success" role="alert">
                        You submitted successfully!
                    </div>
                    <button class="btn btn-primary" @click="newProduct">
                        New product
                    </button>
                    <router-link to="/products" class="btn btn-secondary">
                        Go back to products
                    </router-link>
                </div>
            </formComponent>
        </div>
    </div>
</template>

<script>
import ProductDataService from "@/services/ProductDataService";
import CategoryDataService from "@/services/CategoryDataService";
import InputComponent from "@/components/form/InputComponent.vue";
import FieldComponent from "@/components/form/FieldComponent.vue";
import FormComponent from "@/components/form/FormComponent.vue";
// import LoadingSpinner from "@/components/LoadingSpinner.vue";
import { mapGetters } from "vuex";

export default {
    name: "AddTestForm",
    components: {
        InputComponent,
        FormComponent,
        FieldComponent,
    },
    data() {
        return {
            product: {
                name: "",
                img_url: "",
                price: "",
                description: "",
                category_id: "",
            },
            categories: [],
            message: "",
            submitted: false,
        };
    },
    methods: {
        saveProduct() {
            ProductDataService.create(this.getFormData())
                .then(() => {
                    this.message = null;
                    this.submitted = true;
                })
                .catch((e) => {
                    console.log(e.response.data.message);
                    this.message = e.response.data.message;
                });
        },
        // validateForm() {
        //     if (this.product.name.length < 3) {
        //         this.message =
        //             "Product name should be at least 3 characters long.";
        //         return false;
        //     }
        //     if (!this.product.img_url.startsWith("http")) {
        //         this.message = "Please enter a valid photo URL.";
        //         return false;
        //     }
        //     if (this.product.price === "") {
        //         console.log(this.product.price);
        //         this.message = "Please enter a valid price.";
        //         return false;
        //     }
        //     if (this.product.category_id === "") {
        //         this.message = "Please select a category.";
        //         return false;
        //     }
        //     return true;
        // },
        newProduct() {
            this.submitted = false;
            this.product = {};
        },
        getFormData() {
            return this.formData["addProductForm"];
        },
    },
    computed: {
        ...mapGetters({
            isFormValid: "isFormValid",
        }),
        ...mapGetters({
            formData: "formData",
        }),
    },
    async mounted() {
        // this.$emit("loading:start");
        try {
            this.categories = (await CategoryDataService.getAll()).data;
        } catch (error) {
            console.error("Error fetching data:", error);
        } finally {
            this.$emit("loading:end");
        }
    },
};
</script>
