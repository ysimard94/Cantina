<template>
    <div>
        <slot
            @loading:start="onLoadingStart"
            @loading:end="onLoadingEnd"
        ></slot>
    </div>
</template>

<script>
export default {
    methods: {
        onLoadingStart() {
            this.$emit("loading:start");
        },
        onLoadingEnd() {
            this.$emit("loading:end");
        },
    },
};
</script>
