<template>
    <div class="relative min-h-screen">
        <HeaderComponent />
        <main class="bg-[#D9D9D9]">
            <router-view
                v-slot="{ Component }"
                @loading:start="onLoadingStart"
                @loading:end="onLoadingEnd"
            >
                <LoadingSpinner v-if="$store.getters.isLoading" />
                <transition name="fade" mode="out-in">
                    <!-- <LoadingSpinner v-if="$store.getters.isLoading" /> -->
                    <component :is="Component" />
                </transition>
            </router-view>
            <!-- <transition name="fade" mode="out-in"> -->
            <!-- </transition> -->
        </main>
        <!--<FooterComponent />-->
    </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import LoadingSpinner from "@/components/LoadingSpinner.vue";

export default {
    name: "App",
    components: {
        HeaderComponent,
        FooterComponent,
        LoadingSpinner,
    },
    methods: {
        onLoadingStart() {
            this.$store.dispatch("setLoading", true);
        },
        onLoadingEnd() {
            this.$store.dispatch("setLoading", false);
        },
    },
};
</script>

<style>
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter,
.fade-leave-to {
    opacity: 0;
}
main {
    min-height: 81vh;
    display: flex;
    flex-direction: column;
}
</style>
