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
                <transition name="moveUp" mode="out-in">
                    <component :is="Component" ::key="$route.path" />
                </transition>
            </router-view>
            <MenuComponent
                :menu-ouvert="menuOuvert"
                @fermer-menu="menuOuvert = false"
                @reinitialiser-page="pageActive = -1"
            />
            <RechercheComponent 
                :recherche-ouverte="rechercheOuverte"
                @reinitialiser-page="pageActive = -1; rechercheOuverte = false"
            />
        </main>
        <FooterComponent
            :page-active="pageActive"
            @toggle-menu="menuOuvert = !menuOuvert"
            @toggle-recherche="rechercheOuverte = !rechercheOuverte"
            @fermer-menu="menuOuvert = false"
            @fermer-recherche="rechercheOuverte = false"
            @changer-page-active="pageActive = $event"
        />
    </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import MenuComponent from "@/components/MenuComponent.vue";
import LoadingSpinner from "@/components/LoadingSpinner.vue";
import RechercheComponent from "@/components/RechercheComponent.vue";
import BouteilleDataService from "@/services/BouteilleDataService";

export default {
    name: "App",
    data() {
        return {
            bouteillesSAQ: [],
            menuOuvert: false,
            rechercheOuverte: false,
            pageActive: -1,
        };
    },
    components: {
        HeaderComponent,
        FooterComponent,
        LoadingSpinner,
        MenuComponent,
        RechercheComponent,
    },
    methods: {
        onLoadingStart() {
            this.$store.dispatch("setLoading", true);
        },
        onLoadingEnd() {
            this.$store.dispatch("setLoading", false);
        },
        // async fetchBouteilles() {
        //     try {
        //         const response = await BouteilleDataService.getAll();
        //         this.bouteillesSAQ = response.data;
        //     } catch (error) {
        //         console.log(error.response);
        //     }
        // },
    },
    // async mounted() {
    //     await this.fetchBouteilles();
    // },
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

/* .fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter,
.fade-leave-to {
    opacity: 0;
} */
.moveUp-enter-active {
    animation: fadeIn 0.2s ease-in;
}

@keyframes fadeIn {
    0% {
        opacity: 0;
    }

    50% {
        opacity: 0.5;
    }

    100% {
        opacity: 1;
    }
}

.moveUp-leave-active {
    animation: moveUp 0.1s ease-in;
}

@keyframes moveUp {
    0% {
        transforme: translateX(0);
    }

    100% {
        transforme: translateY(-400px);
    }
}

main {
    min-height: 100vh;
    padding-bottom: 96px;
    margin-bottom: 56px;
    display: flex;
    flex-direction: column;
}
</style>
