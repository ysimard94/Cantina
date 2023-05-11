<template>
    <div class="bg-gray-100 p-4 rounded-lg">


        <div class="mt-4">
             <h3 class="text-lg font-bold mb-2">Avis récents</h3>
        <div v-for="review in reviews" :key="review.id" class="bg-white rounded-lg shadow p-4 mb-4 text-left">
          <p class="text-lg font-bold mb-2">
            {{ review.name }}

             <span class="text-yellow-500">
        <!-- Ajouter autant d'étoiles jaunes que le nombre d'étoiles souhaité -->
        <!-- Ajouter autant d'étoiles grises que le complément à 5 étoiles -->
        <span v-for="i in 5" :key="i">
          <template v-if="i <= review.stars">
            ★
          </template>
          <template v-else>
            ☆
          </template>
        </span>
      </span>
          </p>

          <p class="text-gray-700">{{ review.comment }}</p>
        </div>


        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            reviews: [
                { id: 1, name: 'Emily Selman', stars: 5, comment: "Un vin riche et complexe avec des arômes de fruits noirs et d'épices" },
                { id: 2, name: 'John Doe', stars: 3, comment: "Un vin frais et fruité, parfait pour une soirée d'été" },
                { id: 3, name: 'Jane Smith', stars: 4, comment: 'Ce vin est simplement divin ! Avec des arômes de framboise et de violette.' }
            ]
        };
    }
}
</script>
