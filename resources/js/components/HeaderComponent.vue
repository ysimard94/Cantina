<template>
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <router-link
                        class="flex-shrink-0 flex items-center"
                        :to="{ name: 'home' }"
                    >
                        <img
                            class="h-8 w-auto"
                            src="/img/your-logo.svg"
                            alt="Product Logo"
                        />
                    </router-link>
                    <nav class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <router-link
                            class="nav-link inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 text-gray-900 border-transparent focus:outline-none focus:text-gray-700 focus:border-indigo-300"
                            :to="{ name: 'home' }"
                            >Home</router-link
                        >
                        <router-link
                            class="nav-link inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300"
                            :to="{ name: 'saq-produits' }"
                            >Obtenir produits SAQ</router-link
                        >
                        <router-link
                            class="nav-link inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300"
                            :to="{ name: 'monCellier' }"
                            >Mon Cellier</router-link
                        >
                        <router-link
                            class="nav-link inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300"
                            :to="{ name: 'Catalogue.index' }"
                            >Catalogue</router-link
                        >
                    </nav>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <div class="flex items-center">
                        <form action="#" method="GET" class="relative">
                            <input
                                type="search"
                                name="search"
                                placeholder="Search"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:bg-white focus:placeholder-gray-600 focus:border-gray-300 focus:shadow-outline-blue sm:text-sm transition duration-150 ease-in-out"
                            />
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-3 text-gray-300"
                            >
                                <svg
                                    class="h-5 w-5"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 12a2 2 0 100-4 2 2 0 000 4zm6 0a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    name: "HeaderComponent",
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>
