<template>
    <div class="fixed inset-0">
        <div class="w-full h-full bg-black bg-opacity-90"></div>
        <button class="material-symbols-outlined text-white text-6xl absolute top-5 right-5"
            @click="fermerMenu">
            close
        </button>
    </div>
</template>
<script>
export default {
    name: "MenuComponent",
    methods: {
        fermerMenu() {
            this.$emit("fermer-menu");
        },
    },
};
</script>