<template>{{ message }}</template>

<script>
import SaqProduitsDataService from "@/services/SaqProduitsDataService";
export default {
    name: "SuccessView",
    data() {
        return {
            message: "Wait wail we fetch the data",
        };
    },
    methods: {
        async fetchSaqProduits() {
            this.$emit("loading:start");
            try {
                const reponse = await SaqProduitsDataService.getAll();
                this.message = reponse.data.message;
            } catch (error) {
                console.error("Error fetching data:", error);
            } finally {
                // this.$store.dispatch("setLoading", false);
                this.$emit("loading:end");
            }
        },
    },
    async mounted() {
        console.log("SuccessView mounted");
        await this.fetchSaqProduits();
    },
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>
