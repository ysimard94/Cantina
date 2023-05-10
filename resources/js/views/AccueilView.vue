<template>
    <div>
        <section class="hero-section bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 text-white py-20">
            <div class="container mx-auto px-4">
                <div class="flex flex-col items-center justify-center">
                    <h1 class="font-bold text-4xl sm:text-5xl lg:text-6xl mb-6">
                        Découvrez le futur de la dégustation de vin
                    </h1>
                    <p class="text-lg sm:text-xl lg:text-2xl mb-6 mx-auto">
                        Nous sommes ravis de vous présenter un produit innovant
                        qui révolutionnera la manière dont vous vivez,
                        travaillez et vous amusez. Restez à l'affût pour la
                        grande révélation!
                    </p>
                    <router-link to="/catalogue"
                        class="btn btn-primary bg-white text-purple-600 font-semibold py-3 px-6 rounded-lg hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50 transition duration-150">
                        Voir le catalogue
                    </router-link>
                </div>
            </div>
        </section>
        <section class="features-section py-20">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="card p-6 bg-white shadow-md rounded-lg">
                        <div class="card-body">
                            <h5 class="card-title font-semibold text-xl mb-4">
                                Facile à utiliser
                            </h5>
                            <p class="card-text text-gray-600">
                                Notre plateforme de commerce électronique est
                                conçue pour être facile à utiliser, vous
                                permettant de parcourir et d'acheter des
                                produits en toute simplicité, même si vous
                                n'avez aucune expérience technique.
                            </p>
                        </div>
                    </div>
                    <div class="card p-6 bg-white shadow-md rounded-lg">
                        <div class="card-body">
                            <h5 class="card-title font-semibold text-xl mb-4">
                                Sélection de produits flexible
                            </h5>
                            <p class="card-text text-gray-600">
                                Nous élargissons continuellement notre gamme de
                                produits pour répondre à vos besoins et
                                préférences, assurant une expérience d'achat
                                diversifiée et personnalisée.
                            </p>
                        </div>
                    </div>
                    <div class="card p-6 bg-white shadow-md rounded-lg">
                        <div class="card-body">
                            <h5 class="card-title font-semibold text-xl mb-4">
                                Options abordables
                            </h5>
                            <p class="card-text text-gray-600">
                                Nous nous efforçons de proposer des produits de
                                qualité à des prix compétitifs, rendant notre
                                plateforme accessible aux clients ayant
                                différents budgets.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
export default {

};
</script>
