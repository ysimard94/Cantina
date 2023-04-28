<template>
    <div class="relative min-h-screen">
        <HeaderComponent />
        <main class="bg-[#D9D9D9]">
            <router-view v-slot="{ Component }" @loading:start="onLoadingStart" @loading:end="onLoadingEnd">
                <LoadingSpinner v-if="$store.getters.isLoading" />
                <transition name="fade" mode="out-in">
                    <!-- <LoadingSpinner v-if="$store.getters.isLoading" /> -->
                    <component :is="Component" />
                </transition>
            </router-view>
            <!-- <transition name="fade" mode="out-in"> -->
            <!-- </transition> -->
            <!-- Menu modal qui est montré qu'au clic du bouton dans le footer -->
            <MenuComponent :menu-ouvert="menuOuvert" @fermer-menu="menuOuvert = false" @reinitialiser-page="pageActive = -1"/>
        </main>
        <FooterComponent :page-active="pageActive" @toggle-menu="menuOuvert = !menuOuvert" @fermer-menu="menuOuvert = false"/>
    </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import MenuComponent from "@/components/MenuComponent.vue";
import LoadingSpinner from "@/components/LoadingSpinner.vue";
import BouteilleDataService from "@/services/BouteilleDataService";

export default {
    name: "App",
    data () {
        return {
            bouteillesSAQ: [],
            menuOuvert: false,
            pageActive: -1,
        }
    },
    components: {
        HeaderComponent,
        FooterComponent,
        LoadingSpinner,
        MenuComponent,
    },
    methods: {
        onLoadingStart () {
            this.$store.dispatch("setLoading", true);
        },
        onLoadingEnd () {
            this.$store.dispatch("setLoading", false);
        },
        async fetchBouteilles () {
            try {
                const response = await BouteilleDataService.getAll();
                this.bouteillesSAQ = response.data;
            } catch (error) {
                console.log(error.response);
            }
        },
    },
    async mounted () {
        await this.fetchBouteilles()
    }
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
    min-height: 100vh;
    margin-bottom: 72px;
    display: flex;
    flex-direction: column;
}
</style>