<template>
    <!-- Add your template code here -->
    <div class="slider-component">
        <div ref="slider" class="slider">
            <div
                class="slider-touch-left"
                :style="{ left: touchLeftPos + 'px' }"
                @mousedown="onStart($event, 'left')"
                @touchstart="onStart($event, 'left')"
            >
                <span></span>
            </div>
            <div
                class="slider-touch-right"
                :style="{ left: touchRightPos + 'px' }"
                @mousedown="onStart($event, 'right')"
                @touchstart="onStart($event, 'right')"
            >
                <span></span>
            </div>
            <div class="slider-line">
                <span
                    :style="{
                        marginLeft: lineSpanMarginLeft + 'px',
                        width: lineSpanWidth + 'px',
                    }"
                ></span>
            </div>
        </div>
        <div>Min: {{ minValue }} Max: {{ maxValue }}</div>
    </div>
</template>

<script>
import {
    calculateValues,
    setMinValue,
    setMaxValue,
} from "@/core/rangeSlider.js";

export default {
    name: "RangeSlider",
    props: {
        min: Number,
        max: Number,
        step: Number,
        defaultMin: Number,
        defaultMax: Number,
    },
    data() {
        return {
            // Add your data properties here
        };
    },
    mounted() {
        // Add your mounted code here
    },
    methods: {
        onStart() {
            // Add your onStart code here
        },
        onMove() {
            const { minValue, maxValue } = calculateValues(
                this.touchLeftPos,
                this.touchRightPos,
                this.sliderWidth,
                this.touchWidth,
                this.min,
                this.max,
                this.step
            );
            this.minValue = minValue;
            this.maxValue = maxValue;
        },
        onStop() {
            // Add your onStop code here
        },
        setInitialValues() {
            this.touchLeftPos = setMinValue(
                this.defaultMin,
                this.min,
                this.max,
                this.sliderWidth,
                this.touchWidth
            );
            this.touchRightPos = setMaxValue(
                this.defaultMax,
                this.min,
                this.max,
                this.sliderWidth,
                this.touchWidth
            );
            this.lineSpanMarginLeft = this.touchLeftPos;
            this.lineSpanWidth = this.touchRightPos - this.touchLeftPos;
        },
    },
};
</script>

<style scoped>
/* Add your component styling here */
</style>
