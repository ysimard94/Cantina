<template>
    <div class="loading">
        <svg
            width="50"
            height="50"
            viewBox="0 0 50 50"
            xmlns="http://www.w3.org/2000/svg"
        >
            <circle
                cx="25"
                cy="25"
                r="20"
                fill="none"
                stroke="#000"
                stroke-width="4"
                stroke-linecap="round"
                stroke-dasharray="62.83185307179586"
                stroke-dashoffset="0"
            >
                <animateTransform
                    attributeName="transform"
                    type="rotate"
                    from="0 25 25"
                    to="360 25 25"
                    dur="1s"
                    repeatCount="indefinite"
                />
            </circle>
        </svg>
    </div>
</template>

<script>
export default {
    name: "LoadingSpinner",
};
</script>

<style scoped>
.loading {
    z-index: 999;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
